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
        $query = Inbox::query();
        if($user->role == 'seller'){
            $query->where('seller_id', $user->id);
        }else{
            $query->where('customer_id', $user->id);
        }
        $data = $query->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|integer',
            'customer_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        } else {
            $query = Inbox::where('seller_id',$request->seller_id)->where('customer_id', $request->customer_id)->first();
            if(!$query){
                $inbox = new Inbox();
                $inbox->customer_id = $request->customer_id;
                $inbox->seller_id = $request->seller_id;
                $inbox->save();
                return response()->json(['status' => true, 'data' => $inbox]);
            }
            return response()->json(['status' => true, 'data' => $query]);
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $inbox =  Inbox::with(['seller','customer'])->where('id',$id)->first();
        $inbox->is_read = true;
        $inbox->save();
        return response()->json(['status' => true, 'data' => $inbox]);
    }

    public function update(Request $request, $id)
    {
        $inbox = Inbox::find($id);
        $inbox->last_message = $request->message;
        $inbox->save();
        return $this->index();
    }

}
