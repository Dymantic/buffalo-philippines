@extends('admin.base')

@section('content')
    <product-gallery :product="{{ json_encode($product) }}"></product-gallery>
@endsection