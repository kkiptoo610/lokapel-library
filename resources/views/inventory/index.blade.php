@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-box-seam"></i>

        </div>

        <div>

            <h1>Inventory Management</h1>

            <p>
                Manage teaching materials, laboratory supplies and issued items.
            </p>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- INVENTORY STATISTICS --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">


    {{-- ========================================================= --}}
    {{-- TOTAL ITEMS --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.items.index') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Total Item Types

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $totalItems }}

                            </h2>

                            <div class="stat-card-action">

                                View inventory

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #EFF6FF;
                                color: #2563EB;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-boxes"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- REMAINING STOCK --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.items.index') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Remaining Stock

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $totalStock }}

                            </h2>

                            <div
                                class="stat-card-action"
                                style="color: #059669;"
                            >

                                View inventory

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #ECFDF5;
                                color: #059669;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-box-seam-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- LOW STOCK --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.low-stock') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Low Stock Items

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $lowStockCount }}

                            </h2>

                            <div class="stat-card-action text-warning">

                                View low stock

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #FFFBEB;
                                color: #D97706;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-exclamation-triangle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- ITEMS ISSUED --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.issues') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Items Issued

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $issuedItemsCount }}

                            </h2>

                            <div class="stat-card-action text-purple">

                                View issue history

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #F5F3FF;
                                color: #7C3AED;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-arrow-up-right-square-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- ISSUE ITEM CARD --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.items.index') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Issue Item

                            </div>

                            <h5 class="mb-0 fw-bold">

                                Issue Inventory

                            </h5>

                            <div
                                class="stat-card-action"
                                style="color: #DC2626;"
                            >

                                Select an item to issue

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #FEF2F2;
                                color: #DC2626;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-send-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- TOTAL RESTOCKED --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.restocks') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Total Restocked

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $restockedItemsCount }}

                            </h2>

                            <div
                                class="stat-card-action"
                                style="color: #0891B2;"
                            >

                                View restock history

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #ECFEFF;
                                color: #0891B2;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-box-arrow-in-down"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- OUT OF STOCK --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.low-stock') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Out of Stock

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $outOfStockCount }}

                            </h2>

                            <div
                                class="stat-card-action"
                                style="color: #DC2626;"
                            >

                                Requires attention

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #FEF2F2;
                                color: #DC2626;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-x-circle-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- RESTOCK RECORDS --}}
    {{-- ========================================================= --}}

    <div class="col-md-6 col-xl-3">

        <a
            href="{{ route('inventory.restocks') }}"
            class="dashboard-stat-link"
        >

            <div class="modern-page-card h-100 dashboard-stat-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="text-muted small mb-2">

                                Restock Records

                            </div>

                            <h2 class="mb-0 fw-bold">

                                {{ $totalRestockRecords }}

                            </h2>

                            <div
                                class="stat-card-action"
                                style="color: #16A34A;"
                            >

                                View records

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </div>


                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="
                                width: 55px;
                                height: 55px;
                                border-radius: 15px;
                                background: #F0FDF4;
                                color: #16A34A;
                                font-size: 24px;
                            "
                        >

                            <i class="bi bi-clock-history"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


</div>


{{-- ========================================================= --}}
{{-- LOW STOCK ALERT --}}
{{-- ========================================================= --}}

@if($lowStockCount > 0)

    <div class="alert alert-warning mb-4">

        <div class="d-flex align-items-center gap-3">

            <i
                class="bi bi-exclamation-triangle-fill"
                style="font-size: 24px;"
            ></i>


            <div>

                <strong>
                    Low Stock Warning
                </strong>


                <div class="mt-1">

                    There are

                    <strong>
                        {{ $lowStockCount }}
                    </strong>

                    inventory item(s) that require attention.

                </div>

            </div>


            <a
                href="{{ route('inventory.low-stock') }}"
                class="btn btn-warning ms-auto"
            >

                View Low Stock

            </a>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- INVENTORY FOLDERS --}}
{{-- ========================================================= --}}

