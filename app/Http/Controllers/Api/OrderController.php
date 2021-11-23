<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

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
        $data = [];
        if ($user->role== 'seller') {
            $data = Order::where('seller_id', $user->id)->with(['details.product', 'seller', 'customer'])->get();
        } else if ($user->role == 'customer') {
            $data = Order::where('customer_id', $user->id)->with(['details.product', 'seller', 'customer'])->get();
        }
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
            foreach($carts as $cart){
                $orderCount = Order::where('seller_id', $cart->seller_id)->count();
                $orderCount = sprintf('%04d', ($orderCount + 1));
                $order = new Order;
                $order->number = date("y").$cart->seller->seller_number.$orderCount;
                $order->seller_id = $cart->seller_id;
                $order->customer_id = $user->id;
                $order->delivery_address = 'address';
                $order->save();

                foreach($cart->details as $detail){
                    $item = new OrderDetail;
                    $item->order_id = $order->id;
                    $item->product_id = $detail->product_id;
                    $item->qty = $detail->qty;
                    $item->price = $detail->product->price;
                    $item->save();
                }
            }
            $carts->delete();
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
