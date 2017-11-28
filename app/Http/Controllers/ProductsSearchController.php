<?php

namespace App\Http\Controllers;

use App\Products\ProductsRepository;
use Illuminate\Http\Request;

class ProductsSearchController extends Controller
{
    public function index(ProductsRepository $repository)
    {
        $products = $repository->searchByName(request('q'))->filter(function($product) {
            return $product->published;
        });

        return view('front.products.search', ['products' => $products, 'search_term' => request('q')]);
    }
}
