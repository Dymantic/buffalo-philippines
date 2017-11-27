<?php

namespace App\Http\Controllers\Services;

use App\Products\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RelatedProductsController extends Controller
{
    public function index($slug, ProductsRepository $productsRepository)
    {
        return $productsRepository->productsRelatedTo($slug)->map->toJsonableArray();
    }
}
