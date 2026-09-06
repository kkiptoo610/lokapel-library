@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-arrow-up-right-circle"></i>

        </div>

        <div>

            <h1>Issue Inventory Item</h1>

            <p>

                Issue {{ $item->name }} to a teacher, department or recipient.

            </p>

        </div>

    </div>


    <a
        href="{{ route('inventory.items.show', $item) }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-2"></i>

        Back

    </a>

</div>


<div class="row g-4">


    {{-- ITEM INFORMATION --}}

    <div class="col-lg-4">

        <div class="modern-page-card">

            <div class="card-body p-4">


                <h5>

                    {{ $item->name }}

                </h5>


                <p class="text-muted">

                    {{ $item->category?->name }}

                </p>


                <hr>


                <div class="text-muted small">

                    Available Quantity

                </div>


                <div class="fw-bold fs-2 text-primary">

                    {{ $item->quantity }}

                </div>


                <div class="text-muted">

                    {{ $item->unit }}

                </div>


            </div>

        </div>

    </div>


    {{-- ISSUE FORM --}}

    <div class="col-lg-8">

        <div class="modern-page-card">

            <div class="card-body p-4 p-md-5">


                {{-- VALIDATION ERRORS --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>

                                    {{ $error }}

                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route('inventory.items.issue.store', $item) }}"
                    method="POST"
                >

                    @csrf


                    <div class="row g-4">


                        {{-- TEACHER --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Teacher

                                <span class="text-muted">

                                    (Optional)

                                </span>

                            </label>


                            <select
                                name="teacher_id"
                                class="form-select"
                            >

                                <option value="">

                                    Select teacher

                                </option>


                                @foreach ($teachers as $teacher)

                                    <option
                                        value="{{ $teacher->id }}"
                                        @selected(
                                            old('teacher_id') == $teacher->id
                                        )
                                    >

                                        {{ $teacher->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- DEPARTMENT SEARCHABLE DROPDOWN --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Department / Recipient

                                <span class="text-muted">

                                    (Optional)

                                </span>

                            </label>


                            {{--

                                This hidden input is the actual field
                                submitted to the controller.

                            --}}

                            <input
                                type="hidden"
                                name="department"
                                id="department"
                                value="{{ old('department') }}"
                            >


                            <div class="position-relative">


                                {{-- SEARCH INPUT --}}

                                <input
                                    type="text"
                                    id="departmentSearch"
                                    class="form-control"
                                    placeholder="Search department..."
                                    autocomplete="off"
                                    value="{{ old('department') }}"
                                >


                                {{-- DEPARTMENT DROPDOWN --}}

                                <div
                                    id="departmentDropdown"
                                    class="list-group position-absolute w-100 shadow-sm"
                                    style="
                                        display: none;
                                        max-height: 250px;
                                        overflow-y: auto;
                                        z-index: 1050;
                                    "
                                >

                                    @foreach ($departments as $department)

                                        <button
                                            type="button"
                                            class="list-group-item list-group-item-action department-option"
                                            data-value="{{ $department }}"
                                        >

                                            {{ $department }}

                                        </button>

                                    @endforeach

                                </div>


                            </div>


                            <div class="form-text">

                                Start typing to search for a department.

                            </div>


                        </div>


                        {{-- QUANTITY --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Quantity to Issue

                            </label>


                            <input
                                type="number"
                                name="quantity"
                                value="{{ old('quantity') }}"
                                min="1"
                                max="{{ $item->quantity }}"
                                class="form-control"
                                required
                            >


                            <div class="form-text">

                                Maximum available:
                                {{ $item->quantity }}

                            </div>


                        </div>


                        {{-- ISSUE DATE --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Issue Date

                            </label>


                            <input
                                type="date"
                                name="issued_date"
                                value="{{ old('issued_date', now()->format('Y-m-d')) }}"
                                class="form-control"
                                required
                            >


                        </div>


                        {{-- REMARKS --}}

                        <div class="col-12">

                            <label class="form-label fw-semibold">

                                Remarks

                            </label>


                            <textarea
                                name="remarks"
                                rows="4"
                                class="form-control"
                                placeholder="Optional notes about this issue..."
                            >{{ old('remarks') }}</textarea>


                        </div>


                        {{-- FORM BUTTONS --}}

                        <div class="col-12">

                            <div class="d-flex justify-content-end gap-2">


                                <a
                                    href="{{ route('inventory.items.show', $item) }}"
                                    class="btn btn-outline-secondary"
                                >

                                    Cancel

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >

                                    <i class="bi bi-check-circle me-2"></i>

                                    Issue Item

                                </button>


                            </div>

                        </div>


                    </div>


                </form>


            </div>

        </div>

    </div>


</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const departmentSearch =
            document.getElementById(
                'departmentSearch'
            );


        const departmentDropdown =
            document.getElementById(
                'departmentDropdown'
            );


        const departmentInput =
            document.getElementById(
                'department'
            );


        const departmentOptions =
            document.querySelectorAll(
                '.department-option'
            );


        /*
        |--------------------------------------------------------------------------
        | SHOW DROPDOWN WHEN INPUT IS CLICKED
        |--------------------------------------------------------------------------
        */

        departmentSearch.addEventListener(
            'focus',
            function () {

                let visibleCount = 0;


                departmentOptions.forEach(
                    function (option) {

                        option.style.display =
                            'block';

                        visibleCount++;

                    }
                );


                if (visibleCount > 0) {

                    departmentDropdown.style.display =
                        'block';

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SEARCH DEPARTMENTS
        |--------------------------------------------------------------------------
        */

        departmentSearch.addEventListener(
            'input',
            function () {


                const search =
                    this.value
                        .toLowerCase()
                        .trim();


                let visibleCount = 0;


                departmentOptions.forEach(
                    function (option) {


                        const department =
                            option.dataset.value
                                .toLowerCase();


                        if (
                            department.includes(
                                search
                            )
                        ) {


                            option.style.display =
                                'block';


                            visibleCount++;


                        } else {


                            option.style.display =
                                'none';


                        }


                    }
                );


                /*
                |--------------------------------------------------------------------------
                | SHOW OR HIDE DROPDOWN
                |--------------------------------------------------------------------------
                */

                if (visibleCount > 0) {

                    departmentDropdown.style.display =
                        'block';

                } else {

                    departmentDropdown.style.display =
                        'none';

                }


                /*
                |--------------------------------------------------------------------------
                | CLEAR SELECTED VALUE IF USER CHANGES TEXT
                |--------------------------------------------------------------------------
                */

                if (
                    departmentSearch.value !==
                    departmentInput.value
                ) {

                    departmentInput.value =
                        '';

                }


            }
        );


        /*
        |--------------------------------------------------------------------------
        | SELECT DEPARTMENT
        |--------------------------------------------------------------------------
        */

        departmentOptions.forEach(
            function (option) {


                option.addEventListener(
                    'click',
                    function () {


                        const department =
                            this.dataset.value;


                        /*
                        |--------------------------------------------------------------------------
                        | DISPLAY SELECTED DEPARTMENT
                        |--------------------------------------------------------------------------
                        */

                        departmentSearch.value =
                            department;


                        /*
                        |--------------------------------------------------------------------------
                        | SAVE DEPARTMENT FOR FORM SUBMISSION
                        |--------------------------------------------------------------------------
                        */

                        departmentInput.value =
                            department;


                        /*
                        |--------------------------------------------------------------------------
                        | HIDE DROPDOWN
                        |--------------------------------------------------------------------------
                        */

                        departmentDropdown.style.display =
                            'none';


                    }
                );


            }
        );


        /*
        |--------------------------------------------------------------------------
        | HIDE DROPDOWN WHEN CLICKING OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {


                if (
                    !departmentSearch.contains(
                        event.target
                    )
                    &&
                    !departmentDropdown.contains(
                        event.target
                    )
                ) {


                    departmentDropdown.style.display =
                        'none';


                }


            }
        );


    }
);

</script>


@endsection