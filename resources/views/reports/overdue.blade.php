@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Overdue Books Report</h1>

        <p class="text-muted mb-0">
            Books that have passed their due date and have not been returned.
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


        {{-- PREVIEW REPORT --}}

        <a
            href="{{ route('reports.overdue.preview', request()->query()) }}"
            class="btn btn-danger"
        >

            <i class="bi bi-eye"></i>

            Preview Report

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTER --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3 align-items-end">


                {{-- BORROWER TYPE --}}

                <div class="col-md-4">

                    <label class="form-label">

                        Borrower Type

                    </label>


                    <select
                        name="borrower_type"
                        class="form-select"
                    >

                        <option value="">

                            All Borrowers

                        </option>


                        <option
                            value="learner"
                            @selected(request('borrower_type') === 'learner')
                        >

                            Learners

                        </option>


                        <option
                            value="teacher"
                            @selected(request('borrower_type') === 'teacher')
                        >

                            Teachers

                        </option>


                        <option
                            value="staff"
                            @selected(request('borrower_type') === 'staff')
                        >

                            Staff

                        </option>

                    </select>

                </div>


                {{-- BUTTONS --}}

                <div class="col-md-8">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-search"></i>

                        Filter

                    </button>


                    <a
                        href="{{ route('reports.overdue') }}"
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
{{-- OVERDUE BOOKS TABLE --}}
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


                        <tr class="table-danger">


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

                                <strong class="text-danger">

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


                            {{-- DUE DATE --}}

                            <td>

                                {{ $borrowing->due_date ?? '-' }}

                            </td>


                            {{-- DAYS OVERDUE --}}

                            <td>

                                <strong class="text-danger">

                                    {{ $daysOverdue }}

                                    {{ $daysOverdue == 1 ? 'day' : 'days' }}

                                </strong>

                            </td>


                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-4"
                            >

                                No overdue books found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection