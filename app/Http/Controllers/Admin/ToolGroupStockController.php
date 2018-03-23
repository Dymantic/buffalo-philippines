<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolGroupStockController extends Controller
{
    public function store(ToolGroup $toolgroup)
    {
        request()->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::findOrFail(request("product_id"));

        $product = $toolgroup->addProduct($product);

        return $product->toJsonableArray();
    }

    public function delete(ToolGroup $toolgroup, Product $product)
    {
        $product = $toolgroup->removeProduct($product);

        return $product->toJsonableArray();
    }
}
