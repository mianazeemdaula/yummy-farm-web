<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = User::withAndWhereHas('libraries', function($q) use($user) {
            $q->where('is_lession', 1);
            $q->orWhere('student_id', $user->id);
        })->get();
        return response()->json(['status' => true, 'data' => $data]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'doc' => 'required|mimes:pdf',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        } else {
            $fileName = '';
            if($request->hasFile('doc')){
                $file = $request->doc;
                $name = time().'.'.$file->getClientOriginalExtension();
                $file->move('documents',$name);
                $fileName = 'documents/'.$name;
            }
            $lib = new Library();
            $lib->student_id = $request->user()->id;
            $lib->title = $request->title;
            $lib->is_lession = $request->has('is_lession') ?  $request->is_lession : false;
            $lib->doc = $fileName;
            $lib->save();
            $data = User::has('libraries')->with('libraries')->get();
            return response()->json(['status' => true, 'data' => $data]);
        }
    }
    public function show($id)
    {
        $data = Library::where('student_id', Auth::user()->id)->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $data =  Library::find($id)->delete();
        return response()->json(['status' => $data]);
    }
}
