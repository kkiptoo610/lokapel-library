@extends('layouts.app')

@section('content')

<div class="dashboard-page">
{{-- ========================================================= --}}
{{-- WELCOME HEADER --}}
{{-- ========================================================= --}}

<div class="dashboard-header mb-4">

    <div>

        <div class="dashboard-title-wrapper">

            <div class="dashboard-icon">

                <i class="bi bi-book-half"></i>

            </div>


            <div>

                <h1>

                    Library Dashboard

                </h1>


                <p>

                    Welcome to the Lokapel School Library
                    Management System.

                </p>

            </div>

        </div>

    </div>


    <div class="dashboard-date">

        <i class="bi bi-calendar-event"></i>

        {{ now()->format('l, d F Y') }}

    </div>

</div>



{{-- ========================================================= --}}
{{-- MAIN STATISTICS --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- TOTAL BOOKS --}}

    <div class="col-xl col-md-6">

        <div class="stat-card stat-blue">

            <div class="stat-content">

                <span class="stat-label">

                    Total Books

                </span>


                <h2>

                    {{ number_format($totalBooks) }}

                </h2>


                <p>

                    Total library collection

                </p>

            </div>


            <div class="stat-icon">

                <i class="bi bi-book"></i>

            </div>

        </div>

    </div>



    {{-- AVAILABLE BOOKS --}}

    <div class="col-xl col-md-6">

        <div class="stat-card stat-green">

            <div class="stat-content">

                <span class="stat-label">

                    Available Books

                </span>


                <h2>

                    {{ number_format($availableBooks) }}

                </h2>


                <p>

                    Ready for borrowing

                </p>

            </div>


            <div class="stat-icon">

                <i class="bi bi-check-circle"></i>

            </div>

        </div>

    </div>



    {{-- BORROWED BOOKS --}}

    <div class="col-xl col-md-6">

        <div class="stat-card stat-orange">

            <div class="stat-content">

                <span class="stat-label">

                    Borrowed Books

                </span>


                <h2>

                    {{ number_format($borrowedBooks) }}

                </h2>


                <p>

                    Currently issued

                </p>

            </div>


            <div class="stat-icon">

                <i class="bi bi-arrow-left-right"></i>

            </div>

        </div>

    </div>



    {{-- DAMAGED BOOKS --}}

    <div class="col-xl col-md-6">

        <a
            href="{{ route('reports.damaged') }}"
            class="stat-card-link"
        >

            <div class="stat-card stat-damaged">

                <div class="stat-content">

                    <span class="stat-label">

                        Damaged Books

                    </span>


                    <h2>

                        {{ number_format($damagedBooks) }}

                    </h2>


                    <p>

                        Require repair or replacement

                    </p>

                </div>


                <div class="stat-icon">

                    <i class="bi bi-bookmark-x"></i>

                </div>

            </div>

        </a>

    </div>



    {{-- OVERDUE BOOKS --}}

    <div class="col-xl col-md-6">

        <a
            href="{{ route('reports.overdue') }}"
            class="stat-card-link"
        >

            <div class="stat-card stat-red">

                <div class="stat-content">

                    <span class="stat-label">

                        Overdue Books

                    </span>


                    <h2>

                        {{ number_format($overdueBooks) }}

                    </h2>


                    <p>

                        Require attention

                    </p>

                </div>


                <div class="stat-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>

            </div>

        </a>

    </div>


</div>



{{-- ========================================================= --}}
{{-- PEOPLE STATISTICS --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- LEARNERS --}}

    <div class="col-lg-4">

        <div class="people-card">

            <div class="people-icon people-blue">

                <i class="bi bi-mortarboard"></i>

            </div>


            <div>

                <span>

                    Learners

                </span>


                <h3>

                    {{ number_format($learnersCount) }}

                </h3>

            </div>

        </div>

    </div>



    {{-- TEACHERS --}}

    <div class="col-lg-4">

        <div class="people-card">

            <div class="people-icon people-purple">

                <i class="bi bi-person-workspace"></i>

            </div>


            <div>

                <span>

                    Teachers

                </span>


                <h3>

                    {{ number_format($teachersCount) }}

                </h3>

            </div>

        </div>

    </div>



    {{-- STAFF --}}

    <div class="col-lg-4">

        <div class="people-card">

            <div class="people-icon people-orange">

                <i class="bi bi-people"></i>

            </div>


            <div>

                <span>

                    Staff Members

                </span>


                <h3>

                    {{ number_format($staffCount) }}

                </h3>

            </div>

        </div>

    </div>


