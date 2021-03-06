<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductForm;
use App\Products\Category;
use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    public function show(Product $product)
    {
        $categoryList = Category::completeList();

        return view('admin.products.show', [
            'product' => $product->toJsonableArray(),
            'categoryList' => $categoryList
        ]);
    }

    public function update(Product $product, ProductForm $form)
    {
        $product->update($form->fields());

        return $product->fresh()->toJsonableArray();
    }

    public function delete(Product $product)
    {
        $product->delete();

        return redirect('/admin/categories');
    }
}
