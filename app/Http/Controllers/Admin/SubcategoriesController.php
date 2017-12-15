<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoriesController extends Controller
{

    public function show(Subcategory $subcategory)
    {
        $category = $subcategory->category;
        return view('admin.subcategories.show', [
            'subcategory' => $subcategory->toJsonableArray(),
            'category' => ['id' => $category->id, 'title' => $category->title]
        ]);
    }

    public function store(Category $category)
    {
        request()->validate(['title' => 'required|max:255']);

        $category->addSubcategory(request()->all('title', 'description'));
    }

    public function update(Subcategory $subcategory)
    {
        request()->validate(['title' => 'required|max:255']);

        $subcategory->update(request()->all('title', 'description'));

        return $subcategory->fresh()->toJsonableArray();
    }

    public function delete(Subcategory $subcategory)
    {
        $subcategory->delete();

        return redirect("/admin/categories/{$subcategory->category_id}");
    }
}
