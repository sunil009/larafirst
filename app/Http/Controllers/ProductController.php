<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\StoreProduct;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use App\Cart;
use Session;

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

    public function trash() {
        
        $data['products'] = Product::onlyTrashed()->paginate(3); // get pagination
        // dd($data);
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
     
        $path = 'public/images/no-thumbnail.jpeg';
        
        if($request->has('thumbnail')){
            
            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(), $extension).time().$extension;
            $name = strtolower(str_replace(" ", "-", $name));

            $path = $request->thumbnail->storeAs('public/uploads/', $name);
        }

        $product = Product::create([
            'title'       => $request->title,
            'slug'        => $request->slug,
            'description' => $request->description,
            'price'       => $request->price,
            'discount_price' => isset($request->discount_price) ? $request->discount_price : 0,
            'discount'    => isset($request->discount) ? $request->discount : 0,
            'options' => isset($request->extras) ? json_encode($request->extras) : null,
            'thumbnail' => $path,
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

        dd(Session::get('cart'));   
        $data['products'] = Product::paginate(3);
        $data['categories'] = Category::with('childrens')->get();

        return view('products.all', $data);
    }

    public function single(Product $product) {

        return view('products.single', compact('product'));
    }

    public function addToCart(Product $product, Request $request) {
    
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $qty = $request->qty ? $request->qty : 1;
        $cart = new Cart($oldCart);
        $cart->addProduct($product, $qty);
        Session::put('cart', $cart);
        return back()->with('message', "Product $product->title had been successfully added to Cart.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {

        $categories = Category::all();

        // $categories = Category::with('childrens')->get();
        return view('admin.products.create',compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product) {

        if($request->has('thumbnail')) {    

            $extension = ".".$request->thumbnail->getClientOriginalExtension();
            $name = basename($request->thumbnail->getClientOriginalName(), $extension).time().$extension;
            $name = strtolower(str_replace(" ", "-", $name));

            $path = $request->thumbnail->storeAs('public/uploads/', $name);

            Storage::delete($product->thumbnail);

            $product->thumbnail = $path;
        }

        $product->title = $request->title;
        // $product->slug = $request->slug;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->featured = isset($request->featured) ? $request->featured : 0;
        $product->price = $request->price;
        $product->discount = isset($request->discount) ? $request->discount : 0;
        $product->discount_price = isset($request->discount_price) ? $request->discount_price : 0;
        // $product->options = isset($request->extras) ? json_encode($request->extras) : null;
        $product->categories()->detach();

        if($product->save()) {

            $product->categories()->attach($request->category_id);
            return back()->with('message', 'Product Successfully Updated.');
        } else {

            return back()->with('message', 'Error Updateing Product!');
        }
    }

    public function recoverProduct($id) {
        // $product = Product::withTrashed()->findOrFail($id); // Normal and trash record
        $product = Product::onlyTrashed()->findOrFail($id); // Only tresh record
        
        if($product->restore())
            return back()->with('message', 'Product Successfully Restored!');
        else
            return back()->with('message', 'Error Restored Product!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {

        if($product->categories()->detach() && $product->forceDelete()){
        
            Storage::delete($product->thumbnail);
            return back()->with('message','Product Successfully Deleted!');
        } else {

            return back()->with('message','Error Deleting Product');
        }
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
