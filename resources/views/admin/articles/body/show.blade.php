@extends('admin.base')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endsection

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">{{ $article->title }}</h1>
        <div class="flex justify-end items-center">
            <a href="/admin/articles/{{ $article->id }}"
               class="btn">Back to Article</a>
        </div>
    </div>
    <editor post-id="{{ $article->id }}"
            :post-content="{{ json_encode($article->body) }}"
    ></editor>
@endsection