<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products = new Product([
            'vendor_id' => $request->get('vendor_id') ? $request->get('vendor_id') : null,
            'dealer_id' => $request->get('dealer_id') ? $request->get('dealer_id') : null,
            'category_id' => $request->get('category_id') ? $request->get('category_id') : null,
            'price' => $request->get('price') ? $request->get('price') : null,
            'name' => $request->get('name'),
            'width' => $request->get('width'),
            'height' => $request->get('height'),
            'depth' => $request->get('depth'),
            'weight' => $request->get('weight'),
            'quantity' => $request->get('quantity'),
        ]);
        $products->save();
        return response()->json('Product Successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->vendor_id = $request->get('vendor_id');
        $product->dealer_id = $request->get('dealer_id');
        $product->category_id = $request->get('category_id');
        $product->price = $request->get('price');
        $product->name = $request->get('name');
        $product->width = $request->get('width');
        $product->height = $request->get('height');
        $product->depth = $request->get('depth');
        $product->weight = $request->get('weight');
        $product->quantity = $request->get('quantity');
        $product->save();

        return response()->json('Product Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json('Product Successfully Deleted');
    }
}
