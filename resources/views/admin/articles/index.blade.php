@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">News</h1>
        <div class="flex justify-end items-center">
            <article-form url="/admin/articles"
                          button-text="New Post"></article-form>
        </div>
    </div>

    <articles-list :initial-list="{{ json_encode($articles) }}"></articles-list>

    {{--<articles-list :initial-list="{{ htmlentities(json_encode($articles, JSON_HEX_QUOT), ENT_QUOTES) }}"></articles-list>--}}
@endsection