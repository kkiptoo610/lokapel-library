@extends('layouts.app')

@section('content')

<div class="borrowings-page">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="page-header mb-4">

        <div class="page-title-area">

            <div class="page-icon">

                <i class="bi bi-arrow-left-right"></i>

            </div>


            <div>

                <h1>

                    Book Borrowings

                </h1>


                <p>

                    Follow up on borrowed, overdue and returned books.

                </p>

            </div>

        </div>


        <a
            href="{{ route('borrowings.create') }}"
            class="btn btn-issue-book"
        >

            <i class="bi bi-plus-circle"></i>

            Issue Book

        </a>

    </div>



    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="modern-alert success-alert">

            <div>

                <i class="bi bi-check-circle-fill"></i>

                {{ session('success') }}

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('error'))

        <div class="modern-alert error-alert">

            <div>

                <i class="bi bi-exclamation-circle-fill"></i>

                {{ session('error') }}

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- OVERDUE ALERT --}}
    {{-- ========================================================= --}}

    @if($overdueCount > 0)

        <div class="overdue-alert mb-4">


            <div class="overdue-alert-left">


                <div class="overdue-alert-icon">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                </div>


                <div>

                    <h5>

                        Attention Required

                    </h5>


                    <p>

                        There
                        {{ $overdueCount === 1 ? 'is' : 'are' }}

                        <strong>

                            {{ $overdueCount }}

                        </strong>

                        overdue
                        {{ $overdueCount === 1 ? 'book' : 'books' }}

                        requiring follow-up.

                    </p>

                </div>

            </div>


            <a
                href="{{ route('borrowings.index', ['status' => 'overdue']) }}"
                class="btn btn-overdue"
            >

                <i class="bi bi-eye"></i>

                View Overdue Books

            </a>


        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- FILTERS --}}
    {{-- ========================================================= --}}

    <div class="filter-card mb-4">


        <div class="filter-header">

            <div>

                <h5>

                    <i class="bi bi-funnel"></i>

                    Search & Filter Borrowings

                </h5>


                <p>

                    Find borrowing records quickly.

                </p>

            </div>

        </div>



        <form method="GET">


            <div class="row g-3">


                {{-- SEARCH --}}

                <div class="col-lg-4">

                    <label class="filter-label">

                        Search

                    </label>


                    <div class="search-input-wrapper">

                        <i class="bi bi-search"></i>


                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Borrower, admission number or book..."
                        >

                    </div>

                </div>



                {{-- BORROWER TYPE --}}

                <div class="col-lg-2 col-md-4">

                    <label class="filter-label">

                        Borrower

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



                {{-- CLASS --}}

                <div class="col-lg-2 col-md-4">

                    <label class="filter-label">

                        Class

                    </label>


                    <select
                        name="grade_class"
                        class="form-select"
                    >

                        <option value="">

                            All Classes

                        </option>


                        <option
                            value="Grade 10"
                            @selected(request('grade_class') === 'Grade 10')
                        >

                            Grade 10

                        </option>


                        <option
                            value="Grade 11"
                            @selected(request('grade_class') === 'Grade 11')
                        >

                            Grade 11

                        </option>


                        <option
                            value="Grade 12"
                            @selected(request('grade_class') === 'Grade 12')
                        >

                            Grade 12

                        </option>


                        <option
                            value="Form 3"
                            @selected(request('grade_class') === 'Form 3')
                        >

                            Form 3

                        </option>


                        <option
                            value="Form 4"
                            @selected(request('grade_class') === 'Form 4')
                        >

                            Form 4

                        </option>

                    </select>

                </div>



                {{-- STREAM --}}

                <div class="col-lg-2 col-md-4">

                    <label class="filter-label">

                        Stream

                    </label>


                    <select
                        name="stream"
                        class="form-select"
                    >

                        <option value="">

                            All Streams

                        </option>


                        <option
                            value="East"
                            @selected(request('stream') === 'East')
                        >

                            East

                        </option>


                        <option
                            value="West"
                            @selected(request('stream') === 'West')
                        >

                            West

                        </option>

                    </select>

                </div>



                {{-- STATUS --}}

                <div class="col-lg-2">

                    <label class="filter-label">

                        Status

                    </label>


                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">

                            All Status

                        </option>


                        <option
                            value="borrowed"
                            @selected(request('status') === 'borrowed')
                        >

                            Borrowed

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



                {{-- BUTTONS --}}

                <div class="col-12">


                    <button
                        type="submit"
                        class="btn btn-filter"
                    >

                        <i class="bi bi-search"></i>

                        Apply Filters

                    </button>


                    <a
                        href="{{ route('borrowings.index') }}"
                        class="btn btn-clear"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        Clear Filters

                    </a>


                </div>


            </div>


        </form>


    </div>



    {{-- ========================================================= --}}
    {{-- LEARNERS --}}
    {{-- ========================================================= --}}

    @if($learnerBorrowings->count())

        <div class="borrower-section-title">

            <div class="borrower-section-icon learner-icon">

                <i class="bi bi-mortarboard"></i>

            </div>

            <div>

                <h3>

                    Learner Borrowings

                </h3>

                <p>

                    Each learner is shown once. Click View Books to see all books borrowed by that learner.

                </p>

            </div>

        </div>

        @php

            $groupedByClass =
                $learnerBorrowings->groupBy(
                    fn ($borrowing) =>
                        $borrowing->borrower?->grade_class
                        ?? 'Unknown Class'
                );

        @endphp

        @foreach($groupedByClass as $gradeClass => $classBorrowings)

            <div class="borrowing-card mb-4">

                <div class="borrowing-card-header">

                    <div>

                        <i class="bi bi-building"></i>

                        {{ $gradeClass }}

                    </div>

                    <span>

                        {{ $classBorrowings->count() }}

                        Records

                    </span>

                </div>

                <div class="borrowing-card-body">

                    @php

                        $groupedByStream =
                            $classBorrowings->groupBy(
                                fn ($borrowing) =>
                                    $borrowing->borrower?->stream
                                    ?? 'Unknown Stream'
                            );

                    @endphp

                    @foreach($groupedByStream as $stream => $streamBorrowings)

                        @php

                            $borrowers =
                                $streamBorrowings->groupBy(
                                    fn ($borrowing) =>
                                        ($borrowing->borrower_type ?? '')
                                        . ':'
                                        . ($borrowing->borrower_id ?? $borrowing->borrower?->id ?? $borrowing->id)
                                );

                        @endphp

                        <div class="stream-title">

                            <i class="bi bi-diagram-3"></i>

                            {{ $stream }} Stream

                        </div>

                        <div class="table-responsive">

                            <table class="table modern-borrowing-table borrower-summary-table align-middle">

                                <thead>

                                    <tr>

                                        <th>Learner</th>

                                        <th>Admission No.</th>

                                        <th>Books</th>

                                        <th>Active</th>

                                        <th>Overdue</th>

                                        <th>Status</th>

                                        <th class="text-end">

                                            Action

                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($borrowers as $borrowerKey => $borrowerBorrowings)

                                        @php

                                            $firstBorrowing =
                                                $borrowerBorrowings->first();

                                            $borrower =
                                                $firstBorrowing?->borrower;

                                            $borrowerName =
                                                $borrower?->name
                                                ?? 'Unknown Borrower';

                                            $admissionNumber =
                                                $borrower?->admission_number
                                                ?? '-';

                                            $activeCount =
                                                $borrowerBorrowings
                                                    ->whereIn(
                                                        'status',
                                                        ['borrowed', 'overdue']
                                                    )
                                                    ->count();

                                            $overdueCountForBorrower =
                                                $borrowerBorrowings
                                                    ->where('status', 'overdue')
                                                    ->count();

                                            $detailId =
                                                'learner-books-'
                                                . md5($gradeClass . '-' . $stream . '-' . $borrowerKey);

                                        @endphp

                                        <tr class="borrower-summary-row">

                                            <td>

                                                <div class="borrower-name-cell">

                                                    <div class="borrower-avatar learner-avatar">

                                                        <i class="bi bi-mortarboard"></i>

                                                    </div>

                                                    <div>

                                                        <strong>

                                                            {{ $borrowerName }}

                                                        </strong>

                                                        <small>

                                                            {{ $borrowerBorrowings->count() }}

                                                            {{ $borrowerBorrowings->count() === 1 ? 'record' : 'records' }}

                                                        </small>

                                                    </div>

                                                </div>

                                            </td>

                                            <td>

                                                <span class="admission-badge">

                                                    Admission {{ $admissionNumber }}

                                                </span>

                                            </td>

                                            <td>

                                                <strong>

                                                    {{ $borrowerBorrowings->count() }}

                                                </strong>

                                            </td>

                                            <td>

                                                <span class="count-pill count-active">

                                                    {{ $activeCount }} active

                                                </span>

                                            </td>

                                            <td>

                                                @if($overdueCountForBorrower > 0)

                                                    <span class="count-pill count-overdue">

                                                        {{ $overdueCountForBorrower }} overdue

                                                    </span>

                                                @else

                                                    <span class="text-muted">

                                                        -

                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                @if($overdueCountForBorrower > 0)

                                                    <span class="status-badge status-overdue">

                                                        <i class="bi bi-exclamation-triangle"></i>

                                                        Needs Attention

                                                    </span>

                                                @elseif($activeCount > 0)

                                                    <span class="status-badge status-borrowed">

                                                        <i class="bi bi-bookmark"></i>

                                                        Borrowing

                                                    </span>

                                                @else

                                                    <span class="status-badge status-returned">

                                                        <i class="bi bi-check-circle"></i>

                                                        Returned

                                                    </span>

                                                @endif

                                            </td>

                                            <td class="text-end">

                                                <button
                                                    type="button"
                                                    class="action-button view-button borrower-view-button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $detailId }}"
                                                    aria-expanded="false"
                                                    title="View all books borrowed by {{ $borrowerName }}"
                                                >

                                                    <i class="bi bi-eye"></i>

                                                </button>

                                            </td>

                                        </tr>

                                        <tr class="borrower-detail-row">

                                            <td colspan="7" class="p-0">

                                                <div
                                                    id="{{ $detailId }}"
                                                    class="collapse"
                                                >

                                                    <div class="borrower-books-panel">

                                                        <div class="borrower-books-panel-header">

                                                            <div>

                                                                <i class="bi bi-journals"></i>

                                                                All books for

                                                                <strong>

                                                                    {{ $borrowerName }}

                                                                </strong>

                                                            </div>

                                                            <span>

                                                                {{ $borrowerBorrowings->count() }}

                                                                {{ $borrowerBorrowings->count() === 1 ? 'book' : 'books' }}

                                                            </span>

                                                        </div>

                                                        <div class="table-responsive">

                                                            <table class="table borrower-books-table align-middle mb-0">

                                                                <thead>

                                                                    <tr>

                                                                        <th>Book</th>

                                                                        <th>Copy No.</th>

                                                                        <th>Borrowed</th>

                                                                        <th>Due</th>

                                                                        <th>Returned</th>

                                                                        <th>Condition</th>

                                                                        <th>Damage Description</th>

                                                                        <th>Overdue</th>

                                                                        <th>Status</th>

                                                                        <th class="text-end">Action</th>

                                                                    </tr>

                                                                </thead>

                                                                <tbody>

                                                                    @foreach($borrowerBorrowings as $borrowing)

                                                                        @php

                                                                            $isOverdue =
                                                                                $borrowing->status === 'overdue';

                                                                            $daysOverdue = null;

                                                                            if (
                                                                                $isOverdue
                                                                                &&
                                                                                $borrowing->due_date
                                                                            ) {

                                                                                $daysOverdue =
                                                                                    \Carbon\Carbon::parse(
                                                                                        $borrowing->due_date
                                                                                    )
                                                                                    ->startOfDay()
                                                                                    ->diffInDays(
                                                                                        \Carbon\Carbon::today()
                                                                                            ->startOfDay()
                                                                                    );

                                                                            }

                                                                            $copyNumber =
                                                                                $borrowing->bookCopy?->copy_number
                                                                                ?? '-';

                                                                        @endphp

                                                                        <tr @class(['overdue-row' => $isOverdue])>

                                                                            <td class="book-title">

                                                                                {{ $borrowing->book?->title ?? 'Unknown Book' }}

                                                                            </td>

                                                                            <td>

                                                                                <span class="copy-badge">

                                                                                    {{ $copyNumber }}

                                                                                </span>

                                                                            </td>

                                                                            <td>

                                                                                {{ $borrowing->borrowed_date }}

                                                                            </td>

                                                                            <td>

                                                                                {{ $borrowing->due_date ?? '-' }}

                                                                            </td>

                                                                            <td>

                                                                                {{ $borrowing->returned_date ?? '-' }}

                                                                            </td>


                                                                            {{-- RETURN CONDITION --}}

                                                                            <td>

                                                                                @if($borrowing->status === 'returned')

                                                                                    @if($borrowing->return_condition === 'damaged')

                                                                                        <span class="condition-badge condition-damaged">

                                                                                            <i class="bi bi-exclamation-triangle-fill"></i>

                                                                                            Damaged

                                                                                        </span>

                                                                                    @else

                                                                                        <span class="condition-badge condition-good">

                                                                                            <i class="bi bi-check-circle-fill"></i>

                                                                                            Good Condition

                                                                                        </span>

                                                                                    @endif

                                                                                @else

                                                                                    <span class="text-muted">

                                                                                        -

                                                                                    </span>

                                                                                @endif

                                                                            </td>


                                                                            {{-- DAMAGE DESCRIPTION --}}

                                                                            <td class="damage-description-cell">

                                                                                @if(
                                                                                    $borrowing->status === 'returned'
                                                                                    &&
                                                                                    $borrowing->return_condition === 'damaged'
                                                                                )

                                                                                    {{ $borrowing->damage_description ?? '-' }}

                                                                                @else

                                                                                    <span class="text-muted">

                                                                                        -

                                                                                    </span>

                                                                                @endif

                                                                            </td>


                                                                            <td>

                                                                                @if($isOverdue)

                                                                                    <span class="overdue-days">

                                                                                        {{ $daysOverdue }}

                                                                                        {{ $daysOverdue == 1 ? 'day' : 'days' }}

                                                                                    </span>

                                                                                @else

                                                                                    <span class="text-muted">

                                                                                        -

                                                                                    </span>

                                                                                @endif

                                                                            </td>

                                                                            <td>

                                                                                @if($borrowing->status === 'borrowed')

                                                                                    <span class="status-badge status-borrowed">

                                                                                        Borrowed

                                                                                    </span>

                                                                                @elseif($borrowing->status === 'returned')

                                                                                    <span class="status-badge status-returned">

                                                                                        Returned

                                                                                    </span>

                                                                                @elseif($borrowing->status === 'overdue')

                                                                                    <span class="status-badge status-overdue">

                                                                                        Overdue

                                                                                    </span>

                                                                                @endif

                                                                            </td>

                                                                            <td class="text-end">

                                                                                <a
                                                                                    href="{{ route('borrowings.show', $borrowing) }}"
                                                                                    class="action-button view-button"
                                                                                    title="View Record"
                                                                                >

                                                                                    <i class="bi bi-eye"></i>

                                                                                </a>

                                                                                @if($borrowing->status !== 'returned')

                                                                                    <form
                                                                                        action="{{ route('borrowings.return', $borrowing) }}"
                                                                                        method="POST"
                                                                                        class="d-inline return-book-form"
                                                                                    >

                                                                                        @csrf

                                                                                        <button
                                                                                            type="button"
                                                                                            class="action-button return-button return-book-button"
                                                                                            title="Return Book"
                                                                                            data-name="{{ $borrowerName }}"
                                                                                            data-book="{{ $borrowing->book?->title ?? 'Unknown Book' }}"
                                                                                            data-copy="{{ $copyNumber }}"
                                                                                        >

                                                                                            <i class="bi bi-arrow-return-left"></i>

                                                                                        </button>

                                                                                    </form>

                                                                                @endif

                                                                            </td>

                                                                        </tr>

                                                                    @endforeach

                                                                </tbody>

                                                            </table>

                                                        </div>

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endforeach

                </div>

            </div>

        @endforeach

    @endif



    {{-- ========================================================= --}}
    {{-- TEACHERS --}}
    {{-- ========================================================= --}}

    @if($teacherBorrowings->count())

        <div class="borrower-section-title mt-5">

            <div class="borrower-section-icon teacher-icon">

                <i class="bi bi-person-workspace"></i>

            </div>

            <div>

                <h3>

                    Teacher Borrowings

                </h3>

                <p>

                    Each teacher is shown once. Click View Books to see all borrowing records.

                </p>

            </div>

        </div>

        @php

            $teacherGroups =
                $teacherBorrowings->groupBy(
                    fn ($borrowing) =>
                        ($borrowing->borrower_type ?? '')
                        . ':'
                        . ($borrowing->borrower_id ?? $borrowing->borrower?->id ?? $borrowing->id)
                );

        @endphp

        <div class="borrowing-card mb-4">

            <div class="borrowing-card-body">

                <div class="table-responsive">

                    <table class="table modern-borrowing-table borrower-summary-table align-middle">

                        <thead>

                            <tr>

                                <th>Teacher</th>

                                <th>Phone Number</th>

                                <th>Books</th>

                                <th>Active</th>

                                <th>Overdue</th>

                                <th>Status</th>

                                <th class="text-end">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($teacherGroups as $borrowerKey => $borrowerBorrowings)

                                @php

                                    $firstBorrowing = $borrowerBorrowings->first();
                                    $borrower = $firstBorrowing?->borrower;
                                    $borrowerName = $borrower?->name ?? 'Unknown Teacher';
                                    $phoneNumber = $borrower?->phone_number ?? '-';
                                    $activeCount = $borrowerBorrowings->whereIn('status', ['borrowed', 'overdue'])->count();
                                    $overdueCountForBorrower = $borrowerBorrowings->where('status', 'overdue')->count();
                                    $detailId = 'teacher-books-' . md5($borrowerKey);

                                @endphp

                                <tr class="borrower-summary-row">

                                    <td>

                                        <div class="borrower-name-cell">

                                            <div class="borrower-avatar teacher-avatar">

                                                <i class="bi bi-person-workspace"></i>

                                            </div>

                                            <div>

                                                <strong>{{ $borrowerName }}</strong>

                                                <small>

                                                    {{ $borrowerBorrowings->count() }} {{ $borrowerBorrowings->count() === 1 ? 'record' : 'records' }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>{{ $phoneNumber }}</td>

                                    <td><strong>{{ $borrowerBorrowings->count() }}</strong></td>

                                    <td><span class="count-pill count-active">{{ $activeCount }} active</span></td>

                                    <td>

                                        @if($overdueCountForBorrower > 0)

                                            <span class="count-pill count-overdue">{{ $overdueCountForBorrower }} overdue</span>

                                        @else

                                            <span class="text-muted">-</span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($overdueCountForBorrower > 0)

                                            <span class="status-badge status-overdue">Needs Attention</span>

                                        @elseif($activeCount > 0)

                                            <span class="status-badge status-borrowed">Borrowing</span>

                                        @else

                                            <span class="status-badge status-returned">Returned</span>

                                        @endif

                                    </td>

                                    <td class="text-end">

                                        <button
                                            type="button"
                                            class="action-button view-button borrower-view-button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{ $detailId }}"
                                            aria-expanded="false"
                                            title="View all books borrowed by {{ $borrowerName }}"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </button>

                                    </td>

                                </tr>

                                <tr class="borrower-detail-row">

                                    <td colspan="7" class="p-0">

                                        <div id="{{ $detailId }}" class="collapse">

                                            <div class="borrower-books-panel">

                                                <div class="borrower-books-panel-header">

                                                    <div>

                                                        <i class="bi bi-journals"></i>

                                                        All books for <strong>{{ $borrowerName }}</strong>

                                                    </div>

                                                    <span>{{ $borrowerBorrowings->count() }} {{ $borrowerBorrowings->count() === 1 ? 'book' : 'books' }}</span>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table borrower-books-table align-middle mb-0">

                                                        <thead>

                                                            <tr>

                                                                <th>Book</th>
                                                                <th>Copy No.</th>
                                                                <th>Borrowed</th>
                                                                <th>Due</th>
                                                                <th>Returned</th>
                                                                <th>Condition</th>
                                                                <th>Damage Description</th>
                                                                <th>Overdue</th>
                                                                <th>Status</th>
                                                                <th class="text-end">Action</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            @foreach($borrowerBorrowings as $borrowing)

                                                                @php

                                                                    $isOverdue = $borrowing->status === 'overdue';
                                                                    $daysOverdue = null;

                                                                    if ($isOverdue && $borrowing->due_date) {

                                                                        $daysOverdue = \Carbon\Carbon::parse($borrowing->due_date)
                                                                            ->startOfDay()
                                                                            ->diffInDays(\Carbon\Carbon::today()->startOfDay());

                                                                    }

                                                                    $copyNumber = $borrowing->bookCopy?->copy_number ?? '-';

                                                                @endphp

                                                                <tr @class(['overdue-row' => $isOverdue])>

                                                                    <td class="book-title">{{ $borrowing->book?->title ?? 'Unknown Book' }}</td>

                                                                    <td>

                                                                        <span class="copy-badge">

                                                                            {{ $copyNumber }}

                                                                        </span>

                                                                    </td>

                                                                    <td>{{ $borrowing->borrowed_date }}</td>

                                                                    <td>{{ $borrowing->due_date ?? '-' }}</td>

                                                                    <td>{{ $borrowing->returned_date ?? '-' }}</td>


                                                                    {{-- RETURN CONDITION --}}

                                                                    <td>

                                                                        @if($borrowing->status === 'returned')

                                                                            @if($borrowing->return_condition === 'damaged')

                                                                                <span class="condition-badge condition-damaged">

                                                                                    <i class="bi bi-exclamation-triangle-fill"></i>

                                                                                    Damaged

                                                                                </span>

                                                                            @else

                                                                                <span class="condition-badge condition-good">

                                                                                    <i class="bi bi-check-circle-fill"></i>

                                                                                    Good Condition

                                                                                </span>

                                                                            @endif

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>


                                                                    {{-- DAMAGE DESCRIPTION --}}

                                                                    <td class="damage-description-cell">

                                                                        @if(
                                                                            $borrowing->status === 'returned'
                                                                            &&
                                                                            $borrowing->return_condition === 'damaged'
                                                                        )

                                                                            {{ $borrowing->damage_description ?? '-' }}

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>


                                                                    <td>

                                                                        @if($isOverdue)

                                                                            <span class="overdue-days">

                                                                                {{ $daysOverdue }}

                                                                                {{ $daysOverdue == 1 ? 'day' : 'days' }}

                                                                            </span>

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>

                                                                    <td>

                                                                        @if($borrowing->status === 'borrowed')

                                                                            <span class="status-badge status-borrowed">Borrowed</span>

                                                                        @elseif($borrowing->status === 'returned')

                                                                            <span class="status-badge status-returned">Returned</span>

                                                                        @elseif($borrowing->status === 'overdue')

                                                                            <span class="status-badge status-overdue">Overdue</span>

                                                                        @endif

                                                                    </td>

                                                                    <td class="text-end">

                                                                        <a
                                                                            href="{{ route('borrowings.show', $borrowing) }}"
                                                                            class="action-button view-button"
                                                                            title="View Record"
                                                                        >

                                                                            <i class="bi bi-eye"></i>

                                                                        </a>

                                                                        @if($borrowing->status !== 'returned')

                                                                            <form
                                                                                action="{{ route('borrowings.return', $borrowing) }}"
                                                                                method="POST"
                                                                                class="d-inline return-book-form"
                                                                            >

                                                                                @csrf

                                                                                <button
                                                                                    type="button"
                                                                                    class="action-button return-button return-book-button"
                                                                                    title="Return Book"
                                                                                    data-name="{{ $borrowerName }}"
                                                                                    data-book="{{ $borrowing->book?->title ?? 'Unknown Book' }}"
                                                                                    data-copy="{{ $copyNumber }}"
                                                                                >

                                                                                    <i class="bi bi-arrow-return-left"></i>

                                                                                </button>

                                                                            </form>

                                                                        @endif

                                                                    </td>

                                                                </tr>

                                                            @endforeach

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- STAFF --}}
    {{-- ========================================================= --}}

    @if($staffBorrowings->count())

        <div class="borrower-section-title mt-5">

            <div class="borrower-section-icon staff-icon">

                <i class="bi bi-person-badge"></i>

            </div>

            <div>

                <h3>

                    Staff Borrowings

                </h3>

                <p>

                    Each staff member is shown once. Click View Books to see all borrowing records.

                </p>

            </div>

        </div>

        @php

            $staffGroups =
                $staffBorrowings->groupBy(
                    fn ($borrowing) =>
                        ($borrowing->borrower_type ?? '')
                        . ':'
                        . ($borrowing->borrower_id ?? $borrowing->borrower?->id ?? $borrowing->id)
                );

        @endphp

        <div class="borrowing-card mb-4">

            <div class="borrowing-card-body">

                <div class="table-responsive">

                    <table class="table modern-borrowing-table borrower-summary-table align-middle">

                        <thead>

                            <tr>

                                <th>Staff Member</th>
                                <th>Phone Number</th>
                                <th>Books</th>
                                <th>Active</th>
                                <th>Overdue</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($staffGroups as $borrowerKey => $borrowerBorrowings)

                                @php

                                    $firstBorrowing = $borrowerBorrowings->first();
                                    $borrower = $firstBorrowing?->borrower;
                                    $borrowerName = $borrower?->name ?? 'Unknown Staff';
                                    $phoneNumber = $borrower?->phone_number ?? '-';
                                    $activeCount = $borrowerBorrowings->whereIn('status', ['borrowed', 'overdue'])->count();
                                    $overdueCountForBorrower = $borrowerBorrowings->where('status', 'overdue')->count();
                                    $detailId = 'staff-books-' . md5($borrowerKey);

                                @endphp

                                <tr class="borrower-summary-row">

                                    <td>

                                        <div class="borrower-name-cell">

                                            <div class="borrower-avatar staff-avatar">

                                                <i class="bi bi-person-badge"></i>

                                            </div>

                                            <div>

                                                <strong>{{ $borrowerName }}</strong>

                                                <small>{{ $borrowerBorrowings->count() }} {{ $borrowerBorrowings->count() === 1 ? 'record' : 'records' }}</small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>{{ $phoneNumber }}</td>

                                    <td><strong>{{ $borrowerBorrowings->count() }}</strong></td>

                                    <td><span class="count-pill count-active">{{ $activeCount }} active</span></td>

                                    <td>

                                        @if($overdueCountForBorrower > 0)

                                            <span class="count-pill count-overdue">{{ $overdueCountForBorrower }} overdue</span>

                                        @else

                                            <span class="text-muted">-</span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($overdueCountForBorrower > 0)

                                            <span class="status-badge status-overdue">Needs Attention</span>

                                        @elseif($activeCount > 0)

                                            <span class="status-badge status-borrowed">Borrowing</span>

                                        @else

                                            <span class="status-badge status-returned">Returned</span>

                                        @endif

                                    </td>

                                    <td class="text-end">

                                        <button
                                            type="button"
                                            class="action-button view-button borrower-view-button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{ $detailId }}"
                                            aria-expanded="false"
                                            title="View all books borrowed by {{ $borrowerName }}"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </button>

                                    </td>

                                </tr>

                                <tr class="borrower-detail-row">

                                    <td colspan="7" class="p-0">

                                        <div id="{{ $detailId }}" class="collapse">

                                            <div class="borrower-books-panel">

                                                <div class="borrower-books-panel-header">

                                                    <div>

                                                        <i class="bi bi-journals"></i>

                                                        All books for <strong>{{ $borrowerName }}</strong>

                                                    </div>

                                                    <span>{{ $borrowerBorrowings->count() }} {{ $borrowerBorrowings->count() === 1 ? 'book' : 'books' }}</span>

                                                </div>

                                                <div class="table-responsive">

                                                    <table class="table borrower-books-table align-middle mb-0">

                                                        <thead>

                                                            <tr>

                                                                <th>Book</th>
                                                                <th>Copy No.</th>
                                                                <th>Borrowed</th>
                                                                <th>Due</th>
                                                                <th>Returned</th>
                                                                <th>Condition</th>
                                                                <th>Damage Description</th>
                                                                <th>Overdue</th>
                                                                <th>Status</th>
                                                                <th class="text-end">Action</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>

                                                            @foreach($borrowerBorrowings as $borrowing)

                                                                @php

                                                                    $isOverdue = $borrowing->status === 'overdue';
                                                                    $daysOverdue = null;

                                                                    if ($isOverdue && $borrowing->due_date) {

                                                                        $daysOverdue = \Carbon\Carbon::parse($borrowing->due_date)
                                                                            ->startOfDay()
                                                                            ->diffInDays(\Carbon\Carbon::today()->startOfDay());

                                                                    }

                                                                    $copyNumber = $borrowing->bookCopy?->copy_number ?? '-';

                                                                @endphp

                                                                <tr @class(['overdue-row' => $isOverdue])>

                                                                    <td class="book-title">

                                                                        {{ $borrowing->book?->title ?? 'Unknown Book' }}

                                                                    </td>

                                                                    <td>

                                                                        <span class="copy-badge">

                                                                            {{ $copyNumber }}

                                                                        </span>

                                                                    </td>

                                                                    <td>{{ $borrowing->borrowed_date }}</td>

                                                                    <td>{{ $borrowing->due_date ?? '-' }}</td>

                                                                    <td>{{ $borrowing->returned_date ?? '-' }}</td>


                                                                    {{-- RETURN CONDITION --}}

                                                                    <td>

                                                                        @if($borrowing->status === 'returned')

                                                                            @if($borrowing->return_condition === 'damaged')

                                                                                <span class="condition-badge condition-damaged">

                                                                                    <i class="bi bi-exclamation-triangle-fill"></i>

                                                                                    Damaged

                                                                                </span>

                                                                            @else

                                                                                <span class="condition-badge condition-good">

                                                                                    <i class="bi bi-check-circle-fill"></i>

                                                                                    Good Condition

                                                                                </span>

                                                                            @endif

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>


                                                                    {{-- DAMAGE DESCRIPTION --}}

                                                                    <td class="damage-description-cell">

                                                                        @if(
                                                                            $borrowing->status === 'returned'
                                                                            &&
                                                                            $borrowing->return_condition === 'damaged'
                                                                        )

                                                                            {{ $borrowing->damage_description ?? '-' }}

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>


                                                                    <td>

                                                                        @if($isOverdue)

                                                                            <span class="overdue-days">

                                                                                {{ $daysOverdue }}

                                                                                {{ $daysOverdue == 1 ? 'day' : 'days' }}

                                                                            </span>

                                                                        @else

                                                                            <span class="text-muted">-</span>

                                                                        @endif

                                                                    </td>

                                                                    <td>

                                                                        @if($borrowing->status === 'borrowed')

                                                                            <span class="status-badge status-borrowed">Borrowed</span>

                                                                        @elseif($borrowing->status === 'returned')

                                                                            <span class="status-badge status-returned">Returned</span>

                                                                        @elseif($borrowing->status === 'overdue')

                                                                            <span class="status-badge status-overdue">Overdue</span>

                                                                        @endif

                                                                    </td>

                                                                    <td class="text-end">

                                                                        <a
                                                                            href="{{ route('borrowings.show', $borrowing) }}"
                                                                            class="action-button view-button"
                                                                            title="View Record"
                                                                        >

                                                                            <i class="bi bi-eye"></i>

                                                                        </a>

                                                                        @if($borrowing->status !== 'returned')

                                                                            <form
                                                                                action="{{ route('borrowings.return', $borrowing) }}"
                                                                                method="POST"
                                                                                class="d-inline return-book-form"
                                                                            >

                                                                                @csrf

                                                                                <button
                                                                                    type="button"
                                                                                    class="action-button return-button return-book-button"
                                                                                    title="Return Book"
                                                                                    data-name="{{ $borrowerName }}"
                                                                                    data-book="{{ $borrowing->book?->title ?? 'Unknown Book' }}"
                                                                                    data-copy="{{ $copyNumber }}"
                                                                                >

                                                                                    <i class="bi bi-arrow-return-left"></i>

                                                                                </button>

                                                                            </form>

                                                                        @endif

                                                                    </td>

                                                                </tr>

                                                            @endforeach

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- NO RESULTS --}}
    {{-- ========================================================= --}}

    @if(
        $learnerBorrowings->isEmpty()
        &&
        $teacherBorrowings->isEmpty()
        &&
        $staffBorrowings->isEmpty()
    )


        <div class="empty-borrowings">


            <div class="empty-icon">

                <i class="bi bi-inbox"></i>

            </div>


            <h4>

                No Borrowing Records Found

            </h4>


            <p>

                There are currently no borrowing records matching
                your search criteria.

            </p>


            <a
                href="{{ route('borrowings.create') }}"
                class="btn btn-primary"
            >

                <i class="bi bi-plus-circle"></i>

                Issue a Book

            </a>


        </div>


    @endif



