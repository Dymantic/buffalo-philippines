@extends('admin.base')

@section('content')
    <tool-group :item-attributes='{{ json_encode($tool_group) }}'></tool-group>
@endsection