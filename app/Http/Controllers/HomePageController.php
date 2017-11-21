<?php

namespace App\Http\Controllers;

use App\Products\Product;
use Dymantic\Slideshow\Slide;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function show()
    {
        $slides = Slide::where('published', true)->ordered()->get();
        $featured = Product::featured()->take(8)->get();

        return view('front.home.page', [
            'banner_slides' => $slides,
            'featured' => $featured
        ]);
    }
}
