@extends('layouts.app')

@section('content')

<div class="mb-4">


<h1>Edit Staff Member</h1>

<p class="text-muted">
    Update staff member information.
</p>


</div>

<div class="card shadow-sm">


<div class="card-body">

    <form
        action="{{ route('staff.update', $staff) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <!-- Staff Name -->

        <div class="mb-3">

            <label class="form-label">

                Staff Name

            </label>


            <input
                type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $staff->name) }}"
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
                value="{{ old('phone', $staff->phone) }}"
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

            Update Staff Member

        </button>


        <a
            href="{{ route('staff.index') }}"
            class="btn btn-secondary"
        >

            Cancel

        </a>


    </form>

</div>


</div>

@endsection
