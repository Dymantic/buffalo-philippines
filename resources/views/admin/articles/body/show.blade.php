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
    <wysiwyg-editor name="body"
                    :init-content="{!! htmlentities(json_encode($article->body, JSON_HEX_QUOT), ENT_QUOTES) !!}"
                    save-url="/admin/articles/{{ $article->id }}/body"
                    :save-timer="10"
                    image-upload-url="/admin/articles/{{ $article->id }}/images"
    ></wysiwyg-editor>
    {{--<editor post-id="{{ $article->id }}"--}}
            {{--:post-content="{{ json_encode($article->body) }}"--}}
    {{--></editor>--}}
@endsection