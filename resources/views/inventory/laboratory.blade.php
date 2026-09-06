@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-flask"></i>

        </div>

        <div>

            <h1>Laboratory Inventory</h1>

            <p>

                Manage laboratory equipment, materials, stock and inventory activity.

            </p>

        </div>

    </div>


    <div class="d-flex gap-2 flex-wrap">

        <a
            href="{{ route('inventory.items.index', ['type' => 'laboratory']) }}"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-box-seam me-2"></i>

            View Items

        </a>


        <a
            href="{{ route('inventory.items.create') }}"
            class="btn btn-primary"
        >

            <i class="bi bi-plus-circle me-2"></i>

            Add Laboratory Item

        </a>

    </div>

</div>


{{-- STATISTICS --}}

<div class="row g-4 mb-4">


    {{-- TOTAL ITEMS --}}

    <div class="col-xl-3 col-md-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">


                    <div>

                        <div class="text-muted small mb-2">

                            Laboratory Items

                        </div>


                        <div class="fw-bold fs-3">

                            {{ $items->count() }}

                        </div>

                    </div>


                    <div class="text-primary fs-3">

                        <i class="bi bi-flask"></i>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- AVAILABLE STOCK --}}

    <div class="col-xl-3 col-md-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">


                    <div>

                        <div class="text-muted small mb-2">

                            Available Stock

                        </div>


                        <div class="fw-bold fs-3 text-primary">

                            {{ $remainingStock }}

                        </div>

                    </div>


                    <div class="text-primary fs-3">

                        <i class="bi bi-boxes"></i>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- LOW STOCK --}}

    <div class="col-xl-3 col-md-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">


                    <div>

                        <div class="text-muted small mb-2">

                            Low Stock

                        </div>


                        <div class="fw-bold fs-3 text-warning">

                            {{ $lowStock }}

                        </div>

                    </div>


                    <div class="text-warning fs-3">

                        <i class="bi bi-exclamation-triangle"></i>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- OUT OF STOCK --}}

    <div class="col-xl-3 col-md-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">


                    <div>

                        <div class="text-muted small mb-2">

                            Out of Stock

                        </div>


                        <div class="fw-bold fs-3 text-danger">

                            {{ $outOfStock }}

                        </div>

                    </div>


                    <div class="text-danger fs-3">

                        <i class="bi bi-x-circle"></i>

                    </div>


                </div>

            </div>

        </div>

    </div>


</div>


{{-- SECONDARY STATISTICS --}}

<div class="row g-4 mb-4">


    {{-- CRITICAL STOCK --}}

    <div class="col-md-4">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">


                    <div class="fs-3 text-danger">

                        <i class="bi bi-exclamation-octagon"></i>

                    </div>


                    <div>

                        <div class="text-muted small">

                            Critical Stock

                        </div>


                        <div class="fw-bold fs-4">

                            {{ $criticalStock }}

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- ISSUED ITEMS --}}

    <div class="col-md-4">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">


                    <div class="fs-3 text-primary">

                        <i class="bi bi-arrow-up-right-circle"></i>

                    </div>


                    <div>

                        <div class="text-muted small">

                            Total Issued

                        </div>


                        <div class="fw-bold fs-4">

                            {{ $issuedItems }}

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


    {{-- RESTOCKED ITEMS --}}

    <div class="col-md-4">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex align-items-center gap-3">


                    <div class="fs-3 text-success">

                        <i class="bi bi-arrow-down-left-circle"></i>

                    </div>


                    <div>

                        <div class="text-muted small">

                            Total Restocked

                        </div>


                        <div class="fw-bold fs-4">

                            {{ $restockedItems }}

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


</div>


{{-- LABORATORY ITEMS --}}

