@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Book Details</h1>

        <p class="text-muted mb-0">

            View detailed information and individual physical copies.

        </p>

    </div>


    <div>

        <a
            href="{{ route('books.edit', $book) }}"
            class="btn btn-warning"
        >

            <i class="bi bi-pencil"></i>

            Edit Book

        </a>


        <a
            href="{{ route('books.index') }}"
            class="btn btn-secondary"
        >

            Back

        </a>

    </div>

</div>



{{-- ========================================================= --}}
{{-- BOOK DETAILS --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">

    <div class="card-body">

        <div class="row">


            {{-- ========================================================= --}}
            {{-- BOOK TITLE --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Book Title:</strong>

                <br>

                {{ $book->title }}

            </div>


            {{-- ========================================================= --}}
            {{-- BOOK CODE --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Book Code:</strong>

                <br>

                {{ $book->book_code }}

            </div>


            {{-- ========================================================= --}}
            {{-- AUTHOR --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Author:</strong>

                <br>

                {{ $book->author }}

            </div>


            {{-- ========================================================= --}}
            {{-- ISBN --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>ISBN:</strong>

                <br>

                {{ $book->isbn ?? '-' }}

            </div>


            {{-- ========================================================= --}}
            {{-- MAIN CATEGORY --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Category:</strong>

                <br>

                @if($book->category)

                    <span class="badge text-bg-primary fs-6">

                        {{ $book->category->name }}

                    </span>

                @else

                    -

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- SUBCATEGORY --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Subcategory:</strong>

                <br>

                @if($book->subcategory)

                    <span class="badge text-bg-info fs-6">

                        {{ $book->subcategory->name }}

                    </span>

                @else

                    <span class="text-muted">

                        No subcategory selected

                    </span>

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- PUBLISHER --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Publisher:</strong>

                <br>

                {{ $book->publisher ?? '-' }}

            </div>


            {{-- ========================================================= --}}
            {{-- PUBLICATION YEAR --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Publication Year:</strong>

                <br>

                {{ $book->publication_year ?? '-' }}

            </div>


            {{-- ========================================================= --}}
            {{-- SHELF LOCATION --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Shelf Location:</strong>

                <br>

                {{ $book->shelf_location ?? '-' }}

            </div>


            {{-- ========================================================= --}}
            {{-- DATE ADDED --}}
            {{-- ========================================================= --}}

            <div class="col-md-6 mb-3">

                <strong>Date Added:</strong>

                <br>

                {{ $book->created_at->format('d M Y') }}

            </div>


        </div>


        <hr>


        {{-- ========================================================= --}}
        {{-- COPY STATISTICS --}}
        {{-- ========================================================= --}}

        <div class="row">


            {{-- TOTAL COPIES --}}

            <div class="col-md-4 mb-3">

                <strong>Total Copies:</strong>

                <br>

                <span class="badge text-bg-primary fs-6">

                    {{ $book->total_copies }}

                </span>

            </div>


            {{-- AVAILABLE COPIES --}}

            <div class="col-md-4 mb-3">

                <strong>Available Copies:</strong>

                <br>

                <span class="badge text-bg-success fs-6">

                    {{ $book->available_copies }}

                </span>

            </div>


            {{-- BORROWED COPIES --}}

            <div class="col-md-4 mb-3">

                <strong>Borrowed Copies:</strong>

                <br>

                <span class="badge text-bg-warning fs-6">

                    {{
                        $book
                            ->copies
                            ->where('status', 'borrowed')
                            ->count()
                    }}

                </span>

            </div>


        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- PHYSICAL BOOK COPIES --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mt-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h4 class="mb-0">

                    Physical Book Copies

                </h4>

                <small class="text-muted">

                    Each physical copy has its own unique library number.

                </small>

            </div>

        </div>


        @if(
            $book->copies
            &&
            $book->copies->count() > 0
        )


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Copy Number</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($book->copies as $copy)

                            <tr>


                                <td>

                                    {{ $loop->iteration }}

                                </td>


                                {{-- COPY NUMBER --}}

                                <td>

                                    <strong>

                                        {{ $copy->copy_number }}

                                    </strong>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($copy->status === 'available')

                                        <span class="badge text-bg-success">

                                            Available

                                        </span>


                                    @elseif($copy->status === 'borrowed')

                                        <span class="badge text-bg-warning">

                                            Borrowed

                                        </span>


                                    @elseif($copy->status === 'lost')

                                        <span class="badge text-bg-danger">

                                            Lost

                                        </span>


                                    @elseif($copy->status === 'damaged')

                                        <span class="badge text-bg-secondary">

                                            Damaged

                                        </span>


                                    @else

                                        <span class="badge text-bg-secondary">

                                            {{ ucfirst($copy->status) }}

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

                No individual physical copies have been created for this
                book yet.

            </div>


        @endif

    </div>

</div>



{{-- ========================================================= --}}
{{-- BORROWING HISTORY --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mt-4">

    <div class="card-body">

        <h4 class="mb-3">

            Borrowing History

        </h4>


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Book Copy</th>

                        <th>Borrower</th>

                        <th>Borrowed Date</th>

                        <th>Due Date</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>


                    @forelse($book->borrowings as $borrowing)

                        <tr>


                            <td>

                                {{ $loop->iteration }}

                            </td>


                            {{-- BOOK COPY --}}

                            <td>

                                @if($borrowing->bookCopy)

                                    <strong>

                                        {{ $borrowing->bookCopy->copy_number }}

                                    </strong>

                                @else

                                    <span class="text-muted">

                                        Not assigned

                                    </span>

                                @endif

                            </td>


                            {{-- BORROWER --}}

                            <td>

                                @if($borrowing->borrower)

                                    {{ $borrowing->borrower->name }}

                                @else

                                    <span class="text-danger">

                                        Unknown Borrower

                                    </span>

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


                            {{-- STATUS --}}

                            <td>

                                @if($borrowing->status === 'borrowed')

                                    <span class="badge text-bg-warning">

                                        Borrowed

                                    </span>


                                @elseif($borrowing->status === 'returned')

                                    <span class="badge text-bg-success">

                                        Returned

                                    </span>


                                @elseif($borrowing->status === 'overdue')

                                    <span class="badge text-bg-danger">

                                        Overdue

                                    </span>


                                @else

                                    <span class="badge text-bg-secondary">

                                        {{ ucfirst($borrowing->status) }}

                                    </span>

                                @endif

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >

                                This book has not been borrowed yet.

                            </td>

                        </tr>


                    @endforelse


                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection