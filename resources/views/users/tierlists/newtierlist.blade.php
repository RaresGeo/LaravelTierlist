@extends('layouts.app')

@php
$rows = array('S', 'A', 'B', 'C', 'D', 'E', 'F');
@endphp

@section('content')

<div id="item-modal-menu" class="modal">

    <!-- Modal content -->
    <div class="flex flex-col items-center shadow-xl rounded-lg modal-content w-4/12 mx-auto">
        <div class="flex justify-between p-6 bg-white border border-gray-300 rounded-tl-lg rounded-tr-lg w-full">

            <p class="font-semibold text-gray-800">Formula: {{ $tierlist->template->formula }}</p>
            <button class="close-modal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg></button>

        </div>
        <div class="flex flex-col p-6 w-full flex-grow border border-gray-300 rounded-bl-lg rounded-br-lg">

            <form id="item-form" action="{{ route('savetierlist', $tierlist) }}" method="post" class="flex flex-col justify-center items-center w-full flex-grow">
                @csrf

                <div class="flex justify-center mb-4">
                    <div class="flex flex-col w-full items-center">

                        <label class="mx-3 inline-flex font-semibold text-black" for="name">
                            Name</label>
                        <input type="text" name="name" id="name" placeholder="Item's name" class="bg-gray-100 border-2 p-4 rounded-lg">
                    </div>
                </div>

                <div class="flex flex-wrap justify-center mb-4" id="item-modal-variables">
                    <div class="flex flex-col w-4/12 items-center mx-4 item-modal-variable">
                        <label class="mx-3 inline-flex font-semibold text-black" for="variable">
                            x </label>
                        <input type="text" name="variable" id="variable" placeholder="1" class="bg-gray-100 border-2 p-4 rounded-lg">
                    </div>
                </div>

                <input type="hidden" name="tierlist" value="{{ $tierlist->id }}">
                <input type="hidden" id="item-id" name="item-id" value="-1">

                <div class="flex justify-center mt-6">
                    <button id="item-form-submit" type="submit" class="bg-blue-500 hover:bg-glue-700 text-white px-4 py-3 rounded font-medium">Save</button>
                </div>
            </form>

        </div>
    </div>


</div>

<div class="flex justify-evenly mb-5">
    <div class="w-auto bg-white p-2 mx-3 text-center rounded-lg relative">
        <img src="{{$tierlist->template->profile->path()}}">
        <div class="absolute inset-x-0 bottom-0 h-8 bg-black opacity-75">
            <p class="text-center text-white">{{ $tierlist->template->name }}</p>
        </div>
    </div>

    <div class="w-full bg-gray-200 p-2 mx-3 text-justify rounded-lg flex justify-center items-center">
        {{ $tierlist->template->description }}
    </div>
</div>

<div class="flex justify-center mt-10">
    <div id="tierlist-body" class="flex flex-col items-center w-8/12 bg-gray-900">

        @for ($i = 0; $i < count($tierlist->template->rows); $i++)
            <div class="flex justify-center mb-5 p-0 mx-0 bg-black m-0 p-0 w-full" style="min-height:100px">
                <div class="bg-{{$tierlist->template->rows[$i]->getColour()}}-700 text-center flex justify-center items-center" style="width:100px">
                    @php
                    if($tierlist->template->rows[$i]->name == "null")
                    {
                    if($i < count($rows)) { echo $rows[$i]; } else { echo 'New row' ; } } else { echo $tierlist->template->rows[$i]->name;
                        }
                        @endphp
                </div>
                <!-- vscode format on save keeps messing this up. Nothing I can do about it. -->
                <div id="row-{{ $i }}" class="min-{{ $tierlist->template->rows[$i]->min }} max-{{ $tierlist->template->rows[$i]->max }} w-full flex flex-wrap m-0 p-0">
                    <!-- Where all of the items will go. -->
                </div>

                <div class="bg-{{$tierlist->template->rows[$i]->getColour()}}-700 text-center flex justify-center items-center text-sm" style="width:100px">
                    {{ $tierlist->template->rows[$i]->max }}% - {{ $tierlist->template->rows[$i]->min }}%
                </div>
            </div>
            @endfor
    </div>
