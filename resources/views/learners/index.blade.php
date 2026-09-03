@extends('layouts.app')

@section('content')

<div class="learners-page">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="learners-header mb-4">


        <div class="learners-title-area">


            <div class="learners-header-icon">

                <i class="bi bi-mortarboard-fill"></i>

            </div>


            <div>

                <h1>

                    Learners

                </h1>


                <p>

                    Manage learners and library borrowers.

                </p>

            </div>


        </div>



        <div class="header-actions">


            {{-- BATCH UPLOAD --}}

            <a
                href="{{ route('learners.import.form') }}"
                class="modern-upload-btn"
            >

                <i class="bi bi-file-earmark-arrow-up"></i>

                Batch Upload

            </a>



            {{-- ADD LEARNER --}}

            <a
                href="{{ route('learners.create') }}"
                class="modern-add-btn"
            >

                <i class="bi bi-person-plus-fill"></i>

                Add Learner

            </a>


        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- SUMMARY CARD --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">


        <div class="col-lg-6">


            <div class="learner-summary-card summary-blue">


                <div class="summary-content">


                    <span>

                        Total Learners

                    </span>


                    <h2>

                        {{ number_format($learners->count()) }}

                    </h2>


                    <small>

                        Learners currently displayed

                    </small>


                </div>


                <div class="summary-icon">

                    <i class="bi bi-mortarboard"></i>

                </div>


            </div>


        </div>



        <div class="col-lg-6">


            <div class="learner-summary-card summary-purple">


                <div class="summary-content">


                    <span>

                        Library Borrowers

                    </span>


                    <h2>

                        {{ number_format($learners->count()) }}

                    </h2>


                    <small>

                        Registered learner borrowers

                    </small>


                </div>


                <div class="summary-icon">

                    <i class="bi bi-people-fill"></i>

                </div>


            </div>


        </div>


    </div>



    {{-- ========================================================= --}}
    {{-- SEARCH SECTION --}}
    {{-- ========================================================= --}}

    <div class="modern-search-card mb-4">


        <form method="GET">


            <div class="search-title">


                <div class="search-title-icon">

                    <i class="bi bi-search"></i>

                </div>


                <div>

                    <h5>

                        Search Learners

                    </h5>


                    <p>

                        Find learners quickly using their details.

                    </p>

                </div>


            </div>



            <div class="row g-3">


                <div class="col-lg-10">


                    <div class="search-input-wrapper">


                        <i class="bi bi-search"></i>


                        <input
                            type="text"
                            name="search"
                            class="form-control modern-search-input"
                            value="{{ request('search') }}"
                            placeholder="Search by name, admission number, assessment number, class or stream"
                        >


                    </div>


                </div>



                <div class="col-lg-2">


                    <button
                        type="submit"
                        class="btn search-button w-100"
                    >

                        <i class="bi bi-search"></i>

                        Search

                    </button>


                </div>


            </div>


        </form>


    </div>



    {{-- ========================================================= --}}
    {{-- LEARNERS TABLE --}}
    {{-- ========================================================= --}}

    <div class="learners-table-card">


        {{-- TABLE HEADER --}}

        <div class="table-header">


            <div>


                <h4>

                    <i class="bi bi-people-fill"></i>

                    All Learners

                </h4>


                <p>

                    View and manage registered library learners.

                </p>


            </div>


            <div class="learner-count">

                <i class="bi bi-people"></i>

                {{ number_format($learners->count()) }}

                Learners

            </div>


        </div>



        <div class="table-responsive">


            <table class="table learners-table align-middle mb-0">


                <thead>


                    <tr>


                        <th>

                            #

                        </th>


                        <th>

                            Learner

                        </th>


                        <th>

                            Admission No.

                        </th>


                        <th>

                            Assessment No.

                        </th>


                        <th>

                            Class

                        </th>


                        <th>

                            Stream

                        </th>


                        <th class="text-end">

                            Actions

                        </th>


                    </tr>


                </thead>



                <tbody>


                    @forelse($learners as $learner)


                        <tr>


                            {{-- NUMBER --}}

                            <td>


                                <div class="learner-number">

                                    {{ $loop->iteration }}

                                </div>


                            </td>



                            {{-- LEARNER NAME --}}

                            <td>


                                <div class="learner-profile">


                                    <div class="learner-avatar">

                                        <i class="bi bi-person-fill"></i>

                                    </div>


                                    <div>


                                        <strong>

                                            {{ $learner->name }}

                                        </strong>


                                        <small>

                                            Library Learner

                                        </small>


                                    </div>


                                </div>


                            </td>



                            {{-- ADMISSION NUMBER --}}

                            <td>


                                <span class="admission-number">

                                    <i class="bi bi-card-heading"></i>

                                    {{ $learner->admission_number }}

                                </span>


                            </td>



                            {{-- ASSESSMENT NUMBER --}}

                            <td>


                                @if($learner->assessment_number)


                                    <span class="assessment-number">

                                        {{ $learner->assessment_number }}

                                    </span>


                                @else


                                    <span class="missing-value">

                                        Not provided

                                    </span>


                                @endif


                            </td>



                            {{-- CLASS --}}

                            <td>


                                <span class="class-badge">

                                    <i class="bi bi-building"></i>

                                    {{ $learner->grade_class }}

                                </span>


                            </td>



                            {{-- STREAM --}}

                            <td>


                                <span class="stream-badge">

                                    {{ $learner->stream }}

                                </span>


                            </td>



                            {{-- ACTIONS --}}

                            <td class="text-end">


                                {{-- VIEW --}}

                                <a
                                    href="{{ route('learners.show', $learner) }}"
                                    class="learner-action action-view"
                                    title="View Learner"
                                >

                                    <i class="bi bi-eye-fill"></i>

                                </a>



                                {{-- EDIT --}}

                                <a
                                    href="{{ route('learners.edit', $learner) }}"
                                    class="learner-action action-edit"
                                    title="Edit Learner"
                                >

                                    <i class="bi bi-pencil-square"></i>

                                </a>



                                {{-- DELETE --}}

                                <form
                                    action="{{ route('learners.destroy', $learner) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this learner?')"
                                >


                                    @csrf


                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="learner-action action-delete"
                                        title="Delete Learner"
                                    >

                                        <i class="bi bi-trash-fill"></i>

                                    </button>


                                </form>


                            </td>


                        </tr>


                    @empty


                        <tr>


                            <td
                                colspan="7"
                                class="empty-learners-cell"
                            >


                                <div class="empty-learners-state">


                                    <div class="empty-learners-icon">

                                        <i class="bi bi-mortarboard"></i>

                                    </div>


                                    <h5>

                                        No Learners Found

                                    </h5>


                                    <p>

                                        Add your first learner or upload
                                        learners using the batch upload feature.

                                    </p>


                                    <div class="empty-actions">


                                        <a
                                            href="{{ route('learners.create') }}"
                                            class="btn btn-primary"
                                        >

                                            <i class="bi bi-person-plus"></i>

                                            Add Learner

                                        </a>


                                        <a
                                            href="{{ route('learners.import.form') }}"
                                            class="btn btn-outline-success"
                                        >

                                            <i class="bi bi-file-earmark-arrow-up"></i>

                                            Batch Upload

                                        </a>


                                    </div>


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
{{-- LEARNERS PAGE STYLING --}}
{{-- ========================================================= --}}

