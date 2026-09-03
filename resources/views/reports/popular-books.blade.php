@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Most Borrowed Books</h1>

        <p class="text-muted mb-0">
            Identify the books most frequently borrowed from the library.
        </p>

    </div>

    <div>

        <a
            href="{{ route('reports.index') }}"
            class="btn btn-secondary"
        >

            Back

        </a>

        <button
            class="btn btn-primary"
            onclick="window.print()"
        >

            <i class="bi bi-printer"></i>

            Print

        </button>

    </div>

</div>


<div class="card shadow-sm mb-4 no-print">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3 align-items-end">

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


                <div class="col-md-6">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        Filter

                    </button>

                    <a
                        href="{{ route('reports.popular-books') }}"
                        class="btn btn-secondary"
                    >

                        Clear

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>Rank</th>

                        <th>Book</th>

                        <th>Author</th>

                        <th>Total Copies</th>

                        <th>Total Times Borrowed</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($books as $book)

                        <tr>

                            <td>

                                <strong>

                                    #{{ $loop->iteration }}

                                </strong>

                            </td>

                            <td>

                                {{ $book->book?->title ?? '-' }}

                            </td>

                            <td>

                                {{ $book->book?->author ?? '-' }}

                            </td>

                            <td>

                                {{ $book->book?->total_copies ?? '-' }}

                            </td>

                            <td>

                                <span class="badge text-bg-primary fs-6">

                                    {{ $book->borrowing_count }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center text-muted py-4"
                            >

                                No borrowing statistics found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

@media print {

    .no-print {

        display: none !important;

    }

    .btn {

        display: none !important;

    }

}

</style>

@endsection