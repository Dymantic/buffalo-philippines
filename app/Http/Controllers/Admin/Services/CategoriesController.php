<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        return Category::all()->map->toJsonableArray();
    }
}
