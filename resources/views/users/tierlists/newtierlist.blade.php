@extends('layouts.app')

@php
$rows = array('S', 'A', 'B', 'C', 'D', 'E', 'F');
@endphp

@section('content')

<div id="row-modal-menu" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        <b>Change row attributes.</p>
    </div>

</div>

<div id="item-modal-menu" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <button class="close-modal">&times;</button>
        <form id="item-form">
            @csrf

            <div class="mb-4">
                <label for="name" class="sr-only">Name</label>
                <input type="text" name="name" id="name" placeholder="Item's name" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="score" class="sr-only">Score</label>
                <input type="score" name="score" id="score" placeholder="Give the item a score" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            </div>

            <input type="hidden" name="tierlist" value="{{ $tierlist->id }}">
            <input type="hidden" id="item-id" name="item-id" value="-1">

            <div>
                <button id="item-form-submit" type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Save</button>
            </div>
        </form>
    </div>

</div>

<div class="flex justify-evenly mb-5">
    <div class="w-2/12 bg-gray-200 p-2 mx-3 text-justify rounded-lg flex justify-center items-center">
        Template name: {{ $tierlist->template->name }}
    </div>
    <div class="w-9/12 bg-gray-200 p-2 mx-3 text-justify rounded-lg flex justify-center items-center">
        {{ $tierlist->template->description }}
    </div>
    <div class="w-auto bg-white p-2 mx-3 text-center rounded-lg relative">
        <img src="{{$tierlist->template->profile->path()}}">
        <div class="absolute inset-x-0 bottom-0 h-8 bg-black opacity-75">
            <p class="text-center text-white">{{ count($tierlist->items) - 1 }}</p>
        </div>
    </div>

</div>

@for ($i = 0; $i < count($tierlist->template->rows); $i++)
    <div class="flex justify-center mb-5 p-0 mx-0 bg-{{$tierlist->template->rows[$i]->getColour()}}-500" style="height:100px">
        <div class="bg-{{$tierlist->template->rows[$i]->getColour()}}-700 text-center flex justify-center items-center" style="width:100px">
            @php
            if($tierlist->template->rows[$i]->name == "null")
            {
            if($i < count($rows)) { echo $rows[$i]; } else { echo 'New row' ; } } else { echo $tierlist->template->rows[$i]->name;
                }
                @endphp
        </div>
        <!-- vscode format on save keeps messing this up. Nothing I can do about it. -->
        <div class="w-full">
            <!-- Where all of the items will go. -->
        </div>

        <button class="bg-{{$tierlist->template->rows[$i]->getColour()}}-700 text-justify flex justify-center items-center row-button" style="width:100px">
            <i class="fas fa-cog fa-3x"></i>
        </button>
    </div>
    @endfor

    <div class="w-full flex justify-center m-0 p-0">
        <div class="w-8/12 m-0 p-0 flex justify-center flex-wrap">
            @foreach ($tierlist->items as $item)
            @unless ($item->image == $tierlist->template->profile)
            <div id="image-{{ $item->image->id }}" class="item-image">
                <button class=" itemButton">
                    <img src="{{$item->image->path()}}">
                </button>
            </div>
            @endunless
            @endforeach
        </div>
    </div>

    <script>
        const axios = window.axios

        // Hook up function to all row buttons
        let rowButtons = document.getElementsByClassName("row-button");
        for (let i = 0; i < rowButtons.length; i++) {
            rowButtons[i].addEventListener('click', (event) => {
                showModal("row-modal-menu", event)
            }, {
                passive: true
            })
        }

        // Hook up function to all item buttons
        let itemButtons = document.getElementsByClassName("itemButton");
        for (let i = 0; i < itemButtons.length; i++) {
            itemButtons[i].addEventListener('click', (event) => {
                showModal("item-modal-menu", event)
            }, {
                passive: true
            })
        }

        // Close modal
        let modalClose = document.getElementsByClassName("close-modal");
        for (let i = 0; i < modalClose.length; i++) {
            modalClose[i].addEventListener('click', closeModal, {
                passive: true
            })
        }

        function closeModal() {
            let modals = document.getElementsByClassName("modal");
            for (let i = 0; i < modals.length; i++) {
                modals[i].style.display = "none";
            }
        }

        function showModal(modalId, event) {
            // Get actual button

            let target = event.target
            while (target.type !== "submit") {
                target = target.parentElement
            }
            // We are moving the entire modal below to be a sibling with event.target
            // The entire modal element and its children also inherit the showModal event and throw errors if we accidentally append it to the button
            // Which happens if clicking on the cog icon or on the image

            // See above comment, this is unnecessary but it acts as a bandaid in case it breaks with a similar result again
            //if (!target.classList.contains("rowButton") && !target.classList.contains("itemButton")) return

            // Get modal
            let modal = document.getElementById(modalId)

            // Move modal to be sibling of button (make child of parent of button with appendChild)
            target.parentElement.appendChild(modal)

            // Make modal visible
            modal.style.display = "block";
        }

        let formButton = document.getElementById("item-form-submit")
        formButton.addEventListener("click", (event) => {
            submitFormWithId(event)
        })

        function submitFormWithId(event) {

            event.preventDefault()

            let form = document.getElementById("item-form");
            let div = form

            while (!div.classList.contains("item-image")) {
                div = div.parentElement
            }

            let input = document.getElementById("item-id");
            let itemId = div.id.split("-")[1]
            input.setAttribute("value", itemId);

            if (itemId === undefined) return
            // TODO: DISPLAY AN ERROR HERE... OR SOMETHING
            data = new FormData(form)

            axios.post("{{ route('savetierlist', $tierlist) }}", data)
                .then(response => {
                    console.log(response)
                    closeModal()
                })
                .catch(error => {
                    // manage error here
                })



        }
    </script>

    @endsection