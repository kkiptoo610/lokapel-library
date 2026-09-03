@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Borrowing Details</h1>

        <p class="text-muted mb-0">
            View complete information about this borrowing record and the exact physical book copy.
        </p>

    </div>


    <a
        href="{{ route('borrowings.index') }}"
        class="btn btn-secondary"
    >

        <i class="bi bi-arrow-left"></i>

        Back to Borrowings

    </a>

</div>


{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif


{{-- ========================================================= --}}
{{-- ERROR MESSAGE --}}
{{-- ========================================================= --}}

@if(session('error'))

    <div class="alert alert-danger">

        {{ session('error') }}

    </div>

@endif


<div class="row">


    {{-- ========================================================= --}}
    {{-- BORROWING DETAILS --}}
    {{-- ========================================================= --}}

    <div class="col-lg-8">


        <div class="card shadow-sm mb-4">


            <div class="card-header">

                <strong>

                    <i class="bi bi-journal-bookmark"></i>

                    Borrowing Information

                </strong>

            </div>


            <div class="card-body">


                <div class="row g-4">


                    {{-- ========================================================= --}}
                    {{-- BOOK --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-6">

                        <small class="text-muted">

                            Book

                        </small>

                        <h5 class="mb-0">

                            {{ $borrowing->book?->title ?? '-' }}

                        </h5>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- AUTHOR --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-6">

                        <small class="text-muted">

                            Author

                        </small>

                        <h5 class="mb-0">

                            {{ $borrowing->book?->author ?? '-' }}

                        </h5>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- EXACT PHYSICAL BOOK COPY --}}
                    {{-- ========================================================= --}}

                    <div class="col-12">

                        <div class="card border-primary bg-light">

                            <div class="card-body py-3">


                                <small class="text-muted">

                                    <i class="bi bi-upc-scan"></i>

                                    Exact Physical Book Copy Number

                                </small>


                                <h4 class="mb-1 mt-1 text-primary">

                                    {{ $borrowing->bookCopy?->copy_number ?? '-' }}

                                </h4>


                                <small class="text-muted">

                                    This is the exact physical copy issued to the borrower.

                                </small>


                            </div>

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- PHYSICAL COPY STATUS --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-6">

                        <small class="text-muted">

                            Physical Copy Status

                        </small>

                        <div class="mt-1">

                            @if(($borrowing->bookCopy?->status ?? '') === 'available')

                                <span class="badge text-bg-success">

                                    Available

                                </span>

                            @elseif(($borrowing->bookCopy?->status ?? '') === 'borrowed')

                                <span class="badge text-bg-warning">

                                    Borrowed

                                </span>

                            @else

                                <span class="badge text-bg-secondary">

                                    {{ ucfirst($borrowing->bookCopy?->status ?? 'Unknown') }}

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- BORROWED DATE --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-4">

                        <small class="text-muted">

                            Borrowed Date

                        </small>

                        <h5 class="mb-0">

                            {{ $borrowing->borrowed_date }}

                        </h5>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- DUE DATE --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-4">

                        <small class="text-muted">

                            Due Date

                        </small>

                        <h5 class="mb-0">

                            {{ $borrowing->due_date ?? 'Not specified' }}

                        </h5>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- RETURNED DATE --}}
                    {{-- ========================================================= --}}

                    <div class="col-md-4">

                        <small class="text-muted">

                            Returned Date

                        </small>

                        <h5 class="mb-0">

                            {{ $borrowing->returned_date ?? '-' }}

                        </h5>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- STATUS --}}
                    {{-- ========================================================= --}}

                    <div class="col-12">

                        <small class="text-muted">

                            Borrowing Status

                        </small>

                        <div class="mt-1">


                            @if($borrowing->status === 'borrowed')

                                <span class="badge text-bg-warning">

                                    <i class="bi bi-book"></i>

                                    Borrowed

                                </span>

                            @elseif($borrowing->status === 'returned')

                                <span class="badge text-bg-success">

                                    <i class="bi bi-check-circle"></i>

                                    Returned

                                </span>

                            @elseif($borrowing->status === 'overdue')

                                <span class="badge text-bg-danger">

                                    <i class="bi bi-exclamation-triangle"></i>

                                    Overdue

                                </span>

                            @else

                                <span class="badge text-bg-secondary">

                                    {{ ucfirst($borrowing->status) }}

                                </span>

                            @endif


                        </div>

                    </div>


                </div>


            </div>

        </div>


    </div>


    {{-- ========================================================= --}}
    {{-- BORROWER DETAILS --}}
    {{-- ========================================================= --}}

    <div class="col-lg-4">


        <div class="card shadow-sm mb-4">


            <div class="card-header">

                <strong>

                    <i class="bi bi-person"></i>

                    Borrower Details

                </strong>

            </div>


            <div class="card-body">


                {{-- ========================================================= --}}
                {{-- LEARNER --}}
                {{-- ========================================================= --}}

                @if($borrowing->borrower_type === \App\Models\Learner::class)


                    <div class="mb-3">

                        <small class="text-muted">

                            Learner Name

                        </small>

                        <h5>

                            {{ $borrowing->borrower?->name ?? '-' }}

                        </h5>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">

                            Admission Number

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->admission_number ?? '-' }}

                        </h6>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">

                            Assessment Number

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->assessment_number ?? '-' }}

                        </h6>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">

                            Class / Grade

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->grade_class ?? '-' }}

                        </h6>

                    </div>


                    <div class="mb-0">

                        <small class="text-muted">

                            Stream

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->stream ?? '-' }}

                        </h6>

                    </div>


                {{-- ========================================================= --}}
                {{-- TEACHER --}}
                {{-- ========================================================= --}}

                @elseif($borrowing->borrower_type === \App\Models\Teacher::class)


                    <div class="mb-3">

                        <small class="text-muted">

                            Teacher Name

                        </small>

                        <h5>

                            {{ $borrowing->borrower?->name ?? '-' }}

                        </h5>

                    </div>


                    <div class="mb-0">

                        <small class="text-muted">

                            Phone Number

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->phone_number ?? '-' }}

                        </h6>

                    </div>


                {{-- ========================================================= --}}
                {{-- STAFF --}}
                {{-- ========================================================= --}}

                @elseif($borrowing->borrower_type === \App\Models\Staff::class)


                    <div class="mb-3">

                        <small class="text-muted">

                            Staff Name

                        </small>

                        <h5>

                            {{ $borrowing->borrower?->name ?? '-' }}

                        </h5>

                    </div>


                    <div class="mb-0">

                        <small class="text-muted">

                            Phone Number

                        </small>

                        <h6>

                            {{ $borrowing->borrower?->phone_number ?? '-' }}

                        </h6>

                    </div>


                @endif


            </div>

        </div>


    </div>


