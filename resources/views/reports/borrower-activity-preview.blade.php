<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Borrower Activity Report
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background: #f3f4f6;
            font-family: Arial, Helvetica, sans-serif;
            color: #212529;
        }

        /*
        |--------------------------------------------------------------------------
        | SCREEN WRAPPER
        |--------------------------------------------------------------------------
        */

        .page-wrapper {
            width: 100%;
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .preview-wrapper {
            width: 210mm;
        }

        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */

        .print-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn {
            border: none;
            border-radius: 5px;
            padding: 10px 18px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-print {
            background: #0d6efd;
            color: #ffffff;
        }

        .btn-back {
            background: #6c757d;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
        }

        /*
        |--------------------------------------------------------------------------
        | A4 REPORT PAGE
        |--------------------------------------------------------------------------
        */

        .report-page {
            width: 210mm;
            min-height: 297mm;
            background: #ffffff;
            padding: 12mm 14mm 20mm 14mm;
            position: relative;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.20);
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .report-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 1px solid #444;
        }

        .school-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .report-title {
            margin: 0;
            font-size: 25px;
            font-weight: bold;
        }

        .generated-date {
            margin-top: 8px;
            font-size: 12px;
            color: #555;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION TITLE
        |--------------------------------------------------------------------------
        */

        .section-title {
            font-size: 17px;
            font-weight: bold;
            margin: 20px 0 12px 0;
        }

        /*
        |--------------------------------------------------------------------------
        | BORROWER INFORMATION
        |--------------------------------------------------------------------------
        */

        .borrower-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 40px;
            margin-bottom: 20px;
        }

        .info-item {
            font-size: 14px;
        }

        .info-label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        .statistics-row {
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            gap: 12px;
            margin: 20px 0 25px 0;
        }

        .statistic-item {
            flex: 1 1 25%;
            min-width: 0;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            text-align: center;
            padding: 12px 8px;
        }

        .statistic-label {
            font-size: 11px;
            color: #555;
            margin-bottom: 7px;
        }

        .statistic-number {
            font-size: 22px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table-container {
            width: 100%;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        thead {
            background: #f1f3f5;
        }

        th {
            text-align: left;
            font-weight: bold;
            border: 1px solid #cfd4da;
            padding: 7px;
        }

        td {
            border: 1px solid #cfd4da;
            padding: 7px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .book-title {
            font-weight: bold;
        }

        .book-author {
            display: block;
            margin-top: 4px;
            font-size: 9px;
            color: #6c757d;
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        .status-badge {
            display: inline-block;
            padding: 4px 7px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #999;
        }

        .status-returned {
            color: #198754;
            border-color: #198754;
        }

        .status-borrowed {
            color: #0d6efd;
            border-color: #0d6efd;
        }

        .status-overdue {
            color: #dc3545;
            border-color: #dc3545;
        }

        .empty-row {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .report-footer {
            position: absolute;
            left: 14mm;
            right: 14mm;
            bottom: 10mm;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #ddd;
            padding-top: 7px;
            font-size: 9px;
            color: #555;
        }

        /*
        |--------------------------------------------------------------------------
        | PRINT SETTINGS
        |--------------------------------------------------------------------------
        */

        @page {
            size: A4 portrait;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }

            .print-actions {
                display: none !important;
            }

            .page-wrapper {
                display: block !important;
                width: 210mm !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .preview-wrapper {
                width: 210mm !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .report-page {
                width: 210mm !important;
                min-height: 297mm !important;
                margin: 0 !important;
                padding: 12mm 14mm 20mm 14mm !important;
                box-shadow: none !important;
                background: #ffffff !important;
            }

            .statistics-row {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                width: 100% !important;
                gap: 8px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .statistic-item {
                flex: 1 1 25% !important;
                width: 25% !important;
                padding: 8px 5px !important;
            }

            .table-container {
                width: 100% !important;
                overflow: visible !important;
            }

            table {
                width: 100% !important;
                font-size: 9px !important;
            }

            tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            th,
            td {
                padding: 5px !important;
            }

            thead {
                display: table-header-group;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

        }

    </style>

</head>

<body>

    <div class="page-wrapper">

        <div class="preview-wrapper">

            {{-- BUTTONS --}}

            <div class="print-actions">

                <a
                    href="{{ route('reports.borrower-activity', request()->query()) }}"
                    class="btn btn-back"
                >
                    Back
                </a>

                <button
                    type="button"
                    class="btn btn-print"
                    onclick="window.print()"
                >
                    Print Report
                </button>

            </div>


            {{-- REPORT PAGE --}}

            <div class="report-page">


                {{-- HEADER --}}

                <div class="report-header">

                    <div class="school-name">
                        Lokapel School Library
                    </div>

                    <h1 class="report-title">
                        Borrower Activity Report
                    </h1>

                    <div class="generated-date">
                        Generated on:
                        {{ $reportDate->format('d M Y, h:i A') }}
                    </div>

                </div>


                {{-- BORROWER INFORMATION --}}

                <div class="section-title">
                    Borrower Information
                </div>

                <div class="borrower-info">

                    <div class="info-item">

                        <span class="info-label">
                            Name:
                        </span>

                        <span class="info-value">
                            {{ $borrower?->name ?? '-' }}
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Borrower Type:
                        </span>

                        <span class="info-value">

                            @if($borrower instanceof \App\Models\Learner)

                                Learner

                            @elseif($borrower instanceof \App\Models\Teacher)

                                Teacher

                            @elseif($borrower instanceof \App\Models\Staff)

                                Staff

                            @else

                                -

                            @endif

                        </span>

                    </div>


                    @if($borrower instanceof \App\Models\Learner)

                        <div class="info-item">

                            <span class="info-label">
                                Admission Number:
                            </span>

                            <span class="info-value">
                                {{ $borrower->admission_number ?? '-' }}
                            </span>

                        </div>

                    @endif

                </div>


                {{-- STATISTICS --}}

                @php

                    $totalBorrowings = $borrowings->count();

                    $activeBorrowings = $borrowings
                        ->where('status', 'borrowed')
                        ->count();

                    $returnedBorrowings = $borrowings
                        ->where('status', 'returned')
                        ->count();

                    $overdueBorrowings = $borrowings
                        ->where('status', 'overdue')
                        ->count();

                @endphp


                <div class="statistics-row">


                    <div class="statistic-item">

                        <div class="statistic-label">
                            Total Borrowings
                        </div>

                        <div class="statistic-number">
                            {{ $totalBorrowings }}
                        </div>

                    </div>


                    <div class="statistic-item">

                        <div class="statistic-label">
                            Active Borrowings
                        </div>

                        <div class="statistic-number">
                            {{ $activeBorrowings }}
                        </div>

                    </div>


                    <div class="statistic-item">

                        <div class="statistic-label">
                            Returned
                        </div>

                        <div class="statistic-number">
                            {{ $returnedBorrowings }}
                        </div>

                    </div>


                    <div class="statistic-item">

                        <div class="statistic-label">
                            Overdue
                        </div>

                        <div class="statistic-number">
                            {{ $overdueBorrowings }}
                        </div>

                    </div>


                </div>


                {{-- BORROWING HISTORY --}}

                <div class="section-title">
                    Complete Borrowing History
                </div>


                <div class="table-container">

                    <table>

                        <thead>

                            <tr>

                                <th
                                    style="width: 5%;"
                                    class="text-center"
                                >
                                    #
                                </th>

                                <th style="width: 25%;">
                                    Book
                                </th>

                                <th style="width: 10%;">
                                    Book Code
                                </th>

                                <th style="width: 16%;">
                                    Exact Physical Copy Number
                                </th>

                                <th style="width: 11%;">
                                    Borrowed Date
                                </th>

                                <th style="width: 10%;">
                                    Due Date
                                </th>

                                <th style="width: 11%;">
                                    Returned Date
                                </th>

                                <th style="width: 12%;">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($borrowings as $borrowing)

                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        <span class="book-title">

                                            {{
                                                $borrowing->book?->title
                                                ?? '-'
                                            }}

                                        </span>


                                        @if($borrowing->book?->author)

                                            <span class="book-author">

                                                {{
                                                    $borrowing
                                                        ->book
                                                        ->author
                                                }}

                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        {{
                                            $borrowing->book?->book_code
                                            ?? '-'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            $borrowing
                                                ->bookCopy
                                                ?->copy_number
                                            ?? '-'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            $borrowing->borrowed_date
                                            ? \Carbon\Carbon::parse(
                                                $borrowing->borrowed_date
                                            )->format('Y-m-d')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            $borrowing->due_date
                                            ? \Carbon\Carbon::parse(
                                                $borrowing->due_date
                                            )->format('Y-m-d')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        {{
                                            $borrowing->returned_date
                                            ? \Carbon\Carbon::parse(
                                                $borrowing->returned_date
                                            )->format('Y-m-d')
                                            : '-'
                                        }}

                                    </td>


                                    <td>

                                        @if($borrowing->status === 'returned')

                                            <span class="status-badge status-returned">
                                                Returned
                                            </span>

                                        @elseif($borrowing->status === 'overdue')

                                            <span class="status-badge status-overdue">
                                                Overdue
                                            </span>

                                        @else

                                            <span class="status-badge status-borrowed">
                                                Borrowed
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="empty-row"
                                    >
                                        No borrowing history found for this borrower.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- FOOTER --}}

                <div class="report-footer">

                    <div>
                        Borrower Activity Report
                    </div>

                    <div>
                        Generated:
                        {{ $reportDate->format('d/m/Y H:i') }}
                    </div>

                </div>


            </div>

        </div>

    </div>

</body>

</html>