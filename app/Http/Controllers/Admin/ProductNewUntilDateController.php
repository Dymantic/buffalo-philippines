<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductNewUntilDateController extends Controller
{
    public function update(Product $product)
    {
        request()->validate(['add_days' => 'required|integer']);

        $product->addDaysToNewUntil(request('add_days'));

        return [
            'product_id' => $product->id,
            'is_new'     => $product->fresh()->isNew(),
            'new_until'  => $product->fresh()->new_until->format('Y-m-d')
        ];
    }
}
