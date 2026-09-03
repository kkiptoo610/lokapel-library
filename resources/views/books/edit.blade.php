@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Edit Book</h1>

        <p class="text-muted mb-0">
            Update book information and manage individual physical copies.
        </p>

    </div>

</div>


{{-- VALIDATION ERRORS --}}

@if ($errors->any())

    <div class="alert alert-danger">

        <strong>Please correct the following errors:</strong>

        <ul class="mb-0 mt-2">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


@if (session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif


@if (session('error'))

    <div class="alert alert-danger">

        {{ session('error') }}

    </div>

@endif



{{-- BOOK INFORMATION --}}

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form
            action="{{ route('books.update', $book) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="row">


                {{-- BOOK TITLE --}}

                <div class="col-md-6 mb-3">

                    <label for="title" class="form-label">

                        Book Title

                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $book->title) }}"
                        required
                    >

                    @error('title')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- BOOK CODE --}}

                <div class="col-md-6 mb-3">

                    <label for="book_code" class="form-label">

                        Book Code

                    </label>

                    <input
                        type="text"
                        id="book_code"
                        name="book_code"
                        class="form-control @error('book_code') is-invalid @enderror"
                        value="{{ old('book_code', $book->book_code) }}"
                        required
                    >

                    @error('book_code')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- AUTHOR --}}

                <div class="col-md-6 mb-3">

                    <label for="author" class="form-label">

                        Author

                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        class="form-control @error('author') is-invalid @enderror"
                        value="{{ old('author', $book->author) }}"
                        required
                    >

                    @error('author')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- ISBN --}}

                <div class="col-md-6 mb-3">

                    <label for="isbn" class="form-label">

                        ISBN

                    </label>

                    <input
                        type="text"
                        id="isbn"
                        name="isbn"
                        class="form-control @error('isbn') is-invalid @enderror"
                        value="{{ old('isbn', $book->isbn) }}"
                    >

                    @error('isbn')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- MAIN CATEGORY --}}
                {{-- ================================================= --}}

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


                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'category_id',
                                        $book->category_id
                                    ) == $category->id
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


                {{-- ================================================= --}}
                {{-- SUBCATEGORY --}}
                {{-- ================================================= --}}

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
                    >

                        <option value="">

                            Select Subcategory

                        </option>


                        @foreach ($subcategories as $subcategory)

                            <option
                                value="{{ $subcategory->id }}"
                                data-category="{{ $subcategory->parent_id }}"
                                @selected(
                                    old(
                                        'subcategory_id',
                                        $book->subcategory_id
                                    ) == $subcategory->id
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


                {{-- PUBLISHER --}}

                <div class="col-md-6 mb-3">

                    <label for="publisher" class="form-label">

                        Publisher

                    </label>

                    <input
                        type="text"
                        id="publisher"
                        name="publisher"
                        class="form-control @error('publisher') is-invalid @enderror"
                        value="{{ old('publisher', $book->publisher) }}"
                    >

                    @error('publisher')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- PUBLICATION YEAR --}}

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
                        value="{{ old('publication_year', $book->publication_year) }}"
                        min="1000"
                        max="{{ date('Y') }}"
                    >

                    @error('publication_year')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- SHELF LOCATION --}}

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
                        value="{{ old('shelf_location', $book->shelf_location) }}"
                    >

                    @error('shelf_location')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- TOTAL COPIES --}}

                <div class="col-md-6 mb-3">

                    <label
                        for="total_copies"
                        class="form-label"
                    >

                        Total Physical Copies

                    </label>

                    <input
                        type="number"
                        id="total_copies"
                        name="total_copies"
                        class="form-control @error('total_copies') is-invalid @enderror"
                        value="{{ old('total_copies', $book->copies->count()) }}"
                        min="0"
                        readonly
                    >

                    <small class="text-muted">

                        This number is calculated from the individual copies.

                    </small>

                </div>


            </div>


            {{-- COPY STATISTICS --}}

            <div class="row mt-3">

                <div class="col-md-4 mb-3">

                    <div class="alert alert-primary mb-0">

                        <strong>Total Copies:</strong>

                        {{ $book->copies->count() }}

                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <div class="alert alert-success mb-0">

                        <strong>Available:</strong>

                        {{ $book->copies->where('status', 'available')->count() }}

                    </div>

                </div>


                <div class="col-md-4 mb-3">

                    <div class="alert alert-warning mb-0">

                        <strong>Borrowed:</strong>

                        {{ $book->copies->where('status', 'borrowed')->count() }}

                    </div>

                </div>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="bi bi-save"></i>

                Update Book

            </button>


            <a
                href="{{ route('books.index') }}"
                class="btn btn-secondary"
            >

                Cancel

            </a>


        </form>

    </div>

