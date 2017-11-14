@extends('admin.base')

@section('content')
    <category-page id="{{ $category->id }}"
                   title="{{ $category->title }}"
                   description="{{ $category->description }}"
                   :published="{{ $category->published ? 'true' : 'false' }}"
    ></category-page>
@endsection