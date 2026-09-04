@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="mb-1">
            Class Borrowing Report
        </h1>

        <p class="text-muted mb-0">
            View borrowing activity for learners in a specific class.
        </p>

    </div>


    <div class="d-flex gap-2">

        {{-- BACK BUTTON --}}
        <a
            href="{{ route('reports.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>


        {{-- PRINT REPORT --}}
        @if($selectedClass)

            <a
                href="{{ route('reports.class-borrowing.preview', request()->query()) }}"
                target="_blank"
                class="btn btn-primary"
            >
                <i class="bi bi-printer"></i>
                Print Report
            </a>

        @endif

    </div>

</div>


<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('reports.class-borrowing') }}"
        >

            <div class="row g-3">


                {{-- CLASS --}}

                <div class="col-md-4">

                    <label
                        for="class"
                        class="form-label"
                    >
                        Class
                    </label>


                    <select
                        id="class"
                        name="class"
                        class="form-select"
                    >

                        <option value="">
                            Select Class
                        </option>


                        @foreach($classes as $class)

                            @php

                                $classValue =
                                    json_encode([
                                        'grade_class' => $class->grade_class,
                                        'stream' => $class->stream,
                                    ]);


                                $classLabel =
                                    trim(
                                        ($class->grade_class ?? '')
                                        . ' '
                                        . ($class->stream ?? '')
                                    );

                            @endphp


                            <option
                                value="{{ $classValue }}"
                                @selected(request('class') === $classValue)
                            >
                                {{ $classLabel }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}

                <div class="col-md-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>


                    <select
                        id="status"
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            All Records
                        </option>


                        <option
                            value="borrowed"
                            @selected(request('status') === 'borrowed')
                        >
                            Currently Borrowed
                        </option>


                        <option
                            value="overdue"
                            @selected(request('status') === 'overdue')
                        >
                            Overdue
                        </option>


                        <option
                            value="returned"
                            @selected(request('status') === 'returned')
                        >
                            Returned
                        </option>

                    </select>

                </div>


                {{-- FROM DATE --}}

                <div class="col-md-2">

                    <label
                        for="from_date"
                        class="form-label"
                    >
                        From Date
                    </label>


                    <input
                        type="date"
                        id="from_date"
                        name="from_date"
                        class="form-control"
                        value="{{ request('from_date') }}"
                    >

                </div>


                {{-- TO DATE --}}

                <div class="col-md-2">

                    <label
                        for="to_date"
                        class="form-label"
                    >
                        To Date
                    </label>


                    <input
                        type="date"
                        id="to_date"
                        name="to_date"
                        class="form-control"
                        value="{{ request('to_date') }}"
                    >

                </div>


                {{-- SEARCH BUTTON --}}

                <div class="col-md-1 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        title="Search"
                    >
                        <i class="bi bi-search"></i>
                    </button>

                </div>


            </div>


            {{-- RESET BUTTON --}}

            <div class="mt-3">

                <a
                    href="{{ route('reports.class-borrowing') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-arrow-clockwise"></i>
                    Reset Filters
                </a>

            </div>


        </form>

    </div>

</div>


@if($selectedClass)


    {{-- SUMMARY CARDS --}}

    <div class="row g-4 mb-4">


        {{-- TOTAL RECORDS --}}

        <div class="col-md-3">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total Borrowing Records
                    </small>


                    <h2 class="mb-0">
                        {{ $totalRecords }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- LEARNERS WITH RECORDS --}}

        <div class="col-md-3">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Learners With Records
                    </small>


                    <h2 class="mb-0 text-primary">
                        {{ $totalLearners }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- CURRENTLY BORROWED --}}

        <div class="col-md-3">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Currently Borrowed
                    </small>


                    <h2 class="mb-0 text-warning">
                        {{ $currentlyBorrowed }}
                    </h2>

                </div>

            </div>

        </div>


        {{-- RETURNED BOOKS --}}

        <div class="col-md-3">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Returned Books
                    </small>


                    <h2 class="mb-0 text-success">
                        {{ $returnedCount }}
                    </h2>

                </div>

            </div>

        </div>


    </div>


    {{-- REPORT TABLE --}}

    <div class="card shadow-sm">


        {{-- TABLE HEADER --}}

        <div
            class="card-header bg-white d-flex justify-content-between align-items-center"
        >

            <div>

                <h5 class="mb-0">
                    {{ $selectedClass }}
                </h5>


                <small class="text-muted">
                    Learner borrowing history
                </small>

            </div>


            <span class="badge text-bg-secondary">

                {{ $borrowings->count() }}

                Records

            </span>

        </div>


        {{-- TABLE BODY --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover table-bordered mb-0 align-middle"
                >

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


                                {{-- NUMBER --}}

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- LEARNER --}}

                                <td>
                                    {{ optional($borrowing->borrower)->name ?? 'Unknown Learner' }}
                                </td>


                                {{-- ADMISSION NUMBER --}}

                                <td>
                                    {{ optional($borrowing->borrower)->admission_number ?? '-' }}
                                </td>


                                {{-- BOOK --}}

                                <td>
                                    {{ optional($borrowing->book)->title ?? 'Unknown Book' }}
                                </td>


                                {{-- ACCESSION NUMBER --}}

                                <td>
                                    {{ optional($borrowing->bookCopy)->accession_number ?? '-' }}
                                </td>


                                {{-- BORROWED DATE --}}

                                <td>

                                    @if($borrowing->borrowed_date)

                                        {{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d M Y') }}

                                    @else

                                        -

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


                                {{-- RETURNED DATE --}}

                                <td>

                                    @if($borrowing->returned_date)

                                        {{ \Carbon\Carbon::parse($borrowing->returned_date)->format('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- STATUS --}}

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
                                            {{ ucfirst($borrowing->status) }}
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

                                    <i
                                        class="bi bi-inbox fs-2 d-block mb-2"
                                    ></i>

                                    No borrowing records found for this class.

                                </td>

                            </tr>


                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


    </div>


@else


    {{-- NO CLASS SELECTED --}}

    <div class="card shadow-sm">

        <div class="card-body text-center py-5">

            <i
                class="bi bi-people fs-1 text-muted d-block mb-3"
            ></i>


            <h5>
                Select a Class
            </h5>


            <p class="text-muted mb-0">
                Choose a class above to view learner borrowing records.
            </p>

        </div>

    </div>


@endif


@endsection