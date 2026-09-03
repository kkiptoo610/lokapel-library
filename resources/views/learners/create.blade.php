@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h1>Add Learner</h1>

    <p class="text-muted">
        Add one learner manually.
    </p>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <form
            action="{{ route('learners.store') }}"
            method="POST"
        >

            @csrf


            <div class="row">


                <!-- Name -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Learner Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Admission Number -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Admission Number
                    </label>

                    <input
                        type="text"
                        name="admission_number"
                        class="form-control @error('admission_number') is-invalid @enderror"
                        value="{{ old('admission_number') }}"
                        required
                    >

                    @error('admission_number')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Assessment Number -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Assessment Number

                        <small class="text-muted">
                            (Optional)
                        </small>

                    </label>

                    <input
                        type="text"
                        name="assessment_number"
                        class="form-control @error('assessment_number') is-invalid @enderror"
                        value="{{ old('assessment_number') }}"
                    >

                    @error('assessment_number')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Class / Grade -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Class / Grade
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
                        Stream
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


            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="bi bi-save"></i>

                Save Learner

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