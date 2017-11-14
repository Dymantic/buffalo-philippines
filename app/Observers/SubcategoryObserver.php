<?php

namespace App\Observers;

use App\Products\Subcategory;

class SubcategoryObserver
{
    public function deleting(Subcategory $subcategory)
    {
        $subcategory->toolGroups->each->delete();
    }
}