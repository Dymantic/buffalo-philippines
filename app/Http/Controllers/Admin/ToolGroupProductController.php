<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductForm;
use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolGroupProductController extends Controller
{
    public function store(ToolGroup $toolGroup, ProductForm $form)
    {
        $toolGroup->createProduct($form->fields());
    }
}
