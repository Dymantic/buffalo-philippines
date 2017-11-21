<?php

namespace App\Http\Controllers;

use App\Products\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::published()->get();

        return view('front.categories.page', ['categories' => $categories]);
    }

    public function show($slug)
    {
        $category = Category::published()->where('slug', $slug)->first();

        return view('front.categories.show', [
            'category' => $category,
            'categoryMenu' => $category->menu(),
            'slug' => $slug
        ]);
    }
}
