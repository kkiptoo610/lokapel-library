@extends('layouts.app')

@section('content')

<style>

    /* ========================================================= */
    /* PAGE HEADER */
    /* ========================================================= */

    .inventory-page-header {

        background:
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f4f7fb 100%
            );

        border:
            1px solid
            #e3eaf3;

        border-radius:
            16px;

        padding:
            25px;

        margin-bottom:
            25px;

        box-shadow:
            0 6px 20px
            rgba(0, 0, 0, 0.05);

    }


    .inventory-page-title {

        font-size:
            28px;

        font-weight:
            700;

        color:
            #1f2937;

        margin-bottom:
            6px;

    }


    .inventory-page-subtitle {

        color:
            #6b7280;

        margin-bottom:
            0;

        font-size:
            15px;

    }


    .inventory-title-icon {

        width:
            48px;

        height:
            48px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        background:
            #eaf2ff;

        color:
            #0d6efd;

        border-radius:
            12px;

        font-size:
            22px;

        margin-right:
            15px;

    }


    /* ========================================================= */
    /* BUTTONS */
    /* ========================================================= */

    .inventory-btn-primary {

        background:
            linear-gradient(
                135deg,
                #0d6efd,
                #0a58ca
            );

        border:
            none;

        padding:
            9px 18px;

        border-radius:
            9px;

        font-weight:
            600;

        box-shadow:
            0 4px 10px
            rgba(13, 110, 253, 0.20);

        transition:
            all
            0.2s
            ease;

    }


    .inventory-btn-primary:hover {

        transform:
            translateY(-1px);

        box-shadow:
            0 6px 15px
            rgba(13, 110, 253, 0.30);

    }


    .inventory-btn-secondary {

        border-radius:
            9px;

        padding:
            9px 18px;

        font-weight:
            600;

    }


    /* ========================================================= */
    /* FILTER CARD */
    /* ========================================================= */

    .inventory-filter-card {

        border:
            none;

        border-radius:
            16px;

        overflow:
            hidden;

        box-shadow:
            0 5px 20px
            rgba(0, 0, 0, 0.06);

    }


    .inventory-filter-card
    .card-body {

        padding:
            25px;

        background:
            #ffffff;

    }


    .inventory-filter-title {

        font-size:
            16px;

        font-weight:
            700;

        color:
            #374151;

        margin-bottom:
            20px;

    }


    .inventory-filter-card
    .form-label {

        font-size:
            13px;

        font-weight:
            600;

        color:
            #4b5563;

        margin-bottom:
            7px;

    }


    .inventory-filter-card
    .form-control,

    .inventory-filter-card
    .form-select {

        border-radius:
            9px;

        border:
            1px solid
            #dbe3ec;

        min-height:
            44px;

    }


    .inventory-filter-card
    .form-control:focus,

    .inventory-filter-card
    .form-select:focus {

        border-color:
            #86b7fe;

        box-shadow:
            0 0 0
            0.2rem
            rgba(13, 110, 253, 0.10);

    }


    /* ========================================================= */
    /* LIVE SEARCH */
    /* ========================================================= */

    #searchSuggestions {

        border-radius:
            10px;

        overflow:
            hidden;

        border:
            1px solid
            #e5e7eb;

        margin-top:
            5px;

    }


    #searchSuggestions
    .list-group-item {

        border:
            none;

        border-bottom:
            1px solid
            #eef1f4;

        padding:
            12px 15px;

    }


    #searchSuggestions
    .list-group-item:last-child {

        border-bottom:
            none;

    }


    #searchSuggestions
    .list-group-item:hover {

        background:
            #f4f8ff;

    }


    /* ========================================================= */
    /* BOOK CARD */
    /* ========================================================= */

    .inventory-book-card {

        border:
            none;

        border-radius:
            16px;

        overflow:
            hidden;

        box-shadow:
            0 5px 20px
            rgba(0, 0, 0, 0.06);

        transition:
            all
            0.2s
            ease;

    }


    .inventory-book-card:hover {

        transform:
            translateY(-2px);

        box-shadow:
            0 10px 30px
            rgba(0, 0, 0, 0.09);

    }


    /* ========================================================= */
    /* BOOK HEADER */
    /* ========================================================= */

    .inventory-book-header {

        background:
            linear-gradient(
                135deg,
                #f8fbff,
                #eef5ff
            );

        border-bottom:
            1px solid
            #e1e8f0;

        padding:
            22px;

    }


    .inventory-book-title {

        font-size:
            19px;

        font-weight:
            700;

        color:
            #1f2937;

        line-height:
            1.4;

    }


    .inventory-book-author {

        color:
            #6b7280;

        font-size:
            14px;

    }


    /* ========================================================= */
    /* BOOK BADGES */
    /* ========================================================= */

    .inventory-category-badge {

        background:
            #e7f0ff;

        color:
            #0d5cc7;

        border:
            1px solid
            #cfe2ff;

        font-weight:
            600;

        padding:
            7px 10px;

        border-radius:
            8px;

    }


    .inventory-subcategory-badge {

        background:
            #e6f8f5;

        color:
            #137c6b;

        border:
            1px solid
            #c8eee8;

        font-weight:
            600;

        padding:
            7px 10px;

        border-radius:
            8px;

    }


    /* ========================================================= */
    /* BOOK DETAILS */
    /* ========================================================= */

    .inventory-book-details {

        margin-top:
            14px;

        padding-top:
            12px;

        border-top:
            1px solid
            #e8edf3;

    }


    .inventory-book-details
    small {

        display:
            block;

        margin-bottom:
            5px;

        font-size:
            13px;

    }


    .inventory-detail-label {

        font-weight:
            700;

        color:
            #4b5563;

    }


    /* ========================================================= */
    /* STATISTICS */
    /* ========================================================= */

    .inventory-stat-box {

        min-width:
            115px;

        padding:
            10px 15px;

        border-radius:
            10px;

        text-align:
            center;

        margin-bottom:
            8px;

    }


    .inventory-stat-total {

        background:
            #eaf2ff;

        color:
            #0d5cc7;

        border:
            1px solid
            #cfe2ff;

    }


    .inventory-stat-available {

        background:
            #e9f9ef;

        color:
            #198754;

        border:
            1px solid
            #c8eed6;

    }


    .inventory-stat-number {

        font-size:
            20px;

        font-weight:
            700;

        display:
            block;

    }


    .inventory-stat-label {

        font-size:
            12px;

        font-weight:
            600;

    }


    /* ========================================================= */
    /* TABLE */
    /* ========================================================= */

    .inventory-table {

        margin-bottom:
            0;

    }


    .inventory-table
    thead
    th {

        background:
            #f1f5f9;

        color:
            #374151;

        font-size:
            13px;

        font-weight:
            700;

        padding:
            13px;

        border-bottom:
            2px solid
            #dce3ea;

        white-space:
            nowrap;

    }


    .inventory-table
    tbody
    td {

        padding:
            13px;

        color:
            #374151;

        vertical-align:
            middle;

    }


    .inventory-table
    tbody
    tr {

        transition:
            background
            0.15s
            ease;

    }


    .inventory-table
    tbody
    tr:hover {

        background:
            #f8fbff;

    }


    /* ========================================================= */
    /* COPY NUMBER */
    /* ========================================================= */

    .inventory-copy-number {

        color:
            #0d6efd;

        font-weight:
            700;

        letter-spacing:
            0.2px;

    }


    /* ========================================================= */
    /* STATUS BADGES */
    /* ========================================================= */

    .inventory-status {

        font-size:
            12px;

        font-weight:
            700;

        padding:
            7px 10px;

        border-radius:
            7px;

    }


    /* ========================================================= */
    /* EMPTY STATE */
    /* ========================================================= */

    .inventory-empty-state {

        border-radius:
            14px;

        padding:
            25px;

        border:
            1px solid
            #bee5eb;

    }


    /* ========================================================= */
    /* RESPONSIVE */
    /* ========================================================= */

    @media (max-width: 768px) {

        .inventory-page-header {

            padding:
                20px;

        }


        .inventory-book-header {

            padding:
                18px;

        }


        .inventory-stat-box {

            min-width:
                100px;

        }

    }

