<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Illuminate\Support\Facades\Auth;

class DeliveryChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = DeliveryCharge::where('seller_id', $user->id)->get();
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
        try {
            
            $validator = Validator::make(
                $request->all(),
                [
                    'min_weight' => 'required|min:1',
                    'max_weight' => 'required|min:1',
                    'charges' => 'required|min:1',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()], 200);
            }
            $charges = new DeliveryCharge;
            $charges->seller_id = $request->user()->id;
            $charges->min_weight = $request->min_weight;
            $charges->max_weight = $request->max_weight;
            $charges->charges = $request->charges;
            $charges->save();
            return $this->index();
        } catch (Exception $e) {
            return response()->json(['status' => true, 'data' => $e->getMessage()]);
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
        try {
            
            $validator = Validator::make(
                $request->all(),
                [
                    'min_weight' => 'required|min:1',
                    'max_weight' => 'required|min:1',
                    'charges' => 'required|min:1',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()], 200);
            }
            $charges = DeliveryCharge::find($id);
            $charges->seller_id = $request->user()->id;
            $charges->min_weight = $request->min_weight;
            $charges->max_weight = $request->max_weight;
            $charges->charges = $request->charges;
            $charges->save();
            return $this->index();
        } catch (Exception $e) {
            return response()->json(['status' => true, 'data' => $e->getMessage()]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeliveryCharge::find($id)->delete();
        return $this->index();
    }
}
