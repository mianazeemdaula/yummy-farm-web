<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\MeatProducts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('seller_id', $user->id)->with(['categories'])->get();
        return response()->json(['status' => true, 'data' => $products]);
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
                    'categories' => 'required',
                    'name' => 'required|string|min:4',
                    'bio' => 'required',
                    'price' => 'required',
                    'stock' => 'required',
                    'weight' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()], 200);
            }
            $product = new Product();
            $product->seller_id = $request->user()->id;
            $product->name = $request->name;
            $product->species = $request->species;
            $product->body_part = $request->part;
            $product->pieces = $request->pieces;
            $product->age = $request->age;
            $product->life_style = $request->life_style;
            $product->bio = $request->bio;
            $product->weight = $request->weight;
            $product->price = $request->price;
            $product->vat = $request->price -  ($request->price / 1.21);
            $product->stock = $request->stock;
            $product->delivery_type = $request->delivery_type;
            if($request->has('available_from')){
                $product->available_from = $request->available_from;
            }
            if($request->has('available_to')){
                $product->available_to = $request->available_to;
            }
            if($request->has('delivery_charges')){
                $product->delivery_charges = $request->delivery_charges;
            }
            $product->description = $request->description;
            $product->extra_info = $request->extra_info;
            $product->save();
            if($request->has('category')){
                $product->self_category = $request->category;
                $product->save();
            }else{
                $product->categories()->sync($request->categories);
            }
            return response()->json(['status' => true, 'data' => $product]);
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
                    'categories' => 'required',
                    'name' => 'required|string|min:4',
                    'bio' => 'required',
                    'price' => 'required',
                    'stock' => 'required',
                    'weight' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()], 200);
            }
            $product = Product::find($id);
            $product->name = $request->name;
            $product->species = $request->species;
            $product->body_part = $request->part;
            $product->pieces = $request->pieces;
            $product->age = $request->age;
            $product->life_style = $request->life_style;
            $product->bio = $request->bio;
            $product->weight = $request->weight;
            $product->price = $request->price;
            $product->vat = $request->price -  ($request->price / 1.21);
            $product->stock = $request->stock;
            $product->delivery_type = $request->delivery_type;
            if($request->has('available_from')){
                $product->available_from = $request->available_from;
            }
            if($request->has('available_to')){
                $product->available_to = $request->available_to;
            }
            if($request->has('delivery_charges')){
                $product->delivery_charges = $request->delivery_charges;
            }
            $product->description = $request->description;
            $product->extra_info = $request->extra_info;
            $product->save();
            if($request->has('category')){
                $product->self_category = $request->category;
                $product->save();
            }else{
                $product->categories()->sync($request->categories);
            }
            return response()->json(['status' => true, 'data' => $product]);
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
        Product::find($id)->delete();
        return response()->json(['status' => true, 'data' => 'product deleted']);
    }
}
