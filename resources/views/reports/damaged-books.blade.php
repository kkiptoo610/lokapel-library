@extends('layouts.app')

@section('content')

<div class="container-fluid">


    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">


        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-bookmark-x text-danger"></i>

                Damaged Books

            </h2>


            <p class="text-muted mb-0">

                All physical book copies that require repair or replacement.

            </p>

        </div>


        <a
            href="{{ route('dashboard') }}"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-arrow-left"></i>

            Back to Dashboard

        </a>


    </div>



    {{-- ========================================================= --}}
    {{-- DAMAGED BOOKS TABLE --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm border-0">


        <div class="card-body p-0">


            <div class="table-responsive">


                <table class="table table-hover align-middle mb-0">


                    <thead class="table-light">

                        <tr>

                            <th class="ps-4">

                                Book

                            </th>


                            <th>

                                Copy Number

                            </th>


                            <th>

                                Accession Number

                            </th>


                            <th>

                                Status

                            </th>


                            <th class="text-end pe-4">

                                Action

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @forelse($damagedCopies as $copy)


                            <tr>


                                <td class="ps-4">

                                    <strong>

                                        {{ $copy->book?->title ?? '-' }}

                                    </strong>


                                    @if($copy->book?->book_code)

                                        <br>

                                        <small class="text-muted">

                                            {{ $copy->book->book_code }}

                                        </small>

                                    @endif

                                </td>


                                <td>

                                    {{ $copy->copy_number }}

                                </td>


                                <td>

                                    {{ $copy->accession_number }}

                                </td>


                                <td>

                                    <span
                                        class="badge bg-danger px-3 py-2"
                                    >

                                        <i class="bi bi-exclamation-triangle"></i>

                                        Damaged

                                    </span>

                                </td>


                                <td class="text-end pe-4">

                                    @if($copy->book)

                                        <a
                                            href="{{ route('books.show', $copy->book) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >

                                            <i class="bi bi-eye"></i>

                                            View Book

                                        </a>

                                    @endif

                                </td>


                            </tr>


                        @empty


                            <tr>


                                <td
                                    colspan="5"
                                    class="text-center text-muted py-5"
                                >

                                    <i
                                        class="bi bi-check-circle"
                                        style="font-size: 40px; color: #198754;"
                                    ></i>


                                    <p class="mt-3 mb-0">

                                        Excellent! No damaged books found.

                                    </p>

                                </td>


                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>


        </div>


    </div>


</div>

@endsection