<?php

namespace App\Http\Controllers\Admin;

use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedSubcategoriesController extends Controller
{
    public function store()
    {
        request()->validate(['subcategory_id' => 'required|integer|exists:subcategories,id']);

        Subcategory::findOrFail(request('subcategory_id'))->publish();
    }

    public function delete(Subcategory $subcategory)
    {
        $subcategory->retract();
    }
}
