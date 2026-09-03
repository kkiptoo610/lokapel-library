@extends('layouts.app')

@section('content')

<div class="page-container">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="page-header mb-4">


        <div class="page-title-area">


            <div class="page-icon category-icon">

                <i class="bi bi-tags-fill"></i>

            </div>


            <div>

                <h1>

                    Book Categories

                </h1>


                <p>

                    Organize and manage categories for your library
                    collection.

                </p>

            </div>


        </div>


        <a
            href="{{ route('categories.create') }}"
            class="btn modern-add-btn"
        >

            <i class="bi bi-plus-circle me-1"></i>

            Add Category

        </a>


    </div>



    {{-- ========================================================= --}}
    {{-- CATEGORY SUMMARY --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">


        {{-- MAIN CATEGORIES --}}

        <div class="col-md-6">


            <div class="summary-card summary-brown">


                <div class="summary-content">


                    <span>

                        Main Categories

                    </span>


                    <h2>

                        {{ number_format($categories->whereNull('parent_id')->count()) }}

                    </h2>


                    <small>

                        Main categories currently available

                    </small>


                </div>


                <div class="summary-icon">

                    <i class="bi bi-tags"></i>

                </div>


            </div>


        </div>



        {{-- TOTAL BOOKS --}}

        <div class="col-md-6">


            <div class="summary-card summary-cream">


                <div class="summary-content">


                    <span>

                        Books Categorized

                    </span>


                    <h2>

                        {{ number_format($categories->sum('books_count')) }}

                    </h2>


                    <small>

                        Books assigned to categories

                    </small>


                </div>


                <div class="summary-icon">

                    <i class="bi bi-book-half"></i>

                </div>


            </div>


        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- CATEGORIES TABLE --}}
    {{-- ========================================================= --}}

    <div class="modern-card">


        {{-- CARD HEADER --}}

        <div class="table-card-header">


            <div>


                <h4>

                    <i class="bi bi-collection"></i>

                    Categories & Subcategories

                </h4>


                <p>

                    View, edit and manage your library category structure.

                </p>


            </div>


            <span class="category-count">

                <i class="bi bi-tags-fill me-1"></i>

                {{ number_format($categories->whereNull('parent_id')->count()) }}

                Main Categories

            </span>


        </div>



        {{-- TABLE --}}

        <div class="table-responsive">


            <table class="table modern-table align-middle mb-0">


                <thead>


                    <tr>


                        <th class="number-column">

                            #

                        </th>


                        <th>

                            Category

                        </th>


                        <th>

                            Description

                        </th>


                        <th>

                            Books

                        </th>


                        <th class="text-end">

                            Actions

                        </th>


                    </tr>


                </thead>



                <tbody>


                    @forelse($categories as $category)


                        {{-- ========================================================= --}}
                        {{-- MAIN CATEGORY --}}
                        {{-- ========================================================= --}}

                        @if(!$category->parent_id)


                            <tr>


                                {{-- NUMBER --}}

                                <td>


                                    <div class="row-number">

                                        {{ $loop->iteration }}

                                    </div>


                                </td>



                                {{-- CATEGORY NAME --}}

                                <td>


                                    <div class="category-info">


                                        <div class="category-avatar">

                                            <i class="bi bi-folder-fill"></i>

                                        </div>


                                        <div>


                                            <strong>

                                                {{ $category->name }}

                                            </strong>


                                            <small>

                                                Main Category

                                            </small>


                                        </div>


                                    </div>


                                </td>



                                {{-- DESCRIPTION --}}

                                <td>


                                    @if($category->description)


                                        <span class="category-description">

                                            {{ $category->description }}

                                        </span>


                                    @else


                                        <span class="no-description">

                                            No description provided

                                        </span>


                                    @endif


                                </td>



                                {{-- NUMBER OF BOOKS --}}

                                <td>


                                    @if($category->books_count > 0)


                                        <span class="book-count-badge">


                                            <i class="bi bi-book"></i>


                                            {{ number_format($category->books_count) }}


                                            {{ $category->books_count == 1 ? 'Book' : 'Books' }}


                                        </span>


                                    @else


                                        <span class="empty-book-badge">


                                            <i class="bi bi-book"></i>


                                            No Books


                                        </span>


                                    @endif


                                </td>



                                {{-- ACTIONS --}}

                                <td class="text-end">


                                    {{-- ADD SUBCATEGORY --}}

                                    <a
                                        href="{{ route('categories.create', ['parent_id' => $category->id]) }}"
                                        class="action-button action-add-subcategory"
                                        title="Add Subcategory"
                                    >

                                        <i class="bi bi-plus-circle"></i>

                                    </a>



                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="action-button action-edit"
                                        title="Edit Category"
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                    </a>



                                    {{-- DELETE --}}

                                    @if($category->books_count > 0)


                                        <button
                                            type="button"
                                            class="action-button action-disabled"
                                            disabled
                                            title="This category contains books and cannot be deleted"
                                        >

                                            <i class="bi bi-lock-fill"></i>

                                        </button>


                                    @else


                                        <form
                                            action="{{ route('categories.destroy', $category) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
                                        >


                                            @csrf


                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="action-button action-delete"
                                                title="Delete Category"
                                            >

                                                <i class="bi bi-trash"></i>

                                            </button>


                                        </form>


                                    @endif


                                </td>


                            </tr>



                            {{-- ========================================================= --}}
                            {{-- SUBCATEGORIES --}}
                            {{-- ========================================================= --}}

                            @foreach($categories->where('parent_id', $category->id) as $subcategory)


                                <tr class="subcategory-row">


                                    {{-- SUBCATEGORY INDICATOR --}}

                                    <td>


                                        <div class="subcategory-arrow">

                                            <i class="bi bi-arrow-return-right"></i>

                                        </div>


                                    </td>



                                    {{-- SUBCATEGORY NAME --}}

                                    <td>


                                        <div class="category-info subcategory-info">


                                            <div class="subcategory-avatar">

                                                <i class="bi bi-tag-fill"></i>

                                            </div>


                                            <div>


                                                <strong>

                                                    {{ $subcategory->name }}

                                                </strong>


                                                <small>

                                                    Subcategory under
                                                    {{ $category->name }}

                                                </small>


                                            </div>


                                        </div>


                                    </td>



                                    {{-- DESCRIPTION --}}

                                    <td>


                                        @if($subcategory->description)


                                            <span class="category-description">

                                                {{ $subcategory->description }}

                                            </span>


                                        @else


                                            <span class="no-description">

                                                No description provided

                                            </span>


                                        @endif


                                    </td>



                                    {{-- NUMBER OF BOOKS --}}

                                    <td>


                                        @if($subcategory->books_count > 0)


                                            <span class="book-count-badge">


                                                <i class="bi bi-book"></i>


                                                {{ number_format($subcategory->books_count) }}


                                                {{ $subcategory->books_count == 1 ? 'Book' : 'Books' }}


                                            </span>


                                        @else


                                            <span class="empty-book-badge">


                                                <i class="bi bi-book"></i>


                                                No Books


                                            </span>


                                        @endif


                                    </td>



                                    {{-- ACTIONS --}}

                                    <td class="text-end">


                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('categories.edit', $subcategory) }}"
                                            class="action-button action-edit"
                                            title="Edit Subcategory"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </a>



                                        {{-- DELETE --}}

                                        @if($subcategory->books_count > 0)


                                            <button
                                                type="button"
                                                class="action-button action-disabled"
                                                disabled
                                                title="This subcategory contains books and cannot be deleted"
                                            >

                                                <i class="bi bi-lock-fill"></i>

                                            </button>


                                        @else


                                            <form
                                                action="{{ route('categories.destroy', $subcategory) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this subcategory?')"
                                            >


                                                @csrf


                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="action-button action-delete"
                                                    title="Delete Subcategory"
                                                >

                                                    <i class="bi bi-trash"></i>

                                                </button>


                                            </form>


                                        @endif


                                    </td>


                                </tr>


                            @endforeach


                        @endif


                    @empty


                        {{-- EMPTY STATE --}}

                        <tr>


                            <td
                                colspan="5"
                                class="empty-table"
                            >


                                <div class="empty-state">


                                    <div class="empty-icon">

                                        <i class="bi bi-tags"></i>

                                    </div>


                                    <h5>

                                        No Categories Found

                                    </h5>


                                    <p>

                                        Start organizing your library
                                        by creating your first category.

                                    </p>


                                    <a
                                        href="{{ route('categories.create') }}"
                                        class="btn btn-add-first-category"
                                    >

                                        <i class="bi bi-plus-circle me-1"></i>

                                        Add First Category

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
{{-- PAGE STYLING --}}
{{-- ========================================================= --}}

