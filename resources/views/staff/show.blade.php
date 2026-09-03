@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">


<div>

    <h1>Staff Member Details</h1>

    <p class="text-muted mb-0">
        View staff information and borrowing history.
    </p>

</div>


<div>

    <a
        href="{{ route('staff.edit', $staff) }}"
        class="btn btn-warning"
    >

        <i class="bi bi-pencil"></i>

        Edit

    </a>


    <a
        href="{{ route('staff.index') }}"
        class="btn btn-secondary"
    >

        Back

    </a>

</div>


</div>

<!-- Staff Information -->

<div class="card shadow-sm">


<div class="card-body">

    <div class="row">


        <!-- Name -->

        <div class="col-md-6 mb-3">

            <strong>Name:</strong>

            <br>

            {{ $staff->name }}

        </div>


        <!-- Phone -->

        <div class="col-md-6 mb-3">

            <strong>Phone Number:</strong>

            <br>

            {{ $staff->phone }}

        </div>


    </div>

</div>


</div>

<!-- Borrowing History -->

<div class="card shadow-sm mt-4">


<div class="card-body">

    <h4 class="mb-3">

        Borrowing History

    </h4>


    <div class="table-responsive">

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Book</th>

                    <th>Borrowed Date</th>

                    <th>Due Date</th>

                    <th>Returned Date</th>

                    <th>Status</th>

                </tr>

            </thead>


            <tbody>

                @forelse($staff->borrowings as $borrowing)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>


                        <!-- Book -->

                        <td>

                            {{ $borrowing->book->title ?? 'Unknown Book' }}

                        </td>


                        <!-- Borrowed Date -->

                        <td>

                            {{ $borrowing->borrowed_date }}

                        </td>


                        <!-- Due Date -->

                        <td>

                            {{ $borrowing->due_date ?? '-' }}

                        </td>


                        <!-- Returned Date -->

                        <td>

                            {{ $borrowing->returned_date ?? '-' }}

                        </td>


                        <!-- Status -->

                        <td>

                            @if($borrowing->status === 'borrowed')

                                <span class="badge text-bg-warning">

                                    Borrowed

                                </span>

                            @elseif($borrowing->status === 'returned')

                                <span class="badge text-bg-success">

                                    Returned

                                </span>

                            @else

                                <span class="badge text-bg-danger">

                                    Overdue

                                </span>

                            @endif

                        </td>

                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="6"
                            class="text-center text-muted py-4"
                        >

                            This staff member has not borrowed any books yet.

                        </td>

                    </tr>


                @endforelse


            </tbody>

        </table>

    </div>

</div>


</div>

@endsection
