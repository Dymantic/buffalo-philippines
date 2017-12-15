<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Category;
use App\Products\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryProductsController extends Controller
{
    public function index(Category $category, ProductsRepository $productsRepository)
    {
        return $productsRepository->productsUnder($category)->map->toJsonableArray();
    }
}
