@extends('admin.base')

@section('content')
<div class="flex justify-between items-center">
        <h1 class="f1 normal">Categories</h1>
        <div class="flex justify-end items-center">
          <category-form url="/admin/categories" button-text="Add Category" form-type="create"></category-form>
        </div>
    </div>
    <categories-index></categories-index>
@endsection