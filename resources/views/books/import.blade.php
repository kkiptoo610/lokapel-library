@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Import Books</h1>

        <p class="text-muted mb-0">

            Import multiple books using a CSV file.

        </p>

    </div>


    <a
        href="{{ route('books.index') }}"
        class="btn btn-secondary"
    >

        <i class="bi bi-arrow-left"></i>

        Back to Books

    </a>

</div>


{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div class="alert alert-success">

        <i class="bi bi-check-circle"></i>

        {{ session('success') }}

    </div>

@endif


{{-- ========================================================= --}}
{{-- ERROR MESSAGE --}}
{{-- ========================================================= --}}

@if(session('error'))

    <div class="alert alert-danger">

        <i class="bi bi-exclamation-triangle"></i>

        {{ session('error') }}

    </div>

@endif


{{-- ========================================================= --}}
{{-- VALIDATION ERRORS --}}
{{-- ========================================================= --}}

@if($errors->any())

    <div class="alert alert-danger">

        <strong>

            Please correct the following errors:

        </strong>


        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>

                    {{ $error }}

                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- ========================================================= --}}
{{-- IMPORT FORM --}}
{{-- ========================================================= --}}

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <form
            action="{{ route('books.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- ========================================================= --}}
            {{-- FILE --}}
            {{-- ========================================================= --}}

            <div class="mb-4">

                <label
                    for="file"
                    class="form-label"
                >

                    Select Import File

                    <span class="text-danger">

                        *

                    </span>

                </label>


                <input
                    type="file"
                    id="file"
                    name="file"
                    class="form-control @error('file') is-invalid @enderror"
                    accept=".csv,text/csv"
                    required
                >


                <small class="text-muted">

                    Supported format:
                    CSV.

                </small>


                @error('file')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                @enderror

            </div>


            {{-- ========================================================= --}}
            {{-- IMPORTANT INFORMATION --}}
            {{-- ========================================================= --}}

            <div class="alert alert-info mb-4">

                <div class="d-flex">

                    <div class="me-2">

                        <i class="bi bi-info-circle"></i>

                    </div>


                    <div>

                        <strong>

                            How the import works

                        </strong>


                        <ul class="mb-0 mt-2">

                            <li>

                                Categories and subcategories must already
                                exist in the system.

                            </li>

                            <li>

                                The subcategory must belong to the selected
                                category.

                            </li>

                            <li>

                                Each Book Code must be unique.

                            </li>

                            <li>

                                The system automatically creates the
                                requested number of physical copies.

                            </li>

                            <li>

                                Accession numbers are automatically generated.

                            </li>

                            <li>

                                Individual copy numbers are automatically
                                generated from the Book Code.

                            </li>

                            <li>

                                Author is optional.

                            </li>

                        </ul>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- BUTTONS --}}
            {{-- ========================================================= --}}

            <div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-upload"></i>

                    Import Books

                </button>


                <a
                    href="{{ route('books.template.download') }}"
                    class="btn btn-outline-success"
                >

                    <i class="bi bi-download"></i>

                    Download CSV Template

                </a>


                <a
                    href="{{ route('books.index') }}"
                    class="btn btn-secondary"
                >

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- IMPORT TEMPLATE --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">

    <div class="card-header">

        <strong>

            Import File Template

        </strong>

    </div>


    <div class="card-body">


        <p class="text-muted">

            Your CSV file must contain the following columns.

        </p>


        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>

                            Title

                        </th>

                        <th>

                            Book Code

                        </th>

                        <th>

                            Category

                        </th>

                        <th>

                            Subcategory

                        </th>

                        <th>

                            Shelf

                        </th>

                        <th>

                            Author

                            <span class="text-muted">

                                (Optional)

                            </span>

                        </th>

                        <th>

                            Copies

                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>

                            Mathematics

                        </td>

                        <td>

                            MATH-G10

                        </td>

                        <td>

                            Mathematics

                        </td>

                        <td>

                            Core Mathe

                        </td>

                        <td>

                            A-01

                        </td>

                        <td>

                            Kiptoo Kelvin

                        </td>

                        <td>

                            3

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <div class="alert alert-warning mb-0">

            <i class="bi bi-exclamation-triangle"></i>

            <strong>

                Important:

            </strong>

            The column names must match the template exactly.

        </div>

    </div>

</div>

@endsection