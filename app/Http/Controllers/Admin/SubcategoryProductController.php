<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductForm;
use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubcategoryProductController extends Controller
{
    public function store(Subcategory $subcategory, ProductForm $form)
    {
        $subcategory->createProduct($form->fields());
    }
}