</div>



{{-- INDIVIDUAL COPIES --}}

<div class="card shadow-sm">

    <div
        class="card-header d-flex justify-content-between align-items-center"
    >

        <div>

            <strong>

                Individual Physical Copies

            </strong>

            <div class="small text-muted">

                Add and manage each physical copy separately.

            </div>

        </div>


        <button
            type="button"
            class="btn btn-success"
            data-bs-toggle="modal"
            data-bs-target="#addCopyModal"
        >

            <i class="bi bi-plus-circle"></i>

            Add Individual Copy

        </button>

    </div>


    <div class="card-body">


        @if ($book->copies->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Accession Number</th>

                            <th>Copy Number</th>

                            <th>Status</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($book->copies as $copy)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                <td>

                                    {{ $copy->accession_number }}

                                </td>


                                <td>

                                    <strong>

                                        {{ $copy->copy_number }}

                                    </strong>

                                </td>


                                <td>

                                    <span
                                        class="badge
                                        @if ($copy->status === 'available')
                                            text-bg-success
                                        @elseif ($copy->status === 'borrowed')
                                            text-bg-warning
                                        @elseif ($copy->status === 'lost')
                                            text-bg-danger
                                        @else
                                            text-bg-secondary
                                        @endif"
                                    >

                                        {{ ucfirst($copy->status) }}

                                    </span>

                                </td>


                                <td>

                                    @if ($copy->status !== 'borrowed')

                                        <form
                                            action="{{ route('books.copies.destroy', [$book, $copy]) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this physical copy?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                            >

                                                <i class="bi bi-trash"></i>

                                                Delete

                                            </button>

                                        </form>

                                    @else

                                        <span class="text-muted small">

                                            Cannot delete while borrowed.

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="alert alert-info mb-0">

                No individual physical copies have been created yet.

            </div>

        @endif

    </div>

</div>



{{-- ADD COPY MODAL --}}

<div
    class="modal fade"
    id="addCopyModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                action="{{ route('books.copies.store', $book) }}"
                method="POST"
            >

                @csrf


                <div class="modal-header">

                    <h5 class="modal-title">

                        Add Individual Physical Copy

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                <div class="modal-body">


                    <div class="mb-3">

                        <label
                            for="copy_number"
                            class="form-label"
                        >

                            Copy Number

                        </label>

                        <input
                            type="text"
                            id="copy_number"
                            name="copy_number"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="status"
                            class="form-label"
                        >

                            Status

                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select"
                        >

                            <option value="available">

                                Available

                            </option>

                            <option value="lost">

                                Lost

                            </option>

                            <option value="damaged">

                                Damaged

                            </option>

                        </select>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        Add Copy

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- CATEGORY / SUBCATEGORY FILTER JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function ()
    {

        const categorySelect =
            document.getElementById(
                'category_id'
            );


        const subcategorySelect =
            document.getElementById(
                'subcategory_id'
            );


        function filterSubcategories()
        {

            const selectedCategory =
                categorySelect.value;


            Array.from(
                subcategorySelect.options
            ).forEach(
                function (option)
                {

                    if (
                        option.value === ''
                    ) {

                        option.hidden = false;

                        return;

                    }


                    if (
                        selectedCategory === ''
                    ) {

                        option.hidden = true;

                    }

                    else {

                        option.hidden =
                            option.dataset.category
                            !==
                            selectedCategory;

                    }

                }
            );


            const selectedOption =
                subcategorySelect.options[
                    subcategorySelect.selectedIndex
                ];


            if (
                selectedOption
                &&
                selectedOption.value !== ''
                &&
                selectedOption.dataset.category
                !==
                selectedCategory
            ) {

                subcategorySelect.value = '';

            }

        }


        categorySelect.addEventListener(
            'change',
            function ()
            {

                subcategorySelect.value = '';

                filterSubcategories();

            }
        );


        filterSubcategories();

    }
);

</script>

@endsection