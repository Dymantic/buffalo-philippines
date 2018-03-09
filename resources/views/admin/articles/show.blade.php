@extends('admin.base')

@section('content')
    <article-page :article-attributes="{{ json_encode($article) }}"></article-page>
@endsection