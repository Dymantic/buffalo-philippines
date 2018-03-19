@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Search Products</h1>
        <div class="flex justify-end items-center">
            <a href="/admin/categories"
               class="btn">See Categories</a>
        </div>
    </div>
    <div class="mv3">
        <p class="ff-large-body">Search <span class="ff-headline-small col-p">{{ $product_count }}</span> products, in <span class="ff-headline-small col-p">{{ $category_count }}</span> categories, <span class="ff-headline-small col-p">{{ $subcategory_count }}</span> subcategories and <span class="ff-headline-small col-p">{{ $toolgroup_count }}</span> tool groups.</p>
    </div>
    <product-search search-url="/admin/services/search/products"
                    :initial-results='{{ json_encode($products) }}'
                    initial-term="{{ $search_term }}"
    ></product-search>
@endsection