<div class="modern-page-card mb-4">

    <div class="card-body p-4 p-md-5">


        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


            <div>

                <h5 class="mb-1">

                    Laboratory Inventory Items

                </h5>


                <p class="text-muted mb-0">

                    Current equipment and materials available in the laboratory.

                </p>

            </div>


            <a
                href="{{ route('inventory.items.index', ['type' => 'laboratory']) }}"
                class="btn btn-sm btn-outline-primary"
            >

                View All

                <i class="bi bi-arrow-right ms-1"></i>

            </a>


        </div>


        @if ($items->count() > 0)


            <div class="table-responsive">

                <table class="table align-middle mb-0">


                    <thead>

                        <tr>

                            <th>

                                Item

                            </th>


                            <th>

                                Quantity

                            </th>


                            <th>

                                Unit

                            </th>


                            <th>

                                Stock Status

                            </th>


                            <th class="text-end">

                                Action

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach ($items->take(10) as $item)


                            <tr>


                                <td>

                                    <div class="fw-semibold">

                                        {{ $item->name }}

                                    </div>


                                    @if ($item->description)

                                        <div class="small text-muted">

                                            {{ \Illuminate\Support\Str::limit($item->description, 60) }}

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    <span class="fw-semibold">

                                        {{ $item->quantity }}

                                    </span>

                                </td>


                                <td>

                                    {{ $item->unit }}

                                </td>


                                <td>


                                    @if ($item->quantity <= 0)

                                        <span class="badge text-bg-danger">

                                            Out of Stock

                                        </span>


                                    @elseif ($item->quantity <= 2)

                                        <span class="badge text-bg-danger">

                                            Critical

                                        </span>


                                    @elseif ($item->quantity <= $item->minimum_quantity)

                                        <span class="badge text-bg-warning">

                                            Low Stock

                                        </span>


                                    @else

                                        <span class="badge text-bg-success">

                                            Available

                                        </span>

                                    @endif


                                </td>


                                <td class="text-end">

                                    <a
                                        href="{{ route('inventory.items.show', $item) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >

                                        View

                                    </a>

                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>

            </div>


        @else


            <div class="text-center py-5">


                <div class="fs-1 text-muted mb-3">

                    <i class="bi bi-flask"></i>

                </div>


                <h5>

                    No Laboratory Items Yet

                </h5>


                <p class="text-muted">

                    Start by adding your first laboratory equipment or material.

                </p>


                <a
                    href="{{ route('inventory.items.create') }}"
                    class="btn btn-primary"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Laboratory Item

                </a>


            </div>


        @endif


    </div>

</div>


{{-- RECENT ACTIVITY --}}

<div class="row g-4">


    {{-- RECENT ISSUES --}}

    <div class="col-lg-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">


                    <div>

                        <h5 class="mb-1">

                            Recent Issues

                        </h5>


                        <p class="text-muted small mb-0">

                            Recently issued laboratory inventory.

                        </p>

                    </div>


                    <a
                        href="{{ route('inventory.issues', ['type' => 'laboratory']) }}"
                        class="btn btn-sm btn-outline-primary"
                    >

                        View All

                    </a>


                </div>


                @if ($recentIssues->count() > 0)


                    <div class="table-responsive">

                        <table class="table align-middle mb-0">


                            <tbody>


                                @foreach ($recentIssues as $issue)


                                    <tr>


                                        <td>

                                            <div class="fw-semibold">

                                                {{ $issue->item?->name }}

                                            </div>


                                            <div class="small text-muted">

                                                @if ($issue->teacher)

                                                    {{ $issue->teacher->name }}

                                                @elseif ($issue->department)

                                                    {{ $issue->department }}

                                                @else

                                                    No recipient

                                                @endif

                                            </div>

                                        </td>


                                        <td class="text-end">

                                            <div class="fw-semibold text-danger">

                                                -{{ $issue->quantity }}

                                            </div>


                                            <div class="small text-muted">

                                                {{ optional($issue->issued_date)->format('d M Y') }}

                                            </div>

                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>

                    </div>


                @else


                    <div class="text-center py-4 text-muted">

                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                        No laboratory issues yet.

                    </div>


                @endif


            </div>

        </div>

    </div>


    {{-- RECENT RESTOCKS --}}

    <div class="col-lg-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">


                    <div>

                        <h5 class="mb-1">

                            Recent Restocks

                        </h5>


                        <p class="text-muted small mb-0">

                            Recently restocked laboratory inventory.

                        </p>

                    </div>


                    <a
                        href="{{ route('inventory.restocks', ['type' => 'laboratory']) }}"
                        class="btn btn-sm btn-outline-success"
                    >

                        View All

                    </a>


                </div>


                @if ($recentRestocks->count() > 0)


                    <div class="table-responsive">

                        <table class="table align-middle mb-0">


                            <tbody>


                                @foreach ($recentRestocks as $restock)


                                    <tr>


                                        <td>

                                            <div class="fw-semibold">

                                                {{ $restock->item?->name }}

                                            </div>

                                        </td>


                                        <td class="text-end">

                                            <div class="fw-semibold text-success">

                                                +{{ $restock->quantity }}

                                            </div>


                                            <div class="small text-muted">

                                                {{ optional($restock->restocked_date)->format('d M Y') }}

                                            </div>

                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>

                    </div>


                @else


                    <div class="text-center py-4 text-muted">

                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                        No laboratory restocks yet.

                    </div>


                @endif


            </div>

        </div>

    </div>


</div>

@endsection