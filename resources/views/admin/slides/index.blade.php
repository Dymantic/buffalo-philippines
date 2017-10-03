@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Slides</h1>
        <div class="flex justify-end items-center">
            <form action="/admin/slideshow/slides"
                  method="POST">
                {!! csrf_field() !!}
                <input class="dn"
                       type="checkbox"
                       name="video_slide"
                       value="1"
                       checked>
                <button class="btn">Add Video Slide</button>
            </form>
            <form action="/admin/slideshow/slides"
                  method="POST">
                {!! csrf_field() !!}
                <input class="dn"
                       type="checkbox"
                       value="0"
                       name="video_slide">
                <button class="btn">Add Image Slide</button>
            </form>
        </div>
    </div>
    <p class="f4 black-40">You may drag slides into the order you prefer.</p>
    <slide-index :slides='@json($slides->map->toJsonableArray())'
                 sync_order_url="/admin/slideshow/slide-order"></slide-index>
@endsection