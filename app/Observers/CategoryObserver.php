<?php


namespace App\Observers;


use App\Products\Category;

class CategoryObserver
{
    public function deleting(Category $category)
    {
        $category->subcategories->each->delete();
    }
}