@extends('layouts.app')

@section('content')

<div class="mb-4">


<h1>Edit Teacher</h1>

<p class="text-muted">
    Update teacher information.
</p>


</div>

<div class="card shadow-sm">


<div class="card-body">

    <form
        action="{{ route('teachers.update', $teacher) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <!-- Teacher Name -->

        <div class="mb-3">

            <label class="form-label">

                Teacher Name

            </label>


            <input
                type="text"
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

        <div class="mb-3">

            <label class="form-label">

                Phone Number

            </label>


            <input
                type="text"
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


        <!-- Buttons -->

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

            Cancel

        </a>


    </form>

</div>


</div>

@endsection
