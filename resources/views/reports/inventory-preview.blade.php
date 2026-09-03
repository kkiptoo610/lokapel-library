@extends('layouts.app')

@section('content')

<div class="print-toolbar no-print">

    <a
        href="{{ route('reports.inventory', request()->query()) }}"
        class="btn btn-secondary"
    >
        <i class="bi bi-arrow-left"></i>

        Back to Inventory Report
    </a>


    <button
        type="button"
        class="btn btn-primary"
        onclick="window.print()"
    >
        <i class="bi bi-printer"></i>

        Print Report
    </button>

</div>


<div class="print-page">


    {{-- ========================================================= --}}
    {{-- REPORT HEADER --}}
    {{-- ========================================================= --}}

    <div class="report-header">


        <div class="report-title-section">

            <h1>

                LIBRARY INVENTORY REPORT

            </h1>


            <p>

                Complete library books and physical copies inventory

            </p>

        </div>


        <div class="report-date-section">

            <strong>

                Report Generated:

            </strong>

            <br>

            {{ $reportDate->format('d M Y, h:i A') }}


            @if(request('search'))

                <br><br>

                <strong>

                    Search:

                </strong>

                {{ request('search') }}

            @endif

        </div>


    </div>


    {{-- ========================================================= --}}
    {{-- REPORT SUMMARY --}}
    {{-- ========================================================= --}}

    @php

        $totalBooks = $books->count();


        $totalCopies = $books->sum(
            function ($book) {

                return $book->copies->count();

            }
        );


        $availableCopies = $books->sum(
            function ($book) {

                return $book->copies
                    ->where(
                        'status',
                        'available'
                    )
                    ->count();

            }
        );


        $borrowedCopies = $books->sum(
            function ($book) {

                return $book->copies
                    ->where(
                        'status',
                        'borrowed'
                    )
                    ->count();

            }
        );


        $lostCopies = $books->sum(
            function ($book) {

                return $book->copies
                    ->where(
                        'status',
                        'lost'
                    )
                    ->count();

            }
        );


        $damagedCopies = $books->sum(
            function ($book) {

                return $book->copies
                    ->where(
                        'status',
                        'damaged'
                    )
                    ->count();

            }
        );


        $totalCategories = $books
            ->map(
                function ($book) {

                    if (!$book->category) {

                        return null;

                    }


                    return $book->category->parent_id
                        ? $book->category->parent_id
                        : $book->category->id;

                }
            )
            ->filter()
            ->unique()
            ->count();


        $totalSubcategories = $books
            ->filter(
                function ($book) {

                    return
                        $book->category
                        &&
                        $book->category->parent_id;

                }
            )
            ->pluck(
                'category_id'
            )
            ->unique()
            ->count();

    @endphp


    {{-- ========================================================= --}}
    {{-- REPORT SUMMARY --}}
    {{-- ========================================================= --}}

    <div class="summary-section">


        <div class="summary-item">

            <span>

                Books

            </span>

            <strong>

                {{ $totalBooks }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Categories

            </span>

            <strong>

                {{ $totalCategories }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Subcategories

            </span>

            <strong>

                {{ $totalSubcategories }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Physical Copies

            </span>

            <strong>

                {{ $totalCopies }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Available

            </span>

            <strong>

                {{ $availableCopies }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Borrowed

            </span>

            <strong>

                {{ $borrowedCopies }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Lost

            </span>

            <strong>

                {{ $lostCopies }}

            </strong>

        </div>


        <div class="summary-item">

            <span>

                Damaged

            </span>

            <strong>

                {{ $damagedCopies }}

            </strong>

        </div>


    </div>


    {{-- ========================================================= --}}
    {{-- INVENTORY RESULTS --}}
    {{-- ========================================================= --}}

    @forelse($books as $book)


        @php

            $categoryName = '-';

            $subcategoryName = '-';


            if ($book->category) {

                /*
                |--------------------------------------------------------------------------
                | BOOK BELONGS TO A SUBCATEGORY
                |--------------------------------------------------------------------------
                */

                if ($book->category->parent_id) {

                    $categoryName =
                        $book->category->parent
                            ->name
                        ?? '-';


                    $subcategoryName =
                        $book->category->name
                        ?? '-';

                }


                /*
                |--------------------------------------------------------------------------
                | BOOK BELONGS DIRECTLY TO A CATEGORY
                |--------------------------------------------------------------------------
                */

                else {

                    $categoryName =
                        $book->category->name
                        ?? '-';

                }

            }

        @endphp


        <div class="book-section">


            {{-- ================================================= --}}
            {{-- BOOK INFORMATION --}}
            {{-- ================================================= --}}

            <div class="book-header">


                <div class="book-details">


                    {{-- BOOK TITLE --}}

                    <h2>

                        {{ $book->title }}

                    </h2>


                    {{-- AUTHOR --}}

                    @if($book->author)

                        <p>

                            <strong>

                                Author:

                            </strong>

                            {{ $book->author }}

                        </p>

                    @endif


                    {{-- BOOK CODE --}}

                    <p>

                        <strong>

                            Book Code:

                        </strong>

                        {{ $book->book_code ?? '-' }}

                    </p>


                    {{-- ISBN --}}

                    @if($book->isbn)

                        <p>

                            <strong>

                                ISBN:

                            </strong>

                            {{ $book->isbn }}

                        </p>

                    @endif


                    {{-- ================================================= --}}
                    {{-- CATEGORY --}}
                    {{-- ================================================= --}}

                    <p>

                        <strong>

                            Category:

                        </strong>

                        {{ $categoryName }}

                    </p>


                    {{-- ================================================= --}}
                    {{-- SUBCATEGORY --}}
                    {{-- ================================================= --}}

                    @if(
                        $subcategoryName !== '-'
                    )

                        <p>

                            <strong>

                                Subcategory:

                            </strong>

                            {{ $subcategoryName }}

                        </p>

                    @endif


                    {{-- PUBLISHER --}}

                    @if($book->publisher)

                        <p>

                            <strong>

                                Publisher:

                            </strong>

                            {{ $book->publisher }}

                        </p>

                    @endif


                    {{-- SHELF LOCATION --}}

                    @if($book->shelf_location)

                        <p>

                            <strong>

                                Shelf Location:

                            </strong>

                            {{ $book->shelf_location }}

                        </p>

                    @endif


                </div>


                {{-- ================================================= --}}
                {{-- BOOK SUMMARY --}}
                {{-- ================================================= --}}

                <div class="book-summary">


                    <div>

                        <span>

                            Total Copies

                        </span>

                        <strong>

                            {{ $book->copies->count() }}

                        </strong>

                    </div>


                    <div>

                        <span>

                            Available

                        </span>

                        <strong>

                            {{
                                $book->copies
                                    ->where(
                                        'status',
                                        'available'
                                    )
                                    ->count()
                            }}

                        </strong>

                    </div>


                    <div>

                        <span>

                            Borrowed

                        </span>

                        <strong>

                            {{
                                $book->copies
                                    ->where(
                                        'status',
                                        'borrowed'
                                    )
                                    ->count()
                            }}

                        </strong>

                    </div>


                </div>


            </div>


            {{-- ================================================= --}}
            {{-- PHYSICAL COPIES TABLE --}}
            {{-- ================================================= --}}

            <table class="inventory-table">


                <thead>

                    <tr>

                        <th>#</th>

                        <th>Exact LMS Physical Copy Number</th>

                        <th>Accession Number</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($book->copies as $copy)


                        <tr>


                            {{-- NUMBER --}}

                            <td>

                                {{ $loop->iteration }}

                            </td>


                            {{-- COPY NUMBER --}}

                            <td class="copy-number">

                                {{ $copy->copy_number ?? '-' }}

                            </td>


                            {{-- ACCESSION NUMBER --}}

                            <td>

                                {{ $copy->accession_number ?? '-' }}

                            </td>


                            {{-- STATUS --}}

                            <td>


                                @if(
                                    $copy->status ===
                                    'available'
                                )

                                    Available


                                @elseif(
                                    $copy->status ===
                                    'borrowed'
                                )

                                    Borrowed


                                @elseif(
                                    $copy->status ===
                                    'lost'
                                )

                                    Lost


                                @elseif(
                                    $copy->status ===
                                    'damaged'
                                )

                                    Damaged


                                @else

                                    {{
                                        ucfirst(
                                            $copy->status
                                        )
                                    }}

                                @endif


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="4"
                                class="empty-row"
                            >

                                No physical copies found.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    @empty


        <div class="no-records">

            No inventory records found.

        </div>


    @endforelse


    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <div class="report-footer">


        <div>

            Library Management System

        </div>


        <div>

            Generated:

            {{ $reportDate->format('d M Y, h:i A') }}

        </div>


    </div>


</div>


{{-- ========================================================= --}}
{{-- STYLES --}}
{{-- ========================================================= --}}

<style>


/*
|--------------------------------------------------------------------------
| SCREEN VIEW
|--------------------------------------------------------------------------
*/

.print-toolbar {

    display: flex;

    justify-content: space-between;

    margin-bottom: 20px;

}


.print-page {

    background: white;

    max-width: 210mm;

    margin: 0 auto;

    padding: 20mm;

}


.report-header {

    display: flex;

    justify-content: space-between;

    border-bottom: 2px solid #000;

    padding-bottom: 15px;

    margin-bottom: 20px;

}


.report-title-section h1 {

    margin: 0;

    font-size: 24px;

    font-weight: 700;

}


.report-title-section p {

    margin: 5px 0 0;

    color: #555;

}


.report-date-section {

    text-align: right;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| SUMMARY
|--------------------------------------------------------------------------
*/

.summary-section {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 10px;

    margin-bottom: 25px;

}


.summary-item {

    border: 1px solid #bbb;

    padding: 10px;

    text-align: center;

}


.summary-item span {

    display: block;

    font-size: 12px;

    color: #555;

}


.summary-item strong {

    display: block;

    font-size: 20px;

    margin-top: 5px;

}


/*
|--------------------------------------------------------------------------
| BOOK SECTION
|--------------------------------------------------------------------------
*/

.book-section {

    margin-bottom: 30px;

    page-break-inside: avoid;

}


.book-header {

    border: 1px solid #999;

    border-bottom: none;

    padding: 12px;

    display: flex;

    justify-content: space-between;

}


.book-details h2 {

    font-size: 17px;

    margin: 0 0 8px;

}


.book-details p {

    margin: 3px 0;

    font-size: 13px;

}


/*
|--------------------------------------------------------------------------
| BOOK SUMMARY
|--------------------------------------------------------------------------
*/

.book-summary {

    display: flex;

    gap: 15px;

    align-items: flex-start;

}


.book-summary div {

    text-align: center;

}


.book-summary span {

    display: block;

    font-size: 11px;

}


.book-summary strong {

    font-size: 16px;

}


/*
|--------------------------------------------------------------------------
| INVENTORY TABLE
|--------------------------------------------------------------------------
*/

.inventory-table {

    width: 100%;

    border-collapse: collapse;

    font-size: 12px;

}


.inventory-table th {

    border: 1px solid #999;

    padding: 8px;

    text-align: left;

    background: #eee;

}


.inventory-table td {

    border: 1px solid #999;

    padding: 7px;

}


.copy-number {

    font-weight: bold;

}


.empty-row {

    text-align: center;

    padding: 15px !important;

}


/*
|--------------------------------------------------------------------------
| NO RECORDS
|--------------------------------------------------------------------------
*/

.no-records {

    border: 1px solid #999;

    padding: 20px;

    text-align: center;

}


/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

.report-footer {

    border-top: 1px solid #999;

    margin-top: 30px;

    padding-top: 10px;

    display: flex;

    justify-content: space-between;

    font-size: 11px;

    color: #555;

}


/*
|--------------------------------------------------------------------------
| A4 PRINT SETTINGS
|--------------------------------------------------------------------------
*/

@page {

    size: A4;

    margin: 12mm;

}


@media print {


    body {

        background: white;

    }


    .no-print {

        display: none !important;

    }


    .sidebar {

        display: none !important;

    }


    .content {

        margin-left: 0 !important;

        padding: 0 !important;

    }


    .container,
    .container-fluid {

        width: 100% !important;

        max-width: none !important;

        padding: 0 !important;

        margin: 0 !important;

    }


    .print-page {

        width: 100%;

        max-width: none;

        padding: 0;

        margin: 0;

    }


    .book-section {

        page-break-inside: avoid;

    }


    .inventory-table {

        page-break-inside: auto;

    }


    .inventory-table tr {

        page-break-inside: avoid;

        page-break-after: auto;

    }


    .inventory-table thead {

        display: table-header-group;

    }


    .report-footer {

        margin-top: 20px;

    }


}


</style>

@endsection