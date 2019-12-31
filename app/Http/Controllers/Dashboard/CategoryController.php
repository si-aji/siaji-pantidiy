<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return view('content.dashboard.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_title' => ['required', 'string', 'max:255', 'unique:sa_category,category_title'],
            'category_slug' => ['required', 'string', 'max:255', 'unique:sa_category,category_slug'],
            'category_description' => ['nullable', 'string', 'max:255'],
        ]);

        $category = new Category;
        $category->category_title = $request->category_title;
        $category->category_slug = $request->category_slug;
        $category->category_description = $request->category_description;
        $category->save();

        return redirect()->route('dashboard.category.index')->with([
            'action' => 'Store',
            'message' => 'Category successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $id (Slug)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('category_slug', $id)->firstOrFail();
        return view('content.dashboard.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $id (Slug)
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('category_slug', $id)->firstOrFail();
        return view('content.dashboard.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $id (Slug)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::where('category_slug', $id)->firstOrFail();
        $request->validate([
            'category_title' => ['required', 'string', 'max:255', 'unique:sa_category,category_title,'.$category->id],
            'category_slug' => ['required', 'string', 'max:255', 'unique:sa_category,category_slug,'.$category->id],
            'category_description' => ['nullable', 'string', 'max:255'],
        ]);

        $category->category_title = $request->category_title;
        $category->category_slug = $request->category_slug;
        $category->category_description = $request->category_description;
        $category->save();

        return redirect()->route('dashboard.category.index')->with([
            'action' => 'Update',
            'message' => 'Category successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $id (Slug)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
