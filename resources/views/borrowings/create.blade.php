@extends('layouts.app')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | PREPARE BOOK COPIES FOR JAVASCRIPT
    |--------------------------------------------------------------------------
    */

    $booksJson = json_encode(
        $books->map(function ($book) {

            return [
                'id' => $book->id,

                'title' => $book->title,

                'copies' => $book->copies
                    ->map(function ($copy) {

                        return [

                            'id' => $copy->id,

                            'copy_number' =>
                                $copy->copy_number,

                            'accession_number' =>
                                $copy->accession_number,

                            'status' =>
                                $copy->status,

                        ];

                    })
                    ->values()
                    ->all(),

            ];

        })
        ->values()
        ->all()
    );


    /*
    |--------------------------------------------------------------------------
    | LEARNERS
    |--------------------------------------------------------------------------
    */

    $learnersJson = json_encode(
        $learners->map(function ($learner) {

            return [

                'id' =>
                    $learner->id,

                'name' =>
                    $learner->name,

                'admission_number' =>
                    $learner->admission_number,

                'assessment_number' =>
                    $learner->assessment_number,

                'grade_class' =>
                    $learner->grade_class,

                'stream' =>
                    $learner->stream,

            ];

        })
        ->values()
        ->all()
    );


    /*
    |--------------------------------------------------------------------------
    | TEACHERS
    |--------------------------------------------------------------------------
    */

    $teachersJson = json_encode(
        $teachers->map(function ($teacher) {

            return [

                'id' =>
                    $teacher->id,

                'name' =>
                    $teacher->name,

            ];

        })
        ->values()
        ->all()
    );


    /*
    |--------------------------------------------------------------------------
    | STAFF
    |--------------------------------------------------------------------------
    */

    $staffJson = json_encode(
        $staff->map(function ($staffMember) {

            return [

                'id' =>
                    $staffMember->id,

                'name' =>
                    $staffMember->name,

            ];

        })
        ->values()
        ->all()
    );

@endphp


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Issue Book</h1>

        <p class="text-muted mb-0">

            Select an available book, physical copy and borrower.

        </p>

    </div>


    <a
        href="{{ route('borrowings.index') }}"
        class="btn btn-secondary"
    >

        Back to Borrowings

    </a>

</div>


{{-- SUCCESS MESSAGE --}}

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif


{{-- ERROR MESSAGE --}}

@if(session('error'))

    <div class="alert alert-danger">

        {{ session('error') }}

    </div>

@endif


{{-- VALIDATION ERRORS --}}

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


