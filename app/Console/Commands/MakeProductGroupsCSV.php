<?php

namespace App\Console\Commands;

use App\Products\Category;
use Illuminate\Console\Command;

class MakeProductGroupsCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a csv file of product groupings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csv = Category::all()->flatMap(function($cat) {
            $list = collect([]);
            //add category title
            $list->push($cat->title);
            //add direct category products
            $cat->products->each(function($p) use ($list) {
                $list->push(",{$p->code},{$p->title}");
            });
            //add subcategories
            $cat->subcategories->each(function($subcat) use ($list) {
                $list->push("{$subcat->category->title} >> {$subcat->title}");

                $subcat->products->each(function($p) use ($list) {
                    $list->push(",{$p->code},{$p->title}");
                });

                $subcat->toolGroups->each(function($tg) use ($list) {
                    $list->push("{$tg->subcategory->category->title} >> {$tg->subcategory->title} >> {$tg->title}");

                    $tg->products->each(function($p) use ($list) {
                        $list->push(",{$p->code},{$p->title}");
                    });
                });
            });
            return $list;
        });

        file_put_contents(base_path('products.csv'), implode("\n", $csv->all()));
    }
}
