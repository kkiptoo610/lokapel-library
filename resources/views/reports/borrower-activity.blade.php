@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Borrower Activity Report</h1>

        <p class="text-muted mb-0">
            View the complete borrowing activity of a learner, teacher or staff member.
        </p>

    </div>


    <div>

        <a
            href="{{ route('reports.index') }}"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Reports
        </a>


        @if($borrower)

            <a
                href="{{ route('reports.borrower-activity.preview', request()->query()) }}"
                class="btn btn-primary"
            >
                <i class="bi bi-eye"></i>
                Preview Report
            </a>

        @endif


        <button
            type="button"
            class="btn btn-primary"
            onclick="window.print()"
        >
            <i class="bi bi-printer"></i>
            Print
        </button>

    </div>

</div>



{{-- ========================================================= --}}
{{-- BORROWER SELECTION --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mb-4 no-print">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('reports.borrower-activity') }}"
        >

            <div class="row g-3 align-items-end">


                {{-- ========================================================= --}}
                {{-- BORROWER TYPE --}}
                {{-- ========================================================= --}}

                <div class="col-md-3">

                    <label
                        for="borrowerType"
                        class="form-label"
                    >
                        Borrower Type
                    </label>


                    <select
                        name="borrower_type"
                        id="borrowerType"
                        class="form-select"
                    >

                        <option value="">
                            Select Borrower Type
                        </option>


                        <option
                            value="learner"
                            @selected(request('borrower_type') === 'learner')
                        >
                            Learner
                        </option>


                        <option
                            value="teacher"
                            @selected(request('borrower_type') === 'teacher')
                        >
                            Teacher
                        </option>


                        <option
                            value="staff"
                            @selected(request('borrower_type') === 'staff')
                        >
                            Staff
                        </option>

                    </select>

                </div>



                {{-- ========================================================= --}}
                {{-- SEARCH BORROWER --}}
                {{-- ========================================================= --}}

                <div class="col-md-3">

                    <label
                        for="borrowerSearch"
                        class="form-label"
                    >
                        Search Borrower
                    </label>


                    <input
                        type="text"
                        id="borrowerSearch"
                        class="form-control"
                        placeholder="Select borrower type first"
                        autocomplete="off"
                        disabled
                    >


                    <small
                        id="searchHelp"
                        class="text-muted"
                    >
                        Select a borrower type to search.
                    </small>

                </div>



                {{-- ========================================================= --}}
                {{-- BORROWER --}}
                {{-- ========================================================= --}}

                <div class="col-md-3">

                    <label
                        for="borrowerId"
                        class="form-label"
                    >
                        Select Borrower
                    </label>


                    <select
                        name="borrower_id"
                        id="borrowerId"
                        class="form-select"
                    >

                        <option value="">
                            First select borrower type
                        </option>

                    </select>


                    <small
                        id="borrowerCount"
                        class="text-muted"
                    >
                    </small>

                </div>



                {{-- ========================================================= --}}
                {{-- BUTTONS --}}
                {{-- ========================================================= --}}

                <div class="col-md-3">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-search"></i>
                        View Activity
                    </button>


                    <a
                        href="{{ route('reports.borrower-activity') }}"
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
{{-- BORROWER INFORMATION --}}
{{-- ========================================================= --}}

@if($borrower)


    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <strong>
                Borrower Information
            </strong>

        </div>


        <div class="card-body">

            <div class="row">


                {{-- NAME --}}

                <div class="col-md-4 mb-3">

                    <strong>
                        Name:
                    </strong>

                    <br>

                    {{ $borrower->name }}

                </div>



                {{-- BORROWER TYPE --}}

                <div class="col-md-4 mb-3">

                    <strong>
                        Borrower Type:
                    </strong>

                    <br>


                    @if($borrower instanceof \App\Models\Learner)

                        Learner

                    @elseif($borrower instanceof \App\Models\Teacher)

                        Teacher

                    @elseif($borrower instanceof \App\Models\Staff)

                        Staff

                    @else

                        Unknown

                    @endif

                </div>



                {{-- LEARNER DETAILS --}}

                @if($borrower instanceof \App\Models\Learner)


                    {{-- ADMISSION NUMBER --}}

                    <div class="col-md-4 mb-3">

                        <strong>
                            Admission Number:
                        </strong>

                        <br>

                        {{ $borrower->admission_number ?? '-' }}

                    </div>



                    {{-- GRADE --}}

                    <div class="col-md-4 mb-3">

                        <strong>
                            Grade:
                        </strong>

                        <br>

                        {{ $borrower->grade_class ?? '-' }}

                    </div>



                    {{-- STREAM --}}

                    <div class="col-md-4 mb-3">

                        <strong>
                            Stream:
                        </strong>

                        <br>

                        {{ $borrower->stream ?? '-' }}

                    </div>


                @endif


            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- BORROWING SUMMARY --}}
    {{-- ========================================================= --}}

    @php

        $totalBorrowings =
            $borrowings->count();


        $activeBorrowings =
            $borrowings
                ->whereIn(
                    'status',
                    [
                        'borrowed',
                        'overdue',
                    ]
                )
                ->count();


        $returnedBorrowings =
            $borrowings
                ->where(
                    'status',
                    'returned'
                )
                ->count();


        $overdueBorrowings =
            $borrowings
                ->where(
                    'status',
                    'overdue'
                )
                ->count();

    @endphp



    <div class="row mb-4">


        {{-- TOTAL BORROWINGS --}}

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <small class="text-muted">
                        Total Borrowings
                    </small>


                    <h3 class="mb-0">
                        {{ $totalBorrowings }}
                    </h3>

                </div>

            </div>

        </div>



        {{-- ACTIVE --}}

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <small class="text-muted">
                        Active
                    </small>


                    <h3 class="mb-0 text-warning">
                        {{ $activeBorrowings }}
                    </h3>

                </div>

            </div>

        </div>



        {{-- RETURNED --}}

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <small class="text-muted">
                        Returned
                    </small>


                    <h3 class="mb-0 text-success">
                        {{ $returnedBorrowings }}
                    </h3>

                </div>

            </div>

        </div>



        {{-- OVERDUE --}}

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm">

                <div class="card-body text-center">

                    <small class="text-muted">
                        Overdue
                    </small>


                    <h3 class="mb-0 text-danger">
                        {{ $overdueBorrowings }}
                    </h3>

                </div>

            </div>

        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- BORROWING HISTORY --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm">

        <div class="card-header">

            <strong>
                Borrowing History
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">


                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Book</th>

                            <th>Book Code</th>

                            <th>Physical Copy Number</th>

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



                                {{-- BOOK CODE --}}

                                <td>
                                    {{ $borrowing->book?->book_code ?? '-' }}
                                </td>



                                {{-- PHYSICAL COPY NUMBER --}}

                                <td>

                                    <strong class="text-primary">
                                        {{ $borrowing->bookCopy?->copy_number ?? '-' }}
                                    </strong>

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
                                    colspan="8"
                                    class="text-center text-muted py-4"
                                >

                                    No borrowing records found for this borrower.

                                </td>

                            </tr>


                        @endforelse


                    </tbody>


                </table>

            </div>

        </div>

    </div>



