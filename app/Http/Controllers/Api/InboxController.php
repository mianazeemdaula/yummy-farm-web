<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Fcm;
use App\Http\Controllers\Controller;
use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InboxController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data =  Inbox::where('tutor_id', $user->id)->orWhere('student_id', $user->id)->with(['student','tutor'])->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|integer',
            'tutor_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        } else {
            $inbox = new Inbox();
            $inbox->student_id = $request->student_id;
            $inbox->tutor_id = $request->tutor;
            $inbox->save();
            return response()->json(['status' => true, 'data' => $inbox]);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $data =  Inbox::where([
            ['tutor_id','=',$id],
            ['student_id','=',$user->id],
        ])->OrWhere([
            ['tutor_id','=',$user->id],
            ['student_id','=',$id],
        ])->with(['student', 'tutor'])->first();
        if (!$data) {
            $inbox = new Inbox();
            $inbox->student_id = $user->id;
            $inbox->tutor_id = $id;
            $inbox->save();
            $inbox = Inbox::with(['student','tutor'])->where('id',$inbox->id)->first();
            return response()->json(['status' => true, 'data' => $inbox]);
        }
        $data->is_read = true;
        $data->save();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $inbox = Inbox::find($id);
        $inbox->last_message = $request->message;
        $inbox->save();
        return $this->index();
    }

}
