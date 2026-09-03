@extends('layouts.app')

@section('content')

<div class="book-status-page">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="status-page-header">


        <div class="status-header-left">


            <div class="status-header-icon">

                @if($status === 'available')

                    <i class="bi bi-check-circle"></i>

                @elseif($status === 'borrowed')

                    <i class="bi bi-arrow-left-right"></i>

                @elseif($status === 'damaged')

                    <i class="bi bi-bookmark-x"></i>

                @else

                    <i class="bi bi-bookshelf"></i>

                @endif

            </div>


            <div>


                <h1>

                    {{ $pageTitle }}

                </h1>


                <p>

                    @if($status === 'available')

                        View all physical book copies currently available for borrowing.

                    @elseif($status === 'borrowed')

                        View all physical book copies currently issued to borrowers.

                    @elseif($status === 'damaged')

                        View all physical book copies that require repair or replacement.

                    @else

                        View all physical book copies in the library collection.

                    @endif

                </p>


            </div>


        </div>



        <a
            href="{{ route('dashboard') }}"
            class="back-dashboard-btn"
        >

            <i class="bi bi-arrow-left"></i>

            Back to Dashboard

        </a>


    </div>



    {{-- ========================================================= --}}
    {{-- STATUS NAVIGATION --}}
    {{-- ========================================================= --}}

    <div class="status-navigation">


        <a
            href="{{ route('books.status', 'all') }}"
            class="status-nav-item {{ $status === 'all' ? 'active-all' : '' }}"
        >

            <i class="bi bi-bookshelf"></i>

            <span>

                All Copies

            </span>

        </a>



        <a
            href="{{ route('books.status', 'available') }}"
            class="status-nav-item {{ $status === 'available' ? 'active-available' : '' }}"
        >

            <i class="bi bi-check-circle"></i>

            <span>

                Available

            </span>

        </a>



        <a
            href="{{ route('books.status', 'borrowed') }}"
            class="status-nav-item {{ $status === 'borrowed' ? 'active-borrowed' : '' }}"
        >

            <i class="bi bi-arrow-left-right"></i>

            <span>

                Borrowed

            </span>

        </a>



        <a
            href="{{ route('books.status', 'damaged') }}"
            class="status-nav-item {{ $status === 'damaged' ? 'active-damaged' : '' }}"
        >

            <i class="bi bi-bookmark-x"></i>

            <span>

                Damaged

            </span>

        </a>


    </div>



    {{-- ========================================================= --}}
    {{-- MAIN CARD --}}
    {{-- ========================================================= --}}

    <div class="status-list-card">


        {{-- ===================================================== --}}
        {{-- CARD HEADER --}}
        {{-- ===================================================== --}}

        <div class="status-list-header">


            <div>


                <h4>

                    <i class="bi bi-list-ul"></i>

                    {{ $pageTitle }}

                </h4>


                <p>

                    {{ number_format($bookCopies->total()) }}

                    physical book
                    {{ $bookCopies->total() == 1 ? 'copy' : 'copies' }}
                    found.

                </p>


            </div>



            <a
                href="{{ route('books.create') }}"
                class="add-book-btn"
            >

                <i class="bi bi-plus-circle"></i>

                Add New Book

            </a>


        </div>



        {{-- ===================================================== --}}
        {{-- TABLE --}}
        {{-- ===================================================== --}}

        <div class="table-responsive">


            <table class="table status-table align-middle">


                <thead>


                    <tr>

                        <th>

                            Book

                        </th>


                        <th>

                            Copy Number

                        </th>


                        <th>

                            Accession Number

                        </th>


                        <th>

                            Status

                        </th>


                        <th class="text-end">

                            Action

                        </th>

                    </tr>


                </thead>



                <tbody>


                    @forelse($bookCopies as $copy)


                        <tr>


                            {{-- BOOK --}}

                            <td>


                                <div class="book-info">


                                    <div class="book-icon-small">

                                        <i class="bi bi-book"></i>

                                    </div>


                                    <div>


                                        <strong>

                                            {{ $copy->book?->title ?? 'Unknown Book' }}

                                        </strong>


                                        @if($copy->book?->author)

                                            <small>

                                                {{ $copy->book->author }}

                                            </small>

                                        @endif


                                    </div>


                                </div>


                            </td>



                            {{-- COPY NUMBER --}}

                            <td>


                                <span class="copy-number-badge">

                                    {{ $copy->copy_number }}

                                </span>


                            </td>



                            {{-- ACCESSION NUMBER --}}

                            <td>


                                <span class="accession-number">

                                    {{ $copy->accession_number }}

                                </span>


                            </td>



                            {{-- STATUS --}}

                            <td>


                                @if($copy->status === 'available')


                                    <span class="copy-status status-available">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Available

                                    </span>


                                @elseif($copy->status === 'borrowed')


                                    <span class="copy-status status-borrowed">

                                        <i class="bi bi-arrow-left-right"></i>

                                        Borrowed

                                    </span>


                                @elseif($copy->status === 'damaged')


                                    <span class="copy-status status-damaged">

                                        <i class="bi bi-exclamation-triangle-fill"></i>

                                        Damaged

                                    </span>


                                @else


                                    <span class="copy-status">

                                        {{ ucfirst($copy->status) }}

                                    </span>


                                @endif


                            </td>



                            {{-- ACTION --}}

                            <td class="text-end">


                                @if($copy->book)


                                    <a
                                        href="{{ route('books.show', $copy->book->id) }}"
                                        class="view-book-btn"
                                        title="View Book"
                                    >

                                        <i class="bi bi-eye"></i>

                                        View

                                    </a>


                                @else


                                    <span class="text-muted">

                                        -

                                    </span>


                                @endif


                            </td>


                        </tr>


                    @empty


                        <tr>


                            <td
                                colspan="5"
                                class="empty-status-cell"
                            >


                                <div class="empty-status">


                                    <div class="empty-status-icon">

                                        <i class="bi bi-inbox"></i>

                                    </div>


                                    <h5>

                                        No Book Copies Found

                                    </h5>


                                    <p>


                                        @if($status === 'available')

                                            There are currently no available book copies.

                                        @elseif($status === 'borrowed')

                                            There are currently no borrowed book copies.

                                        @elseif($status === 'damaged')

                                            Great! There are currently no damaged book copies.

                                        @else

                                            No physical book copies have been added yet.

                                        @endif


                                    </p>


                                    <a
                                        href="{{ route('books.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="bi bi-plus-circle"></i>

                                        Add New Book

                                    </a>


                                </div>


                            </td>


                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>



        {{-- ===================================================== --}}
        {{-- PAGINATION --}}
        {{-- ===================================================== --}}

        @if($bookCopies->hasPages())


            <div class="pagination-wrapper">


                {{ $bookCopies->links() }}


            </div>


        @endif


    </div>


