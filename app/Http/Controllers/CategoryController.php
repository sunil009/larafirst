<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        // $data['categories'] = Category::all(); // get all recoard.
        $data['categories'] = Category::paginate(5); // get pagination
        // $data['categories'] = Category::simplePaginate(3); // sinple pagination

        return view('admin.categories.index', $data);
    }

    public function trash() {
        
        $data['categories'] = Category::onlyTrashed()->paginate(5); // get pagination
        // dd($data);
        return view('admin.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $data['categories'] = Category::all();

        return view('admin.categories.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->validate([
            'title' => 'required | min:4',
            'slug'  => 'required | min:4 | unique:categories',
        ]);

        $categories = Category::create($request->only(['title', 'description', 'slug']));
        $categories->childrens()->attach($request->parent_id);

        return redirect()->route('admin.category.index')->with('message', 'Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {

        $data['categories'] = Category::where('id', '!=', $category->id)->get();
        $data['category'] = $category;
        
        return view('admin.categories.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) {

        $request->validate([
            'title' => 'required | min:4',
            'slug'  => 'required | min:4 | unique:categories,slug,'.$request->slug.',slug',
        ]);

        $category->title = $request->title;
        $category->description = $request->description;
        $category->slug = $request->slug;
        // detach all parent category
        $category->childrens()->detach();
        // attach selected parent category
        $category->childrens()->attach($request->parent_id);
        // save current record into DB
        $saved = $category->save();
        // dd($saved);
        
        if($saved) {
            return redirect()->route('admin.category.index')->with('message', 'Record Successfully Updated..!');
        }

        return back()->with('message', 'Record Faild Updated..!');
    }

    public function recoverCat($id) {
        // $category = Category::withTrashed()->findOrFail($id); // Normal and trash record
        $category = Category::onlyTrashed()->findOrFail($id); // Only tresh record
        
        if($category->restore())
            return back()->with('message', 'Category Successfully Restored!');
        else
            return back()->with('message', 'Error Restored Category!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {

        if($category->childrens()->detach() && $category->forceDelete()) {
            return back()->with('message', 'Record Successfully Delete!');
        } else {
            return back()->with('message', 'Error Delete Record!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function remove(Category $category) {

        // dd($category);
        if($category->delete()) {
            return back()->with('message', 'Record Successfully Trashed!');
        } else {
            return back()->with('message', 'Error Trashed Record!');
        }
    }
}
