@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Library Reports</h1>

        <p class="text-muted mb-0">
            View library borrowing and inventory statistics.
        </p>

    </div>

</div>


<!-- REPORT STATISTICS -->

<div class="row g-4 mb-4">


    <!-- TOTAL PHYSICAL COPIES -->

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Total Physical Copies
                </small>

                <h2 class="mb-0">
                    {{ $totalCopies }}
                </h2>

            </div>

        </div>

    </div>


    <!-- AVAILABLE COPIES -->

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Available Copies
                </small>

                <h2 class="mb-0 text-success">
                    {{ $availableCopies }}
                </h2>

            </div>

        </div>

    </div>


    <!-- CURRENTLY BORROWED -->

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Currently Borrowed
                </small>

                <h2 class="mb-0 text-warning">
                    {{ $borrowedCopies }}
                </h2>

            </div>

        </div>

    </div>


    <!-- OVERDUE BOOKS -->

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">
                    Overdue Books
                </small>

                <h2 class="mb-0 text-danger">
                    {{ $overdueCount }}
                </h2>

            </div>

        </div>

    </div>


</div>


<!-- REPORT CARDS -->

<div class="row g-4">


    <!-- BORROWING REPORT -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.borrowings') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-journal-text"></i>

                        Borrowing Report

                    </h5>

                    <p class="text-muted mb-0">

                        View all borrowing records and filter by date,
                        status and borrower type.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- OVERDUE BOOKS -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.overdue') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5 class="text-danger">

                        <i class="bi bi-exclamation-triangle"></i>

                        Overdue Books

                    </h5>

                    <p class="text-muted mb-0">

                        Track books that have passed their return date.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- RETURNED BOOKS -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.returned') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-check-circle"></i>

                        Returned Books

                    </h5>

                    <p class="text-muted mb-0">

                        View all returned books and return dates.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- INVENTORY REPORT -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.inventory') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-bookshelf"></i>

                        Inventory Report

                    </h5>

                    <p class="text-muted mb-0">

                        View all books and individual physical copies.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- MOST BORROWED BOOKS -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.popular-books') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-bar-chart"></i>

                        Most Borrowed Books

                    </h5>

                    <p class="text-muted mb-0">

                        Identify the most frequently borrowed books.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- BORROWER ACTIVITY -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.borrower-activity') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-person-lines-fill"></i>

                        Borrower Activity

                    </h5>

                    <p class="text-muted mb-0">

                        View borrowing history for learners,
                        teachers and staff.

                    </p>

                </div>

            </div>

        </a>

    </div>


    <!-- CLASS BORROWING REPORT -->

    <div class="col-lg-4">

        <a
            href="{{ route('reports.class-borrowing') }}"
            class="text-decoration-none"
        >

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h5>

                        <i class="bi bi-mortarboard-fill"></i>

                        Class Borrowing Report

                    </h5>

                    <p class="text-muted mb-0">

                        Generate a borrowing report for a specific class,
                        such as Grade 10 West, including books currently
                        borrowed and optionally returned books.

                    </p>

                </div>

            </div>

        </a>

    </div>


</div>

@endsection