</div>



{{-- ========================================================= --}}
{{-- STYLING --}}
{{-- ========================================================= --}}

<style>


/* ========================================================= */
/* PAGE */
/* ========================================================= */

.book-status-page {

    padding-bottom: 30px;

}


/* ========================================================= */
/* PAGE HEADER */
/* ========================================================= */

.status-page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding: 28px 30px;

    margin-bottom: 25px;

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


.status-header-left {

    display: flex;

    align-items: center;

    gap: 18px;

}


.status-header-icon {

    width: 64px;

    height: 64px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 18px;

    font-size: 30px;

    background:

        rgba(
            255,
            255,
            255,
            0.18
        );

}


.status-page-header h1 {

    margin: 0;

    font-size: 28px;

    font-weight: 700;

}


.status-page-header p {

    margin: 5px 0 0;

    opacity: 0.85;

}


.back-dashboard-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 11px 16px;

    border-radius: 10px;

    color: white;

    text-decoration: none;

    font-weight: 600;

    background:

        rgba(
            255,
            255,
            255,
            0.15
        );

    transition:

        transform 0.2s ease,
        background 0.2s ease;

}


.back-dashboard-btn:hover {

    color: white;

    transform:

        translateX(-4px);

    background:

        rgba(
            255,
            255,
            255,
            0.25
        );

}



/* ========================================================= */
/* STATUS NAVIGATION */
/* ========================================================= */

.status-navigation {

    display: grid;

    grid-template-columns:

        repeat(
            4,
            1fr
        );

    gap: 15px;

    margin-bottom: 25px;

}


