@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Search Products</h1>
        <div class="flex justify-end items-center">
            <a href="/admin/categories"
               class="btn">See Categories</a>
        </div>
    </div>
    <product-search search-url="/admin/services/search/products"
                    :initial-results='{{ json_encode($products) }}'
                    initial-term="{{ $search_term }}"
    ></product-search>
@endsection