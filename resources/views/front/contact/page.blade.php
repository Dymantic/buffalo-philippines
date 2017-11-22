@extends('front.base')

@section('content')
    <header class="banner-heading mesh-bg col-w-bg bb bw2 mb4 h4 flex items-center justify-center tc">
        <h1 class="strong-type f1">Contact Us</h1>
    </header>
    <section class="mw6 center-ns mh3">
        <p class="f4 f3-ns tc mv5">Leave a message and we will happily get back to you as soon a possible.</p>
        <contact-form url="/contact" button-text=""></contact-form>
    </section>

@endsection