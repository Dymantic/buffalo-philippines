<?php

namespace App\Http\Controllers\Admin;

use App\Products\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSearchController extends Controller
{
    public function index(ProductsRepository $repository)
    {
        $products = request('q') ? $repository->fullSearch(request('q'))->map->toJsonableArray() : [];
        return view('admin.products.search.index', ['products' => $products, 'search_term' => request('q', '')]);
    }
}
