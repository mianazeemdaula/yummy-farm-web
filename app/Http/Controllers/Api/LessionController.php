<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Fcm;
use App\Http\Controllers\Controller;
use App\Models\Lession;
use App\Models\LessionNotes;
use App\Models\LessionTiming;
use App\Models\LessionVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Notifications;
use App\Models\Review;
use App\Models\TutorTime;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// $date = Carbon::parse($userSuppliedDate, auth()->user()->timezone)->setTimezone('UTC');
// // When display a date from the database, convert to user timezone.
// $date = Carbon::parse($databaseSuppliedDate, 'UTC')->setTimezone($user->timezone);

class LessionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lession = Lession::where(function ($a) {
            $a->where('status', 'approved');
            // $a->orWhere('status', 'pending');
        })->where(function ($q) use ($user) {
            $q->where('student_id', $user->id);
            $q->orWhere('tutor_id', $user->id);
        })->with(['notes', 'libraries', 'videos', 'tutor', 'student', 'instrument'])->orderBy('start_at')->get();
        // join('lession_timings', 'lession_timings.lession_id', '=', 'lessions.id')->orderBy('lession_timings.end_time')->get();
        // >sortBy('times.end_time')

        return response()->json(['status' => true, 'data' => $lession], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'instrument_id' => 'required|integer',
                'tutor_id' => 'required|integer',
                // 'start' => 'required',
                'duration' => 'required|integer',
                // 'repeat' => 'required|string',
                // 'end' => 'required',
                'times' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()->first()], 200);
            } else {
                $notifications = [];
                $lessions = [];
                foreach ($request->times as $key => $value) {
                    $startDate = Carbon::parse($value['start'], auth()->user()->time_zone)->setTimezone('UTC');
                    $endDate = Carbon::parse($value['end'], auth()->user()->time_zone)->setTimezone('UTC');
                    $times[] = $value;
                    $lession = new Lession();
                    $lession->instrument_id = $request->instrument_id;
                    $lession->student_id = $request->user()->id;
                    $lession->tutor_id = $request->tutor_id;
                    $lession->lession_duration = $value['duration'];
                    $lession->start_at = $startDate;
                    $lession->end_at = $endDate;
                    $lession->tutor_time_id = $value['id'];
                    $lession->save();
                    $lessions[] = $lession;
                    // $duration = 0;
                    // foreach ($value as $time) {
                    //     $lessionTime = new LessionTiming();
                    //     $lessionTime->lession_id = $lession->id;
                    //     $lessionTime->start_time = $time['from'];
                    //     $lessionTime->end_time = $time['to'];
                    //     $duration += $time['duration'];
                    //     $lessionTime->save();
                    // }
                    // $lession->lession_duration = $duration;
                    // Notifications for teacher
                    ;
                    $notification = new Notifications();
                    $notification->user_id = $lession->tutor_id;
                    $notification->title = 'Confirmation Request';
                    $notification->body = 'Student: ' . $lession->student->name;
                    $notification->notification_time = Carbon::parse($lession->start_at, $lession->tutor->time_zone)->setTimezone('UTC');
                    $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
                    $notification->save();
                    $notifications[] = $notification->id;

                    // Notifications for Student
                    $notification = new Notifications();
                    $notification->user_id = $lession->student_id;
                    $notification->title = 'Request for lession sent';
                    $notification->body = 'Tutor: ' . $lession->tutor->name;
                    $notification->notification_time = Carbon::parse($lession->start_at, $lession->student->time_zone)->setTimezone('UTC');
                    $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
                    $notification->save();
                    $notifications[] = $notification->id;
                }
                // $lession = new Lession();
                // $lession->instrument_id = $request->instrument_id;
                // $lession->student_id = $request->user()->id;
                // $lession->tutor_id = $request->tutor_id;
                // $lession->start_date = $request->start_date;
                // $lession->lession_time = $request->lession_time;
                // $lession->lession_duration = $request->duration;
                // $lession->repeat = $request->repeat;
                // $lession->end_date = $request->end_date;
                // $lession->save();
                // if($request->note != null){
                //     $note = new LessionNotes();
                //     $note->lession_id = $lession->id;
                //     $note->note = $request->note;
                //     $note->save();
                // }
                // if($request->video != null){
                //     $video = new LessionVideos();
                //     $video->lession_id = $lession->id;
                //     $video->video_url = $request->video;
                //     $video->save();
                // }
                // if($request->has('libraries')){
                //     $lession->libraries()->sync($request->libraries);
                // }
                DB::commit();
                // foreach ($tutorNotifications as $value) {
                //     Fcm::sendNotification($value);
                // }
                $notifications = Notifications::whereIn('id', $notifications)->get();
                foreach ($notifications as $value) {
                    Fcm::sendNotification($value);
                }
                return response()->json(['status' => true, 'data' => $lessions[0]], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function show($id)
    {
        $lession = Lession::with(['notes', 'libraries', 'videos', 'tutor', 'times', 'student', 'instrument'])->find($id);
        return response()->json(['status' => true, 'data' => $lession], 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $lession = Lession::find($id);
            $lession->status = $request->status;
            $lession->save();
            $user = $request->user();
            $sendToId = 1;
            $body = '';
            if($request->status == 'finished' || $request->status == 'canceled'){
                $time = TutorTime::find($lession->tutor_time_id);
                if($time){
                    $time->booked = false;
                    $time->save();
                }
            }
            if ($request->status == 'approved' || $request->status == 'canceled') {
                // update the tutor avaialble time
                if($request->status == 'approved'){
                    $time = Carbon::parse($lession->start_at, 'UTC')->setTimezone($lession->tutor->time_zone);
                    $time = TutorTime::find($lession->tutor_time_id);
                    if($time){
                        $time->booked = true;
                        $time->save();
                    }
                }
                $notification = new Notifications();
                $notification->user_id = $lession->student_id;
                $notification->title = 'Lession ' . ucfirst($request->status);
                $notification->body = 'Teacher: ' . $lession->tutor->name;
                $notification->notification_time = Carbon::parse($lession->start_at, $lession->student->time_zone)->setTimezone('UTC');
                $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
                $notification->save();
                Fcm::sendNotification($notification);

                $notification = new Notifications();
                $notification->user_id = $lession->tutor_id;
                $notification->title = 'Lession ' . ucfirst($request->status);
                $notification->body = 'Student: ' . $lession->student->name;
                $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);
                $notification->notification_time = Carbon::parse($lession->start_at, $lession->tutor->time_zone)->setTimezone('UTC');
                $notification->save();
                Fcm::sendNotification($notification);
            } else {
                $time = '';
                if ($user->id == $lession->student_id) {
                    $sendToId = $lession->tutor_id;
                    $body = 'Stduent:' . $lession->student->name;
                    $time = Carbon::parse($lession->start_at, $lession->tutor->time_zone)->setTimezone('UTC');
                } else {
                    $sendToId = $lession->student_id;
                    $body = 'Teacher: ' . $lession->tutor->name;
                    $time = Carbon::parse($lession->start_at, $lession->student->time_zone)->setTimezone('UTC');
                }
                $notification = new Notifications();
                $notification->user_id = $sendToId;
                $notification->title = 'Lession ' . ucfirst($request->status);
                $notification->body = $body;
                $notification->notification_time = $time;
                $notification->data = json_encode(['id' => $lession->id, 'type' => 'lession']);;
                $notification->save();
                Fcm::sendNotification($notification);
            }
            $lession = Lession::with(['notes', 'libraries', 'videos', 'tutor', 'times', 'student', 'instrument'])->find($id);
            return response(['status' => true, 'data' => $lession]);
        } catch (Exception $ex) {
            return response()->json(['status' => $ex], 204);
        }
    }

    public function destroy($id)
    {
        //
    }

    public function addNote(Request $request)
    {
        $note = new LessionNotes();
        $note->lession_id = $request->lession_id;
        $note->note = $request->note;
        $note->save();
        return response(['status' => true]);
    }

    public function addVideo(Request $request)
    {
        try {
            LessionVideos::create(['lession_id', $request->lession_id, 'video_url' => $request->video]);
            return response(['status' => true]);
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'error' => $ex->getMessage()], 204);
        }
    }

    public function addMusicSheet(Request $request)
    {
        try {
            if ($request->hasFile('music_sheet')) {
                $file = $request->music_sheet;
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move('documents', $name);
            }
            return response(['status' => true]);
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'error' => $ex->getMessage()], 204);
        }
    }

    public function updateMusicSheets(Request $request)
    {
        $lession = Lession::find($request->lessionId);
        if ($request->has('libraries')) {
            $lession->libraries()->sync($request->libraries);
        }
        return response(['status' => true]);
    }


    public function submitReview(Request $request)
    {
        try {
            $review = new Review();
            $review->lession_id = $request->lession_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->video_rating = $request->video_rating;
            $review->sound_rating = $request->sound_rating;
            if ($request->user()->hasRole('tutor')) {
                $review->rating_from = 'tutor';
            }
            $review->save();
            return $this->update($request, $request->lession_id);
        } catch (Exception $e) {
            return response()->json(['status' => true, 'data' => $e->getMessage()]);
        }
    }
}
