@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-10/12 bg-gray-200 p-6 my-8 rounded-lg">
        @if (session('status'))
        <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('newtemplate') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4 flex justify-evenly">
                <label for="name" class="sr-only">Template name</label>
                <input type="text" name="name" id="name" placeholder="The template's name" class="shadow-inner bg-gray-100 border-2 w-3/12 p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('name') }}">

                @error('name')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4 flex justify-evenly">

                <label for="description" class="sr-only">description</label>
                <input type="text" name="description" id="description" placeholder="The template's description" class="shadow-inner bg-gray-100 border-2 w-8/12 p-4 rounded-lg " value="{{ old('description') }}">
            </div>

            <div class="mb-8 flex justify-evenly">
                <div class="text-black text-lg w-4/12">
                    <h4>Template profile picture</h4>
                    <input type="file" name="profile" id="profile" placeholder="Insert picture" class="shadow-inner bg-gray-100 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}">

                </div>
                @error('profile')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror


                <div class="text-black text-lg w-4/12">
                    <h4>Items</h4>
                    <input type="file" name="imageCollection[]" id="imageCollection" placeholder="Insert item pictures" class="shadow-inner bg-gray-100 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}" multiple>

                </div>
                @error('imageCollection.*')
                <div class="text-red-500 mt-2 text-sm">
                    One or more files are invalid.
                </div>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-4/12">Create new template</button>
            </div>
        </form>
    </div>
</div>
@endsection