</style>



{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="inventory-page-header">

    <div
        class="
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
            gap-3
        "
    >

        <div
            class="
                d-flex
                align-items-center
            "
        >

            <div class="inventory-title-icon">

                <i class="bi bi-box-seam"></i>

            </div>


            <div>

                <h1 class="inventory-page-title">

                    Library Inventory Report

                </h1>


                <p class="inventory-page-subtitle">

                    View books by category, subcategory and individual physical copies.

                </p>

            </div>

        </div>


        <div
            class="
                d-flex
                gap-2
            "
        >

            {{-- BACK TO REPORTS --}}

            <a
                href="{{ route('reports.index') }}"
                class="
                    btn
                    btn-outline-secondary
                    inventory-btn-secondary
                "
            >

                <i class="bi bi-arrow-left"></i>

                Back

            </a>


            {{-- PREVIEW REPORT --}}

            <a
                href="{{ route('reports.inventory.preview', request()->query()) }}"
                class="
                    btn
                    btn-primary
                    inventory-btn-primary
                "
            >

                <i class="bi bi-eye"></i>

                Preview Report

            </a>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- SEARCH AND FILTERS --}}
{{-- ========================================================= --}}

<div class="card inventory-filter-card mb-4">

    <div class="card-body">

        <div class="inventory-filter-title">

            <i class="bi bi-funnel me-2"></i>

            Search and Filter Inventory

        </div>


        <form
            method="GET"
            action="{{ route('reports.inventory') }}"
        >

            <div class="row g-3">


                {{-- ================================================= --}}
                {{-- SEARCH --}}
                {{-- ================================================= --}}

                <div class="col-md-6 position-relative">

                    <label
                        for="inventorySearch"
                        class="form-label"
                    >

                        Search Books or LMS Number

                    </label>


                    <input
                        type="text"
                        name="search"
                        id="inventorySearch"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Book title, LMS number, book code, author or ISBN..."
                        autocomplete="off"
                    >


                    {{-- LIVE SEARCH SUGGESTIONS --}}

                    <div
                        id="searchSuggestions"
                        class="
                            list-group
                            position-absolute
                            w-100
                            shadow
                        "
                        style="
                            z-index: 1000;
                            display: none;
                            max-height: 350px;
                            overflow-y: auto;
                        "
                    >

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CATEGORY --}}
                {{-- ================================================= --}}

                <div class="col-md-3">

                    <label
                        for="category_id"
                        class="form-label"
                    >

                        Category

                    </label>


                    <select
                        name="category_id"
                        id="category_id"
                        class="form-select"
                    >

                        <option value="">

                            All Categories

                        </option>


                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    request('category_id') == $category->id
                                )
                            >

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- ================================================= --}}
                {{-- SUBCATEGORY --}}
                {{-- ================================================= --}}

                <div class="col-md-3">

                    <label
                        for="subcategory_id"
                        class="form-label"
                    >

                        Subcategory

                    </label>


                    <select
                        name="subcategory_id"
                        id="subcategory_id"
                        class="form-select"
                    >

                        <option value="">

                            All Subcategories

                        </option>


                        @foreach($subcategories as $subcategory)

                            <option
                                value="{{ $subcategory->id }}"
                                data-category="{{ $subcategory->category_id }}"
                                @selected(
                                    request('subcategory_id')
                                    == $subcategory->id
                                )
                            >

                                {{ $subcategory->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- ================================================= --}}
                {{-- BUTTONS --}}
                {{-- ================================================= --}}

                <div class="col-12">

                    <button
                        type="submit"
                        class="
                            btn
                            btn-primary
                            inventory-btn-primary
                        "
                    >

                        <i class="bi bi-search"></i>

                        Search

                    </button>


                    <a
                        href="{{ route('reports.inventory') }}"
                        class="
                            btn
                            btn-outline-secondary
                            inventory-btn-secondary
                            ms-2
                        "
                    >

                        <i class="bi bi-x-circle"></i>

                        Clear

                    </a>

                </div>


            </div>

        </form>

    </div>

