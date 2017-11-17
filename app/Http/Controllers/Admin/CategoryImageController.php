<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryImageController extends Controller
{
    public function store(Category $category)
    {
        request()->validate(['image' => 'required|image']);

        $category->setImage(request('image'));
    }

    public function delete(Category $category)
    {
        $category->clearImage();
    }
}
