<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = Order::with(['details.product', 'seller', 'customer']);
        if ($user->role== 'seller') {
            $data->where('seller_id', $user->id);
        } else if ($user->role == 'customer') {
            $data->where('customer_id', $user->id);
        }
        $data = $data->orderBy('id','desc')->get();
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
        $user = $request->user();
        if($user->role == 'customer'){
            $carts = Cart::where('customer_id',$user->id)->get();
            $detailsIds = [];
            foreach($carts as $cart){
                $orderCount = Order::where('seller_id', $cart->seller_id)->count();
                $orderCount = sprintf('%04d', ($orderCount + 1));
                $order = new Order;
                $order->number = date("y").$cart->seller->seller_number.$orderCount;
                $order->seller_id = $cart->seller_id;
                $order->customer_id = $user->id;
                // $order->delivery_address = 'address';
                $order->save();

                foreach($cart->details as $detail){
                    $item = new OrderDetail;
                    $item->order_id = $order->id;
                    $item->product_id = $detail->product_id;
                    $item->qty = $detail->qty;
                    $item->delivery_type = $detail->delivery_type;
                    $item->delivery_charges = $detail->charges;
                    $item->price = $detail->product->price;
                    $item->save();
                    $detailsIds[] = $detail->id;
                    $detail->product()->update(['stock' => $detail->product->stock - $detail->qty]);
                }
                Mail::to($cart->seller_id)->send(new \App\Mail\OrderGenerated($order));
            }
            Cart::whereIn('id', $carts->pluck('id'))->delete();
            CartDetail::whereIn('id', $detailsIds)->delete();
            return response()->json(['status' => true, 'data' => 'assigned']);
        }else{
            return response()->json(['status' => false, 'data' => 'You are not authorized']);
        }
        return $this->index();
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
        $orders = Order::whereIn('id',$request->ids)->update(['status' => 'delivered']);
        return $this->index();
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
}
