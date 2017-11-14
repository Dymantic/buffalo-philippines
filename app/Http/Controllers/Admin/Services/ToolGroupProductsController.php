<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolGroupProductsController extends Controller
{
    public function index(ToolGroup $toolGroup)
    {
        $products = $toolGroup->products()->paginate(40);

        return [
            'products' => $products->map(function($product) {
                return $product->toJsonableArray();
            }),
            'total_pages' => $products->lastPage(),
            'current_page' => $products->currentPage()
        ];
    }
}
