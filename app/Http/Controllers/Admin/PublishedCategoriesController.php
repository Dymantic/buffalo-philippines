<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedCategoriesController extends Controller
{
    public function store()
    {
        request()->validate(['category_id' => 'required|integer|exists:categories,id']);

        Category::findOrFail(request('category_id'))->publish();
    }

    public function delete(Category $category)
    {
        $category->retract();
    }
}