</div>



{{-- ========================================================= --}}
{{-- RETURN CONFIRMATION MODAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="returnBookModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content modern-modal">


            <div class="modal-header">


                <h5 class="modal-title">

                    <i class="bi bi-arrow-return-left"></i>

                    Confirm Book Return

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>


            <div class="modal-body">


                <p>

                    <strong id="returnBorrowerName"></strong>

                    is returning the following book:

                </p>


                <div class="return-summary">


                    <div class="return-summary-icon">

                        <i class="bi bi-book"></i>

                    </div>


                    <div>


                        <strong id="returnBookTitle">

                        </strong>


                        <div class="mt-2">


                            Copy Number:

                            <span
                                id="returnBookCopy"
                                class="copy-badge"
                            >

                            </span>


                        </div>


                    </div>


                </div>


                {{-- ========================================================= --}}
                {{-- RETURN CONDITION --}}
                {{-- ========================================================= --}}

                <div class="return-condition-section mt-4">

                    <div class="return-condition-heading">

                        <i class="bi bi-clipboard-check"></i>

                        <strong>

                            Condition of Returned Book

                        </strong>

                    </div>


                    <div class="row g-3 mt-1">


                        {{-- GOOD CONDITION --}}

                        <div class="col-md-6">

                            <button
                                type="button"
                                class="return-condition-option condition-option-good active"
                                id="goodConditionOption"
                            >

                                <div class="condition-option-icon">

                                    <i class="bi bi-check-circle-fill"></i>

                                </div>


                                <div>

                                    <strong>

                                        Good Condition

                                    </strong>


                                    <small>

                                        The book has been returned in good condition.

                                    </small>

                                </div>

                            </button>

                        </div>



                        {{-- DAMAGED --}}

                        <div class="col-md-6">

                            <button
                                type="button"
                                class="return-condition-option condition-option-damaged"
                                id="damagedConditionOption"
                            >

                                <div class="condition-option-icon">

                                    <i class="bi bi-exclamation-triangle-fill"></i>

                                </div>


                                <div>

                                    <strong>

                                        Damaged

                                    </strong>


                                    <small>

                                        The returned book has visible damage.

                                    </small>

                                </div>

                            </button>

                        </div>


                    </div>


                    <input
                        type="hidden"
                        id="returnCondition"
                        value="good"
                    >


                    {{-- DAMAGE DESCRIPTION --}}

                    <div
                        class="damage-description-wrapper mt-4"
                        id="damageDescriptionWrapper"
                        style="display: none;"
                    >

                        <label
                            for="damageDescription"
                            class="damage-description-label"
                        >

                            <i class="bi bi-pencil-square"></i>

                            Describe the Damage

                        </label>


                        <textarea
                            id="damageDescription"
                            class="form-control damage-description-input"
                            rows="4"
                            placeholder="Describe the damage to the book..."
                        ></textarea>


                        <small class="damage-description-help">

                            Please provide a clear description of the damage.

                        </small>

                    </div>


                </div>


                <p class="text-muted mt-3 mb-0">

                    Please confirm that this exact physical book copy
                    has been returned.

                </p>


            </div>


            <div class="modal-footer">


                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >

                    Cancel

                </button>


                <button
                    type="button"
                    class="btn btn-success"
                    id="confirmReturnButton"
                >

                    <i class="bi bi-check-circle"></i>

                    Confirm Return

                </button>


            </div>


        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- PAGE STYLING --}}
{{-- ========================================================= --}}

