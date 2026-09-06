@extends('layouts.app')

@section('content')

<div class="page-header">

```
<div class="page-title">

    <div class="page-title-icon">
        <i class="bi bi-plus-circle"></i>
    </div>

    <div>
        <h1>Add Inventory Item</h1>

        <p>
            Add a new item to the teachers or laboratory inventory.
        </p>
    </div>

</div>


<a
    href="{{ route('inventory.index') }}"
    class="btn btn-outline-secondary"
>
    <i class="bi bi-arrow-left me-2"></i>
    Back to Inventory
</a>
```

</div>

<div class="modern-page-card">

```
<div class="card-body p-4 p-md-5">


    @if ($errors->any())

        <div class="alert alert-danger">

            <div class="fw-bold mb-2">

                <i class="bi bi-exclamation-circle me-2"></i>

                Please correct the following errors:

            </div>


            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('inventory.items.store') }}"
        method="POST"
    >

        @csrf


        <div class="row g-4">


            {{-- CATEGORY --}}

            <div class="col-md-6">

                <label
                    for="inventory_category_id"
                    class="form-label fw-semibold"
                >
                    Inventory Category
                </label>


                <select
                    name="inventory_category_id"
                    id="inventory_category_id"
                    class="form-select @error('inventory_category_id') is-invalid @enderror"
                    required
                >

                    <option value="">
                        Select category
                    </option>


                    @foreach ($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            data-type="{{ $category->type }}"
                            @selected(old('inventory_category_id') == $category->id)
                        >

                            {{ $category->name }}

                            @if ($category->type === 'teachers')

                                — Teachers Inventory

                            @elseif ($category->type === 'laboratory')

                                — Laboratory Inventory

                            @endif

                        </option>

                    @endforeach

                </select>


                @error('inventory_category_id')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ITEM NAME --}}

            <div class="col-md-6">

                <label
                    for="name"
                    class="form-label fw-semibold"
                >
                    Item Name
                </label>


                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Search or type a new inventory item..."
                    autocomplete="off"
                    required
                >


                <div
                    id="itemSuggestions"
                    class="list-group mt-2 d-none"
                    style="max-height: 250px; overflow-y: auto;"
                >
                </div>


                <div class="form-text">

                    <i class="bi bi-search me-1"></i>

                    Start typing to search available inventory items.
                    If the item is missing, simply type a new name.

                </div>


                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- UNIT --}}

            <div class="col-md-4">

                <label
                    for="unit"
                    class="form-label fw-semibold"
                >
                    Unit
                </label>


                <input
                    type="text"
                    name="unit"
                    id="unit"
                    value="{{ old('unit', 'Pieces') }}"
                    class="form-control @error('unit') is-invalid @enderror"
                    placeholder="Example: Pieces"
                    required
                >


                @error('unit')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- QUANTITY --}}

            <div class="col-md-4">

                <label
                    for="quantity"
                    class="form-label fw-semibold"
                >
                    Current Quantity
                </label>


                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    value="{{ old('quantity', 0) }}"
                    min="0"
                    class="form-control @error('quantity') is-invalid @enderror"
                    required
                >


                @error('quantity')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- MINIMUM QUANTITY --}}

            <div class="col-md-4">

                <label
                    for="minimum_quantity"
                    class="form-label fw-semibold"
                >
                    Minimum Stock Level
                </label>


                <input
                    type="number"
                    name="minimum_quantity"
                    id="minimum_quantity"
                    value="{{ old('minimum_quantity', 5) }}"
                    min="0"
                    class="form-control @error('minimum_quantity') is-invalid @enderror"
                    required
                >


                <div class="form-text">

                    The item will appear in Low Stock when it reaches this quantity.

                </div>


                @error('minimum_quantity')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- DESCRIPTION --}}

            <div class="col-12">

                <label
                    for="description"
                    class="form-label fw-semibold"
                >

                    Description

                    <span class="text-muted">
                        (Optional)
                    </span>

                </label>


                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Select an item above to automatically add its description, or type your own..."
                >{{ old('description') }}</textarea>


                @error('description')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BUTTONS --}}

            <div class="col-12">

                <div class="d-flex gap-2 justify-content-end">

                    <a
                        href="{{ route('inventory.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-check-circle me-2"></i>

                        Save Inventory Item

                    </button>

                </div>

            </div>


        </div>

    </form>

</div>
```

