<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductMainImageController extends Controller
{
    public function store(Product $product)
    {
        request()->validate(['image' => 'required|image']);

        $product->setMainImage(request('image'));
    }

    public function delete(Product $product)
    {
        $product->clearMainImage();
    }
}