<style>


.borrowings-page {

    padding-bottom: 30px;

}



/* ========================================================= */
/* PAGE HEADER */
/* ========================================================= */

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 25px 28px;

    background:

        linear-gradient(
            135deg,
            #0f3d6e,
            #1558a6,
            #2575d7
        );

    border-radius: 18px;

    color: white;

    box-shadow:
        0 12px 30px
        rgba(37, 117, 215, 0.18);

}


.page-title-area {

    display: flex;

    align-items: center;

    gap: 18px;

}


.page-icon {

    width: 62px;

    height: 62px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 16px;

    font-size: 27px;

    background:

        rgba(255, 255, 255, 0.16);

}


.page-header h1 {

    margin: 0;

    font-size: 28px;

    font-weight: 700;

}


.page-header p {

    margin: 5px 0 0;

    opacity: 0.85;

}


.btn-issue-book {

    background: white;

    color: #1558a6;

    border: none;

    font-weight: 600;

    padding: 11px 18px;

}


.btn-issue-book:hover {

    background: #f2f7ff;

    color: #0f3d6e;

}



/* ========================================================= */
/* ALERTS */
/* ========================================================= */

.modern-alert {

    padding: 16px 20px;

    border-radius: 14px;

    margin-bottom: 20px;

    font-weight: 500;

}


