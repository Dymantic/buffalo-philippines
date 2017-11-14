<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedProductsController extends Controller
{
    public function store()
    {
        request()->validate(['product_id' => 'required|integer|exists:products,id']);

        Product::findOrFail(request('product_id'))->publish();
    }

    public function delete(Product $product)
    {
        $product->retract();
    }
}
