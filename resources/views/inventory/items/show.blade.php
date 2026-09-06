@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-box-seam"></i>

        </div>

        <div>

            <h1>{{ $item->name }}</h1>

            <p>

                Inventory item details and issue history.

            </p>

        </div>

    </div>


    <div class="d-flex gap-2 flex-wrap">

        {{-- BACK TO INVENTORY --}}

        <a
            href="{{ route('inventory.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-2"></i>

            Back to Inventory

        </a>


        {{-- EDIT ITEM --}}

        <a
            href="{{ route('inventory.items.edit', $item) }}"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-pencil me-2"></i>

            Edit

        </a>


        {{-- RESTOCK ITEM --}}

        <a
            href="{{ route('inventory.items.restock', $item) }}"
            class="btn btn-success"
        >

            <i class="bi bi-box-arrow-in-down me-2"></i>

            Restock

        </a>


        {{-- ISSUE ITEM --}}

        <a
            href="{{ route('inventory.items.issue', $item) }}"
            class="btn btn-primary"
        >

            <i class="bi bi-arrow-up-right-circle me-2"></i>

            Issue Item

        </a>

    </div>

</div>


<div class="row g-4">


    {{-- ITEM DETAILS --}}

    <div class="col-lg-8">

        <div class="modern-page-card">

            <div class="card-body p-4">


                <div class="row g-4">


                    <div class="col-md-6">

                        <div class="text-muted small">

                            Category

                        </div>


                        <div class="fw-semibold fs-5">

                            {{ $item->category?->name ?? 'No Category' }}

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="text-muted small">

                            Inventory Type

                        </div>


                        <div class="fw-semibold fs-5 text-capitalize">

                            {{ $item->category?->type ?? 'N/A' }}

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="text-muted small">

                            Current Quantity

                        </div>


                        <div class="fw-bold fs-3">

                            {{ $item->quantity }}

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="text-muted small">

                            Unit

                        </div>


                        <div class="fw-semibold fs-5">

                            {{ $item->unit }}

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="text-muted small">

                            Minimum Level

                        </div>


                        <div class="fw-semibold fs-5">

                            {{ $item->minimum_quantity }}

                        </div>

                    </div>


                    <div class="col-12">

                        <hr>


                        <div class="text-muted small mb-2">

                            Description

                        </div>


                        <div>

                            {{ $item->description ?: 'No description provided.' }}

                        </div>

                    </div>


                </div>

            </div>

        </div>


        {{-- ISSUE HISTORY --}}

        <div class="modern-page-card mt-4">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="mb-1">

                            Issue History

                        </h5>


                        <p class="text-muted mb-0">

                            Recent records for this inventory item.

                        </p>

                    </div>

                </div>


                @if ($issues->count())

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>Date</th>

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

                                            {{ $issue->teacher?->name ?? 'Department / Other' }}

                                        </td>


                                        <td>

                                            {{ $issue->department ?? '—' }}

                                        </td>


                                        <td>

                                            <span class="fw-semibold">

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

                @else

                    <div class="text-center py-5 text-muted">

                        <i
                            class="bi bi-clock-history d-block mb-3"
                            style="font-size: 40px;"
                        ></i>


                        No issue history found for this item.

                    </div>

                @endif


            </div>

        </div>

    </div>


    {{-- STOCK STATUS --}}

    <div class="col-lg-4">

        <div class="modern-page-card">

            <div class="card-body p-4">


                <div class="text-muted small mb-2">

                    Stock Status

                </div>


                @if ($item->quantity <= 0)

                    <div class="alert alert-danger mb-0">

                        <i class="bi bi-x-circle-fill me-2"></i>

                        Out of Stock

                    </div>

                @elseif ($item->quantity <= $item->minimum_quantity)

                    <div class="alert alert-warning mb-0">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        Low Stock

                    </div>

                @else

                    <div class="alert alert-success mb-0">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        Stock Level Good

                    </div>

                @endif


                <hr>


                <div class="small text-muted mb-1">

                    Total Units Issued

                </div>


                <div class="fw-bold fs-3">

                    {{ $issues->sum('quantity') }}

                </div>

            </div>

        </div>


        {{-- RESTOCK QUICK ACTION --}}

        <div class="modern-page-card mt-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="page-title-icon me-3">

                        <i class="bi bi-box-arrow-in-down"></i>

                    </div>

                    <div>

                        <h6 class="mb-1">

                            Add Stock

                        </h6>

                        <p class="text-muted small mb-0">

                            Increase the available quantity for this item.

                        </p>

                    </div>

                </div>


                <div class="mb-3">

                    <div class="small text-muted">

                        Current Stock

                    </div>

                    <div class="fw-bold fs-4">

                        {{ $item->quantity }} {{ $item->unit }}

                    </div>

                </div>


                <a
                    href="{{ route('inventory.items.restock', $item) }}"
                    class="btn btn-success w-100"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Restock Item

                </a>

            </div>

        </div>


        {{-- DELETE --}}

        <div class="modern-page-card mt-4 border border-danger">

            <div class="card-body p-4">


                <h6 class="text-danger">

                    Danger Zone

                </h6>


                <p class="text-muted small">

                    Deleting this item may affect its inventory records.

                </p>


                <form
                    action="{{ route('inventory.items.destroy', $item) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this inventory item?');"
                >

                    @csrf

                    @method('DELETE')


                    <button
                        type="submit"
                        class="btn btn-outline-danger w-100"
                    >

                        <i class="bi bi-trash me-2"></i>

                        Delete Item

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection