@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h1>Batch Upload Learners</h1>

    <p class="text-muted">
        Select the class and stream, then upload a CSV file containing learners.
    </p>

</div>


@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

@endif


<div class="card shadow-sm">

    <div class="card-body">

        <div class="alert alert-info">

            <strong>CSV Format:</strong>

            Your CSV file must contain:

            <br><br>

            <code>
                name,admission_number,assessment_number
            </code>

            <br><br>

            Assessment Number is optional.

            <br>

            The selected Class and Stream will automatically be assigned to all learners in the uploaded file.

        </div>


        <a
            href="{{ route('learners.template.download') }}"
            class="btn btn-outline-primary mb-4"
        >

            <i class="bi bi-download"></i>

            Download CSV Template

        </a>


        <form
            action="{{ route('learners.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="row">


                <!-- Class / Grade Dropdown -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Select Class / Grade
                    </label>

                    <select
                        name="grade_class"
                        class="form-select @error('grade_class') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Class / Grade
                        </option>

                        <option
                            value="Grade 10"
                            @selected(old('grade_class') === 'Grade 10')
                        >
                            Grade 10
                        </option>

                        <option
                            value="Grade 11"
                            @selected(old('grade_class') === 'Grade 11')
                        >
                            Grade 11
                        </option>

                        <option
                            value="Grade 12"
                            @selected(old('grade_class') === 'Grade 12')
                        >
                            Grade 12
                        </option>

                        <option
                            value="Form 3"
                            @selected(old('grade_class') === 'Form 3')
                        >
                            Form 3
                        </option>

                        <option
                            value="Form 4"
                            @selected(old('grade_class') === 'Form 4')
                        >
                            Form 4
                        </option>

                    </select>

                    @error('grade_class')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Stream -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Select Stream
                    </label>

                    <select
                        name="stream"
                        class="form-select @error('stream') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Stream
                        </option>

                        <option
                            value="East"
                            @selected(old('stream') === 'East')
                        >
                            East
                        </option>

                        <option
                            value="West"
                            @selected(old('stream') === 'West')
                        >
                            West
                        </option>

                    </select>

                    @error('stream')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- CSV File -->

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Select CSV File
                    </label>

                    <input
                        type="file"
                        name="csv_file"
                        class="form-control @error('csv_file') is-invalid @enderror"
                        accept=".csv,.txt"
                        required
                    >

                    @error('csv_file')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


            </div>


            <button
                type="submit"
                class="btn btn-success"
            >

                <i class="bi bi-upload"></i>

                Upload Learners

            </button>


            <a
                href="{{ route('learners.index') }}"
                class="btn btn-secondary"
            >

                Cancel

            </a>


        </form>

    </div>

</div>

@endsection