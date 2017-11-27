<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSearchController extends Controller
{
    public function index(ProductsRepository $repository)
    {
        return $repository->fullSearch(request('q'))->map->toJsonableArray();
    }
}
