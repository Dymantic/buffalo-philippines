<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(json_decode(file_get_contents(base_path('ex_categories.json')), true))
            ->mapWithKeys(function ($category) {
                return [
                    $category['id'] => \App\Products\Category::create([
                        'title' => $category['title'],
                        'description' => 'A category'
                    ])
                ];
            });

        $subs = collect(json_decode(file_get_contents(base_path('ex_subs.json')), true))
            ->mapWithKeys(function ($sub) use ($categories) {
                return [
                    $sub['id'] => $categories[$sub['category_id']]->addSubcategory([
                        'title' => $sub['title'],
                        'description' => 'A subcategory'
                    ])
                ];
            });

        $groups = collect(json_decode(file_get_contents(base_path('ex_prgs.json')), true))
            ->mapWithKeys(function ($grp) use ($subs) {
                return [
                    $grp['id'] => $subs[$grp['subcategory_id']]->addToolGroup([
                        'title' => $grp['title'],
                        'description' => 'A tool group'
                    ])
                ];
            });

        $products = collect(json_decode(file_get_contents(base_path('extraction.json')), true))
            ->each(function($product) use ($categories, $subs, $groups) {
               $p = \App\Products\Product::create([
                   'title' => $product['title'],
                   'description' => $product['description'],
                   'writeup' => $product['writeup'],
                   'code' => $product['code'],
                   'new_until' => \Illuminate\Support\Carbon::today()
               ]);
               if($product['product_group_id']) {
                   $groups[$product['product_group_id']]->addProduct($p);
               } else if ($product['subcategory_id']) {
                   $subs[$product['subcategory_id']]->addProduct($p);
               } else {
                   $categories[$product['category_id']]->addProduct($p);
               }

               if($product['image_path']) {
                   $p->setMainImage($product['image_path']);
               }
            });

        \App\Products\ToolGroup::all()->each(function($tg) {
            if($tg->products->count() === 0) {
                $tg->delete();
            }
        });

        \App\Products\Subcategory::all()->each(function($sc) {
            if(($sc->toolGroups->count() === 0) && ($sc->products->count() === 0)) {
                $sc->delete();
            }
        });

        \App\Products\Category::all()->each(function($cat) {
            if(($cat->subcategories->count() === 0) && ($cat->products->count() === 0)) {
                $cat->delete();
            }
        });
    }
}
