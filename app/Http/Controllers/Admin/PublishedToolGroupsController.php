<?php

namespace App\Http\Controllers\Admin;

use App\Products\ToolGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedToolGroupsController extends Controller
{
    public function store()
    {
        request()->validate(['tool_group_id' => 'required|integer|exists:tool_groups,id']);

        ToolGroup::findOrFail(request('tool_group_id'))->publish();
    }

    public function delete(ToolGroup $toolGroup)
    {
        $toolGroup->retract();
    }
}
