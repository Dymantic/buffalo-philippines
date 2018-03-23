<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryStockController extends Controller
{
    public function store(Subcategory $subcategory)
    {
        request()->validate([
            'product_id' => ['required', 'exists:products,id']
        ]);

        $product = Product::findOrFail(request("product_id"));

        $product = $subcategory->addProduct($product);

        return $product->toJsonableArray();
    }

    public function delete(Subcategory $subcategory, Product $product)
    {
        $product = $subcategory->removeProduct($product);

        return $product->toJsonableArray();
    }
}
