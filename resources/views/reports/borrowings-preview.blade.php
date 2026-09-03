<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Borrowing Report
    </title>


    {{-- Bootstrap --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        /* ========================================================= */
        /* GENERAL PAGE */
        /* ========================================================= */

        body {

            background: #f1f3f5;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: #212529;

        }


        /* ========================================================= */
        /* PREVIEW CONTAINER */
        /* ========================================================= */

        .report-page {

            width: 297mm;

            min-height: 210mm;

            margin: 30px auto;

            background: #ffffff;

            padding:

                15mm
                12mm
                15mm
                12mm;

            box-shadow:

                0
                0
                20px
                rgba(0, 0, 0, 0.15);

        }


        /* ========================================================= */
        /* TOP ACTION BUTTONS */
        /* ========================================================= */

        .report-actions {

            width: 297mm;

            margin:

                20px
                auto
                0;

            display: flex;

            justify-content: space-between;

        }


        /* ========================================================= */
        /* REPORT HEADER */
        /* ========================================================= */

        .report-header {

            border-bottom:

                2px
                solid
                #212529;

            padding-bottom:

                12px;

            margin-bottom:

                18px;

        }


        .library-name {

            font-size:

                24px;

            font-weight:

                bold;

            margin:

                0;

        }


        .report-title {

            font-size:

                26px;

            font-weight:

                bold;

            text-align:

                center;

            margin:

                10px
                0
                5px;

        }


        .report-subtitle {

            text-align:

                center;

            color:

                #6c757d;

            font-size:

                15px;

            margin-bottom:

                0;

        }


        /* ========================================================= */
        /* REPORT INFORMATION */
        /* ========================================================= */

        .report-information {

            margin-bottom:

                18px;

            font-size:

                14px;

        }


        .report-information table {

            width:

                100%;

        }


        .report-information td {

            padding:

                5px
                0;

        }


        /* ========================================================= */
        /* REPORT TABLE */
        /* ========================================================= */

        .table-wrapper {

            width:

                100%;

            overflow-x:

                auto;

        }


        .report-table {

            width:

                100%;

            border-collapse:

                collapse;

            table-layout:

                fixed;

            font-size:

                13px;

        }


        .report-table th {

            background:

                #f1f1f1;

            font-weight:

                bold;

            text-align:

                left;

        }


        .report-table th,
        .report-table td {

            border:

                1px
                solid
                #adb5bd;

            padding:

                8px;

            vertical-align:

                top;

            word-wrap:

                break-word;

            overflow-wrap:

                break-word;

        }


        /* ========================================================= */
        /* COLUMN WIDTHS */
        /* ========================================================= */

        .col-number {

            width:

                3%;

        }


        .col-book {

            width:

                22%;

        }


        .col-category {

            width:

                8%;

        }


        .col-subcategory {

            width:

                8%;

        }


        .col-copy {

            width:

                11%;

        }


        .col-borrower {

            width:

                12%;

        }


        .col-type {

            width:

                6%;

        }


        .col-date {

            width:

                8%;

        }


        .col-status {

            width:

                6%;

        }


        /* ========================================================= */
        /* STATUS */
        /* ========================================================= */

        .status {

            font-weight:

                bold;

        }


        .status-borrowed {

            color:

                #856404;

        }


        .status-overdue {

            color:

                #dc3545;

        }


        .status-returned {

            color:

                #198754;

        }


        /* ========================================================= */
        /* FOOTER */
        /* ========================================================= */

        .report-footer {

            margin-top:

                25px;

            padding-top:

                10px;

            border-top:

                1px
                solid
                #ced4da;

            display:

                flex;

            justify-content:

                space-between;

            font-size:

                12px;

            color:

                #6c757d;

        }


        /* ========================================================= */
        /* PRINT SETTINGS */
        /* ========================================================= */

        @page {

            size:

                A4
                landscape;

            margin:

                10mm;

        }


        @media print {


            body {

                background:

                    #ffffff;

            }


            .no-print {

                display:

                    none
                    !important;

            }


            .report-actions {

                display:

                    none
                    !important;

            }


            .report-page {

                width:

                    100%;

                min-height:

                    auto;

                margin:

                    0;

                padding:

                    0;

                box-shadow:

                    none;

            }


            .report-table {

                font-size:

                    11px;

            }


            .report-table th,
            .report-table td {

                padding:

                    7px;

            }


            .report-information {

                font-size:

                    13px;

            }

        }

    </style>

</head>


<body>


{{-- ========================================================= --}}
{{-- ACTION BUTTONS --}}
{{-- ========================================================= --}}

<div class="report-actions no-print">


    <a
        href="{{ url()->previous() }}"
        class="btn btn-secondary"
    >

        <i class="bi bi-arrow-left"></i>

        Back

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


{{-- ========================================================= --}}
{{-- REPORT PAGE --}}
{{-- ========================================================= --}}

<div class="report-page">


    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="report-header">


        <div class="text-center">


            <div class="library-name">

                Lokapel School Library

            </div>


            <div class="report-title">

                Borrowing Report

            </div>


            <div class="report-subtitle">

                Library borrowing records

            </div>


        </div>


    </div>


    {{-- ===================================================== --}}
    {{-- REPORT INFORMATION --}}
    {{-- ===================================================== --}}

    <div class="report-information">


        <table>


            <tr>


                <td>

                    <strong>

                        Report Date:

                    </strong>

                    {{ $reportDate->format('d/m/Y') }}

                </td>


                <td class="text-end">

                    <strong>

                        Total Records:

                    </strong>

                    {{ $borrowings->count() }}

                </td>


            </tr>


            <tr>


                <td>

                    <strong>

                        From Date:

                    </strong>

                    {{ request('from_date') ?: 'All Dates' }}

                </td>


                <td class="text-end">

                    <strong>

                        To Date:

                    </strong>

                    {{ request('to_date') ?: 'Present' }}

                </td>


            </tr>


            <tr>


                <td>

                    <strong>

                        Borrower Type:

                    </strong>


                    @if(request('borrower_type') === 'learner')

                        Learner

                    @elseif(request('borrower_type') === 'teacher')

                        Teacher

                    @elseif(request('borrower_type') === 'staff')

                        Staff

                    @else

                        All Borrowers

                    @endif

                </td>


                <td class="text-end">

                    <strong>

                        Status:

                    </strong>

                    {{ request('status') ?: 'All Statuses' }}

                </td>


            </tr>


        </table>


    </div>


    {{-- ===================================================== --}}
    {{-- REPORT TABLE --}}
    {{-- ===================================================== --}}

    <div class="table-wrapper">


        <table class="report-table">


            <thead>


                <tr>

                    <th class="col-number">
                        #
                    </th>

                    <th class="col-book">
                        Book
                    </th>

                    <th class="col-category">
                        Category
                    </th>

                    <th class="col-subcategory">
                        Subcategory
                    </th>

                    <th class="col-copy">
                        Physical Copy No.
                    </th>

                    <th class="col-borrower">
                        Borrower
                    </th>

                    <th class="col-type">
                        Type
                    </th>

                    <th class="col-date">
                        Borrowed
                    </th>

                    <th class="col-date">
                        Due
                    </th>

                    <th class="col-date">
                        Returned
                    </th>

                    <th class="col-status">
                        Status
                    </th>

                </tr>


            </thead>


            <tbody>


                @forelse($borrowings as $borrowing)


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


                        {{-- CATEGORY --}}

                        <td>

                            {{ $borrowing->book?->category?->name ?? '-' }}

                        </td>


                        {{-- SUBCATEGORY --}}

                        <td>

                            {{ $borrowing->book?->subcategory?->name ?? '-' }}

                        </td>


                        {{-- PHYSICAL COPY NUMBER --}}

                        <td>

                            <strong>

                                {{ $borrowing->bookCopy?->copy_number ?? '-' }}

                            </strong>

                        </td>


                        {{-- BORROWER --}}

                        <td>


                            {{ $borrowing->borrower?->name ?? '-' }}


                            {{-- LEARNER ADMISSION NUMBER --}}

                            @if(
                                $borrowing->borrower_type ===
                                \App\Models\Learner::class
                            )

                                <br>

                                <small class="text-muted">

                                    Admission:
                                    {{
                                        $borrowing->borrower
                                            ?->admission_number
                                            ?? '-'
                                    }}

                                </small>

                            @endif


                        </td>


                        {{-- BORROWER TYPE --}}

                        <td>


                            @if(
                                $borrowing->borrower_type ===
                                \App\Models\Learner::class
                            )

                                Learner


                            @elseif(
                                $borrowing->borrower_type ===
                                \App\Models\Teacher::class
                            )

                                Teacher


                            @elseif(
                                $borrowing->borrower_type ===
                                \App\Models\Staff::class
                            )

                                Staff


                            @else

                                -

                            @endif


                        </td>


                        {{-- BORROWED DATE --}}

                        <td>

                            {{ $borrowing->borrowed_date }}

                        </td>


                        {{-- DUE DATE --}}

                        <td>

                            {{ $borrowing->due_date ?? '-' }}

                        </td>


                        {{-- RETURNED DATE --}}

                        <td>

                            {{ $borrowing->returned_date ?? '-' }}

                        </td>


                        {{-- STATUS --}}

                        <td>


                            @if(
                                $borrowing->status === 'borrowed'
                            )

                                <span class="status status-borrowed">

                                    Borrowed

                                </span>


                            @elseif(
                                $borrowing->status === 'overdue'
                            )

                                <span class="status status-overdue">

                                    Overdue

                                </span>


                            @elseif(
                                $borrowing->status === 'returned'
                            )

                                <span class="status status-returned">

                                    Returned

                                </span>


                            @else

                                {{ ucfirst($borrowing->status) }}

                            @endif


                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="11"
                            style="
                                text-align: center;
                                padding: 20px;
                            "
                        >

                            No borrowing records found.

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

            Generated:

            {{ $reportDate->format('d/m/Y H:i') }}

        </div>


        <div>

            Lokapel School Library

        </div>


        <div>

            Borrowing Report

        </div>


    </div>


</div>


</body>

</html>