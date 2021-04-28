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

            <div class="mb-4 flex justify-between">

                <div class="flex flex-col w-4/12">
                    <label class="mx-3 inline-flex font-semibold text-black" for="name">
                        Name your template</label>
                    <input type="text" name="name" id="name" placeholder="Scuffed template" class="flex-grow w-full shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('name') }}">

                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="flex flex-col w-4/12 mx-4">
                    <label class="mx-3 inline-flex font-semibold text-black" for="profile">
                        Template display picture</label>
                    <input type="file" name="profile" id="profile" class="shadow-inner bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}">

                    @error('profile')
                    <div class="text-red-500 mt-2 text-sm">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="flex flex-col w-4/12">
                    <label class="mx-3 inline-flex font-semibold text-black" for="name">
                        Upload items</label>
                    <input type="file" name="imageCollection[]" id="imageCollection" placeholder="Insert item pictures" class="shadow-inner bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-full p-4 rounded-lg @error('imageCollection[]') border-red-500 @enderror" value="{{ old('imageCollection[]') }}" multiple>

                    @error('imageCollection.*')
                    <div class="text-red-500 mt-2 text-sm">
                        One or more files are invalid.
                    </div>
                    @enderror
                </div>

            </div>

            <div class="flex justify-center mb-4">
                <div class="flex flex-col w-full">

                    <div class="mb-1">
                        <label class="mx-3 inline-flex font-semibold text-black" for="description">
                            Template description</label>
                        <button type="button" class="text-white rounded h-full px-4 bg-red-500 hover:bg-red-700" id="description-toggle"><i class="fas fa-minus"></i></button>
                    </div>
                    <textarea type="text" name="description" id="description" placeholder="A scuffed template for rating scuffed items" class="shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 w-full p-4 rounded-lg h-36" value="{{ old('description') }}"></textarea>
                </div>
            </div>

            <div class="flex justify-center mb-4">
                <div class="flex flex-col w-full">

                    <div class="mb-1">
                        <label class="mx-3 inline-flex font-semibold text-black" for="description">
                            Template formula</label>

                        <i class="fas fa-question tooltip text-green-700">
                            <span class="bg-black text-white rounded-lg text-center px-5 inline-block z-10 font-mono tooltiptext p-2" id="formula-help">
                                <p>
                                    Use only integers (No floating point numbers)
                                    <br>
                                    Variables have to be only one word
                                    <br>
                                    Explain each variable in the template description
                                </p>
                            </span>
                        </i>
                    </div>

                    <input type="text" name="formula" id="formula" placeholder="A + B + C" class="flex-grow w-full shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('formula') }}">
                </div>
            </div>


            <div id="rows" class="mb-8 text-black text-lg w-full">

                <div class="flex justify-evenly mb-4 row">
                    <div class="flex flex-col w-1/12">
                        <label class="mx-2 inline-flex font-semibold text-black text-sm" for="row-colours">
                            Row colour</label>
                        <select name="rowColours[]" class="row-colours shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg">
                            <option value="green">Green</option>
                            <option value="pink">Pink</option>
                            <option value="purple">Violet</option>
                            <option value="blue">Blue</option>
                            <option value="indigo">Indigo</option>
                            <option value="yellow">Amber</option>
                            <option value="red">Red</option>
                        </select>
                    </div>

                    <div class="flex flex-col w-1/12">
                        <label class="mx-2 inline-flex font-semibold text-black text-sm">
                            Min score</label>
                        <input type="text" name="rowsMin[]" placeholder="Min %" class="row-min shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg mr-1 ml-2" value="0">

                        @error('rowsMin.*')
                        <div class="text-red-500 mt-2 text-sm">
                            One or Min % fields are invalid
                        </div>
                        @enderror

                    </div>

                    <div class="flex flex-col w-1/12">
                        <label class="mx-2 inline-flex font-semibold text-black text-sm">
                            Max score</label>
                        <input type="text" name="rowsMax[]" placeholder="Max %" class="row-max shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg mr-1 ml-2" value="100">

                        @error('rowsMax.*')
                        <div class="text-red-500 mt-2 text-sm">
                            One or Max % fields are invalid
                        </div>
                        @enderror

                    </div>



                    <div class="flex flex-col w-10/12">
                        <div class="flex justify-between">
                            <label class="mx-2 inline-flex font-semibold text-black text-sm">
                                Row name</label>
                            <label class="mx-2 inline-flex font-semibold text-black text-xs">
                                Defaults will be given alphabetically (S, A, B, C, etc)</label>
                        </div>
                        <input type="text" name="rows[]" placeholder="S" class="row-name shadow-inner bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 border-2 p-4 rounded-lg">
                    </div>

                    <div class="flex flex-col w-1/12 mr-0 ml-4">
                        <label class="mx-2 inline-flex font-semibold text-black text-sm">
                            Add new row</label>
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white rounded h-full" onclick="addNewRow()"><i class="fas fa-plus"></i></button>
                    </div>

                </div>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-4/12">Create new template</button>
            </div>
        </form>
    </div>
