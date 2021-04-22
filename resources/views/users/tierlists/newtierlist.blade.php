@extends('layouts.app')

@section('content')

<div class="flex justify-evenly mb-5">
    <div class="w-2/12 bg-gray-200 p-2 mx-3 text-center rounded-lg">
        Template name: {{ $template->name }}
    </div>
    <div class="w-9/12 bg-gray-200 p-2 mx-3 text-center rounded-lg">
        {{ $template->description }}
    </div>
</div>

@foreach ($template->rows as $row)
<div class="w-full flex justify-center m-0 p-0">
    <div class="w-full bg-{{$row->getColour()}}-500 p-10 mb-4 text-center">
        {{ $row->name }}
    </div>
</div>
@endforeach

<div class="w-full flex justify-center m-0 p-0">
    <div class="w-8/12 m-0 p-0 flex justify-center flex-wrap">
        @foreach ($template->images as $image)
        <img src="{{$image->path()}}">
        @endforeach
    </div>
</div>

@endsection