<style>


/* ========================================================= */
/* PAGE */
/* ========================================================= */

.learners-page {

    padding-bottom: 30px;

}



/* ========================================================= */
/* HEADER */
/* ========================================================= */

.learners-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 26px 30px;

    border-radius: 18px;

    background:

        linear-gradient(
            135deg,
            #0f3d6e,
            #1558a6,
            #2575d7
        );

    box-shadow:

        0 12px 30px
        rgba(
            21,
            88,
            166,
            0.20
        );

}


.learners-title-area {

    display: flex;

    align-items: center;

    gap: 18px;

}


.learners-header-icon {

    width: 64px;

    height: 64px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 18px;

    font-size: 28px;

    color: white;

    background:

        rgba(
            255,
            255,
            255,
            0.18
        );

}


.learners-header h1 {

    margin: 0;

    color: white;

    font-size: 29px;

    font-weight: 700;

}


.learners-header p {

    margin: 5px 0 0;

    color:

        rgba(
            255,
            255,
            255,
            0.82
        );

}



/* ========================================================= */
/* HEADER BUTTONS */
/* ========================================================= */

.header-actions {

    display: flex;

    gap: 10px;

}


.modern-upload-btn {

    padding: 11px 17px;

    border-radius: 10px;

    text-decoration: none;

    font-weight: 600;

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
            0.25
        );

    transition:

        transform 0.2s ease,
        background 0.2s ease;

}


