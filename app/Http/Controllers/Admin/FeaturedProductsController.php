<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturedProductsController extends Controller
{
    public function store()
    {
        request()->validate(['product_id' => 'required|integer|exists:products,id']);

        Product::findOrFail(request('product_id'))->feature();
    }

    public function delete(Product $product)
    {
        $product->demote();
    }
}
