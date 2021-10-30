<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TutorTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TutorTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = TutorTime::where('user_id', $user->id)->whereDate('from_time', '>=' ,Carbon::now())->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'end' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        }
        $user = $request->user();
        $fromDateTime = Carbon::parse($request->start, auth()->user()->time_zone)->setTimezone('UTC');
        $toDateTime = Carbon::parse($request->end, auth()->user()->time_zone)->setTimezone('UTC');
        $time = TutorTime::where('user_id', $user->id)->where('from_time', $fromDateTime)->first();
        if($time == null){
            $time = new TutorTime();
            $time->user_id = $user->id;
            $time->from_time = $fromDateTime;
            $time->to_time = $toDateTime;
            $time->save();
            return $this->index();;
        }else{
            $time->delete();
            return $this->index();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required',
            'end' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        }
        $time = TutorTime::find($id);
        $time->from_time = $request->start;
        $time->to_time = $request->end;
        $time->save();
        return response()->json(['status' => true, 'data' => $time]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TutorTime::find($id)->delete();
        return $this->index();
    }
}
