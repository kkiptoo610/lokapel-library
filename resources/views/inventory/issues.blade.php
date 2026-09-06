@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-clock-history"></i>

        </div>

        <div>

            <h1>Inventory Issue History</h1>

            <p>

                View all inventory items issued to teachers and departments.

            </p>

        </div>

    </div>


    <a
        href="{{ route('inventory.index') }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-2"></i>

        Inventory Dashboard

    </a>

</div>


<div class="modern-page-card">

    <div class="card-body p-4">


        @if ($issues->count())


            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Date</th>

                            <th>Item</th>

                            <th>Category</th>

                            <th>Recipient</th>

                            <th>Department</th>

                            <th>Quantity</th>

                            <th>Remarks</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($issues as $issue)

                            <tr>

                                <td>

                                    {{ optional($issue->issued_date)->format('d M Y') }}

                                </td>


                                <td>

                                    <a
                                        href="{{ route('inventory.items.show', $issue->item) }}"
                                        class="fw-semibold text-decoration-none"
                                    >

                                        {{ $issue->item?->name ?? 'Deleted Item' }}

                                    </a>

                                </td>


                                <td>

                                    {{ $issue->item?->category?->name ?? '—' }}

                                </td>


                                <td>

                                    {{ $issue->teacher?->name ?? '—' }}

                                </td>


                                <td>

                                    {{ $issue->department ?? '—' }}

                                </td>


                                <td>

                                    <span class="badge bg-primary">

                                        {{ $issue->quantity }}

                                    </span>

                                </td>


                                <td>

                                    {{ $issue->remarks ?? '—' }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="mt-4">

                {{ $issues->links() }}

            </div>


        @else


            <div class="text-center py-5">

                <i
                    class="bi bi-clock-history text-muted"
                    style="font-size: 50px;"
                ></i>


                <h5 class="mt-3">

                    No Inventory Issues Found

                </h5>


                <p class="text-muted">

                    Inventory issue records will appear here.

                </p>

            </div>


        @endif


    </div>

</div>

@endsection