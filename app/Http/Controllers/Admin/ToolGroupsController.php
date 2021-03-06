<?php

namespace App\Http\Controllers\Admin;

use App\Products\Subcategory;
use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToolGroupsController extends Controller
{

    public function show(ToolGroup $toolGroup)
    {
        $toolGroup->load('subcategory.category');
        $subcategory = $toolGroup->subcategory;
        $category = $subcategory->category;
        $product_count = $toolGroup->descendants()->count();

        return view('admin.tool-groups.show', [
            'tool_group' => $toolGroup->toJsonableArray(),
            'category' => ['id' => $category->id, 'title' => $category->title],
            'subcategory' => ['id' => $subcategory->id, 'title' => $subcategory->title],
            'product_count' => $product_count
        ]);
    }

    public function store(Subcategory $subcategory)
    {
        request()->validate(['title' => 'required|max:255']);

        $subcategory->addToolGroup(request()->all('title', 'description'));
    }

    public function update(ToolGroup $toolGroup)
    {
        request()->validate(['title' =>'required|max:255']);

        $toolGroup->update(request()->all('title', 'description'));

        return $toolGroup->fresh()->toJsonableArray();
    }

    public function delete(ToolGroup $toolGroup)
    {
        $toolGroup->delete();

        return redirect("/admin/subcategories/{$toolGroup->subcategory_id}");
    }
}
