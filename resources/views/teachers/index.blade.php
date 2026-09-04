@extends('layouts.app')

@section('content')

<style>

    /* =====================================
       TEACHERS PAGE COLOUR THEME
    ===================================== */

    .teachers-page {

        --cream: #f7f1e3;
        --light-cream: #fcf8ef;
        --brown: #6f4e37;
        --dark-brown: #4e342e;
        --medium-brown: #8b5e3c;
        --soft-brown: #d9c2a3;
        --border-brown: #e5d6c3;

    }


    /* =====================================
       PAGE HEADER
    ===================================== */

    .teachers-header-card {

        background:
            linear-gradient(
                135deg,
                #6f4e37,
                #8b5e3c
            );

        color: white;

        border-radius: 16px;

        padding: 28px 30px;

        box-shadow:
            0 8px 25px
            rgba(111, 78, 55, 0.18);

    }


    .teachers-header-card h1 {

        font-size: 28px;

        font-weight: 700;

        margin-bottom: 6px;

    }


    .teachers-header-card p {

        color: #f8ead8;

        margin-bottom: 0;

    }


    /* =====================================
       HEADER ICON
    ===================================== */

    .teachers-header-icon {

        width: 60px;

        height: 60px;

        border-radius: 14px;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 28px;

        background-color:
            rgba(255, 255, 255, 0.15);

        color: #fff;

    }


    /* =====================================
       ADD TEACHER BUTTON
    ===================================== */

    .btn-add-teacher {

        background-color: #f7ead9;

        color: #6f4e37;

        border: none;

        font-weight: 600;

        padding: 10px 18px;

        border-radius: 10px;

        transition: all 0.2s ease;

    }


    .btn-add-teacher:hover {

        background-color: #ffffff;

        color: #4e342e;

        transform: translateY(-1px);

    }


    /* =====================================
       SEARCH CARD
    ===================================== */

    .search-card {

        border: none;

        border-radius: 16px;

        background-color: #ffffff;

        box-shadow:
            0 5px 20px
            rgba(111, 78, 55, 0.08);

    }


    .search-card .card-body {

        padding: 22px;

    }


    /* =====================================
       SEARCH INPUT
    ===================================== */

    .search-input {

        border-radius: 10px;

        border: 1px solid #e5d6c3;

        padding: 11px 15px;

    }


    .search-input:focus {

        border-color: #8b5e3c;

        box-shadow:
            0 0 0 0.2rem
            rgba(139, 94, 60, 0.15);

    }


    /* =====================================
       SEARCH BUTTON
    ===================================== */

    .btn-search {

        background-color: #6f4e37;

        border: none;

        color: white;

        padding: 11px;

        border-radius: 10px;

        font-weight: 600;

    }


    .btn-search:hover {

        background-color: #4e342e;

        color: white;

    }


    /* =====================================
       TEACHERS TABLE CARD
    ===================================== */

    .teachers-table-card {

        border: none;

        border-radius: 16px;

        overflow: hidden;

        box-shadow:
            0 5px 20px
            rgba(111, 78, 55, 0.08);

    }


    /* =====================================
       TABLE HEADER
    ===================================== */

    .teachers-table-card thead {

        background-color: #f7f1e3;

    }


    .teachers-table-card thead th {

        color: #6f4e37;

        font-weight: 700;

        padding: 16px;

        border-bottom:
            1px solid #e5d6c3;

        white-space: nowrap;

    }


    /* =====================================
       TABLE BODY
    ===================================== */

    .teachers-table-card tbody td {

        padding: 16px;

        vertical-align: middle;

        color: #4e342e;

    }


    .teachers-table-card tbody tr {

        transition: all 0.2s ease;

    }


    .teachers-table-card tbody tr:hover {

        background-color: #fcf8ef;

    }


    /* =====================================
       TEACHER AVATAR
    ===================================== */

    .teacher-avatar {

        width: 42px;

        height: 42px;

        border-radius: 50%;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        background-color: #f7f1e3;

        color: #6f4e37;

        font-size: 18px;

        margin-right: 12px;

        flex-shrink: 0;

    }


    /* =====================================
       PHONE BADGE
    ===================================== */

    .phone-badge {

        background-color: #fcf8ef;

        color: #6f4e37;

        border: 1px solid #e5d6c3;

        padding: 7px 12px;

        border-radius: 8px;

        font-weight: 500;

        white-space: nowrap;

    }


    /* =====================================
       DEPARTMENT BADGE
    ===================================== */

    .department-badge {

        display: inline-block;

        background-color: #f7f1e3;

        color: #6f4e37;

        border: 1px solid #e5d6c3;

        padding: 7px 12px;

        border-radius: 8px;

        font-weight: 500;

        white-space: nowrap;

    }


    /* =====================================
       POSITION BADGE
    ===================================== */

    .position-badge {

        display: inline-block;

        background-color: #f7ead9;

        color: #8b5e3c;

        border: 1px solid #e5d6c3;

        padding: 7px 12px;

        border-radius: 8px;

        font-weight: 600;

        white-space: nowrap;

    }


    /* =====================================
       EMPTY VALUE
    ===================================== */

    .empty-value {

        color: #a08c78;

        font-style: italic;

    }


    /* =====================================
       ACTION BUTTONS
    ===================================== */

    .action-btn {

        width: 38px;

        height: 38px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        border-radius: 9px;

        border: none;

        margin-left: 4px;

        transition: all 0.2s ease;

    }


    .btn-view {

        background-color: #dbeafe;

        color: #2563eb;

    }


    .btn-view:hover {

        background-color: #2563eb;

        color: white;

    }


    .btn-edit {

        background-color: #f7ead9;

        color: #8b5e3c;

    }


    .btn-edit:hover {

        background-color: #8b5e3c;

        color: white;

    }


    .btn-delete {

        background-color: #fee2e2;

        color: #dc2626;

    }


    .btn-delete:hover {

        background-color: #dc2626;

        color: white;

    }


    /* =====================================
       EMPTY STATE
    ===================================== */

    .empty-state {

        padding: 50px 20px;

        text-align: center;

        color: #8b7355;

    }


    .empty-state i {

        font-size: 50px;

        color: #d9c2a3;

        margin-bottom: 15px;

    }