</div>


{{-- ========================================================= --}}
{{-- ACTION BUTTONS --}}
{{-- ========================================================= --}}

<div class="card shadow-sm">


    <div class="card-body">


        <div class="d-flex justify-content-between align-items-center">


            <a
                href="{{ route('borrowings.index') }}"
                class="btn btn-secondary"
            >

                <i class="bi bi-arrow-left"></i>

                Back

            </a>


            @if($borrowing->status !== 'returned')


                <form
                    action="{{ route('borrowings.return', $borrowing) }}"
                    method="POST"
                    id="returnForm"
                >

                    @csrf


                    <button
                        type="button"
                        class="btn btn-success"
                        onclick="confirmReturn()"
                    >

                        <i class="bi bi-check-circle"></i>

                        Return Book

                    </button>


                </form>


            @endif


        </div>


    </div>


</div>


<script>

function confirmReturn() {


    const fullName =
        @json($borrowing->borrower?->name ?? 'Borrower');


    const firstName =
        fullName.trim().split(' ')[0];


    const bookTitle =
        @json($borrowing->book?->title ?? 'this book');


    /*
    |--------------------------------------------------------------------------
    | EXACT PHYSICAL COPY NUMBER
    |--------------------------------------------------------------------------
    */

    const copyNumber =
        @json($borrowing->bookCopy?->copy_number ?? 'Unknown copy');


    const confirmed =
        confirm(
            firstName
            + ' is returning:\n\n'
            + 'Book: "'
            + bookTitle
            + '"\n\n'
            + 'Physical Copy Number:\n'
            + copyNumber
            + '\n\n'
            + 'Please confirm that this exact physical copy is being returned.'
        );


    if (confirmed) {

        document
            .getElementById('returnForm')
            .submit();

    }

}

</script>

@endsection