.success-alert {

    background: #e4f8ee;

    color: #16834d;

}


.error-alert {

    background: #ffe4e4;

    color: #c92a2a;

}


.modern-alert i {

    margin-right: 8px;

}



/* ========================================================= */
/* OVERDUE ALERT */
/* ========================================================= */

.overdue-alert {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 20px 24px;

    border-radius: 16px;

    background:

        linear-gradient(
            135deg,
            #fff1f1,
            #ffe3e3
        );

    border:

        1px solid #ffc9c9;

}


.overdue-alert-left {

    display: flex;

    align-items: center;

    gap: 15px;

}


.overdue-alert-icon {

    width: 50px;

    height: 50px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #e03131;

    color: white;

    font-size: 22px;

}


.overdue-alert h5 {

    margin: 0;

    color: #c92a2a;

    font-weight: 700;

}


.overdue-alert p {

    margin: 5px 0 0;

    color: #6b2b2b;

}


.btn-overdue {

    background: #e03131;

    color: white;

    border: none;

}


.btn-overdue:hover {

    background: #c92a2a;

    color: white;

}



/* ========================================================= */
/* FILTER CARD */
/* ========================================================= */

.filter-card {

    background: white;

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(0, 0, 0, 0.06);

}


.filter-header {

    margin-bottom: 20px;

}


