@extends('admin.base')

@section('content')
    <subcategory-page :item-attributes='{{ json_encode($subcategory) }}'></subcategory-page>
@endsection