<?php

namespace App\Http\Controllers\Admin;

use App\Products\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\Models\Media;

class ProductGalleryImagesController extends Controller
{
    public function store(Product $product)
    {
        request()->validate(['image' => 'required|image']);

        $image = $product->addGalleryImage(request('image'));

        return [
            'image_id' => $image->id,
            'delete_url' => '/admin/gallery-images/' . $image->id
        ];
    }

    public function delete(Media $image)
    {
        $image->delete();
    }
}