@else


    {{-- ========================================================= --}}
    {{-- EMPTY STATE --}}
    {{-- ========================================================= --}}

    <div class="alert alert-info">

        <i class="bi bi-info-circle"></i>

        Select a borrower type, search by name or admission number, then select the borrower to view their borrowing activity.

    </div>


@endif



{{-- ========================================================= --}}
{{-- PREPARE BORROWER DATA --}}
{{-- ========================================================= --}}

@php

    $borrowerData = [

        'learner' => $learners
            ->map(function ($learner) {

                return [

                    'id' =>
                        $learner->id,


                    'name' =>
                        $learner->name,


                    'admission_number' =>
                        $learner->admission_number
                        ?? '',


                    'grade_class' =>
                        $learner->grade_class
                        ?? '',


                    'stream' =>
                        $learner->stream
                        ?? '',


                    'label' =>
                        $learner->name
                        . ' - '
                        . (
                            $learner->admission_number
                            ?? 'No Admission Number'
                        )
                        . ' - '
                        . trim(
                            (
                                $learner->grade_class
                                ?? ''
                            )
                            . ' '
                            . (
                                $learner->stream
                                ?? ''
                            )
                        ),

                ];

            })
            ->values(),



        'teacher' => $teachers
            ->map(function ($teacher) {

                return [

                    'id' =>
                        $teacher->id,


                    'name' =>
                        $teacher->name,


                    'admission_number' =>
                        '',


                    'label' =>
                        $teacher->name,

                ];

            })
            ->values(),



        'staff' => $staff
            ->map(function ($staffMember) {

                return [

                    'id' =>
                        $staffMember->id,


                    'name' =>
                        $staffMember->name,


                    'admission_number' =>
                        '',


                    'label' =>
                        $staffMember->name,

                ];

            })
            ->values(),

    ];

@endphp



