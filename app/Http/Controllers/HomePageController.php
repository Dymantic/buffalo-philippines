<?php

namespace App\Http\Controllers;

use App\Products\Product;
use Dymantic\Articles\Article;
use Dymantic\Slideshow\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomePageController extends Controller
{
    public function show()
    {
        $slides = Slide::where('published', true)->ordered()->get();
        $featured = Product::featured()->take(8)->get();
        $articles = Article::where('is_draft', false)->where('published_on', '<=' ,Carbon::today())->take(4)->get();

        return view('front.home.page', [
            'banner_slides' => $slides,
            'featured' => $featured,
            'articles' => $articles
        ]);
    }
}
