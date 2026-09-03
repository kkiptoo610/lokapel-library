@extends('layouts.app')

@section('content')

<style>

    /* =====================================
       STAFF PAGE COLOUR THEME
    ===================================== */

    .staff-page {

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

    .staff-header-card {

        background: linear-gradient(
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


    .staff-header-card h1 {

        font-size: 28px;

        font-weight: 700;

        margin-bottom: 6px;

    }


    .staff-header-card p {

        color: #f8ead8;

        margin-bottom: 0;

    }


    /* =====================================
       HEADER ICON
    ===================================== */

    .staff-header-icon {

        width: 60px;

        height: 60px;

        border-radius: 14px;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 28px;

        background-color:
            rgba(255, 255, 255, 0.15);

        color: white;

    }


    /* =====================================
       ADD STAFF BUTTON
    ===================================== */

    .btn-add-staff {

        background-color: #f7ead9;

        color: #6f4e37;

        border: none;

        font-weight: 600;

        padding: 10px 18px;

        border-radius: 10px;

        transition: all 0.2s ease;

    }


    .btn-add-staff:hover {

        background-color: white;

        color: #4e342e;

        transform: translateY(-1px);

    }


    /* =====================================
       SEARCH CARD
    ===================================== */

    .staff-search-card {

        border: none;

        border-radius: 16px;

        background-color: white;

        box-shadow:
            0 5px 20px
            rgba(111, 78, 55, 0.08);

    }


    .staff-search-card .card-body {

        padding: 22px;

    }


    /* =====================================
       SEARCH INPUT
    ===================================== */

    .staff-search-input {

        border-radius: 10px;

        border: 1px solid #e5d6c3;

        padding: 11px 15px;

    }


    .staff-search-input:focus {

        border-color: #8b5e3c;

        box-shadow:
            0 0 0 0.2rem
            rgba(139, 94, 60, 0.15);

    }


    /* =====================================
       SEARCH BUTTON
    ===================================== */

    .btn-staff-search {

        background-color: #6f4e37;

        border: none;

        color: white;

        padding: 11px;

        border-radius: 10px;

        font-weight: 600;

    }


    .btn-staff-search:hover {

        background-color: #4e342e;

        color: white;

    }


    /* =====================================
       STAFF TABLE CARD
    ===================================== */

    .staff-table-card {

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

    .staff-table-card thead {

        background-color: #f7f1e3;

    }


    .staff-table-card thead th {

        color: #6f4e37;

        font-weight: 700;

        padding: 16px;

        border-bottom:
            1px solid #e5d6c3;

    }


    /* =====================================
       TABLE BODY
    ===================================== */

    .staff-table-card tbody td {

        padding: 16px;

        vertical-align: middle;

        color: #4e342e;

    }


    .staff-table-card tbody tr {

        transition: all 0.2s ease;

    }


    .staff-table-card tbody tr:hover {

        background-color: #fcf8ef;

    }


    /* =====================================
       STAFF AVATAR
    ===================================== */

    .staff-avatar {

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

    }


    /* =====================================
       PHONE BADGE
    ===================================== */

    .staff-phone-badge {

        background-color: #fcf8ef;

        color: #6f4e37;

        border: 1px solid #e5d6c3;

        padding: 7px 12px;

        border-radius: 8px;

        font-weight: 500;

    }


    /* =====================================
       ACTION BUTTONS
    ===================================== */

    .staff-action-btn {

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


    /* VIEW */

    .staff-btn-view {

        background-color: #dbeafe;

        color: #2563eb;

    }


    .staff-btn-view:hover {

        background-color: #2563eb;

        color: white;

    }


    /* EDIT */

    .staff-btn-edit {

        background-color: #f7ead9;

        color: #8b5e3c;

    }


    .staff-btn-edit:hover {

        background-color: #8b5e3c;

        color: white;

    }


    /* DELETE */

    .staff-btn-delete {

        background-color: #fee2e2;

        color: #dc2626;

    }


    .staff-btn-delete:hover {

        background-color: #dc2626;

        color: white;

    }


    /* =====================================
       EMPTY STATE
    ===================================== */

    .staff-empty-state {

        padding: 50px 20px;

        text-align: center;

        color: #8b7355;

    }


    .staff-empty-state i {

        font-size: 50px;

        color: #d9c2a3;

        margin-bottom: 15px;

    }

</style>


<div class="staff-page">


    {{-- =====================================
         PAGE HEADER
    ===================================== --}}

    <div class="staff-header-card mb-4">

        <div class="d-flex justify-content-between align-items-center">


            <div class="d-flex align-items-center">


                <div class="staff-header-icon me-3">

                    <i class="bi bi-person-badge"></i>

                </div>


                <div>

                    <h1>

                        Staff

                    </h1>


                    <p>

                        Manage staff members who borrow library books.

                    </p>

                </div>


            </div>


            <a
                href="{{ route('staff.create') }}"
                class="btn btn-add-staff"
            >

                <i class="bi bi-person-plus me-1"></i>

                Add Staff

            </a>


        </div>

    </div>


    {{-- =====================================
         SEARCH
    ===================================== --}}

    <div class="card staff-search-card mb-4">

        <div class="card-body">


            <form method="GET">


                <div class="row g-2">


                    <div class="col-md-10">


                        <div class="input-group">


                            <span
                                class="input-group-text bg-white border-end-0"
                            >

                                <i
                                    class="bi bi-search text-muted"
                                ></i>

                            </span>


                            <input
                                type="text"
                                name="search"
                                class="form-control staff-search-input border-start-0"
                                value="{{ request('search') }}"
                                placeholder="Search by staff name or phone number"
                            >


                        </div>


                    </div>


                    <div class="col-md-2">


                        <button
                            type="submit"
                            class="btn btn-staff-search w-100"
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
         STAFF TABLE
    ===================================== --}}

    <div class="card staff-table-card">


        <div class="card-body p-0">


            <div class="table-responsive">


                <table
                    class="table table-hover align-middle mb-0"
                >


                    <thead>


                        <tr>


                            <th class="ps-4">

                                #

                            </th>


                            <th>

                                Staff Member

                            </th>


                            <th>

                                Phone Number

                            </th>


                            <th class="text-end pe-4">

                                Actions

                            </th>


                        </tr>


                    </thead>


                    <tbody>


                        @forelse($staff as $member)


                            <tr>


                                {{-- NUMBER --}}

                                <td class="ps-4">

                                    {{ $loop->iteration }}

                                </td>


                                {{-- STAFF NAME --}}

                                <td>


                                    <div
                                        class="d-flex align-items-center"
                                    >


                                        <div class="staff-avatar">

                                            <i class="bi bi-person-badge"></i>

                                        </div>


                                        <div>


                                            <strong>

                                                {{ $member->name }}

                                            </strong>


                                            <div
                                                class="text-muted small"
                                            >

                                                Library Borrower

                                            </div>


                                        </div>


                                    </div>


                                </td>


                                {{-- PHONE --}}

                                <td>


                                    <span
                                        class="staff-phone-badge"
                                    >

                                        <i
                                            class="bi bi-telephone me-1"
                                        ></i>

                                        {{ $member->phone }}

                                    </span>


                                </td>


                                {{-- ACTIONS --}}

                                <td
                                    class="text-end pe-4"
                                >


                                    {{-- VIEW --}}

                                    <a
                                        href="{{ route('staff.show', $member) }}"
                                        class="staff-action-btn staff-btn-view"
                                        title="View Staff Member"
                                    >

                                        <i
                                            class="bi bi-eye"
                                        ></i>

                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('staff.edit', $member) }}"
                                        class="staff-action-btn staff-btn-edit"
                                        title="Edit Staff Member"
                                    >

                                        <i
                                            class="bi bi-pencil"
                                        ></i>

                                    </a>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route('staff.destroy', $member) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this staff member?')"
                                    >


                                        @csrf


                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="staff-action-btn staff-btn-delete"
                                            title="Delete Staff Member"
                                        >

                                            <i
                                                class="bi bi-trash"
                                            ></i>

                                        </button>


                                    </form>


                                </td>


                            </tr>


                        @empty


                            <tr>


                                <td
                                    colspan="4"
                                >


                                    <div
                                        class="staff-empty-state"
                                    >


                                        <i
                                            class="bi bi-people d-block"
                                        ></i>


                                        <h5>

                                            No Staff Members Found

                                        </h5>


                                        <p class="mb-0">

                                            There are currently no staff
                                            members registered in the
                                            library system.

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