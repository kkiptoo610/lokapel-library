@extends('layouts.app')

@section('content')

<style>

    /* =========================================
       EDIT CATEGORY PAGE
    ========================================= */

    .category-page-header {
        background: linear-gradient(135deg, #5c3b22, #8b5e3c);
        color: white;
        padding: 25px 30px;
        border-radius: 14px;
        margin-bottom: 25px;
        box-shadow: 0 8px 20px rgba(92, 59, 34, 0.18);
    }


    .category-page-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }


    .category-page-header p {
        margin: 5px 0 0;
        color: #f5e6d3;
    }


    /* =========================================
       FORM CARD
    ========================================= */

    .category-form-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(92, 59, 34, 0.12);
    }


    /* =========================================
       CARD HEADER
    ========================================= */

    .category-form-card .card-header {
        background-color: #f3e3cd;
        border-bottom: 1px solid #dfc6a8;
        padding: 18px 25px;
    }


    .category-form-card .card-header h5 {
        margin: 0;
        color: #5c3b22;
        font-weight: 700;
    }


    .category-form-card .card-body {
        padding: 30px;
        background-color: #fffdf9;
    }


    /* =========================================
       ICON BOX
    ========================================= */

    .category-icon {
        width: 42px;
        height: 42px;
        background-color: #6f4528;
        color: white;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 20px;
    }


    /* =========================================
       FORM LABELS
    ========================================= */

    .category-form-card .form-label {
        color: #5c3b22;
        font-weight: 600;
    }


    /* =========================================
       FORM INPUTS
    ========================================= */

    .category-form-card .form-control {
        border: 1px solid #d8c2a8;
        padding: 11px 14px;
        border-radius: 8px;
    }


    .category-form-card .form-control:focus {
        border-color: #8b5e3c;
        box-shadow: 0 0 0 0.2rem rgba(139, 94, 60, 0.15);
    }


    /* =========================================
       SAVE BUTTON
    ========================================= */

    .btn-update-category {
        background-color: #6f4528;
        border-color: #6f4528;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }


    .btn-update-category:hover {
        background-color: #56331d;
        border-color: #56331d;
        color: white;
    }


    /* =========================================
       CANCEL BUTTON
    ========================================= */

    .btn-cancel-category {
        background-color: #ead7bd;
        border-color: #ead7bd;
        color: #5c3b22;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }


    .btn-cancel-category:hover {
        background-color: #ddc3a2;
        border-color: #ddc3a2;
        color: #4a2f1b;
    }


    /* =========================================
       CURRENT CATEGORY BOX
    ========================================= */

    .current-category-box {
        background-color: #f9f0e4;
        border: 1px solid #e2c9aa;
        border-radius: 10px;
        padding: 15px 18px;
        margin-bottom: 25px;
    }


    .current-category-box strong {
        color: #5c3b22;
    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 768px) {

        .category-page-header {
            padding: 20px;
        }


        .category-form-card .card-body {
            padding: 20px;
        }


        .category-page-header h1 {
            font-size: 24px;
        }

    }

</style>


<!-- =========================================
     PAGE HEADER
========================================= -->

<div class="category-page-header">

    <h1>

        <i class="bi bi-pencil-square me-2"></i>

        Edit Category

    </h1>


    <p>

        Update the information for this library category.

    </p>

</div>


<!-- =========================================
     EDIT CATEGORY FORM
========================================= -->

<div class="card category-form-card">


    <!-- CARD HEADER -->

    <div class="card-header d-flex align-items-center">


        <div class="category-icon">

            <i class="bi bi-tag-fill"></i>

        </div>


        <div>

            <h5>

                Category Information

            </h5>


            <small class="text-muted">

                Update the category details below.

            </small>

        </div>


    </div>


    <!-- CARD BODY -->

    <div class="card-body">


        <!-- CURRENT CATEGORY -->

        <div class="current-category-box">

            <strong>

                <i class="bi bi-info-circle me-1"></i>

                Currently Editing:

            </strong>

            {{ $category->name }}

        </div>


        <form
            action="{{ route('categories.update', $category) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <!-- CATEGORY NAME -->

            <div class="mb-4">

                <label class="form-label">

                    <i class="bi bi-tag me-1"></i>

                    Category Name

                </label>


                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}"
                    required
                >


                @error('name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <small class="text-muted">

                    Enter a clear and unique category name.

                </small>

            </div>


            <!-- DESCRIPTION -->

            <div class="mb-4">

                <label class="form-label">

                    <i class="bi bi-card-text me-1"></i>

                    Description

                </label>


                <textarea
                    name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="5"
                    placeholder="Optional category description"
                >{{ old('description', $category->description) }}</textarea>


                @error('description')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <small class="text-muted">

                    Add a short description to help identify this category.

                </small>

            </div>


            <!-- BUTTONS -->

            <div
                class="d-flex justify-content-between align-items-center pt-3 border-top"
            >


                <!-- BACK BUTTON -->

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-cancel-category"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Back to Categories

                </a>


                <!-- UPDATE BUTTON -->

                <button
                    type="submit"
                    class="btn btn-update-category"
                >

                    <i class="bi bi-save me-1"></i>

                    Update Category

                </button>


            </div>


        </form>


    </div>


</div>

@endsection