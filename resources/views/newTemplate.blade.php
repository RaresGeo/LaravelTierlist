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
                <input type="text" name="name" id="name" placeholder="The template's name" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-3/12 p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('name') }}">

                @error('name')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4 flex justify-evenly">

                <label for="description" class="sr-only">description</label>
                <input type="text" name="description" id="description" placeholder="The template's description" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-8/12 p-4 rounded-lg " value="{{ old('description') }}">
            </div>

            <div class="mb-8 flex justify-evenly">
                <div class="text-black text-lg w-4/12">
                    <h4>Template profile picture</h4>
                    <input type="file" name="profile" id="profile" placeholder="Insert picture" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}">

                </div>
                @error('profile')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror


                <div class="text-black text-lg w-4/12">
                    <h4>Items</h4>
                    <input type="file" name="imageCollection[]" id="imageCollection" placeholder="Insert item pictures" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}" multiple>

                </div>
                @error('imageCollection.*')
                <div class="text-red-500 mt-2 text-sm">
                    One or more files are invalid.
                </div>
                @enderror
            </div>

            <div id="rows" class="mb-8 text-black text-lg w-full">
                <div class="flex justify-evenly mb-4">
                    <select id="colours" name="rowColours[]" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg w-1/12">
                        <option value="green">Green</option>
                        <option value="red">Red</option>
                        <option value="yellow">Amber</option>
                        <option value="blue">Blue</option>
                        <option value="indigo">Indigo</option>
                        <option value="purple">Violet</option>
                        <option value="pink">Pink</option>
                    </select>

                    <input type="text" name="rowsMin[]" placeholder="Min %" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-1/12 p-4 rounded-lg mr-1 ml-2" value="0">
                    <input type="text" name="rowsMax[]" placeholder="Max %" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-1/12 p-4 rounded-lg ml-0 mr-2" value="100">

                    @error('rowsMin.*')
                    <div class="text-red-500 mt-2 text-sm">
                        One or Min % fields are invalid
                    </div>
                    @enderror

                    @error('rowsMax.*')
                    <div class="text-red-500 mt-2 text-sm">
                        One or Max % fields are invalid
                    </div>
                    @enderror

                    <input type="text" name="rows[]" placeholder="Name new row" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-10/12 p-4 rounded-lg">

                </div>
            </div>

            <div class="flex justify-center mb-4">
                <button type="button" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-4/12" onclick="addNewRow()">Add a new row</button>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-4/12">Create new template</button>
            </div>
        </form>
    </div>
</div>

<script>
    function splitClasses(classes) {
        return classes.split(" ")
    }

    function addNewRow() {
        var newDiv = document.createElement("div")
        newDiv.classList.add(...splitClasses("flex justify-evenly mb-4"))

        var newDropdown = document.createElement("select")
        newDropdown.innerHTML = document.getElementById("colours").innerHTML
        newDropdown.name = "rowColours[]"
        newDropdown.classList.add(...splitClasses("shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 ml-0 mr-4 rounded-lg w-1/12"))

        var newNameInput = document.createElement("input")
        newNameInput.type = "text"
        newNameInput.name = "rows[]"
        newNameInput.placeholder = "Name new row"
        newNameInput.classList.add(...splitClasses("shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-10/12 p-4 rounded-lg"))

        var newScoreInputMin = document.createElement("input")
        newScoreInputMin.type = "text"
        newScoreInputMin.name = "rowsMin[]"
        newScoreInputMin.placeholder = "Min %"
        newScoreInputMin.classList.add(...splitClasses("shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-1/12 p-4 rounded-lg mr-1 ml-2"))

        var newScoreInputMax = document.createElement("input")
        newScoreInputMax.type = "text"
        newScoreInputMax.name = "rowsMax[]"
        newScoreInputMax.placeholder = "Max %"
        newScoreInputMax.classList.add(...splitClasses("shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-1/12 p-4 rounded-lg ml-0 mr-2"))

        var newButton = document.createElement("button")
        newButton.type = "button"
        newButton.classList.add(...splitClasses("bg-red-500 text-white mr-0 ml-4 rounded font-medium w-1/12"))
        newButton.addEventListener('click', removeRow, false)
        newButton.innerText = "Remove row"

        newDiv.appendChild(newDropdown)
        newDiv.appendChild(newScoreInputMin)
        newDiv.appendChild(newScoreInputMax)
        newDiv.appendChild(newNameInput)
        newDiv.appendChild(newButton)

        document.getElementById("rows").appendChild(newDiv)
    }

    function removeRow() {
        this.parentElement.remove()
    }
</script>
@endsection