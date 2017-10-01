@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Slide #{{ $slide->id }}</h1>
        <div class="flex justify-end items-center">
            <toggle-switch on-url="/admin/slideshow/published-slides"
                           off-url="/admin/slideshow/published-slides/{{ $slide->id }}"
                           label-text="Publish"
                           :toggle-state="{{ $slide->published ? 'true' : 'false' }}"
                           :unique="{{ $slide->id }}"
                           :on-payload="{slide_id: {{ $slide->id }} }"
                           class="mr3"
            ></toggle-switch>
            <delete-modal url="/admin/slideshow/slides/{{ $slide->id }}"
                          :redirect="true"
                          item-name="Slide #{{ $slide->id }}"
            ></delete-modal>
        </div>
    </div>
    <banner-slide media_url="/admin/slideshow/slides/{{ $slide->id }}/{{ $slide->is_video ? 'video' : 'image' }}"
                  current_src="{{ $slide->is_video ? $slide->videoUrl() : $slide->imageUrl('banner') }}"
                  :is_video="{{ $slide->is_video ? 'true' : 'false' }}"
                  info_url="/admin/slideshow/slides/{{ $slide->id }}"
                  :slide-attributes='@json($slide->toJsonableArray())'
    ></banner-slide>
@endsection