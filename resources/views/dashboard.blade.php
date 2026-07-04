@extends('layouts.app')

@section('content')
<div class="w-full bg-gray-200 p-2 text-center">
    Templates
</div>

<div class="flex justify-center">
    <div class="w-8/12">
        <div class="p-6 flex justify-evenly w-full">
            @if ($templates->count())
            @foreach ($templates as $template)
                <x-template :template="$template" />
            @endforeach

            {{ $templates->links() }}

            @else
                <p class="text-white">There are no templates, <a class="underline text-blue-500" href="{{ route('newtemplate') }}" class="p-3">make one!</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
