@extends('admin.base')

@section('content')
    <product-page :item-attributes='{{ json_encode($product) }}'></product-page>
@endsection