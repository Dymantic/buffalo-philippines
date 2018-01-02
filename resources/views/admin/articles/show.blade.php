@extends('admin.base')

@section('content')
    <article-page :article-attributes="{{ htmlentities(json_encode($article, JSON_HEX_QUOT), ENT_QUOTES) }}"></article-page>
@endsection