</div>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Inventory Items
        |--------------------------------------------------------------------------
        */

        const inventoryItems = {


            /*
            |--------------------------------------------------------------------------
            | Teachers Inventory
            |--------------------------------------------------------------------------
            */

            teachers: [

                {
                    name: 'Blue Marker',
                    description: 'Blue whiteboard markers for classroom teaching.'
                },

                {
                    name: 'Black Marker',
                    description: 'Black whiteboard markers.'
                },

                {
                    name: 'Red Marker',
                    description: 'Red whiteboard markers.'
                },

                {
                    name: 'Green Marker',
                    description: 'Green whiteboard markers.'
                },

                {
                    name: 'Chalk',
                    description: 'White and colored chalk for classroom use.'
                },

                {
                    name: 'Duster',
                    description: 'Whiteboard and chalkboard dusters.'
                },

                {
                    name: 'Exercise Books',
                    description: 'Books for teacher lesson preparation and records.'
                },

                {
                    name: 'Manila Papers',
                    description: 'Teaching and classroom presentation materials.'
                },

                {
                    name: 'Rulers',
                    description: 'Rulers for teaching and classroom activities.'
                },

                {
                    name: 'Permanent Marker',
                    description: 'Permanent markers for labeling and general use.'
                },

                {
                    name: 'Pens',
                    description: 'Ballpoint pens for teachers.'
                },

                {
                    name: 'Pencils',
                    description: 'Pencils for classroom and administrative use.'
                },

                {
                    name: 'Staplers',
                    description: 'Staplers for office and teaching documents.'
                },

                {
                    name: 'Staples',
                    description: 'Stapler refill pins.'
                },

                {
                    name: 'Punching Machine',
                    description: 'Paper punching machines.'
                },

                {
                    name: 'Files',
                    description: 'Files for storing teaching documents.'
                },

                {
                    name: 'Folders',
                    description: 'Folders for teacher records.'
                },

                {
                    name: 'A4 Printing Paper',
                    description: 'Printing and photocopying paper.'
                },

                {
                    name: 'Sticky Notes',
                    description: 'Notes for reminders and organization.'
                },

                {
                    name: 'Scissors',
                    description: 'Scissors for teaching and office activities.'
                },

                {
                    name: 'Glue',
                    description: 'Adhesive for teaching materials.'
                },

                {
                    name: 'Attendance Register',
                    description: 'Registers for recording learner attendance.'
                },

                {
                    name: 'Lesson Plan Book',
                    description: 'Books for preparing lesson plans.'
                },

                {
                    name: 'Record of Work Book',
                    description: 'Books for recording completed syllabus work.'
                },

                {
                    name: "Teacher's Diary",
                    description: 'Daily teacher planning and record book.'
                },

                {
                    name: 'Flash Disks',
                    description: 'Storage devices for teaching resources.'
                }

            ],


            /*
            |--------------------------------------------------------------------------
            | Laboratory Inventory
            |--------------------------------------------------------------------------
            */

            laboratory: [

                {
                    name: 'Beakers 100ml',
                    description: 'Glass beakers for laboratory experiments.'
                },

                {
                    name: 'Beakers 250ml',
                    description: 'Glass beakers for laboratory experiments.'
                },

                {
                    name: 'Beakers 500ml',
                    description: 'Large glass beakers.'
                },

                {
                    name: 'Measuring Cylinder 100ml',
                    description: 'Measuring liquids accurately.'
                },

                {
                    name: 'Measuring Cylinder 250ml',
                    description: 'Measuring larger liquid volumes.'
                },

                {
                    name: 'Test Tubes',
                    description: 'Containers for chemical experiments.'
                },

                {
                    name: 'Test Tube Holder',
                    description: 'Holds test tubes during experiments.'
                },

                {
                    name: 'Test Tube Rack',
                    description: 'Holds test tubes upright.'
                },

                {
                    name: 'Conical Flask 250ml',
                    description: 'Used for mixing and chemical reactions.'
                },

                {
                    name: 'Conical Flask 500ml',
                    description: 'Large laboratory flask.'
                },

                {
                    name: 'Thermometer',
                    description: 'Measures temperature.'
                },

                {
                    name: 'Tripod Stand',
                    description: 'Supports apparatus during heating.'
                },

                {
                    name: 'Wire Gauze',
                    description: 'Supports containers during heating.'
                },

                {
                    name: 'Bunsen Burner',
                    description: 'Gas burner for heating.'
                },

                {
                    name: 'Spatula',
                    description: 'Transfers small quantities of chemicals.'
                },

                {
                    name: 'Glass Stirring Rod',
                    description: 'Used for stirring solutions.'
                },

                {
                    name: 'Funnel',
                    description: 'Used for transferring liquids.'
                },

                {
                    name: 'Evaporating Dish',
                    description: 'Used for evaporation experiments.'
                },

                {
                    name: 'Watch Glass',
                    description: 'Used in evaporation and covering containers.'
                },

                {
                    name: 'Mortar and Pestle',
                    description: 'Used for grinding substances.'
                },

                {
                    name: 'Balance',
                    description: 'Measures mass of substances.'
                },

                {
                    name: 'Retort Stand',
                    description: 'Supports laboratory apparatus.'
                },

                {
                    name: 'Clamp',
                    description: 'Holds laboratory apparatus.'
                },

                {
                    name: 'Dropper',
                    description: 'Transfers small quantities of liquid.'
                },

                {
                    name: 'Wash Bottle',
                    description: 'Used for washing laboratory apparatus.'
                },

                {
                    name: 'Petri Dish',
                    description: 'Used for biological experiments.'
                },

                {
                    name: 'Microscope',
                    description: 'Used for observing microscopic specimens.'
                },

                {
                    name: 'Microscope Slides',
                    description: 'Used for preparing specimens.'
                },

                {
                    name: 'Cover Slips',
                    description: 'Covers microscope specimens.'
                },

                {
                    name: 'Specimen Bottles',
                    description: 'Stores biological specimens.'
                },

                {
                    name: 'Dissecting Kit',
                    description: 'Used for biological dissection.'
                },

                {
                    name: 'Forceps',
                    description: 'Used for holding small biological specimens.'
                },

                {
                    name: 'Scalpel',
                    description: 'Used for biological dissection.'
                },

                {
                    name: 'Dissecting Tray',
                    description: 'Used during biological dissection.'
                },

                {
                    name: 'Hand Lens',
                    description: 'Used for observing small specimens.'
                },

                {
                    name: 'Specimen Jars',
                    description: 'Used for storing biological specimens.'
                },

                {
                    name: 'Model of Human Heart',
                    description: 'Educational model of the human heart.'
                },

                {
                    name: 'Model of Human Torso',
                    description: 'Educational model of the human torso.'
                },

                {
                    name: 'Skeleton Model',
                    description: 'Educational human skeleton model.'
                },

                {
                    name: 'Prepared Slides',
                    description: 'Prepared biological microscope slides.'
                },

                {
                    name: 'Burette',
                    description: 'Used for measuring and dispensing liquids accurately.'
                },

                {
                    name: 'Pipette',
                    description: 'Used for transferring measured liquid volumes.'
                },

                {
                    name: 'Pipette Filler',
                    description: 'Used with pipettes for safe liquid transfer.'
                },

                {
                    name: 'Volumetric Flask',
                    description: 'Used for preparing precise liquid volumes.'
                },

                {
                    name: 'Chemical Reagent Bottles',
                    description: 'Used for storing laboratory chemicals.'
                },

                {
                    name: 'Crucible',
                    description: 'Used for heating substances to high temperatures.'
                },

                {
                    name: 'Crucible Tongs',
                    description: 'Used for handling hot crucibles.'
                },

                {
                    name: 'pH Paper',
                    description: 'Used for testing acidity and alkalinity.'
                },

                {
                    name: 'Filter Paper',
                    description: 'Used for filtering mixtures.'
                },

                {
                    name: 'Ammeter',
                    description: 'Measures electric current.'
                },

                {
                    name: 'Voltmeter',
                    description: 'Measures electrical voltage.'
                },

                {
                    name: 'Galvanometer',
                    description: 'Detects and measures small electric currents.'
                },

                {
                    name: 'Connecting Wires',
                    description: 'Used for electrical circuit connections.'
                },

                {
                    name: 'Resistors',
                    description: 'Used to control electrical resistance in circuits.'
                },

                {
                    name: 'Switches',
                    description: 'Used to open and close electrical circuits.'
                },

                {
                    name: 'Cells',
                    description: 'Electrical cells used as power sources.'
                },

                {
                    name: 'Magnets',
                    description: 'Used for magnetism experiments.'
                },

                {
                    name: 'Metre Rule',
                    description: 'Used for measuring length.'
                },

                {
                    name: 'Vernier Caliper',
                    description: 'Used for precise measurement.'
                },

                {
                    name: 'Micrometer Screw Gauge',
                    description: 'Used for measuring very small dimensions.'
                },

                {
                    name: 'Spring Balance',
                    description: 'Used for measuring force or weight.'
                },

                {
                    name: 'Stop Watch',
                    description: 'Used for measuring time intervals.'
                },

                {
                    name: 'Laboratory Coat',
                    description: 'Protective clothing for laboratory work.'
                },

                {
                    name: 'Safety Goggles',
                    description: 'Protects the eyes during laboratory experiments.'
                },

                {
                    name: 'Protective Gloves',
                    description: 'Protects hands during laboratory work.'
                },

                {
                    name: 'First Aid Kit',
                    description: 'Contains supplies for emergency first aid.'
                },

                {
                    name: 'Fire Extinguisher',
                    description: 'Used for extinguishing laboratory fires.'
                },

                {
                    name: 'Safety Signage',
                    description: 'Safety signs for laboratory areas.'
                },

                {
                    name: 'Laboratory Waste Bin',
                    description: 'Used for safe disposal of laboratory waste.'
                }

            ]

        };


        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const categorySelect = document.getElementById(
            'inventory_category_id'
        );

        const itemNameInput = document.getElementById(
            'name'
        );

        const descriptionInput = document.getElementById(
            'description'
        );

        const suggestionsBox = document.getElementById(
            'itemSuggestions'
        );


        /*
        |--------------------------------------------------------------------------
        | Get Selected Category Type
        |--------------------------------------------------------------------------
        */

        function getCategoryType()
        {
            const option =
                categorySelect.options[
                    categorySelect.selectedIndex
                ];

            return option
                ? option.dataset.type
                : '';
        }


        /*
        |--------------------------------------------------------------------------
        | Show Suggestions
        |--------------------------------------------------------------------------
        */

        function showSuggestions()
        {
            const categoryType =
                getCategoryType();

            const searchText =
                itemNameInput.value
                    .trim()
                    .toLowerCase();


            suggestionsBox.innerHTML = '';


            if (
                !categoryType
                ||
                !inventoryItems[categoryType]
            ) {
                suggestionsBox.classList.add(
                    'd-none'
                );

                return;
            }


            const results =
                inventoryItems[
                    categoryType
                ].filter(
                    function (item)
                    {
                        return item.name
                            .toLowerCase()
                            .includes(
                                searchText
                            );
                    }
                );


            if (
                results.length === 0
            ) {

                suggestionsBox.innerHTML = `

                    <div class="list-group-item text-muted">

                        <i class="bi bi-plus-circle me-2"></i>

                        Item not found. You can add
                        "<strong>${itemNameInput.value}</strong>"
                        as a new inventory item.

                    </div>

                `;


                suggestionsBox.classList.remove(
                    'd-none'
                );

                return;
            }


            results
                .slice(0, 10)
                .forEach(
                    function (item)
                    {

                        const button =
                            document.createElement(
                                'button'
                            );


                        button.type =
                            'button';


                        button.className =
                            'list-group-item list-group-item-action';


                        button.innerHTML = `

                            <div class="fw-semibold">

                                ${item.name}

                            </div>


                            <small class="text-muted">

                                ${item.description}

                            </small>

                        `;


                        button.addEventListener(
                            'click',
                            function ()
                            {

                                itemNameInput.value =
                                    item.name;


                                descriptionInput.value =
                                    item.description;


                                suggestionsBox.innerHTML =
                                    '';


                                suggestionsBox.classList.add(
                                    'd-none'
                                );

                            }
                        );


                        suggestionsBox.appendChild(
                            button
                        );

                    }
                );


            suggestionsBox.classList.remove(
                'd-none'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        categorySelect.addEventListener(
            'change',
            function ()
            {

                itemNameInput.value =
                    '';


                descriptionInput.value =
                    '';


                suggestionsBox.innerHTML =
                    '';


                suggestionsBox.classList.add(
                    'd-none'
                );

            }
        );


        itemNameInput.addEventListener(
            'focus',
            showSuggestions
        );


        itemNameInput.addEventListener(
            'input',
            showSuggestions
        );


        document.addEventListener(
            'click',
            function (event)
            {

                if (
                    !itemNameInput.contains(
                        event.target
                    )
                    &&
                    !suggestionsBox.contains(
                        event.target
                    )
                ) {

                    suggestionsBox.classList.add(
                        'd-none'
                    );

                }

            }
        );


    }
);

</script>

@endsection