.filter-header h5 {

    margin: 0;

    color: #253858;

    font-weight: 700;

}


.filter-header p {

    margin: 5px 0 0;

    color: #8a94a6;

}


.filter-label {

    display: block;

    margin-bottom: 7px;

    font-size: 13px;

    font-weight: 600;

    color: #5f6b7a;

}


.search-input-wrapper {

    position: relative;

}


.search-input-wrapper i {

    position: absolute;

    left: 13px;

    top: 50%;

    transform: translateY(-50%);

    color: #8a94a6;

}


.search-input-wrapper input {

    padding-left: 38px;

}


.form-control,
.form-select {

    border-radius: 10px;

    border: 1px solid #dfe5ec;

    min-height: 44px;

}


.form-control:focus,
.form-select:focus {

    border-color: #2575d7;

    box-shadow:

        0 0 0 0.2rem
        rgba(37, 117, 215, 0.12);

}


.btn-filter {

    background: #1769e0;

    color: white;

    border: none;

}


.btn-filter:hover {

    background: #1558a6;

    color: white;

}


.btn-clear {

    background: #eef2f6;

    color: #495057;

    border: none;

}



/* ========================================================= */
/* BORROWER SECTION */
/* ========================================================= */

.borrower-section-title {

    display: flex;

    align-items: center;

    gap: 14px;

    margin-bottom: 20px;

}


.borrower-section-title h3 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.borrower-section-title p {

    margin: 3px 0 0;

    color: #8a94a6;

}


.borrower-section-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    font-size: 22px;

}


.learner-icon {

    background: #e7f0ff;

    color: #1769e0;

}


.teacher-icon {

    background: #f0e8ff;

    color: #7c3aed;

}


.staff-icon {

    background: #fff1df;

    color: #d97706;

}



/* ========================================================= */
/* BORROWING CARD */
/* ========================================================= */

.borrowing-card {

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:

        0 6px 25px
        rgba(0, 0, 0, 0.06);

}


.borrowing-card-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 16px 22px;

    background: #f7f9fc;

    border-bottom: 1px solid #edf0f5;

    font-weight: 700;

    color: #253858;

}


.borrowing-card-header span {

    padding: 5px 10px;

    border-radius: 20px;

    background: #e7f0ff;

    color: #1769e0;

    font-size: 12px;

}


.borrowing-card-body {

    padding: 22px;

}


.stream-title {

    font-weight: 700;

    color: #495057;

    margin:

        18px 0
        12px;

}


.stream-title i {

    color: #2575d7;

}



/* ========================================================= */
/* TABLE */
/* ========================================================= */

.modern-borrowing-table {

    margin-bottom: 0;

}


