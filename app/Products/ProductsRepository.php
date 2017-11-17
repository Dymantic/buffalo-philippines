<?php


namespace App\Products;


class ProductsRepository
{
    public static function productsForCategory($category)
    {
        $category_products = $category->products;
        $subcategory_products = $category->subcategories->flatMap(function ($subcategory) {
            return $subcategory->products;
        });
        $tool_group_products = $category->subcategories
            ->flatMap(function ($subcategory) {
                return $subcategory->toolGroups;
            })->flatMap(function ($toolGroup) {
                return $toolGroup->products;
            });

        return $category_products->merge($subcategory_products)->merge($tool_group_products);
    }
}