<div class="row g-4">


    {{-- TEACHERS INVENTORY --}}

    <div class="col-md-6">

        <a
            href="{{ route('inventory.teachers') }}"
            class="text-decoration-none"
        >

            <div class="modern-page-card h-100 inventory-folder">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-4">

                        <div
                            class="inventory-folder-icon"
                            style="
                                background: #EFF6FF;
                                color: #2563EB;
                            "
                        >

                            <i class="bi bi-person-workspace"></i>

                        </div>


                        <div class="flex-grow-1">

                            <h4 class="mb-2">
                                Teachers Inventory
                            </h4>


                            <p class="text-muted mb-3">

                                Manage teaching materials issued to teachers
                                and departments.

                            </p>


                            <div class="d-flex flex-wrap gap-2">

                                <span class="badge-soft-primary">
                                    <i class="bi bi-pen me-1"></i>
                                    Pens
                                </span>


                                <span class="badge-soft-primary">
                                    <i class="bi bi-pencil me-1"></i>
                                    Markers
                                </span>


                                <span class="badge-soft-primary">
                                    <i class="bi bi-file-earmark me-1"></i>
                                    Files
                                </span>


                                <span class="badge-soft-primary">
                                    <i class="bi bi-calculator me-1"></i>
                                    Mathematics Tools
                                </span>

                            </div>

                        </div>


                        <div class="inventory-arrow">

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- LABORATORY INVENTORY --}}

    <div class="col-md-6">

        <a
            href="{{ route('inventory.laboratory') }}"
            class="text-decoration-none"
        >

            <div class="modern-page-card h-100 inventory-folder">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-4">

                        <div
                            class="inventory-folder-icon"
                            style="
                                background: #ECFDF5;
                                color: #059669;
                            "
                        >

                            <i class="bi bi-flask-fill"></i>

                        </div>


                        <div class="flex-grow-1">

                            <h4 class="mb-2">
                                Laboratory Inventory
                            </h4>


                            <p class="text-muted mb-3">

                                Manage laboratory chemicals, equipment
                                and consumable supplies.

                            </p>


                            <div class="d-flex flex-wrap gap-2">

                                <span class="badge-soft-success">
                                    <i class="bi bi-droplet-fill me-1"></i>
                                    Chemicals
                                </span>


                                <span class="badge-soft-success">
                                    <i class="bi bi-beaker me-1"></i>
                                    Equipment
                                </span>


                                <span class="badge-soft-success">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Consumables
                                </span>

                            </div>

                        </div>


                        <div class="inventory-arrow">

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>

</div>


{{-- ========================================================= --}}
{{-- RECENT INVENTORY ACTIVITY --}}
{{-- ========================================================= --}}

<div class="row g-4 mt-1">


    {{-- RECENT ISSUES --}}

    <div class="col-lg-6">

        <div class="modern-page-card h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="mb-1">

                            <i class="bi bi-arrow-up-right-square-fill me-2 text-purple"></i>

                            Recent Issues

                        </h5>

                        <p class="text-muted small mb-0">

                            Recently issued inventory items.

                        </p>

                    </div>


                    <a
                        href="{{ route('inventory.issues') }}"
                        class="btn btn-sm btn-outline-primary"
                    >

                        View All

                    </a>

                </div>


                @if($recentIssues->count())

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>Item</th>

                                    <th>Quantity</th>

                                    <th>Date</th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($recentIssues as $issue)

                                    <tr>

                                        <td>

                                            <div class="fw-semibold">

                                                {{ $issue->item?->name ?? 'Unknown Item' }}

                                            </div>

                                            <div class="small text-muted">

                                                {{ $issue->teacher?->name ?? ($issue->department ?? 'N/A') }}

                                            </div>

                                        </td>


                                        <td>

                                            <span class="fw-semibold">

                                                {{ $issue->quantity }}

                                            </span>

                                            {{ $issue->item?->unit }}

                                        </td>


                                        <td>

                                            {{ optional($issue->issued_date)->format('d M Y') ?? $issue->issued_date }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-inbox"
                            style="font-size: 35px;"
                        ></i>

                        <div class="mt-2">

                            No recent issues found.

                        </div>

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

                            <i
                                class="bi bi-box-arrow-in-down me-2"
                                style="color: #0891B2;"
                            ></i>

                            Recent Restocks

                        </h5>

                        <p class="text-muted small mb-0">

                            Recently restocked inventory items.

                        </p>

                    </div>


                    <a
                        href="{{ route('inventory.restocks') }}"
                        class="btn btn-sm btn-outline-primary"
                    >

                        View All

                    </a>

                </div>


                @if($recentRestocks->count())

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>Item</th>

                                    <th>Quantity</th>

                                    <th>Date</th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($recentRestocks as $restock)

                                    <tr>

                                        <td>

                                            <div class="fw-semibold">

                                                {{ $restock->item?->name ?? 'Unknown Item' }}

                                            </div>

                                            <div class="small text-muted">

                                                {{ $restock->item?->category?->name ?? 'No Category' }}

                                            </div>

                                        </td>


                                        <td>

                                            <span class="fw-semibold text-success">

                                                +{{ $restock->quantity }}

                                            </span>

                                            {{ $restock->item?->unit }}

                                        </td>


                                        <td>

                                            {{ optional($restock->restocked_date)->format('d M Y') ?? $restock->restocked_date }}

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-4 text-muted">

                        <i
                            class="bi bi-box-arrow-in-down"
                            style="font-size: 35px;"
                        ></i>

                        <div class="mt-2">

                            No recent restocks found.

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- QUICK ACTIONS --}}
{{-- ========================================================= --}}