.modern-borrowing-table thead {

    background: #f5f7fb;

}


.modern-borrowing-table th {

    padding: 14px;

    border: none;

    color: #6c757d;

    font-size: 12px;

    text-transform: uppercase;

    letter-spacing: 0.3px;

}


.modern-borrowing-table td {

    padding: 15px 14px;

    border-color: #edf0f5;

}


.modern-borrowing-table tbody tr {

    transition:

        background 0.2s ease;

}


.modern-borrowing-table tbody tr:hover {

    background: #f8fbff;

}


.book-title {

    font-weight: 500;

    color: #253858;

}


.overdue-row {

    background: #fff8f8;

}


.overdue-row:hover {

    background: #fff1f1 !important;

}



/* ========================================================= */
/* BADGES */
/* ========================================================= */

.copy-badge {

    display: inline-block;

    padding: 5px 10px;

    border-radius: 8px;

    background: #253858;

    color: white;

    font-size: 12px;

    font-weight: 600;

}


.status-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 11px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

}


.status-borrowed {

    background: #fff3cd;

    color: #a66a00;

}


.status-returned {

    background: #dff7e9;

    color: #16834d;

}


.status-overdue {

    background: #ffe4e4;

    color: #c92a2a;

}


.overdue-days {

    font-size: 12px;

    font-weight: 700;

    color: #c92a2a;

}



/* ========================================================= */
/* RETURN CONDITION DISPLAY */
/* ========================================================= */

.condition-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 11px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

}


.condition-good {

    background: #dff7e9;

    color: #16834d;

}


.condition-damaged {

    background: #ffe4e4;

    color: #c92a2a;

}


.damage-description-cell {

    min-width: 180px;

    max-width: 280px;

    color: #495057;

    line-height: 1.5;

    white-space: normal;

}



/* ========================================================= */
/* ACTION BUTTONS */
/* ========================================================= */

.action-button {

    width: 34px;

    height: 34px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 9px;

    border: none;

    text-decoration: none;

    margin-left: 4px;

}


.view-button {

    background: #e7f0ff;

    color: #1769e0;

}


.return-button {

    background: #e4f8ee;

    color: #16834d;

}


.action-button:hover {

    transform: translateY(-2px);

}



/* ========================================================= */
/* EMPTY STATE */
/* ========================================================= */

.empty-borrowings {

    background: white;

    border-radius: 18px;

    padding: 60px 25px;

    text-align: center;

    box-shadow:

        0 6px 25px
        rgba(0, 0, 0, 0.06);

}


.empty-icon {

    width: 70px;

    height: 70px;

    margin: auto;

    margin-bottom: 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 20px;

    background: #e7f0ff;

    color: #1769e0;

    font-size: 30px;

}


.empty-borrowings h4 {

    font-weight: 700;

    color: #253858;

}


.empty-borrowings p {

    color: #8a94a6;

}



/* ========================================================= */
/* MODAL */
/* ========================================================= */

.modern-modal {

    border: none;

    border-radius: 18px;

    overflow: hidden;

}


.return-summary {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border-radius: 14px;

    background: #f7f9fc;

}


.return-summary-icon {

    width: 48px;

    height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #e7f0ff;

    color: #1769e0;

    font-size: 22px;

}



/* ========================================================= */
/* RETURN CONDITION MODAL */
/* ========================================================= */

.return-condition-section {

    padding-top: 5px;

}


.return-condition-heading {

    display: flex;

    align-items: center;

    gap: 9px;

    color: #253858;

    font-size: 16px;

}


.return-condition-heading i {

    color: #1769e0;

    font-size: 19px;

}


.return-condition-option {

    width: 100%;

    min-height: 112px;

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 18px;

    text-align: left;

    border-radius: 16px;

    border: 2px solid #dfe5ec;

    background: #ffffff;

    transition:

        all 0.2s ease;

}


.return-condition-option:hover {

    transform: translateY(-2px);

}


.return-condition-option strong {

    display: block;

    color: #253858;

    margin-bottom: 4px;

}


.return-condition-option small {

    display: block;

    color: #7a8798;

    line-height: 1.45;

}


.condition-option-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 14px;

    font-size: 21px;

}


.condition-option-good .condition-option-icon {

    background: #e4f8ee;

    color: #16834d;

}


.condition-option-damaged .condition-option-icon {

    background: #ffe4e4;

    color: #c92a2a;

}


.condition-option-good.active {

    border-color: #16834d;

    background: #f4fcf7;

}


.condition-option-damaged.active {

    border-color: #c92a2a;

    background: #fff8f8;

}


.damage-description-label {

    display: block;

    margin-bottom: 8px;

    color: #253858;

    font-weight: 700;

}


.damage-description-label i {

    color: #1769e0;

    margin-right: 6px;

}


.damage-description-input {

    min-height: 120px;

    resize: vertical;

}


.damage-description-help {

    display: block;

    margin-top: 6px;

    color: #7a8798;

}



/* ========================================================= */
/* BORROWER SUMMARY + EXPANDABLE BOOK LIST */
/* ========================================================= */

.borrower-summary-row {

    background: #ffffff;

}


.borrower-summary-row > td {

    vertical-align: middle;

}


.borrower-name-cell {

    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 190px;

}


.borrower-name-cell strong {

    display: block;

    color: #253858;

    font-weight: 700;

}


.borrower-name-cell small {

    display: block;

    margin-top: 3px;

    color: #8a94a6;

    font-size: 12px;

}


.borrower-avatar {

    width: 42px;

    height: 42px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;

    font-size: 18px;

}


.learner-avatar {

    background: #e7f0ff;

    color: #1769e0;

}


.teacher-avatar {

    background: #f0e8ff;

    color: #7c3aed;

}


