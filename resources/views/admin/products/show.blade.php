@extends('admin.base')

@section('content')
    <product-page :item-attributes='{!!  htmlentities(json_encode($product, JSON_HEX_QUOT), ENT_QUOTES) !!}'
                  :category-list="{{ json_encode($categoryList) }}"></product-page>
@endsection