@extends('admin.base')

@section('content')
    <subcategory-page :item-attributes='{{ json_encode($subcategory) }}'
                      :category="{{ json_encode($category) }}"
                      :product-count="{{ $product_count }}"
    ></subcategory-page>
@endsection