</div>



{{-- ========================================================= --}}
{{-- INVENTORY MANAGEMENT --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- INVENTORY OVERVIEW --}}

    <div class="col-lg-8">


        <div class="inventory-dashboard-card h-100">


            <div class="inventory-dashboard-header">


                <div>


                    <h4>

                        <i class="bi bi-box-seam"></i>

                        Inventory Management

                    </h4>


                    <p>

                        Manage teacher supplies and laboratory equipment.

                    </p>


                </div>


                <a
                    href="{{ route('inventory.index') }}"
                    class="btn btn-sm btn-outline-primary"
                >

                    Open Inventory

                </a>


            </div>



            <div class="inventory-stats-grid">


                {{-- TOTAL INVENTORY ITEMS --}}

                <div class="inventory-stat-item">


                    <div class="inventory-stat-icon inventory-blue">

                        <i class="bi bi-boxes"></i>

                    </div>


                    <div>


                        <span>

                            Total Items

                        </span>


                        <h3>

                            {{ number_format($totalInventoryItems) }}

                        </h3>


                    </div>


                </div>



                {{-- TEACHER SUPPLIES --}}

                <a
                    href="{{ route('inventory.teachers') }}"
                    class="inventory-stat-item inventory-stat-link"
                >


                    <div class="inventory-stat-icon inventory-purple">

                        <i class="bi bi-person-workspace"></i>

                    </div>


                    <div>


                        <span>

                            Teacher Supplies

                        </span>


                        <h3>

                            {{ number_format($teachersInventoryItems) }}

                        </h3>


                    </div>


                </a>



                {{-- LABORATORY INVENTORY --}}

                <a
                    href="{{ route('inventory.laboratory') }}"
                    class="inventory-stat-item inventory-stat-link"
                >


                    <div class="inventory-stat-icon inventory-green">

                        <i class="bi bi-flask"></i>

                    </div>


                    <div>


                        <span>

                            Laboratory

                        </span>


                        <h3>

                            {{ number_format($laboratoryInventoryItems) }}

                        </h3>


                    </div>


                </a>



                {{-- LOW STOCK --}}

                <a
                    href="{{ route('inventory.low-stock') }}"
                    class="inventory-stat-item inventory-stat-link"
                >


                    <div class="inventory-stat-icon inventory-red">

                        <i class="bi bi-exclamation-triangle"></i>

                    </div>


                    <div>


                        <span>

                            Low Stock

                        </span>


                        <h3>

                            {{ number_format($lowStockInventoryItems) }}

                        </h3>


                    </div>


                </a>


            </div>


        </div>


    </div>



    {{-- INVENTORY QUICK ACTIONS --}}

    <div class="col-lg-4">


        <div class="inventory-actions-card h-100">


            <h4>

                <i class="bi bi-lightning-fill"></i>

                Inventory Actions

            </h4>


            <p>

                Quickly manage school supplies.

            </p>



            <a
                href="{{ route('inventory.items.create') }}"
                class="inventory-action inventory-action-blue"
            >

                <i class="bi bi-plus-circle"></i>


                <span>

                    Add Inventory Item

                </span>

            </a>



            <a
                href="{{ route('inventory.teachers') }}"
                class="inventory-action inventory-action-purple"
            >

                <i class="bi bi-person-workspace"></i>


                <span>

                    Teacher Supplies

                </span>

            </a>



            <a
                href="{{ route('inventory.laboratory') }}"
                class="inventory-action inventory-action-green"
            >

                <i class="bi bi-flask"></i>


                <span>

                    Laboratory Inventory

                </span>

            </a>



            <a
                href="{{ route('inventory.low-stock') }}"
                class="inventory-action inventory-action-red"
            >

                <i class="bi bi-exclamation-triangle"></i>


                <span>

                    Low Stock Alerts

                    @if($lowStockInventoryItems > 0)

                        <small>

                            {{ number_format($lowStockInventoryItems) }}

                        </small>

                    @endif

                </span>

            </a>


        </div>


    </div>


