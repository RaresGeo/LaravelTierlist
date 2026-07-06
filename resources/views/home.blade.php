@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
        Home

        <div class="mt-6 border-t pt-4 text-sm text-gray-600">
            <p class="font-semibold text-gray-800">Just want to look around?</p>
            <p>Use the guest account below to explore the project.</p>
            <p class="mt-2">
                <span class="font-medium">Email:</span> <code>guest@tierlist.app</code>
                &nbsp;·&nbsp;
                <span class="font-medium">Password:</span> <code>guest1234</code>
            </p>
        </div>
    </div>
</div>
@endsection
