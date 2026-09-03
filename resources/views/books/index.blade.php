@extends('layouts.app')

@section('content')

<div class="books-page">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="page-header mb-4">

        <div class="page-header-content">


            <div class="page-title-icon">

                <i class="bi bi-book-half"></i>

            </div>


            <div>

                <h1>

                    Books Collection

                </h1>


                <p>

                    Manage all library books and their physical copies.

                </p>

            </div>


        </div>


        <a
            href="{{ route('books.create') }}"
            class="add-book-btn"
        >

            <i class="bi bi-plus-circle-fill"></i>

            Add New Book

        </a>


    </div>



    {{-- ========================================================= --}}
    {{-- SEARCH CARD --}}
    {{-- ========================================================= --}}

    <div class="search-card mb-4">


        <div class="search-card-header">

            <div>

                <h5>

                    <i class="bi bi-search"></i>

                    Search Library Books

                </h5>


                <p>

                    Quickly find books using their details or physical copy number.

                </p>

            </div>

        </div>



        <form method="GET">


            <div class="row g-3 align-items-center">


                <div class="col-lg-10">


                    <div class="search-input-wrapper">


                        <i class="bi bi-search"></i>


                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search by title, author, ISBN, shelf location, or copy number..."
                        >


                    </div>


                </div>



                <div class="col-lg-2">


                    <button
                        type="submit"
                        class="search-button w-100"
                    >

                        <i class="bi bi-search"></i>

                        Search

                    </button>


                </div>


            </div>


        </form>


    </div>



    {{-- ========================================================= --}}
    {{-- BOOKS TABLE --}}
    {{-- ========================================================= --}}

    <div class="books-card">


        {{-- CARD HEADER --}}

        <div class="books-card-header">


            <div>


                <h4>

                    <i class="bi bi-bookshelf"></i>

                    Library Books

                </h4>


                <p>

                    View and manage all books in the library collection.

                </p>


            </div>



            <div class="books-count">


                <i class="bi bi-book"></i>

                {{ $books->count() }}

                Books


            </div>


        </div>



        {{-- TABLE --}}

        <div class="table-responsive">


            <table class="table books-table align-middle mb-0">


                <thead>


                    <tr>

                        <th>#</th>

                        <th>Book Details</th>

                        <th>Author</th>

                        <th>Category</th>

                        <th class="text-center">

                            Total

                        </th>

                        <th class="text-center">

                            Available

                        </th>

                        <th class="text-center">

                            Borrowed

                        </th>

                        <th>Shelf</th>

                        <th class="text-end">

                            Actions

                        </th>

                    </tr>


                </thead>



                <tbody>


                    @forelse($books as $book)


                        @php

                            $totalCopies =
                                $book->total_copies;

                            $availableCopies =
                                $book->available_copies;

                            $borrowedCopies =
                                $totalCopies - $availableCopies;

                        @endphp



                        <tr>


                            {{-- NUMBER --}}

                            <td>


                                <div class="book-number">

                                    {{ $loop->iteration }}

                                </div>


                            </td>



                            {{-- BOOK DETAILS --}}

                            <td>


                                <div class="book-details">


                                    <div class="book-icon-small">

                                        <i class="bi bi-book"></i>

                                    </div>



                                    <div>


                                        <strong class="book-title">

                                            {{ $book->title }}

                                        </strong>



                                        @if($book->isbn)


                                            <small class="book-isbn">

                                                ISBN:

                                                {{ $book->isbn }}

                                            </small>


                                        @endif



                                        @if(
                                            $book->copies &&
                                            $book->copies->count() > 0
                                        )


                                            <small class="physical-copies">


                                                <i class="bi bi-copy"></i>

                                                {{ $book->copies->count() }}

                                                physical copies


                                            </small>


                                        @endif


                                    </div>


                                </div>


                            </td>



                            {{-- AUTHOR --}}

                            <td>


                                <span class="author-name">

                                    <i class="bi bi-person"></i>

                                    {{ $book->author }}

                                </span>


                            </td>



                            {{-- CATEGORY --}}

                            <td>


                                <span class="category-badge">


                                    <i class="bi bi-tag"></i>

                                    {{ $book->category->name ?? '-' }}


                                </span>


                            </td>



                            {{-- TOTAL COPIES --}}

                            <td class="text-center">


                                <span class="copy-badge total-copy">


                                    {{ $totalCopies }}


                                </span>


                            </td>



                            {{-- AVAILABLE COPIES --}}

                            <td class="text-center">


                                @if($availableCopies > 0)


                                    <span
                                        class="copy-badge available-copy"
                                    >

                                        {{ $availableCopies }}

                                    </span>


                                @else


                                    <span
                                        class="copy-badge unavailable-copy"
                                    >

                                        0

                                    </span>


                                @endif


                            </td>



                            {{-- BORROWED COPIES --}}

                            <td class="text-center">


                                @if($borrowedCopies > 0)


                                    <span
                                        class="copy-badge borrowed-copy"
                                    >

                                        {{ $borrowedCopies }}

                                    </span>


                                @else


                                    <span class="zero-copy">

                                        0

                                    </span>


                                @endif


                            </td>



                            {{-- SHELF LOCATION --}}

                            <td>


                                @if($book->shelf_location)


                                    <span class="shelf-location">


                                        <i class="bi bi-geo-alt"></i>

                                        {{ $book->shelf_location }}


                                    </span>


                                @else


                                    <span class="text-muted">

                                        -

                                    </span>


                                @endif


                            </td>



                            {{-- ACTIONS --}}

                            <td class="text-end">


                                <div class="action-buttons">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('books.show', $book) }}"
                                        class="action-btn view-btn"
                                        title="View Book and Copies"
                                    >

                                        <i class="bi bi-eye-fill"></i>

                                    </a>



                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('books.edit', $book) }}"
                                        class="action-btn edit-btn"
                                        title="Edit Book"
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                    </a>



                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('books.destroy', $book) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this book? All physical copies will also be deleted.')"
                                    >


                                        @csrf

                                        @method('DELETE')



                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                            title="Delete Book"
                                        >

                                            <i class="bi bi-trash-fill"></i>

                                        </button>


                                    </form>


                                </div>


                            </td>


                        </tr>



                    @empty


                        <tr>


                            <td
                                colspan="9"
                                class="text-center"
                            >


                                <div class="empty-books">


                                    <div class="empty-books-icon">

                                        <i class="bi bi-book"></i>

                                    </div>


                                    <h5>

                                        No Books Found

                                    </h5>


                                    <p>

                                        Your library does not have any books matching your search.

                                    </p>


                                    <a
                                        href="{{ route('books.create') }}"
                                        class="btn btn-primary"
                                    >

                                        <i class="bi bi-plus-circle"></i>

                                        Add Your First Book

                                    </a>


                                </div>


                            </td>


                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


    </div>


