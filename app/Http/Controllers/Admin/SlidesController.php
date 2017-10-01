<?php

namespace App\Http\Controllers\Admin;

use Dymantic\Slideshow\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlidesController extends Controller
{
    public function index()
    {
        $slides = Slide::ordered()->get();
        return view('admin.slides.index', ['slides' => $slides]);
    }

    public function show(Slide $slide)
    {
        return view('admin.slides.show', ['slide' => $slide]);
    }
}
