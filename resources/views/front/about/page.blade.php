@extends('front.base', ['pageName' => ''])

@section('content')
    <header class="banner-heading mesh-bg bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">About Buffalo</h1>
    </header>
    <div>
        <p class="ff-body tc mv5 lh-copy measure-ultra ph4 center">Buffalo® was established in 1964 in the United States during the industrial progress of the 20th century with the intention of bringing high quality tools and related products to customers. Buffalo® believes that good tools can heighten a workers professional performance and improve the quality of their daily work.</p>
    </div>
    <div class="flex justify-between measure-wide ph2 center-ns timeline">
        <div class="history-point">
            <img class="center db" src="/images/logos/1964_logo.png" width="75" height="75"
             alt="Buffalo Tools logo from 1964">
            <p class="tc b">1964</p>
        </div>
        <div class="history-point">
            <img class="center db" src="/images/logos/1974_logo.png" width="75" height="75"
             alt="Buffalo Tools logo from 1964">
            <p class="tc b">1974</p>
        </div>
        <div class="history-point">
            <img class="center db" src="/images/logos/1984_logo.png" width="75" height="75"
             alt="Buffalo Tools logo from 1964">
            <p class="tc b">1984</p>
        </div>
        <div class="history-point">
            <img class="center db" src="/images/logos/navbar.png" width="57" height="75"
             alt="Current Buffalo Tools logo">
            <p class="tc b">1990 - now</p>
        </div>
    </div>
@endsection