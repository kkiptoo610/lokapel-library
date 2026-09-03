@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Borrowing Report</h1>

        <p class="text-muted mb-0">
            View and analyze all library borrowing records.
        </p>

    </div>


    <div>

        <a
            href="{{ route('reports.index') }}"
            class="btn btn-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Back to Reports

        </a>


        <a
            href="{{ route('reports.borrowings.preview', request()->query()) }}"
            class="btn btn-primary"
        >

            <i class="bi bi-eye"></i>

            Preview Report

        </a>

    </div>

</div>



{{-- ========================================================= --}}
{{-- FILTERS --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('reports.borrowings') }}"
        >

            <div class="row g-3">


                {{-- ========================================================= --}}
                {{-- SEARCH --}}
                {{-- ========================================================= --}}

                <div class="col-md-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Book, copy number or borrower..."
                    >

                </div>



                {{-- ========================================================= --}}
                {{-- CATEGORY --}}
                {{-- ========================================================= --}}

                <div class="col-md-4">

                    <label class="form-label">
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



                {{-- ========================================================= --}}
                {{-- SUBCATEGORY --}}
                {{-- ========================================================= --}}

                <div class="col-md-4">

                    <label class="form-label">
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
                                data-parent="{{ $subcategory->parent_id }}"
                                @selected(
                                    request('subcategory_id') == $subcategory->id
                                )
                            >

                                @if($subcategory->parent)

                                    {{ $subcategory->parent->name }}

                                    —

                                @endif

                                {{ $subcategory->name }}

                            </option>

                        @endforeach

                    </select>

                </div>



                {{-- ========================================================= --}}
                {{-- FROM DATE --}}
                {{-- ========================================================= --}}

                <div class="col-md-2">

                    <label class="form-label">
                        From Date
                    </label>

                    <input
                        type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                        class="form-control"
                    >

                </div>



                {{-- ========================================================= --}}
                {{-- TO DATE --}}
                {{-- ========================================================= --}}

                <div class="col-md-2">

                    <label class="form-label">
                        To Date
                    </label>

                    <input
                        type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                        class="form-control"
                    >

                </div>



                {{-- ========================================================= --}}
                {{-- BORROWER TYPE --}}
                {{-- ========================================================= --}}

                <div class="col-md-2">

                    <label class="form-label">
                        Borrower Type
                    </label>

                    <select
                        name="borrower_type"
                        class="form-select"
                    >

                        <option value="">
                            All
                        </option>


                        <option
                            value="learner"
                            @selected(
                                request('borrower_type') === 'learner'
                            )
                        >

                            Learners

                        </option>


                        <option
                            value="teacher"
                            @selected(
                                request('borrower_type') === 'teacher'
                            )
                        >

                            Teachers

                        </option>


                        <option
                            value="staff"
                            @selected(
                                request('borrower_type') === 'staff'
                            )
                        >

                            Staff

                        </option>

                    </select>

                </div>



                {{-- ========================================================= --}}
                {{-- STATUS --}}
                {{-- ========================================================= --}}

                <div class="col-md-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            All
                        </option>


                        <option
                            value="borrowed"
                            @selected(
                                request('status') === 'borrowed'
                            )
                        >

                            Borrowed

                        </option>


                        <option
                            value="overdue"
                            @selected(
                                request('status') === 'overdue'
                            )
                        >

                            Overdue

                        </option>


                        <option
                            value="returned"
                            @selected(
                                request('status') === 'returned'
                            )
                        >

                            Returned

                        </option>

                    </select>

                </div>



                {{-- ========================================================= --}}
                {{-- BUTTONS --}}
                {{-- ========================================================= --}}

                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-search"></i>

                        Filter

                    </button>


                    <a
                        href="{{ route('reports.borrowings') }}"
                        class="btn btn-secondary"
                    >

                        Clear

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>