</div>



{{-- ========================================================= --}}
{{-- DAILY ACTIVITY --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- LIBRARY ACTIVITY --}}

    <div class="col-lg-8">


        <div class="modern-card h-100">


            <div class="section-header">


                <div>


                    <h4>

                        <i class="bi bi-lightning-charge"></i>

                        Library Activity

                    </h4>


                    <p>

                        Current borrowing activity.

                    </p>


                </div>


            </div>



            <div class="activity-grid">


                {{-- BORROWED TODAY --}}

                <div class="activity-box">


                    <div class="activity-icon activity-blue">

                        <i class="bi bi-box-arrow-up-right"></i>

                    </div>


                    <div>


                        <span>

                            Borrowed Today

                        </span>


                        <h3>

                            {{ number_format($borrowedToday) }}

                        </h3>


                    </div>


                </div>



                {{-- RETURNED TODAY --}}

                <div class="activity-box">


                    <div class="activity-icon activity-green">

                        <i class="bi bi-box-arrow-in-down-left"></i>

                    </div>


                    <div>


                        <span>

                            Returned Today

                        </span>


                        <h3>

                            {{ number_format($returnedToday) }}

                        </h3>


                    </div>


                </div>



                {{-- THIS WEEK --}}

                <div class="activity-box">


                    <div class="activity-icon activity-purple">

                        <i class="bi bi-calendar-week"></i>

                    </div>


                    <div>


                        <span>

                            Borrowed This Week

                        </span>


                        <h3>

                            {{ number_format($borrowedThisWeek) }}

                        </h3>


                    </div>


                </div>



                {{-- THIS MONTH --}}

                <div class="activity-box">


                    <div class="activity-icon activity-orange">

                        <i class="bi bi-calendar-month"></i>

                    </div>


                    <div>


                        <span>

                            Borrowed This Month

                        </span>


                        <h3>

                            {{ number_format($borrowedThisMonth) }}

                        </h3>


                    </div>


                </div>


            </div>


        </div>


    </div>



    {{-- QUICK ACTIONS --}}

    <div class="col-lg-4">


        <div class="quick-actions-card h-100">


            <h4>

                <i class="bi bi-lightning-fill"></i>

                Quick Actions

            </h4>


            <p>

                Frequently used library actions.

            </p>



            <a
                href="{{ route('books.create') }}"
                class="quick-action quick-action-blue"
            >

                <i class="bi bi-plus-circle"></i>


                <span>

                    Add New Book

                </span>

            </a>



            <a
                href="{{ route('learners.create') }}"
                class="quick-action quick-action-green"
            >

                <i class="bi bi-person-plus"></i>


                <span>

                    Add Learner

                </span>

            </a>



            <a
                href="{{ route('borrowings.create') }}"
                class="quick-action quick-action-orange"
            >

                <i class="bi bi-arrow-left-right"></i>


                <span>

                    Issue Book

                </span>

            </a>



            <a
                href="{{ route('reports.index') }}"
                class="quick-action quick-action-purple"
            >

                <i class="bi bi-bar-chart-line"></i>


                <span>

                    View Reports

                </span>

            </a>


        </div>


    </div>


</div>



