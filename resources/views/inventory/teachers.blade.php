@extends('layouts.app')

@section('content')

<div class="page-header">

<div class="page-title">

    <div class="page-title-icon">

        <i class="bi bi-person-workspace"></i>

    </div>

    <div>

        <h1>Teachers Inventory</h1>

        <p>
            Manage teaching materials, stationery and mathematics tools.
        </p>

    </div>

</div>


<a
    href="{{ route('inventory.items.create') }}"
    class="btn btn-primary"
>

    <i class="bi bi-plus-circle me-2"></i>

    Add Item

</a>

</div>

{{-- ========================================================= --}}
{{-- QUICK SUMMARY --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">

{{-- TOTAL ITEMS --}}

<div class="col-md-4">

    <div class="modern-page-card h-100">

        <div class="card-body">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="summary-icon summary-primary"
                >

                    <i class="bi bi-box-seam"></i>

                </div>


                <div>

                    <div class="text-muted small">

                        Item Types

                    </div>


                    <h3 class="mb-0">

                        {{ $items->count() }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- AVAILABLE STOCK --}}

<div class="col-md-4">

    <div class="modern-page-card h-100">

        <div class="card-body">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="summary-icon summary-success"
                >

                    <i class="bi bi-boxes"></i>

                </div>


                <div>

                    <div class="text-muted small">

                        Total Remaining Stock

                    </div>


                    <h3 class="mb-0">

                        {{ $items->sum('quantity') }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- LOW STOCK --}}