{{-- ========================================================= --}}
{{-- SEARCHABLE BORROWER DROPDOWN JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const borrowerType =
            document.getElementById(
                'borrowerType'
            );


        const borrowerSearch =
            document.getElementById(
                'borrowerSearch'
            );


        const borrowerId =
            document.getElementById(
                'borrowerId'
            );


        const borrowerCount =
            document.getElementById(
                'borrowerCount'
            );


        const searchHelp =
            document.getElementById(
                'searchHelp'
            );


        const selectedBorrowerId =
            "{{ request('borrower_id') }}";


        const borrowerData =
            @json($borrowerData);



        /*
        |--------------------------------------------------------------------------
        | UPDATE SEARCH PLACEHOLDER
        |--------------------------------------------------------------------------
        */

        function updateSearchSettings() {


            const selectedType =
                borrowerType.value;


            borrowerSearch.value =
                '';


            if (
                selectedType === 'learner'
            ) {

                borrowerSearch.disabled =
                    false;


                borrowerSearch.placeholder =
                    'Search by name or admission number';


                searchHelp.textContent =
                    'Type a learner name or admission number.';


                return;

            }


            if (
                selectedType === 'teacher'
            ) {

                borrowerSearch.disabled =
                    false;


                borrowerSearch.placeholder =
                    'Search teacher by name';


                searchHelp.textContent =
                    'Type the teacher name.';


                return;

            }


            if (
                selectedType === 'staff'
            ) {

                borrowerSearch.disabled =
                    false;


                borrowerSearch.placeholder =
                    'Search staff by name';


                searchHelp.textContent =
                    'Type the staff member name.';


                return;

            }


            borrowerSearch.disabled =
                true;


            borrowerSearch.placeholder =
                'Select borrower type first';


            searchHelp.textContent =
                'Select a borrower type to search.';


        }



        /*
        |--------------------------------------------------------------------------
        | GET FILTERED BORROWERS
        |--------------------------------------------------------------------------
        */

        function getFilteredBorrowers() {


            const selectedType =
                borrowerType.value;


            const searchTerm =
                borrowerSearch.value
                    .trim()
                    .toLowerCase();


            if (
                !selectedType
                ||
                !borrowerData[selectedType]
            ) {

                return [];

            }


            return borrowerData[selectedType]
                .filter(
                    function (borrower) {


                        if (
                            searchTerm === ''
                        ) {

                            return true;

                        }


                        const name =
                            (
                                borrower.name
                                ?? ''
                            )
                            .toLowerCase();


                        const admissionNumber =
                            (
                                borrower.admission_number
                                ?? ''
                            )
                            .toLowerCase();


                        const label =
                            (
                                borrower.label
                                ?? ''
                            )
                            .toLowerCase();


                        return (
                            name.includes(
                                searchTerm
                            )
                            ||
                            admissionNumber.includes(
                                searchTerm
                            )
                            ||
                            label.includes(
                                searchTerm
                            )
                        );


                    }
                );


        }



        /*
        |--------------------------------------------------------------------------
        | POPULATE BORROWERS
        |--------------------------------------------------------------------------
        */

        function populateBorrowers() {


            const selectedType =
                borrowerType.value;


            const filteredBorrowers =
                getFilteredBorrowers();


            const currentSelectedId =
                borrowerId.value
                ||
                selectedBorrowerId;


            borrowerId.innerHTML =
                '';


            const defaultOption =
                document.createElement(
                    'option'
                );


            defaultOption.value =
                '';


            if (
                !selectedType
            ) {

                defaultOption.textContent =
                    'First select borrower type';

            } else if (
                filteredBorrowers.length === 0
            ) {

                defaultOption.textContent =
                    'No borrower found';

            } else {

                defaultOption.textContent =
                    'Select Borrower';

            }


            borrowerId.appendChild(
                defaultOption
            );


            filteredBorrowers.forEach(
                function (borrower) {


                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        borrower.id;


                    option.textContent =
                        borrower.label;


                    if (
                        String(
                            borrower.id
                        )
                        ===
                        String(
                            currentSelectedId
                        )
                    ) {

                        option.selected =
                            true;

                    }


                    borrowerId.appendChild(
                        option
                    );


                }
            );


            if (
                selectedType
            ) {

                borrowerCount.textContent =
                    filteredBorrowers.length
                    +
                    (
                        filteredBorrowers.length === 1
                            ? ' borrower found'
                            : ' borrowers found'
                    );

            } else {

                borrowerCount.textContent =
                    '';

            }


        }



        /*
        |--------------------------------------------------------------------------
        | CHANGE BORROWER TYPE
        |--------------------------------------------------------------------------
        */

        borrowerType.addEventListener(
            'change',
            function () {


                borrowerId.value =
                    '';


                updateSearchSettings();


                populateBorrowers();


                if (
                    !borrowerSearch.disabled
                ) {

                    borrowerSearch.focus();

                }


            }
        );



        /*
        |--------------------------------------------------------------------------
        | SEARCH WHILE TYPING
        |--------------------------------------------------------------------------
        */

        borrowerSearch.addEventListener(
            'input',
            function () {


                populateBorrowers();


            }
        );



        /*
        |--------------------------------------------------------------------------
        | INITIAL LOAD
        |--------------------------------------------------------------------------
        */

        updateSearchSettings();


        populateBorrowers();


    }
);

</script>



{{-- ========================================================= --}}
{{-- PRINT STYLES --}}
{{-- ========================================================= --}}

<style>

@media print {


    .no-print {

        display: none !important;

    }


    .btn {

        display: none !important;

    }


    .sidebar {

        display: none !important;

    }


    .content {

        margin-left: 0 !important;

        padding: 0 !important;

    }


    .card {

        box-shadow: none !important;

        border: none !important;

    }


}

</style>

@endsection