{{-- ========================================================= --}}
{{-- RECENT ACTIVITY AND OVERDUE --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- RECENT BORROWINGS --}}

    <div class="col-lg-8">


        <div class="modern-card">


            <div class="section-header">


                <div>


                    <h4>

                        <i class="bi bi-clock-history"></i>

                        Recent Borrowing Activity

                    </h4>


                    <p>

                        Latest activity in the library.

                    </p>


                </div>


                <a
                    href="{{ route('borrowings.index') }}"
                    class="btn btn-sm btn-outline-primary"
                >

                    View All

                </a>


            </div>



            <div class="table-responsive">


                <table class="table modern-table align-middle">


                    <thead>


                        <tr>


                            <th>

                                Book

                            </th>


                            <th>

                                Borrower

                            </th>


                            <th>

                                Date

                            </th>


                            <th>

                                Status

                            </th>


                        </tr>


                    </thead>


                    <tbody>


                        @forelse($recentBorrowings as $borrowing)


                            <tr>


                                <td>


                                    <strong>

                                        {{ $borrowing->book?->title ?? '-' }}

                                    </strong>


                                    @if($borrowing->bookCopy?->copy_number)


                                        <br>


                                        <small>

                                            {{ $borrowing->bookCopy->copy_number }}

                                        </small>


                                    @endif


                                </td>



                                <td>

                                    {{ $borrowing->borrower?->name ?? '-' }}

                                </td>



                                <td>

                                    {{ $borrowing->borrowed_date }}

                                </td>



                                <td>


                                    @if($borrowing->status === 'returned')


                                        <span class="status-badge status-returned">

                                            Returned

                                        </span>


                                    @elseif($borrowing->status === 'overdue')


                                        <span class="status-badge status-overdue">

                                            Overdue

                                        </span>


                                    @else


                                        <span class="status-badge status-borrowed">

                                            Borrowed

                                        </span>


                                    @endif


                                </td>


                            </tr>


                        @empty


                            <tr>


                                <td
                                    colspan="4"
                                    class="text-center text-muted py-4"
                                >

                                    No recent borrowing activity.

                                </td>


                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>


        </div>


    </div>



    {{-- OVERDUE ALERTS --}}

    <div class="col-lg-4">


        <div class="overdue-card">


            <div class="overdue-header">


                <div>


                    <h4>

                        <i class="bi bi-exclamation-circle"></i>

                        Overdue Alert

                    </h4>


                    <p>

                        Books requiring attention.

                    </p>


                </div>


                <span>

                    {{ number_format($overdueBooks) }}

                </span>


            </div>



            <div class="overdue-list">


                @forelse($overdueBorrowings as $borrowing)


                    <div class="overdue-item">


                        <div class="overdue-book-icon">

                            <i class="bi bi-book"></i>

                        </div>


                        <div class="overdue-info">


                            <strong>

                                {{ $borrowing->book?->title ?? '-' }}

                            </strong>


                            <span>

                                {{ $borrowing->borrower?->name ?? '-' }}

                            </span>


                            <small>

                                Due:
                                {{ $borrowing->due_date }}

                            </small>


                        </div>


                    </div>


                @empty


                    <div class="empty-overdue">


                        <i class="bi bi-check-circle"></i>


                        <p>

                            Excellent! No overdue books.

                        </p>


                    </div>


                @endforelse


            </div>



            <a
                href="{{ route('reports.overdue') }}"
                class="btn btn-danger w-100 mt-3"
            >

                View Overdue Report

            </a>


        </div>


    </div>


</div>



{{-- ========================================================= --}}
{{-- POPULAR BOOKS --}}
{{-- ========================================================= --}}

<div class="modern-card mb-4">


    <div class="section-header">


        <div>


            <h4>

                <i class="bi bi-star-fill"></i>

                Most Borrowed Books

            </h4>


            <p>

                The most popular books in your library.

            </p>


        </div>


        <a
            href="{{ route('reports.popular-books') }}"
            class="btn btn-sm btn-outline-primary"
        >

            Full Report

        </a>


    </div>



    <div class="row g-3">


        @forelse($popularBooks as $index => $item)


            <div class="col-lg col-md-6">


                <div class="popular-book">


                    <div class="book-rank">

                        {{ $index + 1 }}

                    </div>


                    <div>


                        <strong>

                            {{ $item->book?->title ?? '-' }}

                        </strong>


                        <small>

                            {{ number_format($item->borrowing_count) }}
                            borrowings

                        </small>


                    </div>


                </div>


            </div>


        @empty


            <div class="col-12 text-center text-muted py-4">

                No borrowing data available.

            </div>


        @endforelse


    </div>