.staff-avatar {

    background: #fff1df;

    color: #d97706;

}


.admission-badge {

    display: inline-flex;

    align-items: center;

    padding: 6px 10px;

    border-radius: 8px;

    background: #f3f6fa;

    color: #4b5b70;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

}


.count-pill {

    display: inline-flex;

    align-items: center;

    padding: 6px 10px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

}


.count-active {

    background: #e7f0ff;

    color: #1769e0;

}


.count-overdue {

    background: #ffe4e4;

    color: #c92a2a;

}


.borrower-detail-row > td {

    border-top: none !important;

}


.borrower-books-panel {

    margin: 0 12px 16px;

    border: 1px solid #e6ebf2;

    border-radius: 14px;

    overflow: hidden;

    background: #fbfcfe;

}


.borrower-books-panel-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 16px;

    padding: 14px 18px;

    background: #f1f5fa;

    color: #253858;

}


.borrower-books-panel-header i {

    margin-right: 7px;

    color: #1769e0;

}


.borrower-books-panel-header span {

    padding: 5px 10px;

    border-radius: 20px;

    background: #ffffff;

    color: #1769e0;

    font-size: 12px;

    font-weight: 700;

}


.borrower-books-table {

    background: #ffffff;

}


.borrower-books-table thead {

    background: #f8fafc;

}


.borrower-books-table th {

    padding: 12px 14px;

    border: none;

    color: #6c757d;

    font-size: 11px;

    text-transform: uppercase;

    letter-spacing: 0.3px;

}


.borrower-books-table td {

    padding: 13px 14px;

    border-color: #edf0f5;

}


.borrower-view-button {

    transition: transform 0.2s ease, background 0.2s ease;

}


.borrower-view-button[aria-expanded="true"] {

    background: #1769e0;

    color: #ffffff;

}



/* ========================================================= */
/* RESPONSIVE */
/* ========================================================= */

@media (max-width: 768px) {


    .page-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;

    }


    .overdue-alert {

        flex-direction: column;

        align-items: flex-start;

        gap: 18px;

    }


    .borrowing-card-body {

        padding: 12px;

    }


    .return-condition-option {

        min-height: auto;

    }


}


</style>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const returnModalElement =
            document.getElementById(
                'returnBookModal'
            );


        const borrowerNameElement =
            document.getElementById(
                'returnBorrowerName'
            );


        const returnBookTitleElement =
            document.getElementById(
                'returnBookTitle'
            );


        const returnBookCopyElement =
            document.getElementById(
                'returnBookCopy'
            );


        const confirmReturnButton =
            document.getElementById(
                'confirmReturnButton'
            );


        const goodConditionOption =
            document.getElementById(
                'goodConditionOption'
            );


        const damagedConditionOption =
            document.getElementById(
                'damagedConditionOption'
            );


        const returnConditionInput =
            document.getElementById(
                'returnCondition'
            );


        const damageDescriptionWrapper =
            document.getElementById(
                'damageDescriptionWrapper'
            );


        const damageDescription =
            document.getElementById(
                'damageDescription'
            );


        const returnModal =
            new bootstrap.Modal(
                returnModalElement
            );


        let selectedReturnForm =
            null;


        const returnButtons =
            document.querySelectorAll(
                '.return-book-button'
            );


        returnButtons.forEach(
            function (button) {


                button.addEventListener(
                    'click',
                    function () {


                        borrowerNameElement.textContent =
                            button.dataset.name;


                        returnBookTitleElement.textContent =
                            button.dataset.book;


                        returnBookCopyElement.textContent =
                            button.dataset.copy;


                        selectedReturnForm =
                            button.closest(
                                '.return-book-form'
                            );


                        goodConditionOption.classList.add(
                            'active'
                        );


                        damagedConditionOption.classList.remove(
                            'active'
                        );


                        returnConditionInput.value =
                            'good';


                        damageDescriptionWrapper.style.display =
                            'none';


                        damageDescription.value =
                            '';


                        returnModal.show();


                    }
                );


            }
        );



        goodConditionOption.addEventListener(
            'click',
            function () {


                returnConditionInput.value =
                    'good';


                goodConditionOption.classList.add(
                    'active'
                );


                damagedConditionOption.classList.remove(
                    'active'
                );


                damageDescriptionWrapper.style.display =
                    'none';


                damageDescription.value =
                    '';


            }
        );



        damagedConditionOption.addEventListener(
            'click',
            function () {


                returnConditionInput.value =
                    'damaged';


                damagedConditionOption.classList.add(
                    'active'
                );


                goodConditionOption.classList.remove(
                    'active'
                );


                damageDescriptionWrapper.style.display =
                    'block';


            }
        );



        confirmReturnButton.addEventListener(
            'click',
            function () {


                if (
                    returnConditionInput.value === 'damaged'
                    &&
                    damageDescription.value.trim() === ''
                ) {


                    damageDescription.focus();


                    alert(
                        'Please describe the damage before confirming the return.'
                    );


                    return;


                }


                if (selectedReturnForm) {


                    let conditionInput =
                        selectedReturnForm.querySelector(
                            'input[name="return_condition"]'
                        );


                    if (!conditionInput) {


                        conditionInput =
                            document.createElement(
                                'input'
                            );


                        conditionInput.type =
                            'hidden';


                        conditionInput.name =
                            'return_condition';


                        selectedReturnForm.appendChild(
                            conditionInput
                        );


                    }


                    conditionInput.value =
                        returnConditionInput.value;



                    let descriptionInput =
                        selectedReturnForm.querySelector(
                            'input[name="damage_description"]'
                        );


                    if (!descriptionInput) {


                        descriptionInput =
                            document.createElement(
                                'input'
                            );


                        descriptionInput.type =
                            'hidden';


                        descriptionInput.name =
                            'damage_description';


                        selectedReturnForm.appendChild(
                            descriptionInput
                        );


                    }


                    descriptionInput.value =
                        damageDescription.value.trim();


                    confirmReturnButton.disabled =
                        true;


                    confirmReturnButton.innerHTML =
                        'Returning...';


                    selectedReturnForm.submit();


                }


            }
        );



        returnModalElement.addEventListener(
            'hidden.bs.modal',
            function () {


                selectedReturnForm =
                    null;


                borrowerNameElement.textContent =
                    '';


                returnBookTitleElement.textContent =
                    '';


                returnBookCopyElement.textContent =
                    '';


                returnConditionInput.value =
                    'good';


                damageDescription.value =
                    '';


                damageDescriptionWrapper.style.display =
                    'none';


                goodConditionOption.classList.add(
                    'active'
                );


                damagedConditionOption.classList.remove(
                    'active'
                );


                confirmReturnButton.disabled =
                    false;


                confirmReturnButton.innerHTML =
                    '<i class="bi bi-check-circle"></i> Confirm Return';


            }
        );


    }
);

</script>

@endsection