@extends('layouts.app')

@section('content')

<style>

    /* =========================================
       ADD CATEGORY PAGE
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


    /* =========================================
       CARD BODY
    ========================================= */

    .category-form-card .card-body {
        padding: 30px;
        background-color: #fffdf9;
    }


    /* =========================================
       FORM LABELS
    ========================================= */

    .category-form-card .form-label {
        color: #5c3b22;
        font-weight: 600;
    }


    /* =========================================
       INPUTS AND SELECT
    ========================================= */

    .category-form-card .form-control,
    .category-form-card .form-select {
        border: 1px solid #d8c2a8;
        padding: 11px 14px;
        border-radius: 8px;
    }


    .category-form-card .form-control:focus,
    .category-form-card .form-select:focus {
        border-color: #8b5e3c;
        box-shadow: 0 0 0 0.2rem rgba(139, 94, 60, 0.15);
    }


    /* =========================================
       SAVE BUTTON
    ========================================= */

    .btn-save-category {
        background-color: #6f4528;
        border-color: #6f4528;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
    }


    .btn-save-category:hover {
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
       CATEGORY TYPE INFO BOX
    ========================================= */

    .category-info-box {
        background-color: #f9f0e4;
        border-left: 4px solid #8b5e3c;
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 25px;
        color: #5c3b22;
    }


    .category-info-box strong {
        color: #5c3b22;
    }


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

        <i class="bi bi-tags-fill me-2"></i>

        Add Category

    </h1>


    <p>

        Create a main category or subcategory to organize your library books.

    </p>

</div>


<!-- =========================================
     CATEGORY FORM
========================================= -->

<div class="card category-form-card">


    <!-- CARD HEADER -->

    <div class="card-header d-flex align-items-center">

        <div class="category-icon">

            <i class="bi bi-folder-plus"></i>

        </div>


        <div>

            <h5>

                Category Information

            </h5>


            <small class="text-muted">

                Organize books using main categories and subcategories.

            </small>

        </div>

    </div>


    <!-- CARD BODY -->

    <div class="card-body">


        <!-- INFORMATION -->

        <div class="category-info-box">

            <i class="bi bi-info-circle-fill me-2"></i>

            <strong>Smart Category Structure:</strong>

            Leave the Parent Category empty to create a main category.
            Select an existing category to create a subcategory.

        </div>


        <form
            action="{{ route('categories.store') }}"
            method="POST"
        >

            @csrf


            <!-- =========================================
                 CATEGORY NAME
            ========================================= -->

            <div class="mb-4">

                <label class="form-label">

                    <i class="bi bi-tag me-1"></i>

                    Category Name

                </label>


                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Example: Biology"
                    required
                >


                @error('name')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <small class="text-muted">

                    Example: Sciences, Biology, English or Mathematics.

                </small>

            </div>


            <!-- =========================================
                 PARENT CATEGORY
            ========================================= -->

            <div class="mb-4">

                <label class="form-label">

                    <i class="bi bi-diagram-3 me-1"></i>

                    Parent Category

                </label>


                <select
                    name="parent_id"
                    class="form-select @error('parent_id') is-invalid @enderror"
                >

                    <option value="">

                        -- No Parent (Main Category) --

                    </option>


                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(old('parent_id') == $category->id)
                        >

                            {{ $category->name }}

                        </option>

                    @endforeach


                </select>


                @error('parent_id')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <small class="text-muted">

                    Example: Select "Sciences" when creating Biology,
                    Chemistry or Physics.

                </small>

            </div>


            <!-- =========================================
                 DESCRIPTION
            ========================================= -->

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
                >{{ old('description') }}</textarea>


                @error('description')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror


                <small class="text-muted">

                    Add a short description to help identify this category.

                </small>

            </div>


            <!-- =========================================
                 BUTTONS
            ========================================= -->

            <div
                class="d-flex justify-content-between align-items-center pt-3 border-top"
            >


                <!-- BACK -->

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-cancel-category"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Back to Categories

                </a>


                <!-- SAVE -->

                <button
                    type="submit"
                    class="btn btn-save-category"
                >

                    <i class="bi bi-save me-1"></i>

                    Save Category

                </button>


            </div>


        </form>


    </div>


</div>

@endsection