<style>


/* =========================================================
   PAGE
========================================================= */

.page-container {

    padding-bottom: 30px;

}



/* =========================================================
   PAGE HEADER
========================================================= */

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 25px 28px;

    border-radius: 18px;

    background:

        linear-gradient(
            135deg,
            #5c3b22,
            #7a5132,
            #9a6a45
        );

    box-shadow:

        0 12px 30px
        rgba(
            92,
            59,
            34,
            0.22
        );

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

    border-radius: 17px;

    font-size: 28px;

    color: white;

    background:

        rgba(
            255,
            255,
            255,
            0.15
        );

    border:

        1px solid
        rgba(
            255,
            255,
            255,
            0.18
        );

}


.page-header h1 {

    color: white;

    margin: 0;

    font-size: 28px;

    font-weight: 700;

}


.page-header p {

    color: #f5e6d3;

    margin: 5px 0 0;

}


.modern-add-btn {

    border-radius: 10px;

    padding: 11px 18px;

    font-weight: 600;

    border: none;

    background: #f3e3cd;

    color: #5c3b22;

}


.modern-add-btn:hover {

    background: white;

    color: #5c3b22;

}



/* =========================================================
   SUMMARY CARDS
========================================================= */

.summary-card {

    min-height: 145px;

    border-radius: 17px;

    padding: 24px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    overflow: hidden;

    position: relative;

    transition:

        transform 0.25s ease,
        box-shadow 0.25s ease;

}