.modern-upload-btn:hover {

    color: white;

    transform:

        translateY(-2px);

    background:

        rgba(
            255,
            255,
            255,
            0.25
        );

}


.modern-add-btn {

    padding: 11px 18px;

    border-radius: 10px;

    text-decoration: none;

    font-weight: 600;

    color: #1558a6;

    background: white;

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.modern-add-btn:hover {

    color: #0f3d6e;

    transform:

        translateY(-2px);

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
/* SUMMARY CARDS */
/* ========================================================= */

.learner-summary-card {

    min-height: 145px;

    border-radius: 17px;

    padding: 24px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    color: white;

    overflow: hidden;

    transition:

        transform 0.25s ease,
        box-shadow 0.25s ease;

}


.learner-summary-card:hover {

    transform:

        translateY(-5px);

    box-shadow:

        0 16px 32px
        rgba(
            0,
            0,
            0,
            0.15
        );

}


.summary-blue {

    background:

        linear-gradient(
            135deg,
            #1769e0,
            #3f8cff
        );

}


.summary-purple {

    background:

        linear-gradient(
            135deg,
            #6d28d9,
            #a855f7
        );

}


.summary-content span {

    font-size: 15px;

    opacity: 0.9;

}


.summary-content h2 {

    margin:

        5px 0;

    font-size: 36px;

    font-weight: 700;

}


.summary-content small {

    opacity: 0.82;

}


.summary-icon {

    font-size: 60px;

    opacity: 0.25;

}



/* ========================================================= */
/* SEARCH CARD */
/* ========================================================= */

.modern-search-card {

    background: white;

    padding: 24px;

    border-radius: 18px;

    box-shadow:

        0 6px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}


.search-title {

    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 18px;

}


.search-title-icon {

    width: 42px;

    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    background: #eef5ff;

    color: #2575d7;

}


.search-title h5 {

    margin: 0;

    font-weight: 700;

    color: #253858;

}


.search-title p {

    margin:

        3px 0 0;

    color: #8a94a6;

    font-size: 13px;

}


.search-input-wrapper {

    position: relative;

}


.search-input-wrapper > i {

    position: absolute;

    left: 16px;

    top: 50%;

    transform:

        translateY(-50%);

    color: #94a3b8;

}


.modern-search-input {

    height: 48px;

    padding-left: 45px;

    border-radius: 12px;

    border:

        1px solid #e2e8f0;

}


.modern-search-input:focus {

    border-color: #2575d7;

    box-shadow:

        0 0 0 0.2rem
        rgba(
            37,
            117,
            215,
            0.12
        );

}


.search-button {

    height: 48px;

    border-radius: 12px;

    color: white;

    font-weight: 600;

    background:

        linear-gradient(
            135deg,
            #1769e0,
            #2575d7
        );

    border: none;

}


.search-button:hover {

    color: white;

    background:

        linear-gradient(
            135deg,
            #1558a6,
            #1769e0
        );

}



/* ========================================================= */
/* TABLE CARD */
/* ========================================================= */

.learners-table-card {

    background: white;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:

        0 8px 25px
        rgba(
            0,
            0,
            0,
            0.06
        );

}



/* ========================================================= */
/* TABLE HEADER */
/* ========================================================= */

.table-header {

    padding:

        24px 25px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    border-bottom:

        1px solid #edf0f5;

}


.table-header h4 {

    margin: 0;

    color: #253858;

    font-weight: 700;

}


.table-header h4 i {

    color: #2575d7;

}


.table-header p {

    margin:

        5px 0 0;

    color: #8a94a6;

}


.learner-count {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding:

        8px 14px;

    border-radius: 20px;

    background: #eef5ff;

    color: #1769e0;

    font-size: 13px;

    font-weight: 600;

}



/* ========================================================= */
/* TABLE */
/* ========================================================= */

.learners-table thead {

    background: #f7f9fc;

}


.learners-table th {

    border: none;

    padding:

        16px 18px;

    color: #64748b;

    font-size: 13px;

    font-weight: 600;

}


.learners-table td {

    padding:

        17px 18px;

    border-color: #edf0f5;

}


.learners-table tbody tr {

    transition:

        background 0.2s ease;

}


.learners-table tbody tr:hover {

    background: #fafcff;

}



/* ========================================================= */
/* NUMBER */
/* ========================================================= */

.learner-number {

    width: 32px;

    height: 32px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    background: #f1f5f9;

    color: #64748b;

    font-size: 13px;

    font-weight: 600;

}



/* ========================================================= */
/* LEARNER PROFILE */
/* ========================================================= */

.learner-profile {

    display: flex;

    align-items: center;

    gap: 12px;

}


.learner-avatar {

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


.learner-profile strong {

    display: block;

    color: #253858;

}


.learner-profile small {

    display: block;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 12px;

}



/* ========================================================= */
/* ADMISSION NUMBER */
/* ========================================================= */

.admission-number {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    color: #475569;

    font-weight: 500;

}


.admission-number i {

    color: #2575d7;

}



/* ========================================================= */
/* ASSESSMENT NUMBER */
/* ========================================================= */

.assessment-number {

    color: #64748b;

}


.missing-value {

    color: #a0aec0;

    font-size: 13px;

    font-style: italic;

}



/* ========================================================= */
/* CLASS BADGE */
/* ========================================================= */

.class-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding:

        7px 12px;

    border-radius: 20px;

    background: #f0e8ff;

    color: #7c3aed;

    font-size: 12px;

    font-weight: 600;

}


.stream-badge {

    display: inline-block;

    padding:

        7px 13px;

    border-radius: 20px;

    background: #e4f8ee;

    color: #16834d;

    font-size: 12px;

    font-weight: 600;

}



/* ========================================================= */
/* ACTION BUTTONS */
/* ========================================================= */

.learner-action {

    width: 36px;

    height: 36px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border-radius: 10px;

    border: none;

    text-decoration: none;

    margin-left: 5px;

    transition:

        transform 0.2s ease,
        box-shadow 0.2s ease;

}


.learner-action:hover {

    transform:

        translateY(-2px);

}


.action-view {

    background: #e7f0ff;

    color: #1769e0;

}


.action-view:hover {

    background: #d6e7ff;

    color: #0f4fa8;

}


.action-edit {

    background: #fff4d6;

    color: #d97706;

}


.action-edit:hover {

    background: #ffe8a3;

    color: #b45309;

}


.action-delete {

    background: #ffe5e5;

    color: #dc2626;

}


.action-delete:hover {

    background: #ffd0d0;

    color: #b91c1c;

}



/* ========================================================= */
/* EMPTY STATE */
/* ========================================================= */

.empty-learners-cell {

    padding:

        55px !important;

}


.empty-learners-state {

    text-align: center;

}


.empty-learners-icon {

    width: 70px;

    height: 70px;

    margin:

        0 auto 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 20px;

    background: #eef5ff;

    color: #2575d7;

    font-size: 30px;

}


.empty-learners-state h5 {

    color: #253858;

    font-weight: 700;

}


.empty-learners-state p {

    color: #8a94a6;

}


.empty-actions {

    display: flex;

    justify-content: center;

    gap: 10px;

    margin-top: 15px;

}



/* ========================================================= */
/* RESPONSIVE */
/* ========================================================= */

@media (max-width: 768px) {


    .learners-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 20px;

    }


    .header-actions {

        width: 100%;

        flex-direction: column;

    }


    .modern-upload-btn,
    .modern-add-btn {

        width: 100%;

        text-align: center;

    }


    .table-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .learner-count {

        width: 100%;

        justify-content: center;

    }


    .empty-actions {

        flex-direction: column;

    }


}


</style>

@endsection