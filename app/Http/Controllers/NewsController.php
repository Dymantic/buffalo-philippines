<?php

namespace App\Http\Controllers;

use Dymantic\Articles\Article;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $articles = Article::published()->latest()->paginate(10);

        return view('front.news.index', ['articles' => $articles]);
    }

    public function show($slug)
    {
        $article = Article::published()->where('slug', $slug)->firstOrFail();

        return view('front.news.show', ['article' => $article]);
    }
}