</div>

<div class="flex justify-center mt-6">
    <button id="canvas-save" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-3 rounded m-4 font-medium">Save tierlist</button>
</div>

<div class="w-full flex justify-center mt-4 p-0">
    <div class="w-8/12 m-0 p-0 flex justify-center flex-wrap">
        @foreach ($tierlist->items as $item)
        @unless ($item->image == $tierlist->template->profile)
        <div id="image-{{ $item->id }}" class="item-image score-{{ $item->score }} {{ $item->variables }} name-{{ $item->name }}" style="height:100px">
            <button class=" itemButton">
                <img src="{{$item->image->path()}}">
            </button>
        </div>
        @endunless
        @endforeach
    </div>
</div>

<script>
    // Get highest score
    let highestScoreItem = document.getElementsByClassName("item-image")[0]
    //maxScore = isNaN(maxScore) ? 0 : maxScore

    // Get all variables
    let formula = "{{ $tierlist->template->formula }}"
    formula = window.tokenize(formula)

    let formulaVariables = []

    for (token of formula) {
        if (window.isName(token))
            formulaVariables.push(token)
    }

    // Append them to the item modal
    let dummyModalVariable = document.getElementsByClassName("item-modal-variable")[0]
    for (formulaVariable of formulaVariables) {
        let newModalVariable = document.createElement("div")

        newModalVariable.classList.add(...dummyModalVariable.classList)
        newModalVariable.innerHTML = dummyModalVariable.innerHTML

        let modalLabel = newModalVariable.children[0]
        modalLabel.innerText = formulaVariable
        modalLabel.setAttribute("for", `variable-${formulaVariable}`)

        let modalInput = newModalVariable.children[1]
        modalInput.id = `variable-${formulaVariable}`
        modalInput.name = `variable-${formulaVariable}`

        dummyModalVariable.parentElement.appendChild(newModalVariable)
    }

    dummyModalVariable.remove()

    const axios = window.axios

    // Order all items accordingly
    reorderAll()

    function reorderAll() {
        let items = document.getElementsByClassName("item-image")
        for (item of items) {

            let score = parseInt(getClassValue(item, "score"))
            orderByScore(score, item)
        }
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

        let target = event.target.closest("button")

        // We are moving the entire modal below to be a sibling with event.target
        // The entire modal element and its children also inherit the showModal event and throw errors if we accidentally append it to the button
        // Which happens if clicking on the cog icon or on the image

        // See above comment, this is unnecessary but it acts as a bandaid in case it breaks with a similar result again
        //if (!target.classList.contains("rowButton") && !target.classList.contains("itemButton")) return

        // Get modal
        let modal = document.getElementById(modalId)


        // Move modal to be sibling of button (make child of parent of button with appendChild)
        target.parentElement.appendChild(modal)

        // Do some logic and fill in fields
        if (modalId.split("-")[0] === "item") {
            let itemDiv = target.closest(".item-image")
            let itemName = getClassValue(itemDiv, "name")

            // Change name input
            let nameInput = document.getElementById("name")
            nameInput.value = itemName

            for (formulaVariable of formulaVariables) {
                let variableValue = getClassValue(itemDiv, formulaVariable)
                let formulaInput = document.getElementById(`variable-${formulaVariable}`)
                formulaInput.value = isNaN(parseInt(variableValue)) ? 0 : parseInt(variableValue)
            }
        }

        // Make modal visible
        modal.style.display = "block";
    }

    let itemFormButton = document.getElementById("item-form-submit")
    itemFormButton.addEventListener("click", (event) => {
        submitItemForm(event)
    })

    function submitItemForm(event) {
        // Don't reload the page
        event.preventDefault()

        // Get form and item div
        let form = document.getElementById("item-form");
        let itemDiv = form.closest(".item-image")

        let input = document.getElementById("item-id");
        let itemId = itemDiv.id.split("-")[1]

        formData = new FormData(form)

        let variableString = ''

        for (formulaVariable of formulaVariables) {
            let variableInput = form.elements[`variable-${formulaVariable}`]

            formula.splice(formula.indexOf(formulaVariable), 1, variableInput.value)

            variableString += `${formulaVariable}-${variableInput.value} `

            formData.delete(`variable-${formulaVariable}`)
        }
        variableString = variableString.trim()
        let code = formula.join(' ')
        let score = parseInt(window.calculate(code))
        let itemName = form.elements['name'].value

        formData.append("item-id", itemId)
        formData.append("score", score)
        formData.append("variables", variableString)

        axios.post("{{ route('savetierlist', $tierlist) }}", formData)
            .then(response => {
                closeModal()
                changeClassValue(itemDiv, 'name', itemName)

                if (itemDiv.classList.length === 3) {
                    // Add variables as classes
                    itemDiv.classList.add(...variableString.split(" "))

                }

                if (itemDiv === highestScoreItem) {
                    // ----- We just changed the highest, we have to reorder all if the new score is different
                    // If its score is higher, just change the score class and reorder all
                    if (score > getScore(itemDiv)) {
                        changeClassValue(itemDiv, 'score', score)
                        reorderAll()
                    } else if (score < getScore(itemDiv)) { // If it's lower, we have to find the new highest and also reorder all
                        changeClassValue(itemDiv, 'score', score)
                        highestScoreItem = getHighest(itemDiv)
                        reorderAll()
                    }
                    // If it's the same, do nothing
                } else {
                    changeClassValue(itemDiv, 'score', score)
                    // Check if it's higher 
                    if (score > getScore(highestScoreItem)) {
                        // Change highest and reorder all
                        highestScoreItem = itemDiv
                        reorderAll()
                    } else {
                        // If it's not, only order this one
                        orderByScore(score, itemDiv)
                    }
                }
            })
            .catch(error => {
                // manage error here
                console.log(error)
            })

        // Move item accordingly
    }

    function orderByScore(score, item) {
        if (isNaN(score)) return
        for (let i = 0; i < "{{ count($tierlist->template->rows) }}"; i++) {

            let rowDiv = document.getElementById(`row-${i}`)
            let rowDivMin = parseInt(rowDiv.classList.item(0).split('-')[1])

            if (parseInt(score / getScore(highestScoreItem)) * 100 >= rowDivMin) {
                let children = rowDiv.children
                for (child of children) {
                    let itemScore = parseInt(child.classList.item(1).split('-')[1])
                    if (score > itemScore) {
                        rowDiv.insertBefore(item, child)
                        return
                    }
                }
                rowDiv.appendChild(item)
                return
            }
        }
    }

    function getScore(itemDiv) {
        let score = parseInt(itemDiv.classList.item(1).split("-")[1])
        return isNaN(score) ? 0 : score
    }

    function getHighest(pastHighest) {
        let items = document.getElementsByClassName("item-image")

        for (item of items) {
            if (getScore(item) > getScore(pastHighest))
                return item
        }
    }

    function getClassIndex(div, _class) {
        let classes = div.classList
        for (let i = 0; i < classes.length; i++) {
            if (classes[i].split('-')[0] === _class) {
                return i
            }
        }
    }

    function changeClassValue(div, _class, newValue) {
        let classes = div.classList
        let index = getClassIndex(div, _class)
        classes.remove(classes.item(index))
        classes.add(`${_class}-${newValue}`)
    }

    function getClassValue(div, _class) {
        let index = getClassIndex(div, _class)
        return div.classList.item(index).split("-")[1]
    }

    let div = document.querySelector("#tierlist-body");

    document.getElementById("canvas-save").addEventListener("click", function() {
        html2canvas(div, {}).then((canvas) => {
            let image = canvas.toDataURL("image/png");
            let link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "html_image.png";
            link.href = canvas.toDataURL("image/png");
            link.target = '_blank';
            link.click();
        });
    })
</script>

@endsection