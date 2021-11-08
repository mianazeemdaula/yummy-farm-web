<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
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
        try {
            
            $validator = Validator::make(
                $request->all(),
                [
                    'product_category_id' => 'required|email|string',
                    'name' => 'required|string|min:4',
                    'species' => 'required|string',
                    'kind' => 'required|string',
                    'bio' => 'required',
                    'price_incl_vat' => 'required',
                    'price_excl_vat' => 'required',
                    'stock' => 'required',
                    'weight' => 'required',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['required' => $validator->errors()], 200);
            }
            $product = new Product();
            $product->product_category_id = $request->category_id;
            $product->seller_id = $request->user()->id;
            $product->name = $request->name;
            $product->species = $request->species;
            $product->kind = $request->kind;
            $product->bio = $request->bio;
            $product->price_incl_vat = $request->price_incl_vat;
            $product->price_excl_vat = $request->price_excl_vat;
            $product->delivery_charges = $request->delivery_charges;
            $product->stock = $request->stock;
            $product->weight = $request->weight;
            $product->detail = $request->detail;
            $product->save();
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
}
