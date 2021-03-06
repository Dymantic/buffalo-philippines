<?php

namespace App\Http\Controllers\Services;

use App\Products\Category;
use App\Products\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoryProductsController extends Controller
{
    public function index($slug, ProductsRepository $productsRepository)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return $productsRepository->publicCatalogForCategory($category);
    }
}
