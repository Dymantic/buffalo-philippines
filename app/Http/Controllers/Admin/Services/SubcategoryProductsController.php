<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryProductsController extends Controller
{
    public function index(Subcategory $subcategory)
    {
        $products = $subcategory->products()->paginate(40);

        return [
            'products' => $products->map(function($product) {
                return $product->toJsonableArray();
            }),
            'total_pages' => $products->lastPage(),
            'current_page' => $products->currentPage()
        ];
    }
}