</div>

<script>
    console.log(window.tokenize("3 + 2 * (1 / 3)"))

    const defaultRowNames = ['S', 'A', 'B', 'C', 'D', 'E', 'F']

    function splitClasses(classes) {
        return classes.split(" ")
    }

    function addNewRow() {
        let newDiv = document.createElement("div")
        newDiv.classList.add(...splitClasses("flex justify-evenly mb-4 row"))
        let rows = document.getElementsByClassName("row")
        newDiv.innerHTML = rows[0].innerHTML

        // Try removing all labels
        let labels = newDiv.querySelectorAll("label")
        for (label of labels) {
            label.remove()
        }

        // Change colour to next one
        let previousRowColours = rows[rows.length - 1].getElementsByClassName("row-colours")[0]
        let rowColours = newDiv.getElementsByClassName("row-colours")[0]
        rowColours.selectedIndex = previousRowColours.selectedIndex + 1 < rowColours.options.length ? previousRowColours.selectedIndex + 1 : 0

        // Change min input to be empty

        let rowMinInput = newDiv.getElementsByClassName("row-min")[0]
        rowMinInput.value = ""

        // Change max to be min of last one

        let rowMaxInput = newDiv.getElementsByClassName("row-max")[0]
        let rowMinPrevious = parseInt(rows[rows.length - 1].getElementsByClassName("row-min")[0].value)

        if (!isNaN(rowMinPrevious) && rowMinPrevious !== 0) {
            rowMaxInput.value = rowMinPrevious
        } else {
            rowMaxInput.value = ""
        }

        // Change row name placeholder
        let rowNameInput = newDiv.getElementsByClassName("row-name")[0]
        rowNameInput.setAttribute("placeholder", defaultRowNames.length > rows.length ? defaultRowNames[rows.length] : "Name new row")

        // Change button from add to remove
        let button = newDiv.getElementsByTagName("button")[0]
        button.innerHTML = '<i class="fas fa-minus"></i>'
        button.classList.remove(...splitClasses("bg-blue-500 hover:bg-blue-700"))
        button.classList.add(...splitClasses("bg-red-500 hover:bg-red-700"))
        button.removeAttribute("onclick");
        button.addEventListener('click', removeRow, {
            passive: true
        })

        document.getElementById("rows").appendChild(newDiv)
    }

    function removeRow() {
        let row = this
        while (!row.classList.contains("row")) {
            row = row.parentElement
        }
        row.remove()
    }

    let descriptionToggle = document.getElementById("description-toggle")

    descriptionToggle.addEventListener('click', (event) => toggleButton(event, 'description'), {
        passive: true
    })

    function toggleButton(event, tagId) {
        toggleTag(tagId)
        // Change colour from blue to red and vice-versa
        let button = event.target.closest("button")
        button.classList.toggle("bg-blue-500")
        button.classList.toggle("hover:bg-blue-700")
        button.classList.toggle("bg-red-500")
        button.classList.toggle("hover:bg-red-700")

        // Change icon from plus to minus and vice-versa
        let icon = button.children[0]

        icon.classList.toggle("fa-plus")
        icon.classList.toggle("fa-minus")
    }

    function toggleTag(tagId) {
        let tag = document.getElementById(tagId)
        tag.style.display = tag.style.display === "none" ? "initial" : "none";
    }
</script>
@endsection