@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h1>Add Book</h1>

    <p class="text-muted">
        Add a new book and assign a unique number to each physical copy.
    </p>

</div>


{{-- ========================================================= --}}
{{-- VALIDATION ERRORS --}}
{{-- ========================================================= --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Please correct the following errors:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- ========================================================= --}}
{{-- BOOK FORM --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">

    <div class="card-body">

        <form
            action="{{ route('books.store') }}"
            method="POST"
        >

            @csrf


            <div class="row">


                {{-- ========================================================= --}}
                {{-- BOOK TITLE --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >

                        Book Title

                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >

                    @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- BOOK CODE --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="book_code"
                        class="form-label"
                    >

                        Book Code

                    </label>

                    <input
                        type="text"
                        id="book_code"
                        name="book_code"
                        class="form-control @error('book_code') is-invalid @enderror"
                        value="{{ old('book_code') }}"
                        placeholder="Example: BIO-G10"
                        required
                    >

                    <small class="text-muted">
                        Enter a unique code for this book.
                    </small>

                    @error('book_code')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- AUTHOR --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="author"
                        class="form-label"
                    >

                        Author

                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        class="form-control @error('author') is-invalid @enderror"
                        value="{{ old('author') }}"
                        required
                    >

                    @error('author')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- CATEGORY --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="category_id"
                        class="form-label"
                    >

                        Category

                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>


                        {{-- ONLY MAIN CATEGORIES --}}

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old('category_id') == $category->id
                                )
                            >

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>


                    @error('category_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- SUBCATEGORY --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="subcategory_id"
                        class="form-label"
                    >

                        Subcategory

                    </label>

                    <select
                        id="subcategory_id"
                        name="subcategory_id"
                        class="form-select @error('subcategory_id') is-invalid @enderror"
                        disabled
                    >

                        <option value="">
                            Select Subcategory
                        </option>


                        {{-- ALL SUBCATEGORIES --}}
                        {{-- JavaScript will filter them by parent_id --}}

                        @foreach($subcategories as $subcategory)

                            <option
                                value="{{ $subcategory->id }}"

                                data-parent-id="{{ $subcategory->parent_id }}"

                                @selected(
                                    old('subcategory_id') == $subcategory->id
                                )
                            >

                                {{ $subcategory->name }}

                            </option>

                        @endforeach

                    </select>


                    <small class="text-muted">
                        Select a category first to see its subcategories.
                    </small>


                    @error('subcategory_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- ISBN --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="isbn"
                        class="form-label"
                    >

                        ISBN

                    </label>

                    <input
                        type="text"
                        id="isbn"
                        name="isbn"
                        class="form-control @error('isbn') is-invalid @enderror"
                        value="{{ old('isbn') }}"
                    >

                    @error('isbn')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- PUBLISHER --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="publisher"
                        class="form-label"
                    >

                        Publisher

                    </label>

                    <input
                        type="text"
                        id="publisher"
                        name="publisher"
                        class="form-control @error('publisher') is-invalid @enderror"
                        value="{{ old('publisher') }}"
                    >

                    @error('publisher')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- PUBLICATION YEAR --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="publication_year"
                        class="form-label"
                    >

                        Publication Year

                    </label>

                    <input
                        type="number"
                        id="publication_year"
                        name="publication_year"
                        class="form-control @error('publication_year') is-invalid @enderror"
                        value="{{ old('publication_year') }}"
                        min="1000"
                        max="{{ date('Y') }}"
                    >

                    @error('publication_year')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- TOTAL COPIES --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="total_copies"
                        class="form-label"
                    >

                        Total Copies

                    </label>

                    <input
                        type="number"
                        id="total_copies"
                        name="total_copies"
                        class="form-control @error('total_copies') is-invalid @enderror"
                        value="{{ old('total_copies', 1) }}"
                        min="1"
                        required
                    >

                    <small class="text-muted">
                        Enter the number of physical copies.
                    </small>

                    @error('total_copies')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ========================================================= --}}
                {{-- SHELF LOCATION --}}
                {{-- ========================================================= --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="shelf_location"
                        class="form-label"
                    >

                        Shelf Location

                    </label>

                    <input
                        type="text"
                        id="shelf_location"
                        name="shelf_location"
                        class="form-control @error('shelf_location') is-invalid @enderror"
                        value="{{ old('shelf_location') }}"
                        placeholder="Example: Shelf A - Row 2"
                    >

                    @error('shelf_location')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


            </div>


            <hr class="my-4">


            {{-- ========================================================= --}}
            {{-- INDIVIDUAL COPY NUMBERS --}}
            {{-- ========================================================= --}}

            <div class="mb-3">

                <h4>
                    Individual Book Copy Numbers
                </h4>

                <p class="text-muted mb-0">
                    Give every physical book copy its own unique library number.
                </p>

                <p class="text-muted">

                    Example:

                    <strong>
                        LMS/BIO/01/026
                    </strong>

                </p>

            </div>


            <div
                id="copy_numbers_container"
                class="row"
            >
            </div>


            <div class="alert alert-info">

                <i class="bi bi-info-circle"></i>

                The number of copy number fields automatically matches
                the Total Copies entered above.

            </div>


            {{-- ========================================================= --}}
            {{-- BUTTONS --}}
            {{-- ========================================================= --}}

            <div class="mt-4">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-save"></i>

                    Save Book

                </button>


                <a
                    href="{{ route('books.index') }}"
                    class="btn btn-secondary"
                >

                    Cancel

                </a>

            </div>


        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function ()
    {


        /*
        |--------------------------------------------------------------------------
        | CATEGORY AND SUBCATEGORY
        |--------------------------------------------------------------------------
        */

        const categorySelect =
            document.getElementById(
                'category_id'
            );


        const subcategorySelect =
            document.getElementById(
                'subcategory_id'
            );


        /*
        |--------------------------------------------------------------------------
        | STORE ALL SUBCATEGORY OPTIONS
        |--------------------------------------------------------------------------
        */

        const allSubcategoryOptions =
            Array.from(
                subcategorySelect.options
            )
            .filter(
                option =>
                    option.value !== ''
            )
            .map(
                option =>
                    option.cloneNode(true)
            );


        /*
        |--------------------------------------------------------------------------
        | LOAD SUBCATEGORIES
        |--------------------------------------------------------------------------
        */

        function loadSubcategories()
        {

            const selectedCategoryId =
                categorySelect.value;


            /*
            |--------------------------------------------------------------------------
            | CLEAR CURRENT OPTIONS
            |--------------------------------------------------------------------------
            */

            subcategorySelect.innerHTML =
                '<option value="">Select Subcategory</option>';


            /*
            |--------------------------------------------------------------------------
            | NO CATEGORY SELECTED
            |--------------------------------------------------------------------------
            */

            if (
                selectedCategoryId === ''
            ) {

                subcategorySelect.disabled =
                    true;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | FILTER MATCHING SUBCATEGORIES
            |--------------------------------------------------------------------------
            */

            const matchingSubcategories =
                allSubcategoryOptions.filter(
                    function (option)
                    {

                        return (
                            option.dataset.parentId
                            ===
                            selectedCategoryId
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | ADD MATCHING OPTIONS
            |--------------------------------------------------------------------------
            */

            matchingSubcategories.forEach(
                function (option)
                {

                    subcategorySelect.appendChild(
                        option.cloneNode(true)
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | ENABLE / DISABLE
            |--------------------------------------------------------------------------
            */

            if (
                matchingSubcategories.length > 0
            ) {

                subcategorySelect.disabled =
                    false;

            }

            else {

                subcategorySelect.disabled =
                    true;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY CHANGE EVENT
        |--------------------------------------------------------------------------
        */

        categorySelect.addEventListener(
            'change',
            function ()
            {

                loadSubcategories();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        loadSubcategories();


        /*
        |--------------------------------------------------------------------------
        | COPY NUMBER SYSTEM
        |--------------------------------------------------------------------------
        */

        const totalCopiesInput =
            document.getElementById(
                'total_copies'
            );


        const copyNumbersContainer =
            document.getElementById(
                'copy_numbers_container'
            );


        const oldCopyNumbers =
            @json(
                old(
                    'copy_numbers',
                    []
                )
            );


        function generateCopyFields()
        {

            let totalCopies =
                parseInt(
                    totalCopiesInput.value
                );


            if (
                isNaN(
                    totalCopies
                )
                ||
                totalCopies < 1
            ) {

                totalCopies = 1;

            }


            /*
            |--------------------------------------------------------------------------
            | SAVE EXISTING VALUES
            |--------------------------------------------------------------------------
            */

            const currentValues =
                [];


            const existingInputs =
                copyNumbersContainer.querySelectorAll(
                    'input[name="copy_numbers[]"]'
                );


            existingInputs.forEach(
                function (input)
                {

                    currentValues.push(
                        input.value
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | CLEAR CONTAINER
            |--------------------------------------------------------------------------
            */

            copyNumbersContainer.innerHTML =
                '';


            /*
            |--------------------------------------------------------------------------
            | CREATE NEW FIELDS
            |--------------------------------------------------------------------------
            */

            for (
                let index = 0;
                index < totalCopies;
                index++
            ) {

                const column =
                    document.createElement(
                        'div'
                    );


                column.className =
                    'col-md-6 mb-3';


                const label =
                    document.createElement(
                        'label'
                    );


                label.className =
                    'form-label';


                label.textContent =
                    'Copy '
                    +
                    (index + 1)
                    +
                    ' Number';


                const input =
                    document.createElement(
                        'input'
                    );


                input.type =
                    'text';


                input.name =
                    'copy_numbers[]';


                input.className =
                    'form-control';


                input.required =
                    true;


                input.placeholder =
                    'Example: LMS/BOOK/'
                    +
                    String(
                        index + 1
                    ).padStart(
                        2,
                        '0'
                    )
                    +
                    '/026';


                /*
                |--------------------------------------------------------------------------
                | RESTORE VALUES
                |--------------------------------------------------------------------------
                */

                if (
                    currentValues[index]
                ) {

                    input.value =
                        currentValues[index];

                }

                else if (
                    oldCopyNumbers[index]
                ) {

                    input.value =
                        oldCopyNumbers[index];

                }


                column.appendChild(
                    label
                );


                column.appendChild(
                    input
                );


                copyNumbersContainer.appendChild(
                    column
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL COPIES EVENTS
        |--------------------------------------------------------------------------
        */

        totalCopiesInput.addEventListener(
            'input',
            generateCopyFields
        );


        totalCopiesInput.addEventListener(
            'change',
            generateCopyFields
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL COPY FIELDS
        |--------------------------------------------------------------------------
        */

        generateCopyFields();


    }
);

</script>

@endsection