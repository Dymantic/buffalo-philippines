@extends('front.base', ['pageName' => ''])

@section('title')
    Buffalo Tools Philippines - Our Story
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Buffalo Tools Philippines - Our Story',
        'ogImage' => url('/images/facebook_og.jpg'),
        'ogDescription' => 'With a history spanning decades, we at Buffalo Tools know what we are doing. That\'s how we can bring you the best tools for the job, every time.'
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">About Buffalo</h1>
    </header>
    <div>
        <p class="ff-body tc mv5 lh-copy measure-ultra ph4 center">Buffalo® is a tool supplier established in 1964 in the United States during the industrial progress of the 20th century. Buffalo® believes the industrial progression would not have been possible without the hard work of its technicians. </p>
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
    <p class="ff-body tc mv5 lh-copy measure-ultra ph4 center">Buffalo® values and believes technicians play an essential role throughout the development of our society. For this reason, Buffalo® is dedicated to continually bringing high quality tools to serve the particular needs of all technicians, who hope to improve the efficiency and quality of their daily work.</p>
    <p class="ff-body tc mv5 lh-copy measure-ultra ph4 center">Buffalo® provides customers a long-lasting and trustworthy product with consistent innovation and improvements. Buffalo®’s products manifest the spirit of each worker, our tools play an important role in every craftsman’s daily working life just as craftsman are to our society.</p>
@endsection