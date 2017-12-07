@extends('front.base')

@section('content')
    <header class="banner-heading mesh-bg col-w-bg bb bw2 mb4 flex items-center justify-center tc">
        <h1 class="ff-headline">Contact Us</h1>
    </header>
    <section class="mw6 center-ns mh3">
        <p class="ff-body tc mv5 lh-copy">Leave a message and we will get back to you as soon a possible.</p>
        <contact-form url="/contact" button-text=""></contact-form>
    </section>

@endsection