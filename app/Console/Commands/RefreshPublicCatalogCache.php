<?php

namespace App\Console\Commands;

use App\Products\Category;
use App\Products\ProductsRepository;
use Illuminate\Console\Command;

class RefreshPublicCatalogCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'catalog:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the public catalog for each product category';
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        parent::__construct();

        $this->productsRepository = $productsRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Category::all()->each(function($category) {
           cache()->forget($category->slug);
           $this->productsRepository->publicCatalogForCategory($category);
        });
    }
}
