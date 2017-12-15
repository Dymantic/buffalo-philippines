@extends('admin.base')

@section('content')
    <tool-group :item-attributes='{{ json_encode($tool_group) }}'
                :category="{{ json_encode($category) }}"
                :subcategory="{{ json_encode($subcategory) }}"
    ></tool-group>
@endsection