@extends('layouts.app')

@section('content')

<style>
    .print-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .print-page {
        background: #ffffff;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
        padding-bottom: 1.25rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #dee2e6;
    }

    .report-title {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .report-subtitle {
        margin: .35rem 0 0;
        color: #6c757d;
    }

    .report-meta {
        text-align: right;
        font-size: .9rem;
        color: #495057;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .summary-box {
        border: 1px solid #dee2e6;
        border-radius: .5rem;
        padding: 1rem;
        background: #fff;
    }

    .summary-box span {
        display: block;
        color: #6c757d;
        font-size: .85rem;
        margin-bottom: .35rem;
    }

    .summary-box strong {
        font-size: 1.5rem;
    }

    @media print {
        .no-print,
        .navbar,
        .sidebar,
        nav,
        aside,
        footer,
        .print-toolbar,
        .btn {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .container,
        .container-fluid,
        main,
        .content-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card,
        .card-body {
            border: 0 !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .print-page {
            width: 100% !important;
        }

        .table {
            font-size: 11px !important;
        }

        .table th,
        .table td {
            padding: 6px !important;
        }

        .report-header {
            page-break-inside: avoid;
        }

        .summary-grid {
            page-break-inside: avoid;
        }
    }
</style>


<div class="print-toolbar no-print">

    <a
        href="{{ route('reports.class-borrowing', request()->query()) }}"
        class="btn btn-secondary"
    >
        <i class="bi bi-arrow-left"></i>
        Back to Class Report
    </a>


    <button
        type="button"
        class="btn btn-primary"
        onclick="window.print();"
    >
        <i class="bi bi-printer"></i>
        Print Report
    </button>

</div>


<div class="print-page">

    <div class="report-header">

        <div>

            <h1 class="report-title">
                CLASS BORROWING REPORT
            </h1>

            <p class="report-subtitle">
                Borrowing activity for learners in
                <strong>
                    {{ $selectedClass ?? 'Selected Class' }}
                </strong>
            </p>

        </div>


        <div class="report-meta">

            <strong>
                Report Generated:
            </strong>

            <br>

            {{ $reportDate->format('d M Y, h:i A') }}

            @if($gradeClass || $stream)

                <br><br>

                <strong>
                    Class:
                </strong>

                {{ trim(($gradeClass ?? '') . ' ' . ($stream ?? '')) }}

            @endif

            @if(request('status'))

                <br>

                <strong>
                    Status:
                </strong>

                {{ ucfirst(request('status')) }}

            @endif

            @if(request('from_date') || request('to_date'))

                <br>

                <strong>
                    Period:
                </strong>

                {{ request('from_date') ? \Carbon\Carbon::parse(request('from_date'))->format('d M Y') : 'Beginning' }}
                -
                {{ request('to_date') ? \Carbon\Carbon::parse(request('to_date'))->format('d M Y') : 'Present' }}

            @endif

        </div>

    </div>


    @php

        $totalRecords =
            $borrowings->count();

        $totalLearners =
            $borrowings
                ->pluck('borrower_id')
                ->unique()
                ->count();

        $currentlyBorrowed =
            $borrowings
                ->whereIn(
                    'status',
                    [
                        'borrowed',
                        'overdue',
                    ]
                )
                ->count();

        $returnedCount =
            $borrowings
                ->where(
                    'status',
                    'returned'
                )
                ->count();

    @endphp


    <div class="summary-grid">

        <div class="summary-box">

            <span>
                Total Borrowing Records
            </span>

            <strong>
                {{ number_format($totalRecords) }}
            </strong>

        </div>


        <div class="summary-box">

            <span>
                Learners With Records
            </span>

            <strong>
                {{ number_format($totalLearners) }}
            </strong>

        </div>


        <div class="summary-box">

            <span>
                Currently Borrowed
            </span>

            <strong>
                {{ number_format($currentlyBorrowed) }}
            </strong>

        </div>


        <div class="summary-box">

            <span>
                Returned Books
            </span>

            <strong>
                {{ number_format($returnedCount) }}
            </strong>

        </div>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Learner</th>

                            <th>Admission No.</th>

                            <th>Book</th>

                            <th>Accession No.</th>

                            <th>Borrowed Date</th>

                            <th>Due Date</th>

                            <th>Returned Date</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($borrowings as $borrowing)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $borrowing->borrower->name ?? 'Unknown Learner' }}
                                </td>


                                <td>
                                    {{ $borrowing->borrower->admission_number ?? '-' }}
                                </td>


                                <td>
                                    {{ $borrowing->book->title ?? 'Unknown Book' }}
                                </td>


                                <td>
                                    {{ $borrowing->bookCopy->accession_number ?? '-' }}
                                </td>


                                <td>

                                    @if($borrowing->borrowed_date)

                                        {{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if($borrowing->due_date)

                                        {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if($borrowing->returned_date)

                                        {{ \Carbon\Carbon::parse($borrowing->returned_date)->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if($borrowing->status === 'borrowed')

                                        <span class="badge text-bg-warning">
                                            Borrowed
                                        </span>

                                    @elseif($borrowing->status === 'overdue')

                                        <span class="badge text-bg-danger">
                                            Overdue
                                        </span>

                                    @elseif($borrowing->status === 'returned')

                                        <span class="badge text-bg-success">
                                            Returned
                                        </span>

                                    @else

                                        <span class="badge text-bg-secondary">
                                            {{ ucfirst($borrowing->status ?? 'unknown') }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center text-muted py-5"
                                >

                                    No borrowing records found for this class.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <div
        class="text-center text-muted mt-4"
        style="font-size: 0.8rem;"
    >

        School Library Management System

    </div>

</div>

@endsection