<div class="card shadow-sm">

    <div class="card-body p-4">


        <form
            action="{{ route('borrowings.store') }}"
            method="POST"
        >

            @csrf


            <div class="row g-4">


                {{-- ===================================================== --}}
                {{-- SELECT BOOK --}}
                {{-- ===================================================== --}}

                <div class="col-md-12">

                    <label
                        for="book_id"
                        class="form-label fw-semibold"
                    >

                        Select Book

                    </label>


                    <select
                        id="book_id"
                        name="book_id"
                        class="form-select @error('book_id') is-invalid @enderror"
                        required
                    >

                        <option value="">

                            Select a Book

                        </option>


                        @foreach($books as $book)

                            <option
                                value="{{ $book->id }}"
                                @selected(
                                    old('book_id') == $book->id
                                )
                            >

                                {{ $book->title }}

                                @if(!empty($book->author))

                                    — {{ $book->author }}

                                @endif

                                | Available:
                                {{ $book->copies->count() }}

                            </option>

                        @endforeach

                    </select>


                    @error('book_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <small class="text-muted">

                        Select the book you want to issue.

                    </small>

                </div>


                {{-- ===================================================== --}}
                {{-- SELECT PHYSICAL COPY --}}
                {{-- ===================================================== --}}

                <div class="col-md-12">

                    <label
                        for="book_copy_id"
                        class="form-label fw-semibold"
                    >

                        Select Physical Copy

                    </label>


                    <select
                        id="book_copy_id"
                        name="book_copy_id"
                        class="form-select @error('book_copy_id') is-invalid @enderror"
                        required
                        disabled
                    >

                        <option value="">

                            First select a book

                        </option>

                    </select>


                    @error('book_copy_id')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror


                    <small class="text-muted">

                        Only available physical copies will be displayed.

                    </small>

                </div>


                {{-- ===================================================== --}}
                {{-- BORROWER TYPE --}}
                {{-- ===================================================== --}}

                <div class="col-md-12">

                    <label
                        for="borrower_type"
                        class="form-label fw-semibold"
                    >

                        Borrower Type

                    </label>


                    <select
                        id="borrower_type"
                        name="borrower_type"
                        class="form-select @error('borrower_type') is-invalid @enderror"
                        required
                    >

                        <option value="">

                            Select Borrower Type

                        </option>


                        <option
                            value="learner"
                            @selected(
                                old('borrower_type') === 'learner'
                            )
                        >

                            Learner

                        </option>


                        <option
                            value="teacher"
                            @selected(
                                old('borrower_type') === 'teacher'
                            )
                        >

                            Teacher

                        </option>


                        <option
                            value="staff"
                            @selected(
                                old('borrower_type') === 'staff'
                            )
                        >

                            Staff

                        </option>

                    </select>

                </div>


                {{-- ===================================================== --}}
                {{-- LEARNER ADMISSION NUMBER --}}
                {{-- ===================================================== --}}

                <div
                    class="col-md-12"
                    id="learner_search_container"
                    style="display: none;"
                >

                    <label
                        for="learner_admission_search"
                        class="form-label fw-semibold"
                    >

                        Admission Number

                    </label>


                    <input
                        type="text"
                        id="learner_admission_search"
                        class="form-control"
                        placeholder="Type learner admission number..."
                        autocomplete="off"
                    >


                    <small class="text-muted">

                        Type the admission number and the learner details
                        will be found automatically.

                    </small>


                    <div
                        id="learner_not_found"
                        class="alert alert-danger mt-3"
                        style="display: none;"
                    >

                        No learner was found with that admission number.

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- LEARNER DETAILS --}}
                {{-- ===================================================== --}}

                <div
                    class="col-md-12"
                    id="learner_details_container"
                    style="display: none;"
                >

                    <div class="card border-primary">

                        <div class="card-body">

                            <h5 class="card-title mb-3">

                                Learner Details

                            </h5>


                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label class="form-label">

                                        Learner Name

                                    </label>


                                    <input
                                        type="text"
                                        id="learner_name_display"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">

                                        Admission Number

                                    </label>


                                    <input
                                        type="text"
                                        id="learner_admission_display"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">

                                        Assessment Number

                                    </label>


                                    <input
                                        type="text"
                                        id="learner_assessment_display"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">

                                        Class / Grade

                                    </label>


                                    <input
                                        type="text"
                                        id="learner_grade_display"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">

                                        Stream

                                    </label>


                                    <input
                                        type="text"
                                        id="learner_stream_display"
                                        class="form-control"
                                        readonly
                                    >

                                </div>


                            </div>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- TEACHER / STAFF --}}
                {{-- ===================================================== --}}

                <div
                    class="col-md-12"
                    id="other_borrower_container"
                    style="display: none;"
                >

                    <label
                        for="borrower_select"
                        class="form-label fw-semibold"
                    >

                        Select Borrower

                    </label>


                    <select
                        id="borrower_select"
                        class="form-select"
                    >

                        <option value="">

                            Select Borrower

                        </option>

                    </select>

                </div>


                {{-- ACTUAL BORROWER ID --}}

                <input
                    type="hidden"
                    id="borrower_id"
                    name="borrower_id"
                    value="{{ old('borrower_id') }}"
                >


                {{-- ===================================================== --}}
                {{-- BORROWED DATE --}}
                {{-- ===================================================== --}}

                <div class="col-md-6">

                    <label
                        for="borrowed_date"
                        class="form-label fw-semibold"
                    >

                        Borrowed Date

                    </label>


                    <input
                        type="date"
                        id="borrowed_date"
                        name="borrowed_date"
                        class="form-control @error('borrowed_date') is-invalid @enderror"
                        value="{{ old('borrowed_date', date('Y-m-d')) }}"
                        required
                    >

                </div>


                {{-- ===================================================== --}}
                {{-- DUE DATE --}}
                {{-- ===================================================== --}}

                <div class="col-md-6">

                    <label
                        for="due_date"
                        class="form-label fw-semibold"
                    >

                        Due Date

                        <span class="text-muted">

                            (Optional)

                        </span>

                    </label>


                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        class="form-control @error('due_date') is-invalid @enderror"
                        value="{{ old('due_date') }}"
                    >

                </div>


                {{-- ===================================================== --}}
                {{-- BUTTONS --}}
                {{-- ===================================================== --}}

                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >

                        <i class="bi bi-check-circle"></i>

                        Issue Book

                    </button>


                    <a
                        href="{{ route('borrowings.index') }}"
                        class="btn btn-secondary"
                    >

                        Cancel

                    </a>

                </div>


            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | FORM ELEMENTS
        |--------------------------------------------------------------------------
        */

        const bookSelect =
            document.getElementById('book_id');


        const bookCopySelect =
            document.getElementById('book_copy_id');


        const borrowerType =
            document.getElementById('borrower_type');


        const borrowerId =
            document.getElementById('borrower_id');


        const learnerSearchContainer =
            document.getElementById(
                'learner_search_container'
            );


        const learnerAdmissionSearch =
            document.getElementById(
                'learner_admission_search'
            );


        const learnerDetailsContainer =
            document.getElementById(
                'learner_details_container'
            );


        const learnerNotFound =
            document.getElementById(
                'learner_not_found'
            );


        const learnerNameDisplay =
            document.getElementById(
                'learner_name_display'
            );


        const learnerAdmissionDisplay =
            document.getElementById(
                'learner_admission_display'
            );


        const learnerAssessmentDisplay =
            document.getElementById(
                'learner_assessment_display'
            );


        const learnerGradeDisplay =
            document.getElementById(
                'learner_grade_display'
            );


        const learnerStreamDisplay =
            document.getElementById(
                'learner_stream_display'
            );


        const otherBorrowerContainer =
            document.getElementById(
                'other_borrower_container'
            );


        const borrowerSelect =
            document.getElementById(
                'borrower_select'
            );


        /*
        |--------------------------------------------------------------------------
        | DATA FROM LARAVEL
        |--------------------------------------------------------------------------
        */

        const books =
            {!! $booksJson !!};


        const learners =
            {!! $learnersJson !!};


        const teachers =
            {!! $teachersJson !!};


        const staff =
            {!! $staffJson !!};


        /*
        |--------------------------------------------------------------------------
        | POPULATE PHYSICAL COPIES
        |--------------------------------------------------------------------------
        */

        function populateBookCopies(
            bookId,
            selectedCopyId = null
        ) {

            bookCopySelect.innerHTML =
                '<option value="">Select Physical Copy</option>';


            bookCopySelect.disabled =
                true;


            if (!bookId) {

                return;

            }


            const book =
                books.find(function (item) {

                    return String(item.id)
                        ===
                        String(bookId);

                });


            if (!book) {

                return;

            }


            if (!book.copies || book.copies.length === 0) {

                bookCopySelect.innerHTML =
                    '<option value="">No available copies</option>';

                return;

            }


            book.copies.forEach(
                function (copy) {

                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        copy.id;


                    /*
                    |--------------------------------------------------------------------------
                    | DISPLAY COPY NUMBER
                    |--------------------------------------------------------------------------
                    |
                    | Example:
                    | LMS/CORE-MATH/01/026
                    |
                    */

                    option.textContent =
                        copy.copy_number
                        +
                        (
                            copy.accession_number
                                ? ' | Accession: '
                                    + copy.accession_number
                                : ''
                        );


                    if (
                        selectedCopyId
                        &&
                        String(copy.id)
                        ===
                        String(selectedCopyId)
                    ) {

                        option.selected =
                            true;

                    }


                    bookCopySelect.appendChild(
                        option
                    );

                }
            );


            bookCopySelect.disabled =
                false;

        }


        /*
        |--------------------------------------------------------------------------
        | BOOK CHANGE
        |--------------------------------------------------------------------------
        */

        bookSelect.addEventListener(
            'change',
            function () {

                populateBookCopies(
                    bookSelect.value
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RESET LEARNER DETAILS
        |--------------------------------------------------------------------------
        */

        function resetLearnerDetails() {

            learnerNameDisplay.value =
                '';

            learnerAdmissionDisplay.value =
                '';

            learnerAssessmentDisplay.value =
                '';

            learnerGradeDisplay.value =
                '';

            learnerStreamDisplay.value =
                '';

            learnerDetailsContainer.style.display =
                'none';

            learnerNotFound.style.display =
                'none';

            borrowerId.value =
                '';

        }


        /*
        |--------------------------------------------------------------------------
        | FIND LEARNER
        |--------------------------------------------------------------------------
        */

        function findLearnerByAdmissionNumber() {

            const admissionNumber =
                learnerAdmissionSearch.value
                    .trim()
                    .toLowerCase();


            resetLearnerDetails();


            if (admissionNumber === '') {

                return;

            }


            const learner =
                learners.find(
                    function (item) {

                        return String(
                            item.admission_number
                        )
                        .trim()
                        .toLowerCase()
                        ===
                        admissionNumber;

                    }
                );


            if (!learner) {

                learnerNotFound.style.display =
                    'block';

                return;

            }


            borrowerId.value =
                learner.id;


            learnerNameDisplay.value =
                learner.name ?? '';


            learnerAdmissionDisplay.value =
                learner.admission_number ?? '';


            learnerAssessmentDisplay.value =
                learner.assessment_number ?? '';


            learnerGradeDisplay.value =
                learner.grade_class ?? '';


            learnerStreamDisplay.value =
                learner.stream ?? '';


            learnerDetailsContainer.style.display =
                'block';

        }


        /*
        |--------------------------------------------------------------------------
        | POPULATE TEACHERS
        |--------------------------------------------------------------------------
        */

        function populateTeachers() {

            borrowerSelect.innerHTML =
                '<option value="">Select a Teacher</option>';


            teachers.forEach(
                function (teacher) {

                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        teacher.id;


                    option.textContent =
                        teacher.name;


                    borrowerSelect.appendChild(
                        option
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | POPULATE STAFF
        |--------------------------------------------------------------------------
        */

        function populateStaff() {

            borrowerSelect.innerHTML =
                '<option value="">Select a Staff Member</option>';


            staff.forEach(
                function (staffMember) {

                    const option =
                        document.createElement(
                            'option'
                        );


                    option.value =
                        staffMember.id;


                    option.textContent =
                        staffMember.name;


                    borrowerSelect.appendChild(
                        option
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | BORROWER TYPE CHANGE
        |--------------------------------------------------------------------------
        */

        borrowerType.addEventListener(
            'change',
            function () {


                const type =
                    borrowerType.value;


                borrowerId.value =
                    '';


                learnerAdmissionSearch.value =
                    '';


                resetLearnerDetails();


                borrowerSelect.innerHTML =
                    '<option value="">Select Borrower</option>';


                learnerSearchContainer.style.display =
                    'none';


                otherBorrowerContainer.style.display =
                    'none';


                if (type === 'learner') {

                    learnerSearchContainer.style.display =
                        'block';

                    return;

                }


                if (type === 'teacher') {

                    otherBorrowerContainer.style.display =
                        'block';


                    populateTeachers();

                    return;

                }


                if (type === 'staff') {

                    otherBorrowerContainer.style.display =
                        'block';


                    populateStaff();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | LEARNER ADMISSION NUMBER
        |--------------------------------------------------------------------------
        */

        learnerAdmissionSearch.addEventListener(
            'input',
            function () {

                findLearnerByAdmissionNumber();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | TEACHER / STAFF SELECTION
        |--------------------------------------------------------------------------
        */

        borrowerSelect.addEventListener(
            'change',
            function () {

                borrowerId.value =
                    borrowerSelect.value;

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RESTORE OLD BOOK AND COPY
        |--------------------------------------------------------------------------
        */

        const oldBookId =
            @json(old('book_id'));


        const oldBookCopyId =
            @json(old('book_copy_id'));


        if (oldBookId) {

            bookSelect.value =
                oldBookId;


            populateBookCopies(
                oldBookId,
                oldBookCopyId
            );

        }


        /*
        |--------------------------------------------------------------------------
        | RESTORE OLD BORROWER TYPE
        |--------------------------------------------------------------------------
        */

        const oldBorrowerType =
            @json(old('borrower_type'));


        const oldBorrowerId =
            @json(old('borrower_id'));


        if (oldBorrowerType) {

            borrowerType.value =
                oldBorrowerType;


            borrowerType.dispatchEvent(
                new Event('change')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | RESTORE OLD LEARNER
        |--------------------------------------------------------------------------
        */

        if (
            oldBorrowerType === 'learner'
            &&
            oldBorrowerId
        ) {

            const oldLearner =
                learners.find(
                    function (learner) {

                        return String(learner.id)
                            ===
                            String(oldBorrowerId);

                    }
                );


            if (oldLearner) {

                learnerAdmissionSearch.value =
                    oldLearner.admission_number;


                findLearnerByAdmissionNumber();

            }

        }


        /*
        |--------------------------------------------------------------------------
        | RESTORE TEACHER OR STAFF
        |--------------------------------------------------------------------------
        */

        if (
            (
                oldBorrowerType === 'teacher'
                ||
                oldBorrowerType === 'staff'
            )
            &&
            oldBorrowerId
        ) {

            borrowerSelect.value =
                oldBorrowerId;


            borrowerId.value =
                oldBorrowerId;

        }


    }
);

</script>

@endsection