</div>



{{-- ========================================================= --}}
{{-- INVENTORY RESULTS --}}
{{-- ========================================================= --}}

@forelse($books as $book)

    @php

        /*
        |--------------------------------------------------------------------------
        | DETERMINE CORRECT CATEGORY
        |--------------------------------------------------------------------------
        */

        $displayCategory = null;


        if (
            $book->subcategory
            &&
            $book->subcategory->category
        ) {

            $displayCategory =
                $book->subcategory->category;

        }

        elseif (
            $book->category
        ) {

            $displayCategory =
                $book->category;

        }

    @endphp


    <div class="card inventory-book-card mb-4">


        {{-- ================================================= --}}
        {{-- BOOK HEADER --}}
        {{-- ================================================= --}}

        <div class="inventory-book-header">

            <div
                class="
                    d-flex
                    justify-content-between
                    align-items-start
                    flex-wrap
                    gap-3
                "
            >


                {{-- ================================================= --}}
                {{-- BOOK INFORMATION --}}
                {{-- ================================================= --}}

                <div>


                    {{-- BOOK TITLE --}}

                    <div class="inventory-book-title">

                        <i
                            class="
                                bi
                                bi-book
                                text-primary
                                me-2
                            "
                        ></i>

                        {{ $book->title }}

                    </div>


                    {{-- AUTHOR --}}

                    @if($book->author)

                        <div class="inventory-book-author mt-1">

                            By

                            {{ $book->author }}

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- CATEGORY AND SUBCATEGORY --}}
                    {{-- ================================================= --}}

                    <div class="mt-3">


                        {{-- MAIN CATEGORY --}}

                        @if($displayCategory)

                            <span
                                class="
                                    badge
                                    inventory-category-badge
                                    me-1
                                "
                            >

                                <i class="bi bi-folder me-1"></i>

                                Category:

                                {{ $displayCategory->name }}

                            </span>

                        @endif


                        {{-- SUBCATEGORY --}}

                        @if($book->subcategory)

                            <span
                                class="
                                    badge
                                    inventory-subcategory-badge
                                "
                            >

                                <i class="bi bi-folder2-open me-1"></i>

                                Subcategory:

                                {{ $book->subcategory->name }}

                            </span>

                        @endif


                    </div>


                    {{-- ================================================= --}}
                    {{-- BOOK DETAILS --}}
                    {{-- ================================================= --}}

                    <div class="inventory-book-details">


                        {{-- BOOK CODE --}}

                        <small>

                            <span class="inventory-detail-label">

                                <i class="bi bi-upc-scan me-1"></i>

                                Book Code:

                            </span>

                            {{ $book->book_code ?? '-' }}

                        </small>


                        {{-- ISBN --}}

                        @if($book->isbn)

                            <small>

                                <span class="inventory-detail-label">

                                    ISBN:

                                </span>

                                {{ $book->isbn }}

                            </small>

                        @endif


                        {{-- SHELF LOCATION --}}

                        @if($book->shelf_location)

                            <small>

                                <span class="inventory-detail-label">

                                    <i class="bi bi-geo-alt me-1"></i>

                                    Shelf:

                                </span>

                                {{ $book->shelf_location }}

                            </small>

                        @endif


                    </div>


                </div>


                {{-- ================================================= --}}
                {{-- BOOK STATISTICS --}}
                {{-- ================================================= --}}

                <div
                    class="
                        d-flex
                        gap-2
                    "
                >

                    <div
                        class="
                            inventory-stat-box
                            inventory-stat-total
                        "
                    >

                        <span class="inventory-stat-number">

                            {{ $book->total_copies }}

                        </span>


                        <span class="inventory-stat-label">

                            Total Copies

                        </span>

                    </div>


                    <div
                        class="
                            inventory-stat-box
                            inventory-stat-available
                        "
                    >

                        <span class="inventory-stat-number">

                            {{ $book->available_copies }}

                        </span>


                        <span class="inventory-stat-label">

                            Available

                        </span>

                    </div>

                </div>


            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PHYSICAL COPIES --}}
        {{-- ================================================= --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="
                        table
                        table-hover
                        inventory-table
                    "
                >

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>

                                Exact LMS Physical Copy Number

                            </th>

                            <th>

                                Accession Number

                            </th>

                            <th>

                                Status

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($book->copies as $copy)

                            <tr>


                                {{-- NUMBER --}}

                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                {{-- LMS COPY NUMBER --}}

                                <td>

                                    <span
                                        class="
                                            inventory-copy-number
                                        "
                                    >

                                        {{ $copy->copy_number ?? '-' }}

                                    </span>

                                </td>


                                {{-- ACCESSION NUMBER --}}

                                <td>

                                    {{ $copy->accession_number ?? '-' }}

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if(
                                        $copy->status === 'available'
                                    )

                                        <span
                                            class="
                                                badge
                                                text-bg-success
                                                inventory-status
                                            "
                                        >

                                            <i class="bi bi-check-circle me-1"></i>

                                            Available

                                        </span>


                                    @elseif(
                                        $copy->status === 'borrowed'
                                    )

                                        <span
                                            class="
                                                badge
                                                text-bg-warning
                                                inventory-status
                                            "
                                        >

                                            <i class="bi bi-book me-1"></i>

                                            Borrowed

                                        </span>


                                    @elseif(
                                        $copy->status === 'lost'
                                    )

                                        <span
                                            class="
                                                badge
                                                text-bg-danger
                                                inventory-status
                                            "
                                        >

                                            <i class="bi bi-exclamation-circle me-1"></i>

                                            Lost

                                        </span>


                                    @elseif(
                                        $copy->status === 'damaged'
                                    )

                                        <span
                                            class="
                                                badge
                                                text-bg-secondary
                                                inventory-status
                                            "
                                        >

                                            <i class="bi bi-tools me-1"></i>

                                            Damaged

                                        </span>


                                    @else

                                        <span
                                            class="
                                                badge
                                                text-bg-secondary
                                                inventory-status
                                            "
                                        >

                                            {{
                                                ucfirst(
                                                    $copy->status
                                                )
                                            }}

                                        </span>

                                    @endif

                                </td>


                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="
                                        text-center
                                        text-muted
                                        py-4
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-inbox
                                            me-2
                                        "
                                    ></i>

                                    No individual physical copies found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


@empty

    <div
        class="
            alert
            alert-info
            inventory-empty-state
        "
    >

        <i class="bi bi-info-circle me-2"></i>

        No books found for the selected search,
        category or subcategory.

    </div>

@endforelse



{{-- ========================================================= --}}
{{-- PREPARE DATA FOR LIVE SEARCH --}}
{{-- ========================================================= --}}

@php

    $inventorySearchData = $books
        ->map(function ($book) {


            /*
            |--------------------------------------------------------------------------
            | DETERMINE CATEGORY FOR LIVE SEARCH
            |--------------------------------------------------------------------------
            */

            $categoryName = '';


            if (
                $book->subcategory
                &&
                $book->subcategory->category
            ) {

                $categoryName =
                    $book
                        ->subcategory
                        ->category
                        ->name;

            }

            elseif (
                $book->category
            ) {

                $categoryName =
                    $book
                        ->category
                        ->name;

            }


            return [

                'title' =>
                    $book->title,

                'book_code' =>
                    $book->book_code,

                'author' =>
                    $book->author,

                'isbn' =>
                    $book->isbn,

                'category' =>
                    $categoryName,

                'subcategory' =>
                    $book->subcategory
                        ? $book->subcategory->name
                        : '',

                'copies' =>
                    $book->copies
                        ->map(function ($copy) {

                            return [

                                'copy_number' =>
                                    $copy->copy_number,

                                'accession_number' =>
                                    $copy->accession_number,

                            ];

                        })
                        ->values(),

            ];

        })
        ->values();

@endphp



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const searchInput =
            document.getElementById(
                'inventorySearch'
            );


        const suggestions =
            document.getElementById(
                'searchSuggestions'
            );


        const categorySelect =
            document.getElementById(
                'category_id'
            );


        const subcategorySelect =
            document.getElementById(
                'subcategory_id'
            );


        const books =
            {!! json_encode($inventorySearchData) !!};


        /*
        |--------------------------------------------------------------------------
        | FILTER SUBCATEGORIES
        |--------------------------------------------------------------------------
        */

        function filterSubcategories() {


            const categoryId =
                categorySelect.value;


            Array.from(
                subcategorySelect.options
            )
            .forEach(
                function (option) {


                    if (
                        option.value === ''
                    ) {

                        option.hidden =
                            false;

                        return;

                    }


                    if (
                        categoryId === ''
                    ) {

                        option.hidden =
                            false;

                        return;

                    }


                    option.hidden =
                        option.dataset.category
                        !==
                        categoryId;


                }
            );


            if (
                subcategorySelect.value
            ) {

                const selectedOption =
                    subcategorySelect.options[
                        subcategorySelect.selectedIndex
                    ];


                if (
                    selectedOption
                    &&
                    categoryId
                    &&
                    selectedOption.dataset.category
                    !==
                    categoryId
                ) {

                    subcategorySelect.value =
                        '';

                }

            }


        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY CHANGE
        |--------------------------------------------------------------------------
        */

        categorySelect.addEventListener(
            'change',
            function () {

                filterSubcategories();

            }
        );


        filterSubcategories();


        /*
        |--------------------------------------------------------------------------
        | LIVE SEARCH
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            'input',
            function () {


                const search =
                    searchInput.value
                        .trim()
                        .toLowerCase();


                suggestions.innerHTML =
                    '';


                if (
                    search.length < 1
                ) {

                    suggestions.style.display =
                        'none';

                    return;

                }


                const matches = [];


                books.forEach(
                    function (book) {


                        const bookText =
                            (
                                (book.title || '')
                                + ' '
                                + (book.book_code || '')
                                + ' '
                                + (book.author || '')
                                + ' '
                                + (book.isbn || '')
                                + ' '
                                + (book.category || '')
                                + ' '
                                + (book.subcategory || '')
                            )
                            .toLowerCase();


                        if (
                            bookText.includes(
                                search
                            )
                        ) {

                            matches.push({

                                type:
                                    'book',

                                title:
                                    book.title,

                                subtitle:
                                    'Category: '
                                    + (
                                        book.category
                                        || '-'
                                    )
                                    + (
                                        book.subcategory
                                        ? ' | Subcategory: '
                                            + book.subcategory
                                        : ''
                                    ),

                                value:
                                    book.title,

                            });

                        }


                        if (
                            Array.isArray(
                                book.copies
                            )
                        ) {

                            book.copies.forEach(
                                function (copy) {


                                    const copyText =
                                        (
                                            (
                                                copy.copy_number
                                                || ''
                                            )
                                            + ' '
                                            + (
                                                copy.accession_number
                                                || ''
                                            )
                                        )
                                        .toLowerCase();


                                    if (
                                        copyText.includes(
                                            search
                                        )
                                    ) {

                                        matches.push({

                                            type:
                                                'copy',

                                            title:
                                                copy.copy_number
                                                || copy.accession_number,

                                            subtitle:
                                                book.title
                                                + (
                                                    book.category
                                                    ? ' | Category: '
                                                        + book.category
                                                    : ''
                                                )
                                                + (
                                                    book.subcategory
                                                    ? ' | Subcategory: '
                                                        + book.subcategory
                                                    : ''
                                                ),

                                            value:
                                                copy.copy_number
                                                || copy.accession_number,

                                        });

                                    }

                                }
                            );

                        }


                    }
                );


                if (
                    matches.length === 0
                ) {

                    suggestions.style.display =
                        'none';

                    return;

                }


                matches
                    .slice(0, 10)
                    .forEach(
                        function (match) {


                            const item =
                                document.createElement(
                                    'button'
                                );


                            item.type =
                                'button';


                            item.className =
                                'list-group-item list-group-item-action';


                            if (
                                match.type === 'book'
                            ) {

                                item.innerHTML =
                                    '<strong>'
                                    + match.title
                                    + '</strong>'
                                    + '<br>'
                                    + '<small class="text-muted">'
                                    + match.subtitle
                                    + '</small>';

                            }

                            else {

                                item.innerHTML =
                                    '<strong class="text-primary">'
                                    + match.title
                                    + '</strong>'
                                    + '<br>'
                                    + '<small class="text-muted">'
                                    + match.subtitle
                                    + '</small>';

                            }


                            item.addEventListener(
                                'click',
                                function () {


                                    searchInput.value =
                                        match.value;


                                    suggestions.style.display =
                                        'none';


                                    searchInput
                                        .closest(
                                            'form'
                                        )
                                        .submit();


                                }
                            );


                            suggestions.appendChild(
                                item
                            );


                        }
                    );


                suggestions.style.display =
                    'block';


            }
        );


        /*
        |--------------------------------------------------------------------------
        | HIDE SUGGESTIONS
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {


                if (
                    !searchInput.contains(
                        event.target
                    )
                    &&
                    !suggestions.contains(
                        event.target
                    )
                ) {

                    suggestions.style.display =
                        'none';

                }


            }
        );


    }
);

</script>

@endsection