<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instrument;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use App\Models\Lession;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $data['user'] = $user;
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if($user->hasRole('tutor')){
            $user = $user->getTutor($user->id);
        }
        $data['user'] = $user;
        $data['instruments'] = Instrument::with(['category'])->get();
        $data['languages'] = Language::all();
        return response()->json(['status' => true, 'data' => $data]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function teachingHours()
    {
        $user = Auth::user();
        $data['hours'] = $user->tutorToughtHours;
        $data['lessions'] = Lession::join('lession_logs','lession_logs.lession_id', '=', 'lessions.id')
        ->join('users','lessions.student_id', '=', 'users.id')
        ->groupBy('lessions.id','users.name','lessions.start_at')
        ->where('lessions.tutor_id', $user->id)
        ->get(['lessions.id','users.name','lessions.start_at',DB::raw('SUM(TIMESTAMPDIFF(MINUTE,start_time,end_time) / 60) as value')]);
        return response()->json(['status' => true, 'data' => $data]);
    }
}
