<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\User;
use App\Models\DeliveryCharge;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('customer_id', $user->id)->with(['seller', 'details.product.categories'])->get();
        return response()->json($cart);
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
        $product = Product::findOrFail($request->product_id);
        $auth = $request->user();
        $cartData =  Cart::where('seller_id',$product->seller_id)->where('customer_id',$auth->id)->first();
        if(!$cartData){
            $cart = new Cart;
            $cart->seller_id = $product->seller_id;
            $cart->customer_id = $auth->id;
            $cart->save();
            $totalWeight = $request->qty * $product->weight;
            $charges = 0.0;
            $dvCharges = DeliveryCharge::where('seller_id',$product->seller_id)->where('min_weight','>=', $totalWeight) ->where('max_weight','<=',$totalWeight)->first();
            if($dvCharges){
                $charges = $dvCharges->charges;
            }
            $detail = new CartDetail;
            $detail->cart_id = $cart->id;
            $detail->product_id = $product->id;
            $detail->delivery_type = $request->method;
            $detail->qty = $request->qty;
            $detail->charges = $request->charges;
            $detail->save();
        }else{
            $item = CartDetail::where('cart_id', $cartData->id)->where('product_id', $product->id)->first();
            if(!$item){
                $detail = new CartDetail;
                $detail->cart_id = $cartData->id;
                $detail->product_id = $product->id;
                $detail->delivery_type = $request->method;
                $detail->qty = $request->qty;
                $detail->save();
            }else{
                $item->qty = $item->qty + $request->qty;
                $item->save();
            }
            
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
        $cartProduct =  CartDetail::findOrFail($id);

        $qty = 0;
        if($request->qty > 0){
            $qty = $cartProduct->qty + 1;
        }else{
            $qty = $cartProduct->qty - 1;
        }
        if($qty <= 0){
            $cartProduct->delete();
        }else{
            $cartProduct->qty = $qty;
            $cartProduct->save();
        }
        $query = Cart::doesntHave('details')->delete();
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