{{-- ========================================================= --}}
{{-- REPORT TABLE --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">

    <div class="card-body">


        {{-- ========================================================= --}}
        {{-- REPORT SUMMARY --}}
        {{-- ========================================================= --}}

        <div
            class="d-flex justify-content-between align-items-center mb-3"
        >

            <div>

                <strong>

                    Total Borrowing Records:

                    {{ $totalRecords }}

                </strong>


                <span class="ms-3 text-muted">

                    Unique Books:

                    {{ $totalBooks }}

                </span>


                <span class="ms-3 text-muted">

                    Categories:

                    {{ $totalCategories }}

                </span>

            </div>


            <div class="text-muted">

                @if(
                    request('from_date')
                    ||
                    request('to_date')
                )

                    Date Range:

                    {{ request('from_date') ?: 'Beginning' }}

                    to

                    {{ request('to_date') ?: 'Present' }}

                @else

                    All borrowing records

                @endif

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}

        <div class="table-responsive">

            <table
                class="table table-hover align-middle"
            >

                <thead>

                    <tr>

                        <th style="width: 60px">
                            #
                        </th>


                        <th>
                            Book
                        </th>


                        <th>
                            Category
                        </th>


                        <th>
                            Subcategory
                        </th>


                        <th>
                            Total Borrowings
                        </th>


                        <th>
                            Unique Borrowers
                        </th>


                        <th>
                            Currently Borrowed
                        </th>


                        <th>
                            Overdue
                        </th>


                        <th>
                            Returned
                        </th>


                        <th>
                            Details
                        </th>

                    </tr>

                </thead>



                <tbody>


                    {{-- ========================================================= --}}
                    {{-- GROUP BY CATEGORY --}}
                    {{-- ========================================================= --}}

                    @forelse(
                        $groupedBorrowings
                        as $categoryName => $categoryBooks
                    )


                        {{-- ========================================================= --}}
                        {{-- CATEGORY HEADER --}}
                        {{-- ========================================================= --}}

                        <tr
                            class="table-primary"
                        >

                            <td
                                colspan="10"
                                class="fw-bold py-3"
                            >

                                <i
                                    class="bi bi-folder-fill me-2"
                                ></i>


                                {{ $categoryName }}


                                <span
                                    class="badge text-bg-primary ms-2"
                                >

                                    {{ $categoryBooks->count() }}

                                    {{ Str::plural(
                                        'Book',
                                        $categoryBooks->count()
                                    ) }}

                                </span>

                            </td>

                        </tr>



                        {{-- ========================================================= --}}
                        {{-- BOOKS --}}
                        {{-- ========================================================= --}}

                        @foreach(
                            $categoryBooks
                            as $item
                        )


                            @php

                                $book =
                                    $item['book'];

                            @endphp


                            <tr>


                                {{-- NUMBER --}}

                                <td>

                                    {{ $loop->iteration }}

                                </td>



                                {{-- BOOK --}}

                                <td>


                                    <strong>

                                        {{
                                            $book?->title
                                            ?? '-'
                                        }}

                                    </strong>


                                    @if(
                                        $book?->author
                                    )

                                        <br>


                                        <small
                                            class="text-muted"
                                        >

                                            {{ $book->author }}

                                        </small>

                                    @endif


                                    @if(
                                        $book?->book_code
                                    )

                                        <br>


                                        <small
                                            class="text-primary fw-semibold"
                                        >

                                            {{ $book->book_code }}

                                        </small>

                                    @endif


                                </td>



                                {{-- CATEGORY --}}

                                <td>

                                    {{ $categoryName }}

                                </td>



                                {{-- SUBCATEGORY --}}

                                <td>


                                    @if(
                                        $book?->subcategory
                                    )

                                        <span
                                            class="badge text-bg-light border text-dark"
                                        >

                                            {{
                                                $book
                                                    ->subcategory
                                                    ->name
                                            }}

                                        </span>

                                    @else

                                        <span
                                            class="text-muted"
                                        >

                                            -

                                        </span>

                                    @endif


                                </td>



                                {{-- TOTAL BORROWINGS --}}

                                <td>


                                    <span
                                        class="fw-bold"
                                    >

                                        {{
                                            $item[
                                                'total_borrowings'
                                            ]
                                        }}

                                    </span>


                                </td>



                                {{-- UNIQUE BORROWERS --}}

                                <td>

                                    {{
                                        $item[
                                            'unique_borrowers'
                                        ]
                                    }}

                                </td>



                                {{-- CURRENTLY BORROWED --}}

                                <td>


                                    @if(
                                        $item[
                                            'currently_borrowed'
                                        ] > 0
                                    )

                                        <span
                                            class="badge text-bg-warning"
                                        >

                                            {{
                                                $item[
                                                    'currently_borrowed'
                                                ]
                                            }}

                                        </span>

                                    @else

                                        <span
                                            class="text-muted"
                                        >

                                            0

                                        </span>

                                    @endif


                                </td>



                                {{-- OVERDUE --}}

                                <td>


                                    @if(
                                        $item[
                                            'overdue'
                                        ] > 0
                                    )

                                        <span
                                            class="badge text-bg-danger"
                                        >

                                            {{
                                                $item[
                                                    'overdue'
                                                ]
                                            }}

                                        </span>

                                    @else

                                        <span
                                            class="text-muted"
                                        >

                                            0

                                        </span>

                                    @endif


                                </td>



                                {{-- RETURNED --}}

                                <td>


                                    @if(
                                        $item[
                                            'returned'
                                        ] > 0
                                    )

                                        <span
                                            class="badge text-bg-success"
                                        >

                                            {{
                                                $item[
                                                    'returned'
                                                ]
                                            }}

                                        </span>

                                    @else

                                        <span
                                            class="text-muted"
                                        >

                                            0

                                        </span>

                                    @endif


                                </td>



                                {{-- DETAILS --}}

                                <td>


                                    @if($book)

                                        <a
                                            href="{{ route(
                                                'reports.borrowings.book-details',
                                                array_merge(
                                                    [
                                                        'book' =>
                                                            $book->id,
                                                    ],
                                                    request()->only(
                                                        [
                                                            'from_date',
                                                            'to_date',
                                                            'status',
                                                            'borrower_type',
                                                            'search',
                                                        ]
                                                    )
                                                )
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >

                                            <i
                                                class="bi bi-eye"
                                            ></i>

                                            View

                                        </a>

                                    @endif


                                </td>


                            </tr>


                        @endforeach



                        {{-- ========================================================= --}}
                        {{-- CATEGORY TOTAL --}}
                        {{-- ========================================================= --}}

                        <tr
                            class="table-light fw-bold"
                        >


                            <td
                                colspan="4"
                                class="text-end"
                            >

                                {{ $categoryName }}

                                Total:

                            </td>


                            <td>

                                {{
                                    $categoryBooks->sum(
                                        'total_borrowings'
                                    )
                                }}

                            </td>


                            <td>

                                {{
                                    $categoryBooks->sum(
                                        'unique_borrowers'
                                    )
                                }}

                            </td>


                            <td>

                                {{
                                    $categoryBooks->sum(
                                        'currently_borrowed'
                                    )
                                }}

                            </td>


                            <td>

                                {{
                                    $categoryBooks->sum(
                                        'overdue'
                                    )
                                }}

                            </td>


                            <td>

                                {{
                                    $categoryBooks->sum(
                                        'returned'
                                    )
                                }}

                            </td>


                            <td>

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="10"
                                class="text-center text-muted py-4"
                            >

                                No borrowing records found.

                            </td>

                        </tr>


                    @endforelse


                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- SUBCATEGORY FILTER JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(

    'DOMContentLoaded',

    function () {


        const categorySelect =

            document.getElementById(
                'category_id'
            );


        const subcategorySelect =

            document.getElementById(
                'subcategory_id'
            );


        const options =

            Array.from(
                subcategorySelect.options
            );


        function filterSubcategories()
        {


            const categoryId =

                categorySelect.value;


            options.forEach(

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

                    }

                    else {

                        option.hidden =

                            option.dataset.parent !==
                            categoryId;

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
                selectedOption.hidden

            ) {

                subcategorySelect.value =
                    '';

            }


        }



        categorySelect.addEventListener(

            'change',

            function () {

                filterSubcategories();

            }

        );


        filterSubcategories();


    }

);

</script>


@endsection