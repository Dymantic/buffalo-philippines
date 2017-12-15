@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">{{ $category->title }}</h1>
        <div class="flex justify-end items-center">
            <a href="/admin/categories/{{ $category->id }}"
               class="btn">Manage Category</a>
        </div>
    </div>
    <show-category :menu-structure='{{ json_encode($categoryMenu) }}'
                   products-fetch-url="/admin/services/categories/{{ $category->id }}/products"
                   category-title="{{ $category->title }}"
                   :for-admin="true"
                   :show-subcategory='{{ json_encode($subcategory) }}'
                   :show-tool-group='{{ json_encode($toolGroup) }}'
                   showing-type="{{ $showType }}"
                   :menu-subcategory="{{ $menuSubcategory ?? 'null' }}"
    ></show-category>
@endsection