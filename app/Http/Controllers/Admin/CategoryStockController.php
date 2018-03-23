<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryStockController extends Controller
{
    public function store(Category $category)
    {
        request()->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::findOrFail(request("product_id"));

        $category->addProduct($product);

        return $product->fresh()->toJsonableArray();
    }
}
