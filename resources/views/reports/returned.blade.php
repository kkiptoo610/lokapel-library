@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Returned Books Report</h1>

        <p class="text-muted mb-0">
            View the history of books returned to the library.
        </p>

    </div>


    <div>

        <a
            href="{{ route('reports.index') }}"
            class="btn btn-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Back

        </a>


        <a
            href="{{ route('reports.returned.preview', request()->query()) }}"
            class="btn btn-primary"
        >

            <i class="bi bi-eye"></i>

            Preview Report

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- DATE FILTER --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3 align-items-end">


                {{-- FROM DATE --}}

                <div class="col-md-3">

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


                {{-- TO DATE --}}

                <div class="col-md-3">

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


                {{-- BUTTONS --}}

                <div class="col-md-6">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-search"></i>

                        Filter

                    </button>


                    <a
                        href="{{ route('reports.returned') }}"
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
{{-- RETURNED BOOKS TABLE --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Book</th>

                        <th>Exact LMS Copy Number</th>

                        <th>Borrower</th>

                        <th>Borrowed Date</th>

                        <th>Returned Date</th>

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

                                    <small class="text-muted">

                                        {{ $borrowing->book->author }}

                                    </small>

                                @endif

                            </td>


                            {{-- EXACT LMS PHYSICAL COPY NUMBER --}}

                            <td>

                                <strong class="text-success">

                                    {{ $borrowing->bookCopy?->copy_number ?? '-' }}

                                </strong>

                            </td>


                            {{-- BORROWER --}}

                            <td>

                                {{ $borrowing->borrower?->name ?? '-' }}


                                @if(
                                    $borrowing->borrower_type ===
                                    \App\Models\Learner::class
                                )

                                    <br>

                                    <small class="text-muted">

                                        {{ $borrowing->borrower?->admission_number ?? '' }}

                                    </small>

                                @endif

                            </td>


                            {{-- BORROWED DATE --}}

                            <td>

                                {{ $borrowing->borrowed_date }}

                            </td>


                            {{-- RETURNED DATE --}}

                            <td>

                                {{ $borrowing->returned_date ?? '-' }}

                            </td>


                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >

                                No returned books found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection