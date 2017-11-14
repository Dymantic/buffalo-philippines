<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryProductsController extends Controller
{
    public function index(Category $category)
    {
        $products = $category->products()->paginate(40);

        return [
            'products' => $products->map(function($product) {
                return $product->toJsonableArray();
            }),
            'total_pages' => $products->lastPage(),
            'current_page' => $products->currentPage()
        ];
    }
}
