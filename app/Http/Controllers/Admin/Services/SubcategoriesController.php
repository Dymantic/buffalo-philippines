<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoriesController extends Controller
{
    public function index(Category $category)
    {
        return $category->subcategories->map->toJsonableArray();
    }
}
