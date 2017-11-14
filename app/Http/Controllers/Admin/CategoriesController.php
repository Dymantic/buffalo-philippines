<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    public function index()
    {
        return view('admin.categories.index');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', ['category' => $category]);
    }

    public function store()
    {
        request()->validate(['title' => 'required|max:255']);

        Category::create(request()->all());
    }

    public function update(Category $category)
    {
        request()->validate(['title' => 'required|max:255']);

        $category->update(request()->all('title', 'description'));

        return $category->fresh()->toJsonableArray();
    }

    public function delete(Category $category)
    {
        $category->delete();

        return redirect("/admin/categories");
    }
}
