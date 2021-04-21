@props(['template' => $template])

<a href="{{ route('home') }}" class="relative">
    <img src="{{$template->profile->path()}}">
    <div class="absolute inset-x-0 bottom-0 h-8 bg-black opacity-75">
        <p class="text-center text-white">{{ $template->name }}</p>
    </div>
</a>