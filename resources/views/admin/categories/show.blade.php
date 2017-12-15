@extends('admin.base')

@section('content')
    <category-page id="{{ $category->id }}"
                   title="{{ $category->title }}"
                   description="{{ $category->description }}"
                   :published="{{ $category->published ? 'true' : 'false' }}"
                   image="{{ $category->imageUrl('thumb') }}"
                   :menu-structure="{{ json_encode($category->menu()) }}"
    ></category-page>
@endsection