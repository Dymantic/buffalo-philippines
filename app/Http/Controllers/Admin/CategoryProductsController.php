<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductForm;
use App\Products\Category;
use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryProductsController extends Controller
{
    public function store(Category $category, ProductForm $form)
    {
        $category->createProduct($form->fields());
    }

    public function index(Category $category)
    {
        return view('admin.categories.products.index', [
            'category'        => $category,
            'categoryMenu'    => $category->completeMenu(),
        ]);
    }
}
