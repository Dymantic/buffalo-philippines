<?php

namespace App\Http\Controllers\Admin\Services;

use App\Products\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolGroupsController extends Controller
{
    public function index(Subcategory $subcategory)
    {
        return $subcategory->toolGroups->map->toJsonableArray();
    }
}