.summary-card:hover {

    transform:

        translateY(-5px);

    box-shadow:

        0 16px 30px
        rgba(
            92,
            59,
            34,
            0.18
        );

}


.summary-brown {

    color: white;

    background:

        linear-gradient(
            135deg,
            #6f4528,
            #8b5e3c
        );

}


.summary-cream {

    color: #5c3b22;

    background:

        linear-gradient(
            135deg,
            #f3e3cd,
            #ead7bd
        );

    border:

        1px solid
        #dfc6a8;

}


.summary-content span {

    font-size: 15px;

    opacity: 0.9;

}


.summary-content h2 {

    font-size: 36px;

    font-weight: 700;

    margin: 5px 0;

}


.summary-content small {

    opacity: 0.8;

}


.summary-icon {

    font-size: 58px;

    opacity: 0.18;

}



/* =========================================================
   MAIN CARD
========================================================= */

.modern-card {

    background: #fffdf9;

    border-radius: 18px;

    overflow: hidden;

    border:

        1px solid
        #eadcc8;

    box-shadow:

        0 8px 25px
        rgba(
            92,
            59,
            34,
            0.08
        );

}



/* =========================================================
   TABLE HEADER
========================================================= */

.table-card-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 24px 25px;

    background: #f3e3cd;

    border-bottom:

        1px solid
        #dfc6a8;

}


.table-card-header h4 {

    margin: 0;

    color: #5c3b22;

    font-weight: 700;

}


.table-card-header h4 i {

    color: #8b5e3c;

}


.table-card-header p {

    margin: 5px 0 0;

    color: #80654f;

}


.category-count {

    background: #fffaf4;

    color: #6f4528;

    border:

        1px solid
        #d8bfa4;

    padding: 8px 14px;

    border-radius: 20px;

    font-size: 13px;

    font-weight: 600;

}



/* =========================================================
   TABLE
========================================================= */

.modern-table {

    margin-bottom: 0;

}


.modern-table thead {

    background: #f8f1e8;

}


.modern-table th {

    border: none;

    color: #705845;

    font-size: 13px;

    font-weight: 700;

    padding: 16px 18px;

}


