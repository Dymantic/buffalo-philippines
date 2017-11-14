<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductGalleryController extends Controller
{
    public function show(Product $product)
    {
        return view('admin.products.gallery.show', ['product' => $product->toJsonableArray()]);
    }
}
