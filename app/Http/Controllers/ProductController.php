<?php

namespace App\Http\Controllers;

use App\Product;
// use App\Http\Requests\StoreProduct;
use App\Http\Requests\StoreProduct;
use Illuminate\Http\Request;
use App\Category;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $data['products'] = Product::paginate(3);
        
        return view('admin.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
        $data['categories'] = Category::with('childrens')->get();
        return view('admin.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request) {

        // dd($request->featured);

        $extension = ".".$request->thumbnail->getClientOriginalExtension();
        $name = basename($request->thumbnail->getClientOriginalName(), $extension).time().$extension;
        $name = strtolower(str_replace(" ", "-", $name));

        $path = $request->thumbnail->move(public_path('images'), $name);
        // dd($path);

        $product = Product::create([
            'title'       => $request->title,
            'slug'        => $request->slug,
            'description' => $request->description,
            'price'       => $request->price,
            'discount_price' => isset($request->discount_price) ? $request->discount_price : 0,
            'discount'    => isset($request->discount) ? $request->discount : 0,
            'thumbnail' => $name,
            'featured'  => isset($request->featured) ? $request->featured : 0,
            'status'    => $request->status,
        ]);

        if($product) {

            $product->categories()->attach($request->category_id);
            return back()->with('message', 'Product Successfully Added.');
            
        } else {

            return back()->with('message', 'Error Instrting Product!');
        }

        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product) {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function remove(Product $product) {

        // dd($product);
        if($product->delete()) {
            return back()->with('message', 'Record Successfully Trashed!');
        } else {
            return back()->with('message', 'Error Trashed Record!');
        }
    }
}
