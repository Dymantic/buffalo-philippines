<?php


namespace App\Products;


use Illuminate\Support\Carbon;

trait Stockable
{

    public function products()
    {
        return $this->morphToMany(Product::class, 'stockable');
    }

    public function createProduct($product_attributes)
    {
        return $this->products()->create(array_merge($product_attributes, ['new_until' => Carbon::today()->addMonth()]));
    }

    /**
     *@test
     */
    public function addProduct(Product $product)
    {
        $this->products()->attach($product);
    }
}