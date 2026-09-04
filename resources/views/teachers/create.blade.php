@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="mb-1">
            Add Teacher
        </h1>

        <p class="text-muted mb-0">
            Register a teacher as a library borrower.
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
            action="{{ route('teachers.store') }}"
            method="POST"
        >

            @csrf


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
                        value="{{ old('name') }}"
                        placeholder="Enter teacher's full name"
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
                        value="{{ old('phone') }}"
                        placeholder="Example: 0712345678"
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
                            @selected(old('department') === 'Administration')
                        >

                            Administration

                        </option>


                        <option
                            value="Mathematics"
                            @selected(old('department') === 'Mathematics')
                        >

                            Mathematics

                        </option>


                        <option
                            value="Sciences"
                            @selected(old('department') === 'Sciences')
                        >

                            Sciences

                        </option>


                        <option
                            value="Languages"
                            @selected(old('department') === 'Languages')
                        >

                            Languages

                        </option>


                        <option
                            value="Humanities"
                            @selected(old('department') === 'Humanities')
                        >

                            Humanities

                        </option>


                        <option
                            value="Technical"
                            @selected(old('department') === 'Technical')
                        >

                            Technical

                        </option>


                        <option
                            value="Creative Arts"
                            @selected(old('department') === 'Creative Arts')
                        >

                            Creative Arts

                        </option>


                        <option
                            value="Physical Education"
                            @selected(old('department') === 'Physical Education')
                        >

                            Physical Education

                        </option>


                        <option
                            value="Library"
                            @selected(old('department') === 'Library')
                        >

                            Library

                        </option>


                        <option
                            value="Other"
                            @selected(old('department') === 'Other')
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


                <!-- Position -->

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
                            @selected(old('position') === 'Principal')
                        >

                            Principal

                        </option>


                        <option
                            value="Deputy Principal"
                            @selected(old('position') === 'Deputy Principal')
                        >

                            Deputy Principal

                        </option>


                        <option
                            value="Director of Studies (D.O.S)"
                            @selected(old('position') === 'Director of Studies (D.O.S)')
                        >

                            Director of Studies (D.O.S)

                        </option>


                        <option
                            value="Senior Teacher"
                            @selected(old('position') === 'Senior Teacher')
                        >

                            Senior Teacher

                        </option>


                        <option
                            value="Head of Department"
                            @selected(old('position') === 'Head of Department')
                        >

                            Head of Department (HOD)

                        </option>


                        <option
                            value="Class Teacher"
                            @selected(old('position') === 'Class Teacher')
                        >

                            Class Teacher

                        </option>


                        <option
                            value="Teacher"
                            @selected(old('position') === 'Teacher')
                        >

                            Teacher

                        </option>


                        <option
                            value="Librarian"
                            @selected(old('position') === 'Librarian')
                        >

                            Librarian

                        </option>


                        <option
                            value="Other"
                            @selected(old('position') === 'Other')
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

                    Save Teacher

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