.status-nav-item {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    padding: 16px;

    border-radius: 14px;

    background: white;

    color: #64748b;

    text-decoration: none;

    font-weight: 600;

    box-shadow:

        0 5px 20px
        rgba(
            0,
            0,
            0,
            0.05
        );

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.status-nav-item:hover {

    transform:

        translateY(-3px);

    color: #1769e0;

    box-shadow:

        0 10px 25px
        rgba(
            0,
            0,
            0,
            0.08
        );

}


.active-all {

    background:

        linear-gradient(
            135deg,
            #1769e0,
            #3f8cff
        );

    color: white;

}


.active-available {

    background:

        linear-gradient(
            135deg,
            #11998e,
            #38ef7d
        );

    color: white;

}


.active-borrowed {

    background:

        linear-gradient(
            135deg,
            #f7971e,
            #ffd200
        );

    color: white;

}


.active-damaged {

    background:

        linear-gradient(
            135deg,
            #b91c1c,
            #dc2626
        );

    color: white;

}


.active-all:hover,
.active-available:hover,
.active-borrowed:hover,
.active-damaged:hover {

    color: white;

}



/* ========================================================= */
/* MAIN CARD */
/* ========================================================= */

.status-list-card {

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


.status-list-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 25px;

}


.status-list-header h4 {

    margin: 0;

    font-size: 21px;

    font-weight: 700;

    color: #253858;

}


.status-list-header h4 i {

    color: #1769e0;

    margin-right: 8px;

}


.status-list-header p {

    margin: 6px 0 0;

    color: #8a94a6;

}


.add-book-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 10px 16px;

    border-radius: 10px;

    background: #1769e0;

    color: white;

    text-decoration: none;

    font-weight: 600;

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.add-book-btn:hover {

    color: white;

    transform:

        translateY(-2px);

    box-shadow:

        0 8px 18px
        rgba(
            23,
            105,
            224,
            0.25
        );

}



/* ========================================================= */
/* TABLE */
/* ========================================================= */

.status-table {

    margin-bottom: 0;

}


.status-table thead {

    background: #f5f7fb;

}


.status-table th {

    padding: 15px;

    border: none;

    color: #6c757d;

    font-size: 13px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.5px;

}


.status-table td {

    padding: 18px 15px;

    border-color: #edf0f5;

}


.status-table tbody tr {

    transition:

        background 0.2s ease;

}


.status-table tbody tr:hover {

    background: #f8fbff;

}



/* ========================================================= */
/* BOOK INFORMATION */
/* ========================================================= */

.book-info {

    display: flex;

    align-items: center;

    gap: 12px;

}


.book-icon-small {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #e7f0ff;

    color: #1769e0;

    font-size: 19px;

}


.book-info strong {

    display: block;

    color: #253858;

}


.book-info small {

    display: block;

    margin-top: 3px;

    color: #8a94a6;

}



/* ========================================================= */
/* COPY NUMBER */
/* ========================================================= */

.copy-number-badge {

    display: inline-block;

    padding: 6px 10px;

    border-radius: 8px;

    background: #eef2f7;

    color: #475569;

    font-size: 12px;

    font-weight: 600;

}


.accession-number {

    color: #475569;

    font-family: monospace;

    font-size: 13px;

}



/* ========================================================= */
/* STATUS BADGES */
/* ========================================================= */

.copy-status {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 7px 12px;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 700;

}


.status-available {

    background: #dff7e9;

    color: #16834d;

}


.status-borrowed {

    background: #fff1df;

    color: #c77700;

}


.status-damaged {

    background: #ffe4e4;

    color: #c62828;

}



/* ========================================================= */
/* VIEW BUTTON */
/* ========================================================= */

.view-book-btn {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 12px;

    border-radius: 8px;

    background: #e7f0ff;

    color: #1769e0;

    text-decoration: none;

    font-size: 12px;

    font-weight: 700;

    transition:

        background 0.2s ease,
        transform 0.2s ease;

}


.view-book-btn:hover {

    background: #1769e0;

    color: white;

    transform:

        translateY(-2px);

}



/* ========================================================= */
/* EMPTY STATE */
/* ========================================================= */

.empty-status-cell {

    padding: 0 !important;

}


.empty-status {

    text-align: center;

    padding: 60px 20px;

}


.empty-status-icon {

    width: 70px;

    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: 0 auto 18px;

    border-radius: 50%;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 30px;

}


.empty-status h5 {

    font-weight: 700;

    color: #334155;

}


.empty-status p {

    color: #8a94a6;

    margin-bottom: 20px;

}



/* ========================================================= */
/* PAGINATION */
/* ========================================================= */

.pagination-wrapper {

    margin-top: 25px;

    display: flex;

    justify-content: center;

}



/* ========================================================= */
/* RESPONSIVE */
/* ========================================================= */

@media (max-width: 992px) {


    .status-navigation {

        grid-template-columns:

            repeat(
                2,
                1fr
            );

    }


}


@media (max-width: 768px) {


    .status-page-header {

        flex-direction: column;

        align-items: flex-start;

    }


    .status-header-left {

        align-items: flex-start;

    }


    .back-dashboard-btn {

        width: 100%;

        justify-content: center;

    }


    .status-list-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .add-book-btn {

        width: 100%;

        justify-content: center;

    }


    .status-navigation {

        grid-template-columns: 1fr;

    }


}


@media (max-width: 576px) {


    .status-page-header {

        padding: 22px;

    }


    .status-page-header h1 {

        font-size: 23px;

    }


    .status-header-icon {

        width: 52px;

        height: 52px;

        font-size: 24px;

    }


    .status-list-card {

        padding: 15px;

    }


}


</style>

@endsection