</style>


<div class="teachers-page">


    {{-- =====================================
         PAGE HEADER
    ===================================== --}}

    <div class="teachers-header-card mb-4">

        <div class="d-flex justify-content-between align-items-center">


            <div class="d-flex align-items-center">


                <div class="teachers-header-icon me-3">

                    <i class="bi bi-person-workspace"></i>

                </div>


                <div>

                    <h1>

                        Teachers

                    </h1>


                    <p>

                        Manage teachers who borrow library books.

                    </p>

                </div>


            </div>


            <a
                href="{{ route('teachers.create') }}"
                class="btn btn-add-teacher"
            >

                <i class="bi bi-person-plus me-1"></i>

                Add Teacher

            </a>


        </div>

    </div>


    {{-- =====================================
         SEARCH
    ===================================== --}}

    <div class="card search-card mb-4">

        <div class="card-body">


            <form method="GET">


                <div class="row g-2">


                    <div class="col-md-10">


                        <div class="input-group">


                            <span class="input-group-text bg-white border-end-0">

                                <i class="bi bi-search text-muted"></i>

                            </span>


                            <input
                                type="text"
                                name="search"
                                class="form-control search-input border-start-0"
                                value="{{ request('search') }}"
                                placeholder="Search by teacher name, phone number, department or position"
                            >


                        </div>


                    </div>


                    <div class="col-md-2">


                        <button
                            type="submit"
                            class="btn btn-search w-100"
                        >

                            <i class="bi bi-search me-1"></i>

                            Search

                        </button>


                    </div>


                </div>


            </form>


        </div>

    </div>


    {{-- =====================================
         TEACHERS TABLE
    ===================================== --}}

    <div class="card teachers-table-card">


        <div class="card-body p-0">


            <div class="table-responsive">


                <table class="table table-hover align-middle mb-0">


                    <thead>


                        <tr>

                            <th class="ps-4">

                                #

                            </th>


                            <th>

                                Teacher

                            </th>


                            <th>

                                Phone Number

                            </th>


                            <th>

                                Department

                            </th>


                            <th>

                                Position / Designation

                            </th>


                            <th class="text-end pe-4">

                                Actions

                            </th>

                        </tr>


                    </thead>


                    <tbody>


                        @forelse($teachers as $teacher)


                            <tr>


                                {{-- NUMBER --}}

                                <td class="ps-4">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- TEACHER NAME --}}

                                <td>


                                    <div class="d-flex align-items-center">


                                        <div class="teacher-avatar">

                                            <i class="bi bi-person"></i>

                                        </div>


                                        <div>


                                            <strong>

                                                {{ $teacher->name }}

                                            </strong>


                                            <div
                                                class="text-muted small"
                                            >

                                                Library Borrower

                                            </div>


                                        </div>


                                    </div>


                                </td>


                                {{-- PHONE NUMBER --}}

                                <td>


                                    @if($teacher->phone)

                                        <span class="phone-badge">

                                            <i class="bi bi-telephone me-1"></i>

                                            {{ $teacher->phone }}

                                        </span>

                                    @else

                                        <span class="empty-value">

                                            Not provided

                                        </span>

                                    @endif


                                </td>


                                {{-- DEPARTMENT --}}

                                <td>


                                    @if($teacher->department)

                                        <span class="department-badge">

                                            <i class="bi bi-building me-1"></i>

                                            {{ $teacher->department }}

                                        </span>

                                    @else

                                        <span class="empty-value">

                                            Not assigned

                                        </span>

                                    @endif


                                </td>


                                {{-- POSITION --}}

                                <td>


                                    @if($teacher->position)

                                        <span class="position-badge">

                                            <i class="bi bi-person-badge me-1"></i>

                                            {{ $teacher->position }}

                                        </span>

                                    @else

                                        <span class="empty-value">

                                            Teacher

                                        </span>

                                    @endif


                                </td>


                                {{-- ACTIONS --}}

                                <td class="text-end pe-4">


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('teachers.show', $teacher) }}"
                                        class="action-btn btn-view"
                                        title="View Teacher"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('teachers.edit', $teacher) }}"
                                        class="action-btn btn-edit"
                                        title="Edit Teacher"
                                    >

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('teachers.destroy', $teacher) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this teacher?')"
                                    >


                                        @csrf


                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="action-btn btn-delete"
                                            title="Delete Teacher"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>


                                    </form>


                                </td>


                            </tr>


                        @empty


                            <tr>


                                <td
                                    colspan="6"
                                >


                                    <div class="empty-state">


                                        <i class="bi bi-person-x d-block"></i>


                                        <h5>

                                            No Teachers Found

                                        </h5>


                                        <p class="mb-0">

                                            There are currently no teachers
                                            registered in the library system.

                                        </p>


                                    </div>


                                </td>


                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>


        </div>


    </div>


</div>

@endsection