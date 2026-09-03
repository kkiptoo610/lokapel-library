@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Book Borrowing Details</h2>

            <p class="text-muted mb-0">
                Complete borrowing history for this book.
            </p>
        </div>

        <a
            href="{{ route('reports.borrowings', request()->only([
                'from_date',
                'to_date',
                'status',
                'borrower_type',
                'category_id',
                'subcategory_id',
                'search'
            ])) }}"
            class="btn btn-outline-secondary"
        >
            ← Back to Report
        </a>

    </div>


    {{-- BOOK INFORMATION --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <h4 class="fw-bold">
                        {{ $book->title }}
                    </h4>

                    <p class="mb-1">
                        <strong>Author:</strong>
                        {{ $book->author ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Book Code:</strong>
                        {{ $book->book_code ?? '-' }}
                    </p>

                    <p class="mb-0">
                        <strong>ISBN:</strong>
                        {{ $book->isbn ?? '-' }}
                    </p>

                </div>


                <div class="col-md-4">

                    <p class="mb-1">
                        <strong>Category:</strong>
                    </p>

                    <p>

                        @if($book->subcategory && $book->subcategory->parent)

                            {{ $book->subcategory->parent->name }}

                        @elseif($book->category)

                            {{ $book->category->name }}

                        @else

                            Uncategorized

                        @endif

                    </p>


                    <p class="mb-1">
                        <strong>Subcategory:</strong>
                    </p>

                    <p>
                        {{ $book->subcategory->name ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- SUMMARY --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm text-center">

                <div class="card-body">

                    <small class="text-muted">
                        Total Borrowings
                    </small>

                    <h3 class="fw-bold mb-0">
                        {{ $bookBorrowings->count() }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm text-center">

                <div class="card-body">

                    <small class="text-muted">
                        Unique Borrowers
                    </small>

                    <h3 class="fw-bold mb-0">
                        {{ $borrowers->count() }}
                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm text-center">

                <div class="card-body">

                    <small class="text-muted">
                        Active Borrowings
                    </small>

                    <h3 class="fw-bold text-warning mb-0">

                        {{ $bookBorrowings->whereIn('status', ['borrowed', 'overdue'])->count() }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-3 mb-3">

            <div class="card shadow-sm text-center">

                <div class="card-body">

                    <small class="text-muted">
                        Returned
                    </small>

                    <h3 class="fw-bold text-success mb-0">

                        {{ $bookBorrowings->where('status', 'returned')->count() }}

                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- BORROWERS --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">
                Borrower Activity
            </h5>

        </div>


        <div class="card-body p-0">

            @if($borrowers->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Borrower</th>
                                <th>Type</th>
                                <th>Admission Number</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Active</th>
                                <th>Latest Borrowing</th>
                                <th>Status</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($borrowers as $index => $item)

                                @php
                                    $borrower = $item['borrower'];
                                    $latest = $item['latest_borrowing'];
                                @endphp


                                {{-- BORROWER ROW --}}
                                <tr>

                                    <td>
                                        {{ $index + 1 }}
                                    </td>


                                    <td>

                                        <strong>
                                            {{ $borrower->name ?? 'Unknown Borrower' }}
                                        </strong>

                                    </td>


                                    <td>

                                        <span class="badge bg-primary">

                                            {{ $item['borrower_type'] }}

                                        </span>

                                    </td>


                                    <td>

                                        {{ $borrower->admission_number ?? '-' }}

                                    </td>


                                    <td class="text-center">

                                        <strong>
                                            {{ $item['total_borrowings'] }}
                                        </strong>

                                    </td>


                                    <td class="text-center">

                                        @if($item['active_borrowings'] > 0)

                                            <span class="badge bg-warning text-dark">

                                                {{ $item['active_borrowings'] }}

                                            </span>

                                        @else

                                            0

                                        @endif

                                    </td>


                                    <td>

                                        @if($latest && $latest->borrowed_date)

                                            {{ \Carbon\Carbon::parse($latest->borrowed_date)->format('d M Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    <td>

                                        @if($latest && $latest->status === 'returned')

                                            <span class="badge bg-success">
                                                Returned
                                            </span>

                                        @elseif($latest && $latest->status === 'overdue')

                                            <span class="badge bg-danger">
                                                Overdue
                                            </span>

                                        @elseif($latest && $latest->status === 'borrowed')

                                            <span class="badge bg-warning text-dark">
                                                Borrowed
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>


                                {{-- BORROWING HISTORY --}}
                                @if($item['borrowings']->count() > 0)

                                    <tr>

                                        <td colspan="8" class="bg-light">

                                            <div class="p-3">

                                                <strong>
                                                    Borrowing History
                                                </strong>


                                                <div class="table-responsive mt-2">

                                                    <table class="table table-sm table-bordered mb-0">

                                                        <thead>

                                                            <tr>
                                                                <th>Copy</th>
                                                                <th>Borrowed Date</th>
                                                                <th>Due Date</th>
                                                                <th>Returned Date</th>
                                                                <th>Status</th>
                                                            </tr>

                                                        </thead>


                                                        <tbody>

                                                            @foreach($item['borrowings'] as $borrowing)

                                                                <tr>

                                                                    <td>

                                                                        @if($borrowing->bookCopy)

                                                                            {{ $borrowing->bookCopy->accession_number ?? $borrowing->bookCopy->copy_number ?? '-' }}

                                                                        @else

                                                                            -

                                                                        @endif

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

                                                                        @if($borrowing->status === 'returned')

                                                                            <span class="badge bg-success">
                                                                                Returned
                                                                            </span>

                                                                        @elseif($borrowing->status === 'overdue')

                                                                            <span class="badge bg-danger">
                                                                                Overdue
                                                                            </span>

                                                                        @elseif($borrowing->status === 'borrowed')

                                                                            <span class="badge bg-warning text-dark">
                                                                                Borrowed
                                                                            </span>

                                                                        @else

                                                                            <span class="badge bg-secondary">

                                                                                {{ ucfirst($borrowing->status) }}

                                                                            </span>

                                                                        @endif

                                                                    </td>

                                                                </tr>

                                                            @endforeach

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </td>

                                    </tr>

                                @endif

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <h5 class="text-muted">
                        No borrowing records found for this book.
                    </h5>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection