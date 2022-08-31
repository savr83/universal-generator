<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new CategoriesResource(Category::paginate());
        return response()->json($categories);
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
        $category = new Category([
            'parent_id' => $request->get('parent_id') ? $request->get('parent_id') : null,
//          'parent_id' => $request->get('parent_id'),
            'name' => $request->get('name'),
        ]);
        $category->save();
        return new CategoryResource($category);
//        return response()->json('Category Successfully added');

//        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->parent_id = $request->get('parent_id');
        $category->name = $request->get('name');
        $category->save();
        return new CategoryResource($category);

//        return response()->json('Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json('Category Successfully Deleted');
    }
}