.modern-table td {

    padding: 18px;

    border-color: #f0e5d8;

}


.modern-table tbody tr {

    transition:

        background 0.2s ease;

}


.modern-table tbody tr:hover {

    background: #fff8ef;

}



/* =========================================================
   SUBCATEGORY ROW
========================================================= */

.subcategory-row {

    background: #fffaf4;

}


.subcategory-row:hover {

    background: #fff5e8 !important;

}


.subcategory-arrow {

    color: #9a7b62;

    font-size: 20px;

    text-align: center;

}


.subcategory-info {

    padding-left: 25px;

}


.subcategory-avatar {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #fffdf9;

    border: 1px solid #dfc6a8;

    color: #8b5e3c;

    font-size: 16px;

}



/* =========================================================
   ROW NUMBER
========================================================= */

.row-number {

    width: 32px;

    height: 32px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #f3e3cd;

    color: #6f4528;

    font-size: 13px;

    font-weight: 700;

}



/* =========================================================
   CATEGORY INFO
========================================================= */

.category-info {

    display: flex;

    align-items: center;

    gap: 12px;

}


.category-avatar {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #f3e3cd;

    color: #8b5e3c;

    font-size: 18px;

}


.category-info strong {

    display: block;

    color: #5c3b22;

    font-weight: 700;

}


.category-info small {

    display: block;

    color: #a08068;

    font-size: 12px;

}



/* =========================================================
   DESCRIPTION
========================================================= */

.category-description {

    color: #705f52;

}


.no-description {

    color: #aa9684;

    font-style: italic;

}



/* =========================================================
   BOOK BADGES
========================================================= */

.book-count-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 7px 12px;

    border-radius: 20px;

    background: #e9d5bd;

    color: #5c3b22;

    font-size: 12px;

    font-weight: 700;

}


.empty-book-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 7px 12px;

    border-radius: 20px;

    background: #f3eee8;

    color: #9a8a7c;

    font-size: 12px;

}



/* =========================================================
   ACTION BUTTONS
========================================================= */

.action-button {

    width: 36px;

    height: 36px;

    border: none;

    border-radius: 10px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    margin-left: 5px;

    text-decoration: none;

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.action-button:hover {

    transform:

        translateY(-2px);

}



/* =========================================================
   ADD SUBCATEGORY
========================================================= */

.action-add-subcategory {

    background: #e3f3e8;

    color: #2f7a4f;

}


.action-add-subcategory:hover {

    background: #cce8d5;

    color: #1f5c39;

}



/* =========================================================
   EDIT
========================================================= */

.action-edit {

    background: #fff0c9;

    color: #b7791f;

}


.action-edit:hover {

    background: #ffe4a3;

    color: #8a5b12;

}



/* =========================================================
   DELETE
========================================================= */

.action-delete {

    background: #ffe3df;

    color: #c0392b;

}


.action-delete:hover {

    background: #ffcfc8;

    color: #96281d;

}



/* =========================================================
   DISABLED
========================================================= */

.action-disabled {

    background: #eee7df;

    color: #a89b90;

    cursor: not-allowed;

}



/* =========================================================
   EMPTY STATE
========================================================= */

.empty-table {

    padding: 55px !important;

}


.empty-state {

    text-align: center;

}


.empty-icon {

    width: 70px;

    height: 70px;

    margin: 0 auto 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 18px;

    background: #f3e3cd;

    color: #8b5e3c;

    font-size: 30px;

}


.empty-state h5 {

    color: #5c3b22;

    font-weight: 700;

}


.empty-state p {

    color: #8c7868;

}


.btn-add-first-category {

    background: #6f4528;

    border-color: #6f4528;

    color: white;

    border-radius: 9px;

    padding: 10px 18px;

    font-weight: 600;

}


.btn-add-first-category:hover {

    background: #56331d;

    border-color: #56331d;

    color: white;

}



/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 768px) {


    .page-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;

        padding: 22px;

    }


    .modern-add-btn {

        width: 100%;

    }


    .table-card-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .category-count {

        width: 100%;

        text-align: center;

    }


}


</style>

@endsection