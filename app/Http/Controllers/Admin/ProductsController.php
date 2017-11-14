<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductForm;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product->toJsonableArray()]);
    }

    public function update(Product $product, ProductForm $form)
    {
        $product->update($form->fields());

        return $product->fresh()->toJsonableArray();
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