</div>



{{-- ========================================================= --}}
{{-- BOOKS PAGE STYLING --}}
{{-- ========================================================= --}}

<style>


/* ========================================================= */
/* PAGE */
/* ========================================================= */

.books-page {

    padding-bottom: 30px;

}



/* ========================================================= */
/* PAGE HEADER */
/* ========================================================= */

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 28px 30px;

    border-radius: 20px;

    background:

        linear-gradient(
            135deg,
            #0f3d6e,
            #1558a6,
            #2d7dd2
        );

    color: white;

    box-shadow:

        0 15px 35px
        rgba(
            21,
            88,
            166,
            0.20
        );

}


.page-header-content {

    display: flex;

    align-items: center;

    gap: 18px;

}


.page-title-icon {

    width: 65px;

    height: 65px;

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


.page-header h1 {

    margin: 0;

    font-size: 29px;

    font-weight: 700;

}


.page-header p {

    margin:

        5px 0 0;

    opacity: 0.85;

}


.add-book-btn {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 12px 20px;

    border-radius: 12px;

    text-decoration: none;

    background: white;

    color: #1558a6;

    font-weight: 700;

    transition:

        all 0.25s ease;

}


.add-book-btn:hover {

    color: #1558a6;

    transform:

        translateY(-3px);

    box-shadow:

        0 8px 20px
        rgba(
            0,
            0,
            0,
            0.15
        );

}



/* ========================================================= */
/* SEARCH CARD */
/* ========================================================= */

.search-card {

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


.search-card-header {

    margin-bottom: 18px;

}


.search-card-header h5 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.search-card-header h5 i {

    color: #1769e0;

    margin-right: 6px;

}


.search-card-header p {

    margin:

        5px 0 0;

    color: #8a94a6;

    font-size: 14px;

}


.search-input-wrapper {

    position: relative;

}


.search-input-wrapper > i {

    position: absolute;

    top: 50%;

    left: 16px;

    transform:

        translateY(-50%);

    color: #8a94a6;

}


.search-input-wrapper input {

    height: 50px;

    padding-left: 45px;

    border-radius: 12px;

    border:

        1px solid #e2e8f0;

}


.search-input-wrapper input:focus {

    border-color: #2575d7;

    box-shadow:

        0 0 0 4px
        rgba(
            37,
            117,
            215,
            0.10
        );

}


.search-button {

    height: 50px;

    border: none;

    border-radius: 12px;

    background:

        linear-gradient(
            135deg,
            #1558a6,
            #2575d7
        );

    color: white;

    font-weight: 600;

    transition:

        all 0.2s ease;

}


.search-button:hover {

    transform:

        translateY(-2px);

    box-shadow:

        0 8px 18px
        rgba(
            37,
            117,
            215,
            0.25
        );

}



/* ========================================================= */
/* BOOKS CARD */
/* ========================================================= */

.books-card {

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.books-card-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding:

        25px
        25px
        18px;

}


.books-card-header h4 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.books-card-header h4 i {

    color: #1769e0;

    margin-right: 6px;

}


.books-card-header p {

    margin:

        5px 0 0;

    color: #8a94a6;

    font-size: 14px;

}


.books-count {

    display: flex;

    align-items: center;

    gap: 8px;

    padding:

        9px
        14px;

    border-radius: 10px;

    background: #e7f0ff;

    color: #1769e0;

    font-weight: 600;

}



/* ========================================================= */
/* TABLE */
/* ========================================================= */

.books-table {

    margin: 0;

}


.books-table thead {

    background: #f5f8fc;

}


.books-table th {

    padding:

        15px
        14px;

    font-size: 12px;

    text-transform: uppercase;

    letter-spacing: 0.4px;

    color: #6b7280;

    border: none;

    white-space: nowrap;

}


.books-table td {

    padding:

        16px
        14px;

    border-color: #eef1f5;

}


.books-table tbody tr {

    transition:

        background 0.2s ease;

}


.books-table tbody tr:hover {

    background: #f8fbff;

}



/* ========================================================= */
/* BOOK NUMBER */
/* ========================================================= */

.book-number {

    width: 32px;

    height: 32px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #eef4ff;

    color: #1769e0;

    font-size: 12px;

    font-weight: 700;

}



/* ========================================================= */
/* BOOK DETAILS */
/* ========================================================= */

.book-details {

    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 220px;

}


.book-icon-small {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background:

        linear-gradient(
            135deg,
            #e7f0ff,
            #dbeafe
        );

    color: #1769e0;

    font-size: 18px;

}


.book-title {

    display: block;

    color: #253858;

    margin-bottom: 3px;

}


.book-isbn {

    display: block;

    color: #8a94a6;

    font-size: 11px;

}


.physical-copies {

    display: block;

    margin-top: 2px;

    color: #1558a6;

    font-size: 11px;

}



/* ========================================================= */
/* AUTHOR */
/* ========================================================= */

.author-name {

    color: #4b5563;

    white-space: nowrap;

}


.author-name i {

    color: #8a94a6;

    margin-right: 4px;

}



/* ========================================================= */
/* CATEGORY */
/* ========================================================= */

.category-badge {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding:

        7px
        10px;

    border-radius: 20px;

    background: #f0e8ff;

    color: #7c3aed;

    font-size: 12px;

    font-weight: 600;

    white-space: nowrap;

}



/* ========================================================= */
/* COPY BADGES */
/* ========================================================= */

.copy-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 35px;

    padding:

        6px
        10px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 700;

}


.total-copy {

    background: #e7f0ff;

    color: #1769e0;

}


.available-copy {

    background: #e4f8ee;

    color: #16834d;

}


.unavailable-copy {

    background: #ffe4e4;

    color: #d63031;

}


.borrowed-copy {

    background: #fff1df;

    color: #d97706;

}


.zero-copy {

    color: #9ca3af;

    font-weight: 600;

}



/* ========================================================= */
/* SHELF LOCATION */
/* ========================================================= */

.shelf-location {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: #4b5563;

    font-size: 13px;

}


.shelf-location i {

    color: #1769e0;

}



/* ========================================================= */
/* ACTION BUTTONS */
/* ========================================================= */

.action-buttons {

    display: flex;

    justify-content: flex-end;

    gap: 7px;

}


.action-btn {

    width: 36px;

    height: 36px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border: none;

    border-radius: 10px;

    text-decoration: none;

    transition:

        all 0.2s ease;

}


.action-btn:hover {

    transform:

        translateY(-2px);

}


.view-btn {

    background: #e7f0ff;

    color: #1769e0;

}


.view-btn:hover {

    background: #1769e0;

    color: white;

}


.edit-btn {

    background: #fff1df;

    color: #d97706;

}


.edit-btn:hover {

    background: #f59e0b;

    color: white;

}


.delete-btn {

    background: #ffe4e4;

    color: #d63031;

}


.delete-btn:hover {

    background: #dc2626;

    color: white;

}



/* ========================================================= */
/* EMPTY STATE */
/* ========================================================= */

.empty-books {

    padding:

        50px
        20px;

}


.empty-books-icon {

    width: 70px;

    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin:

        0
        auto
        15px;

    border-radius: 20px;

    background: #e7f0ff;

    color: #1769e0;

    font-size: 30px;

}


.empty-books h5 {

    font-weight: 700;

    color: #253858;

}


.empty-books p {

    color: #8a94a6;

    margin-bottom: 20px;

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


    .add-book-btn {

        width: 100%;

        justify-content: center;

    }


    .books-card-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .books-count {

        width: 100%;

        justify-content: center;

    }


}


</style>

@endsection