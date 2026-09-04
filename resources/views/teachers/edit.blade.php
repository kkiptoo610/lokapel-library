@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="mb-1">
            Edit Teacher
        </h1>

        <p class="text-muted mb-0">
            Update teacher information.
        </p>

    </div>


    <a
        href="{{ route('teachers.index') }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left"></i>

        Back to Teachers

    </a>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <form
            action="{{ route('teachers.update', $teacher) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="row">


                <!-- Teacher Name -->

                <div class="col-md-6 mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >

                        Teacher Name

                    </label>


                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $teacher->name) }}"
                        required
                    >


                    @error('name')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- Phone Number -->

                <div class="col-md-6 mb-3">

                    <label
                        for="phone"
                        class="form-label"
                    >

                        Phone Number

                    </label>


                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $teacher->phone) }}"
                        required
                    >


                    @error('phone')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- Department -->

                <div class="col-md-6 mb-3">

                    <label
                        for="department"
                        class="form-label"
                    >

                        Department

                    </label>


                    <select
                        id="department"
                        name="department"
                        class="form-select @error('department') is-invalid @enderror"
                    >

                        <option value="">

                            Select Department

                        </option>


                        <option
                            value="Administration"
                            @selected(old('department', $teacher->department) === 'Administration')
                        >
                            Administration
                        </option>


                        <option
                            value="Mathematics"
                            @selected(old('department', $teacher->department) === 'Mathematics')
                        >
                            Mathematics
                        </option>


                        <option
                            value="Sciences"
                            @selected(old('department', $teacher->department) === 'Sciences')
                        >
                            Sciences
                        </option>


                        <option
                            value="Languages"
                            @selected(old('department', $teacher->department) === 'Languages')
                        >
                            Languages
                        </option>


                        <option
                            value="Humanities"
                            @selected(old('department', $teacher->department) === 'Humanities')
                        >
                            Humanities
                        </option>


                        <option
                            value="Technical"
                            @selected(old('department', $teacher->department) === 'Technical')
                        >
                            Technical
                        </option>


                        <option
                            value="Creative Arts"
                            @selected(old('department', $teacher->department) === 'Creative Arts')
                        >
                            Creative Arts
                        </option>


                        <option
                            value="Physical Education"
                            @selected(old('department', $teacher->department) === 'Physical Education')
                        >
                            Physical Education
                        </option>


                        <option
                            value="Library"
                            @selected(old('department', $teacher->department) === 'Library')
                        >
                            Library
                        </option>


                        <option
                            value="Other"
                            @selected(old('department', $teacher->department) === 'Other')
                        >
                            Other
                        </option>

                    </select>


                    @error('department')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                <!-- Position / Designation -->

                <div class="col-md-6 mb-3">

                    <label
                        for="position"
                        class="form-label"
                    >

                        Position / Designation

                    </label>


                    <select
                        id="position"
                        name="position"
                        class="form-select @error('position') is-invalid @enderror"
                    >

                        <option value="">

                            Select Position

                        </option>


                        <option
                            value="Principal"
                            @selected(old('position', $teacher->position) === 'Principal')
                        >
                            Principal
                        </option>


                        <option
                            value="Deputy Principal"
                            @selected(old('position', $teacher->position) === 'Deputy Principal')
                        >
                            Deputy Principal
                        </option>


                        <option
                            value="Director of Studies (D.O.S)"
                            @selected(old('position', $teacher->position) === 'Director of Studies (D.O.S)')
                        >
                            Director of Studies (D.O.S)
                        </option>


                        <option
                            value="Senior Teacher"
                            @selected(old('position', $teacher->position) === 'Senior Teacher')
                        >
                            Senior Teacher
                        </option>


                        <option
                            value="Head of Department"
                            @selected(old('position', $teacher->position) === 'Head of Department')
                        >
                            Head of Department (HOD)
                        </option>


                        <option
                            value="Class Teacher"
                            @selected(old('position', $teacher->position) === 'Class Teacher')
                        >
                            Class Teacher
                        </option>


                        <option
                            value="Teacher"
                            @selected(old('position', $teacher->position) === 'Teacher')
                        >
                            Teacher
                        </option>


                        <option
                            value="Librarian"
                            @selected(old('position', $teacher->position) === 'Librarian')
                        >
                            Librarian
                        </option>


                        <option
                            value="Other"
                            @selected(old('position', $teacher->position) === 'Other')
                        >
                            Other
                        </option>

                    </select>


                    @error('position')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


            </div>


            <!-- Buttons -->

            <div class="d-flex gap-2 mt-3">

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="bi bi-save"></i>

                    Update Teacher

                </button>


                <a
                    href="{{ route('teachers.index') }}"
                    class="btn btn-secondary"
                >

                    <i class="bi bi-x-circle"></i>

                    Cancel

                </a>

            </div>


        </form>

    </div>

</div>

@endsection