<?php

namespace App\Http\Controllers\Admin;

use App\Products\Category;
use App\Products\Product;
use App\Products\ProductsRepository;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductSearchController extends Controller
{
    public function index(ProductsRepository $repository)
    {
        $product_count = Product::count();
        $category_count = Category::count();
        $subcategory_count = Subcategory::count();
        $toolgroup_count = ToolGroup::count();

        $products = request('q')
            ? $repository->fullSearch(request('q'))->map->toJsonableArray()
            : [];

        return view('admin.products.search.index', [
            'products'      => $products,
            'search_term'   => request('q', ''),
            'product_count' => $product_count,
            'category_count' => $category_count,
            'subcategory_count' => $subcategory_count,
            'toolgroup_count' => $toolgroup_count,
        ]);
    }
}