<div class="modern-page-card mt-4">

    <div class="card-body">

        <div
            class="
                d-flex
                flex-column
                flex-md-row
                justify-content-between
                align-items-md-center
                gap-3
            "
        >

            <div>

                <h5 class="mb-1">

                    Quick Actions

                </h5>


                <p class="text-muted mb-0">

                    Quickly add, issue, or restock inventory items.

                </p>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <a
                    href="{{ route('inventory.items.create') }}"
                    class="btn btn-primary"
                >

                    <i class="bi bi-plus-circle me-2"></i>

                    Add Inventory Item

                </a>


                <a
                    href="{{ route('inventory.items.index') }}"
                    class="btn btn-outline-danger"
                >

                    <i class="bi bi-send-fill me-2"></i>

                    Issue Item

                </a>


                <a
                    href="{{ route('inventory.issues') }}"
                    class="btn btn-outline-primary"
                >

                    <i class="bi bi-clock-history me-2"></i>

                    View Issue History

                </a>


                <a
                    href="{{ route('inventory.restocks') }}"
                    class="btn btn-outline-success"
                >

                    <i class="bi bi-box-arrow-in-down me-2"></i>

                    View Restock History

                </a>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- PAGE STYLES --}}
{{-- ========================================================= --}}

<style>

    .dashboard-stat-link {

        display: block;

        height: 100%;

        color: inherit;

        text-decoration: none;

    }


    .dashboard-stat-card {

        position: relative;

        overflow: hidden;

        cursor: pointer;

        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;

    }


    .dashboard-stat-card:hover {

        transform: translateY(-5px);

        border-color: #BFDBFE;

        box-shadow:
            0 18px 40px
            rgba(15, 23, 42, 0.10);

    }


    .dashboard-stat-card:hover h2 {

        color: #2563EB;

    }


    .stat-card-action {

        margin-top: 10px;

        display: flex;

        align-items: center;

        gap: 6px;

        color: #2563EB;

        font-size: 12px;

        font-weight: 600;

        transition: all 0.25s ease;

    }


    .dashboard-stat-card:hover .stat-card-action {

        gap: 10px;

    }


    .text-purple {

        color: #7C3AED !important;

    }


    .inventory-folder {

        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;

        cursor: pointer;

    }


    .inventory-folder:hover {

        transform: translateY(-5px);

        border-color: #BFDBFE;

        box-shadow:
            0 18px 40px
            rgba(15, 23, 42, 0.10);

    }


    .inventory-folder-icon {

        width: 70px;

        height: 70px;

        min-width: 70px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 18px;

        font-size: 30px;

    }


    .inventory-arrow {

        width: 42px;

        height: 42px;

        min-width: 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        color: #64748B;

        background: #F8FAFC;

        transition: all 0.25s ease;

    }


    .inventory-folder:hover .inventory-arrow {

        color: white;

        background: #2563EB;

        transform: translateX(4px);

    }


    .modern-page-card .table th {

        color: #64748B;

        font-size: 12px;

        font-weight: 600;

        border-top: none;

    }


    .modern-page-card .table td {

        vertical-align: middle;

    }


    @media (max-width: 576px) {

        .inventory-folder-icon {

            width: 55px;

            height: 55px;

            min-width: 55px;

            font-size: 24px;

        }


        .inventory-arrow {

            display: none;

        }


        .dashboard-stat-card {

            min-height: 150px;

        }

    }

</style>

@endsection