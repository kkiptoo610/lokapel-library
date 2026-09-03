@extends('layouts.app')

@section('content')

<div class="container-fluid">


    {{-- ========================================================= --}}
    {{-- PREVIEW BUTTONS --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4 no-print">


        <a
            href="{{ route('reports.overdue', request()->query()) }}"
            class="btn btn-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Back to Report

        </a>


        <button
            type="button"
            class="btn btn-danger"
            onclick="window.print()"
        >

            <i class="bi bi-printer"></i>

            Print Report

        </button>


    </div>


    {{-- ========================================================= --}}
    {{-- PRINTABLE DOCUMENT --}}
    {{-- ========================================================= --}}

    <div class="print-document">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <div class="report-header">


            <div>

                <h1>

                    Overdue Books Report

                </h1>


                <p>

                    Library Management System

                </p>

            </div>


            <div class="report-date">

                <strong>

                    Generated:

                </strong>

                <br>

                {{ $reportDate->format('d M Y, h:i A') }}

            </div>


        </div>


        {{-- ===================================================== --}}
        {{-- FILTER INFORMATION --}}
        {{-- ===================================================== --}}

        <div class="filter-information">


            <strong>

                Borrower Type:

            </strong>


            @if(request('borrower_type') === 'learner')

                Learners

            @elseif(request('borrower_type') === 'teacher')

                Teachers

            @elseif(request('borrower_type') === 'staff')

                Staff

            @else

                All Borrowers

            @endif


        </div>


        {{-- ===================================================== --}}
        {{-- SUMMARY --}}
        {{-- ===================================================== --}}

        <div class="report-summary">


            <span class="summary-label">

                Total Overdue Books

            </span>


            <strong class="summary-value">

                {{ $borrowings->count() }}

            </strong>


        </div>


        {{-- ===================================================== --}}
        {{-- OVERDUE TABLE --}}
        {{-- ===================================================== --}}

        <div class="table-responsive">

            <table class="report-table">


                <thead>

                    <tr>

                        <th>#</th>

                        <th>Book</th>

                        <th>Physical Copy Number</th>

                        <th>Borrower</th>

                        <th>Due Date</th>

                        <th>Days Overdue</th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($borrowings as $borrowing)

                        @php

                            $daysOverdue = $borrowing->due_date
                                ? \Carbon\Carbon::parse(
                                    $borrowing->due_date
                                )
                                ->startOfDay()
                                ->diffInDays(
                                    \Carbon\Carbon::today()
                                        ->startOfDay()
                                )
                                : 0;

                        @endphp


                        <tr>


                            {{-- NUMBER --}}

                            <td>

                                {{ $loop->iteration }}

                            </td>


                            {{-- BOOK --}}

                            <td>

                                <strong>

                                    {{ $borrowing->book?->title ?? '-' }}

                                </strong>


                                @if($borrowing->book?->author)

                                    <br>

                                    <small>

                                        {{ $borrowing->book->author }}

                                    </small>

                                @endif

                            </td>


                            {{-- COPY NUMBER --}}

                            <td>

                                {{ $borrowing->bookCopy?->copy_number ?? '-' }}

                            </td>


                            {{-- BORROWER --}}

                            <td>

                                {{ $borrowing->borrower?->name ?? '-' }}


                                @if(
                                    $borrowing->borrower_type ===
                                    \App\Models\Learner::class
                                    &&
                                    $borrowing->borrower?->admission_number
                                )

                                    <br>

                                    <small>

                                        {{ $borrowing->borrower->admission_number }}

                                    </small>

                                @endif

                            </td>


                            {{-- DUE DATE --}}

                            <td>

                                @if($borrowing->due_date)

                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- DAYS OVERDUE --}}

                            <td>

                                <strong>

                                    {{ $daysOverdue }}

                                    {{ $daysOverdue == 1 ? 'day' : 'days' }}

                                </strong>

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="no-results"
                            >

                                No overdue books found.

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>

        </div>


        {{-- ===================================================== --}}
        {{-- FOOTER --}}
        {{-- ===================================================== --}}

        <div class="report-footer">


            <div>

                Library Management System

            </div>


            <div>

                Total Records:

                <strong>

                    {{ $borrowings->count() }}

                </strong>

            </div>


        </div>


    </div>


</div>


<style>


/* ========================================================= */
/* SCREEN DOCUMENT */
/* ========================================================= */

.print-document {

    background: #ffffff;

    padding: 40px;

}


.report-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    border-bottom: 2px solid #000000;

    padding-bottom: 20px;

    margin-bottom: 20px;

}


.report-header h1 {

    margin: 0;

    font-size: 28px;

    font-weight: 700;

}


.report-header p {

    margin: 5px 0 0;

    color: #666666;

}


.report-date {

    text-align: right;

    font-size: 14px;

}


.filter-information {

    padding: 12px 15px;

    margin-bottom: 20px;

    border: 1px solid #dddddd;

    background: #f8f9fa;

}


.report-summary {

    margin-bottom: 25px;

}


.summary-label {

    display: block;

    font-size: 14px;

    color: #666666;

}


.summary-value {

    display: block;

    font-size: 30px;

}


.report-table {

    width: 100%;

    border-collapse: collapse;

}


.report-table th {

    border: 1px solid #333333;

    padding: 10px;

    text-align: left;

    font-weight: 700;

}


.report-table td {

    border: 1px solid #777777;

    padding: 9px;

    vertical-align: top;

}


.report-table small {

    color: #555555;

}


.no-results {

    text-align: center;

    padding: 30px !important;

}


.report-footer {

    display: flex;

    justify-content: space-between;

    margin-top: 25px;

    padding-top: 15px;

    border-top: 1px solid #000000;

    font-size: 12px;

}


/* ========================================================= */
/* PRINT SETTINGS */
/* ========================================================= */

@page {

    size: A4 landscape;

    margin: 12mm;

}


@media print {


    body {

        background: #ffffff !important;

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

        width: 100% !important;

    }


    .container-fluid {

        padding: 0 !important;

        margin: 0 !important;

        width: 100% !important;

    }


    .print-document {

        padding: 0 !important;

        width: 100% !important;

    }


    .report-table {

        font-size: 11px;

    }


    .report-table tr {

        page-break-inside: avoid;

    }


    .report-header {

        page-break-after: avoid;

    }


}

</style>

@endsection