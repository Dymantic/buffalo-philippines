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

        $viewOptions = $this->viewOptions();


        return view('admin.categories.products.index', [
            'category'        => $category,
            'categoryMenu'    => $category->menu(),
            'showType'        => $viewOptions['type'],
            'toolGroup'       => $viewOptions['tool_group'],
            'subcategory'     => $viewOptions['sub'],
            'menuSubcategory' => $viewOptions['menuSubcategory']
        ]);
    }

    private function viewOptions()
    {
        $subcategory = Subcategory::find(request('subcategory'));
        $toolGroup = ToolGroup::find(request('tool-group'));

        if (!$toolGroup && !$subcategory) {
            return [
                'sub'             => ['id' => null, 'title' => '', 'tool_groups' => []],
                'type'            => 'Category',
                'tool_group'      => ['id' => null, 'title' => ''],
                'menuSubcategory' => null
            ];
        }

        if ($subcategory) {
            return [
                'sub'             => [
                    'id'          => $subcategory->id,
                    'title'       => $subcategory->title,
                    'tool_groups' => $subcategory->toolGroups->pluck('id')->all()
                ],
                'type'            => 'Subcategory',
                'tool_group'      => ['id' => null, 'title' => ''],
                'menuSubcategory' => $subcategory->id
            ];
        }

        $sub = $toolGroup->subcategory;

        return [
            'sub'             => [
                'id'          => $sub->id,
                'title'       => $sub->title,
                'tool_groups' => $sub->toolGroups->pluck('id')->all()
            ],
            'type'            => 'Tool Group',
            'tool_group'      => ['id' => $toolGroup->id, 'title' => $toolGroup->title],
            'menuSubcategory' => $sub->id
        ];
    }
}