<div class="col-md-4">

    <div class="modern-page-card h-100">

        <div class="card-body">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="summary-icon summary-warning"
                >

                    <i class="bi bi-exclamation-triangle"></i>

                </div>


                <div>

                    <div class="text-muted small">

                        Low Stock Items

                    </div>


                    <h3 class="mb-0">

                        {{
                            $items->filter(
                                fn ($item) =>
                                    $item->quantity <= $item->minimum_stock
                            )->count()
                        }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

</div>
</div>

{{-- ========================================================= --}}
{{-- LOW STOCK ALERT --}}
{{-- ========================================================= --}}

@php

$lowStockItems = $items->filter(
    fn ($item) =>
        $item->quantity <= $item->minimum_stock
);

@endphp

@if($lowStockItems->count() > 0)

<div class="alert alert-warning">

    <div class="d-flex align-items-center gap-3">

        <i
            class="bi bi-exclamation-triangle-fill"
            style="font-size: 24px;"
        ></i>


        <div>

            <strong>

                Low Stock Alert

            </strong>


            <div>

                {{
                    $lowStockItems->count()
                }}

                item(s) require restocking.

            </div>

        </div>


        <a
            href="{{ route('inventory.low-stock') }}"
            class="btn btn-warning ms-auto"
        >

            View Details

        </a>

    </div>

</div>

@endif

{{-- ========================================================= --}}
{{-- INVENTORY TABLE --}}
{{-- ========================================================= --}}

<div class="modern-page-card">

<div class="card-body">


    {{-- HEADER --}}

    <div
        class="
            d-flex
            flex-column
            flex-md-row
            justify-content-between
            align-items-md-center
            gap-3
            mb-4
        "
    >

        <div>

            <h5 class="mb-1">

                Teaching Materials

            </h5>


            <p class="text-muted mb-0">

                View, manage and issue materials to teachers and departments.

            </p>

        </div>


        <a
            href="{{ route('inventory.issues') }}"
            class="btn btn-outline-primary"
        >

            <i class="bi bi-clock-history me-2"></i>

            Issue History

        </a>

    </div>


    {{-- TABLE RESPONSIVE --}}

    <div class="table-responsive">


        <table class="table modern-table align-middle">


            <thead>

                <tr>

                    <th>

                        Item

                    </th>


                    <th>

                        Category

                    </th>


                    <th>

                        Remaining

                    </th>


                    <th>

                        Status

                    </th>


                    <th>

                        Last Updated

                    </th>


                    <th class="text-end">

                        Actions

                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($items as $item)


                    @php

                        $isOutOfStock =
                            $item->quantity <= 0;


                        $isLowStock =
                            $item->quantity > 0
                            &&
                            $item->quantity <=
                            $item->minimum_stock;

                    @endphp


                    <tr>


                        {{-- ITEM NAME --}}

                        <td>

                            <div
                                class="
                                    d-flex
                                    align-items-center
                                    gap-3
                                "
                            >

                                <div
                                    class="item-icon"
                                >

                                    <i class="bi bi-box"></i>

                                </div>


                                <div>

                                    <strong>

                                        {{ $item->name }}

                                    </strong>


                                    @if($item->description)

                                        <div
                                            class="
                                                text-muted
                                                small
                                            "
                                        >

                                            {{
                                                \Illuminate\Support\Str::limit(
                                                    $item->description,
                                                    55
                                                )
                                            }}

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </td>


                        {{-- CATEGORY --}}

                        <td>

                            @if($item->category)

                                <span
                                    class="
                                        badge-soft-primary
                                    "
                                >

                                    {{
                                        $item->category->name
                                    }}

                                </span>

                            @else

                                <span
                                    class="text-muted"
                                >

                                    No Category

                                </span>

                            @endif

                        </td>


                        {{-- QUANTITY --}}

                        <td>

                            <strong>

                                {{ $item->quantity }}

                            </strong>

                        </td>


                        {{-- STATUS --}}

                        <td>


                            @if($isOutOfStock)

                                <span
                                    class="
                                        badge-soft-danger
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-x-circle
                                            me-1
                                        "
                                    ></i>

                                    Out of Stock

                                </span>


                            @elseif($isLowStock)

                                <span
                                    class="
                                        badge-soft-warning
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-exclamation-triangle
                                            me-1
                                        "
                                    ></i>

                                    Low Stock

                                </span>


                            @else

                                <span
                                    class="
                                        badge-soft-success
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-check-circle
                                            me-1
                                        "
                                    ></i>

                                    Available

                                </span>

                            @endif


                        </td>


                        {{-- UPDATED --}}

                        <td>

                            <span
                                class="text-muted"
                            >

                                {{
                                    $item->updated_at
                                        ? $item->updated_at->format(
                                            'd M Y'
                                        )
                                        : '-'
                                }}

                            </span>

                        </td>


                        {{-- ACTIONS --}}

                        <td class="text-end">


                            {{-- VIEW --}}

                            <a
                                href="{{ route('inventory.items.show', $item) }}"
                                class="
                                    action-btn
                                    action-view
                                "
                                title="View Item"
                            >

                                <i
                                    class="
                                        bi
                                        bi-eye
                                    "
                                ></i>

                            </a>


                            {{-- ISSUE --}}

                            @if(
                                $item->quantity > 0
                            )

                                <a
                                    href="{{ route('inventory.items.issue', $item) }}"
                                    class="
                                        action-btn
                                        action-issue
                                    "
                                    title="Issue Item"
                                >

                                    <i
                                        class="
                                            bi
                                            bi-box-arrow-up-right
                                        "
                                    ></i>

                                </a>

                            @endif


                            {{-- EDIT --}}

                            <a
                                href="{{ route('inventory.items.edit', $item) }}"
                                class="
                                    action-btn
                                    action-edit
                                "
                                title="Edit Item"
                            >

                                <i
                                    class="
                                        bi
                                        bi-pencil
                                    "
                                ></i>

                            </a>


                            {{-- DELETE --}}

                            <form
                                action="{{ route('inventory.items.destroy', $item) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="
                                    return confirm(
                                        'Are you sure you want to delete this inventory item?'
                                    );
                                "
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="
                                        action-btn
                                        action-delete
                                    "
                                    title="Delete Item"
                                >

                                    <i
                                        class="
                                            bi
                                            bi-trash
                                        "
                                    ></i>

                                </button>

                            </form>


                        </td>


                    </tr>


                @empty


                    <tr>

                        <td
                            colspan="6"
                            class="
                                text-center
                                py-5
                            "
                        >

                            <div
                                class="
                                    empty-state
                                "
                            >

                                <i
                                    class="
                                        bi
                                        bi-box-seam
                                    "
                                ></i>


                                <h5>

                                    No Teaching Materials Yet

                                </h5>


                                <p>

                                    Start by adding markers, pens, files,
                                    manila papers or mathematics tools.

                                </p>


                                <a
                                    href="{{ route('inventory.items.create') }}"
                                    class="
                                        btn
                                        btn-primary
                                    "
                                >

                                    <i
                                        class="
                                            bi
                                            bi-plus-circle
                                            me-2
                                        "
                                    ></i>

                                    Add First Item

                                </a>

                            </div>

                        </td>

                    </tr>


                @endforelse


            </tbody>


        </table>


    </div>


</div>
</div>

{{-- ========================================================= --}}
{{-- PAGE STYLES --}}
{{-- ========================================================= --}}

<style>

    .summary-icon {

        width: 55px;

        height: 55px;

        min-width: 55px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 15px;

        font-size: 23px;

    }


    .summary-primary {

        background: #EFF6FF;

        color: #2563EB;

    }


    .summary-success {

        background: #ECFDF5;

        color: #059669;

    }


    .summary-warning {

        background: #FFFBEB;

        color: #D97706;

    }


    .item-icon {

        width: 42px;

        height: 42px;

        min-width: 42px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 12px;

        color: #2563EB;

        background: #EFF6FF;

        font-size: 18px;

    }


    .action-issue {

        background: #F5F3FF;

        color: #7C3AED;

    }


    .action-issue:hover {

        background: #7C3AED;

        color: white;

    }


    .empty-state {

        max-width: 450px;

        margin: 0 auto;

    }


    .empty-state > i {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        width: 75px;

        height: 75px;

        margin-bottom: 18px;

        border-radius: 20px;

        font-size: 34px;

        color: #2563EB;

        background: #EFF6FF;

    }


    .empty-state h5 {

        font-weight: 700;

        margin-bottom: 8px;

    }


    .empty-state p {

        color: #64748B;

        margin-bottom: 20px;

    }


    @media (max-width: 768px) {

        .page-header {

            gap: 15px;

        }


        .page-header .btn {

            width: 100%;

        }


        .modern-table th,
        .modern-table td {

            white-space: nowrap;

        }

    }

</style>

@endsection
