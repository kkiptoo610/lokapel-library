@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>Teacher Details</h1>

        <p class="text-muted mb-0">
            View teacher information and borrowing history.
        </p>

    </div>


    <div>

        <a
            href="{{ route('teachers.edit', $teacher) }}"
            class="btn btn-warning"
        >

            <i class="bi bi-pencil"></i>

            Edit

        </a>


        <a
            href="{{ route('teachers.index') }}"
            class="btn btn-secondary"
        >

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>

</div>


<!-- =====================================
     TEACHER INFORMATION
===================================== -->

<div class="card shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            <i class="bi bi-person-workspace me-2"></i>

            Teacher Information

        </h5>

    </div>


    <div class="card-body">

        <div class="row">


            <!-- TEACHER NAME -->

            <div class="col-md-6 mb-4">

                <small class="text-muted">

                    Teacher Name

                </small>

                <div>

                    <strong>

                        {{ $teacher->name }}

                    </strong>

                </div>

            </div>


            <!-- PHONE NUMBER -->

            <div class="col-md-6 mb-4">

                <small class="text-muted">

                    Phone Number

                </small>

                <div>

                    <strong>

                        {{ $teacher->phone ?? '-' }}

                    </strong>

                </div>

            </div>


            <!-- DEPARTMENT -->

            <div class="col-md-6 mb-4">

                <small class="text-muted">

                    Department

                </small>

                <div>

                    <strong>

                        {{ $teacher->department ?? '-' }}

                    </strong>

                </div>

            </div>


            <!-- POSITION -->

            <div class="col-md-6 mb-4">

                <small class="text-muted">

                    Position / Role

                </small>

                <div>

                    <strong>

                        {{ $teacher->position ?? 'Teacher' }}

                    </strong>

                </div>

            </div>


        </div>

    </div>

</div>


<!-- =====================================
     BORROWING HISTORY
===================================== -->

<div class="card shadow-sm mt-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h4 class="mb-0">

            <i class="bi bi-book me-2"></i>

            Borrowing History

        </h4>


        <span class="badge text-bg-secondary">

            {{ $teacher->borrowings->count() }}

            {{ $teacher->borrowings->count() === 1 ? 'Record' : 'Records' }}

        </span>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">

                            #

                        </th>


                        <th>

                            Book

                        </th>


                        <th>

                            Borrowed Date

                        </th>


                        <th>

                            Due Date

                        </th>


                        <th>

                            Returned Date

                        </th>


                        <th class="pe-4">

                            Status

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($teacher->borrowings as $borrowing)

                        <tr>


                            <!-- NUMBER -->

                            <td class="ps-4">

                                {{ $loop->iteration }}

                            </td>


                            <!-- BOOK -->

                            <td>

                                <strong>

                                    {{ optional($borrowing->book)->title ?? 'Unknown Book' }}

                                </strong>

                            </td>


                            <!-- BORROWED DATE -->

                            <td>

                                @if($borrowing->borrowed_date)

                                    {{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <!-- DUE DATE -->

                            <td>

                                @if($borrowing->due_date)

                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <!-- RETURNED DATE -->

                            <td>

                                @if($borrowing->returned_date)

                                    {{ \Carbon\Carbon::parse($borrowing->returned_date)->format('d M Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <!-- STATUS -->

                            <td class="pe-4">


                                @if($borrowing->status === 'borrowed')

                                    <span class="badge text-bg-warning">

                                        <i class="bi bi-book me-1"></i>

                                        Borrowed

                                    </span>


                                @elseif($borrowing->status === 'returned')

                                    <span class="badge text-bg-success">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Returned

                                    </span>


                                @elseif($borrowing->status === 'overdue')

                                    <span class="badge text-bg-danger">

                                        <i class="bi bi-exclamation-triangle me-1"></i>

                                        Overdue

                                    </span>


                                @else

                                    <span class="badge text-bg-secondary">

                                        {{ ucfirst($borrowing->status ?? 'Unknown') }}

                                    </span>

                                @endif


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted py-5"
                            >

                                <i class="bi bi-book fs-2 d-block mb-2"></i>

                                This teacher has not borrowed any books yet.

                            </td>

                        </tr>


                    @endforelse


                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection