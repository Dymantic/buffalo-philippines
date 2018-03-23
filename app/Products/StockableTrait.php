<?php


namespace App\Products;


use Illuminate\Support\Carbon;

trait StockableTrait
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

        return $product->fresh();
    }

    public function removeProduct(Product $product)
    {
        $this->products()->detach($product);

        return $product->fresh();
    }

    public function heritage()
    {

        return [
            'id' => $this->id,
            'type' => class_basename($this),
            'title' => $this->title,
            'parent' => $this->parent() ? $this->parent()->heritage() : null
        ];
    }
}