</div>
```

</div>

{{-- ========================================================= --}}
{{-- DASHBOARD STYLING --}}
{{-- ========================================================= --}}

<style>


/* ========================================================= */
/* PAGE */
/* ========================================================= */

.dashboard-page {

    padding-bottom: 30px;

}



/* ========================================================= */
/* HEADER */
/* ========================================================= */

.dashboard-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 28px 30px;

    border-radius: 18px;

    background:

        linear-gradient(
            135deg,
            #0f3d6e,
            #1558a6,
            #2575d7
        );

    color: white;

    box-shadow:

        0 12px 30px
        rgba(
            37,
            117,
            215,
            0.18
        );

}


.dashboard-title-wrapper {

    display: flex;

    align-items: center;

    gap: 18px;

}


.dashboard-icon {

    width: 64px;

    height: 64px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    border-radius: 18px;

    background:

        rgba(
            255,
            255,
            255,
            0.18
        );

}


.dashboard-header h1 {

    margin: 0;

    font-size: 28px;

    font-weight: 700;

}


.dashboard-header p {

    margin: 5px 0 0;

    opacity: 0.85;

}


.dashboard-date {

    background:

        rgba(
            255,
            255,
            255,
            0.15
        );

    padding: 10px 16px;

    border-radius: 10px;

    font-size: 14px;

}



/* ========================================================= */
/* STAT CARD LINKS */
/* ========================================================= */

.stat-card-link {

    display: block;

    text-decoration: none;

    color: inherit;

}


.stat-card-link:hover {

    color: inherit;

}



/* ========================================================= */
/* STAT CARDS */
/* ========================================================= */

.stat-card {

    position: relative;

    min-height: 160px;

    border-radius: 18px;

    padding: 25px;

    overflow: hidden;

    color: white;

    display: flex;

    justify-content: space-between;

    align-items: center;

    transition:

        transform 0.25s ease,
        box-shadow 0.25s ease;

}


.stat-card:hover {

    transform:

        translateY(-6px);

    box-shadow:

        0 18px 35px
        rgba(
            0,
            0,
            0,
            0.18
        );

}


.stat-blue {

    background:

        linear-gradient(
            135deg,
            #1769e0,
            #3f8cff
        );

}


.stat-green {

    background:

        linear-gradient(
            135deg,
            #11998e,
            #38ef7d
        );

}


.stat-orange {

    background:

        linear-gradient(
            135deg,
            #f7971e,
            #ffd200
        );

}


.stat-damaged {

    background:

        linear-gradient(
            135deg,
            #a71919,
            #dc2626
        );

}


.stat-red {

    background:

        linear-gradient(
            135deg,
            #e53935,
            #ff6b6b
        );

}


.stat-label {

    font-size: 15px;

    opacity: 0.9;

}


.stat-card h2 {

    font-size: 36px;

    margin:

        8px 0;

    font-weight: 700;

}


.stat-card p {

    margin: 0;

    font-size: 13px;

    opacity: 0.85;

}


.stat-icon {

    font-size: 58px;

    opacity: 0.28;

}



/* ========================================================= */
/* PEOPLE CARDS */
/* ========================================================= */

.people-card {

    background: white;

    border-radius: 16px;

    padding: 22px;

    display: flex;

    align-items: center;

    gap: 18px;

    box-shadow:

        0 5px 20px
        rgba(
            0,
            0,
            0,
            0.06
        );

    transition:

        transform 0.2s ease;

}


.people-card:hover {

    transform:

        translateY(-4px);

}


.people-card span {

    color: #6c757d;

}


.people-card h3 {

    margin: 4px 0 0;

    font-size: 28px;

}


.people-icon {

    width: 55px;

    height: 55px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 15px;

    font-size: 24px;

}


.people-blue {

    background: #e7f0ff;

    color: #1769e0;

}


.people-purple {

    background: #f0e8ff;

    color: #7c3aed;

}


.people-orange {

    background: #fff1df;

    color: #f7971e;

}



/* ========================================================= */
/* INVENTORY DASHBOARD */
/* ========================================================= */

.inventory-dashboard-card {

    background:

        linear-gradient(
            135deg,
            #ffffff,
            #f6f9ff
        );

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.inventory-dashboard-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 22px;

}


.inventory-dashboard-header h4 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.inventory-dashboard-header p {

    margin: 5px 0 0;

    color: #8a94a6;

}


.inventory-stats-grid {

    display: grid;

    grid-template-columns:

        repeat(
            2,
            1fr
        );

    gap: 15px;

}


.inventory-stat-item {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border-radius: 15px;

    background: white;

    box-shadow:

        0 4px 15px
        rgba(
            0,
            0,
            0,
            0.05
        );

}


.inventory-stat-link {

    text-decoration: none;

    color: inherit;

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.inventory-stat-link:hover {

    color: inherit;

    transform:

        translateY(-4px);

    box-shadow:

        0 10px 25px
        rgba(
            0,
            0,
            0,
            0.10
        );

}


.inventory-stat-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    font-size: 23px;

}


.inventory-blue {

    background: #e7f0ff;

    color: #1769e0;

}


.inventory-purple {

    background: #f0e8ff;

    color: #7c3aed;

}


.inventory-green {

    background: #e4f8ee;

    color: #11998e;

}


.inventory-red {

    background: #ffe4e4;

    color: #d63031;

}


.inventory-stat-item span {

    color: #7c8798;

    font-size: 13px;

}


.inventory-stat-item h3 {

    margin: 4px 0 0;

    font-size: 26px;

    font-weight: 700;

}



/* ========================================================= */
/* INVENTORY ACTIONS */
/* ========================================================= */

.inventory-actions-card {

    background:

        linear-gradient(
            135deg,
            #ffffff,
            #f7faff
        );

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.inventory-actions-card h4 {

    margin: 0;

    font-weight: 700;

}


.inventory-actions-card p {

    margin:

        5px 0 18px;

    color: #8a94a6;

}


.inventory-action {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 13px 15px;

    border-radius: 12px;

    margin-bottom: 10px;

    text-decoration: none;

    font-weight: 600;

    transition:

        transform 0.2s ease;

}


.inventory-action:hover {

    transform:

        translateX(5px);

}


.inventory-action-blue {

    background: #e7f0ff;

    color: #1769e0;

}


.inventory-action-purple {

    background: #f0e8ff;

    color: #7c3aed;

}


.inventory-action-green {

    background: #e4f8ee;

    color: #11998e;

}


.inventory-action-red {

    background: #ffe4e4;

    color: #d63031;

}


.inventory-action small {

    margin-left: auto;

    padding:

        3px 8px;

    border-radius: 20px;

    background:

        rgba(
            214,
            48,
            49,
            0.15
        );

    color: #d63031;

}



/* ========================================================= */
/* MODERN CARD */
/* ========================================================= */

.modern-card {

    background: white;

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.section-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 22px;

}


.section-header h4 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.section-header p {

    margin: 4px 0 0;

    color: #8a94a6;

}



/* ========================================================= */
/* ACTIVITY GRID */
/* ========================================================= */

.activity-grid {

    display: grid;

    grid-template-columns:

        repeat(
            2,
            1fr
        );

    gap: 15px;

}


.activity-box {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border-radius: 14px;

    background: #f8fafc;

}


.activity-icon {

    width: 45px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    font-size: 20px;

}


.activity-blue {

    background: #e7f0ff;

    color: #1769e0;

}


.activity-green {

    background: #e4f8ee;

    color: #11998e;

}


.activity-purple {

    background: #f0e8ff;

    color: #7c3aed;

}


.activity-orange {

    background: #fff1df;

    color: #f7971e;

}


.activity-box span {

    color: #7c8798;

    font-size: 13px;

}


.activity-box h3 {

    margin: 3px 0 0;

}



/* ========================================================= */
/* QUICK ACTIONS */
/* ========================================================= */

.quick-actions-card {

    background:

        linear-gradient(
            135deg,
            #ffffff,
            #f5f9ff
        );

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.quick-actions-card h4 {

    font-weight: 700;

}


.quick-actions-card p {

    color: #8a94a6;

}


.quick-action {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 12px 15px;

    border-radius: 12px;

    margin-bottom: 10px;

    text-decoration: none;

    font-weight: 600;

    transition:

        transform 0.2s ease;

}


.quick-action:hover {

    transform:

        translateX(5px);

}


.quick-action-blue {

    background: #e7f0ff;

    color: #1769e0;

}


.quick-action-green {

    background: #e4f8ee;

    color: #11998e;

}


.quick-action-orange {

    background: #fff1df;

    color: #d97706;

}


.quick-action-purple {

    background: #f0e8ff;

    color: #7c3aed;

}



/* ========================================================= */
/* TABLE */
/* ========================================================= */

.modern-table thead {

    background: #f5f7fb;

}


.modern-table th {

    color: #6c757d;

    font-weight: 600;

    border: none;

}


.modern-table td {

    padding:

        15px 10px;

}


.modern-table small {

    color: #8a94a6;

}



/* ========================================================= */
/* STATUS BADGES */
/* ========================================================= */

.status-badge {

    padding:

        6px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

}


.status-returned {

    background: #dff7e9;

    color: #16834d;

}


.status-borrowed {

    background: #e7f0ff;

    color: #1769e0;

}


.status-overdue {

    background: #ffe4e4;

    color: #d63031;

}



/* ========================================================= */
/* OVERDUE CARD */
/* ========================================================= */

.overdue-card {

    background: white;

    border-radius: 18px;

    padding: 25px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.overdue-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

}


.overdue-header h4 {

    margin: 0;

    color: #d63031;

}


.overdue-header p {

    margin: 5px 0;

    color: #8a94a6;

}


.overdue-header span {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #ffe4e4;

    color: #d63031;

    font-weight: 700;

}


.overdue-item {

    display: flex;

    gap: 12px;

    padding: 15px 0;

    border-bottom:

        1px solid #edf0f5;

}


.overdue-book-icon {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #fff1f1;

    color: #d63031;

}


.overdue-info {

    display: flex;

    flex-direction: column;

}


.overdue-info strong {

    font-size: 13px;

}


.overdue-info span {

    color: #6c757d;

    font-size: 12px;

}


.overdue-info small {

    color: #d63031;

}


.empty-overdue {

    text-align: center;

    padding: 30px;

    color: #11998e;

}


.empty-overdue i {

    font-size: 40px;

}



/* ========================================================= */
/* POPULAR BOOKS */
/* ========================================================= */

.popular-book {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 15px;

    background: #f8fafc;

    border-radius: 14px;

}


.book-rank {

    width: 38px;

    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background:

        linear-gradient(
            135deg,
            #1769e0,
            #3f8cff
        );

    color: white;

    font-weight: 700;

}


.popular-book strong {

    display: block;

    font-size: 13px;

}


.popular-book small {

    color: #8a94a6;

}



/* ========================================================= */
/* RESPONSIVE DESIGN */
/* ========================================================= */

@media (max-width: 768px) {


    .dashboard-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;

    }


    .dashboard-date {

        width: 100%;

    }


    .activity-grid {

        grid-template-columns: 1fr;

    }


    .inventory-dashboard-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 12px;

    }


    .inventory-stats-grid {

        grid-template-columns: 1fr;

    }


    .section-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 12px;

    }


    .dashboard-title-wrapper {

        align-items: flex-start;

    }


}


</style>

@endsection
