@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-boxes"></i>

        </div>

        <div>

            <h1>All Inventory Items</h1>

            <p>
                View, manage, issue and restock all inventory items.
            </p>

        </div>

    </div>


    <div class="d-flex gap-2">

        <a
            href="{{ route('inventory.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="bi bi-arrow-left me-2"></i>

            Back to Inventory

        </a>


        <a
            href="{{ route('inventory.items.create') }}"
            class="btn btn-primary"
        >

            <i class="bi bi-plus-circle me-2"></i>

            Add Inventory Item

        </a>

    </div>

</div>


{{-- SUCCESS MESSAGE --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>

@endif


{{-- INVENTORY CARD --}}

<div class="modern-page-card">

    <div class="card-body p-4">


        {{-- SEARCH --}}

        <form
            method="GET"
            action="{{ route('inventory.items.index') }}"
            class="mb-4"
        >

            <div class="row g-3">


                <div class="col-md-6">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search inventory items..."
                            value="{{ request('search') }}"
                        >

                    </div>

                </div>


                <div class="col-md-4">

                    <select
                        name="category"
                        class="form-select"
                    >

                        <option value="">

                            All Categories

                        </option>


                        @foreach($categories ?? [] as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    request('category') == $category->id
                                )
                            >

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-outline-primary w-100"
                    >

                        <i class="bi bi-funnel me-1"></i>

                        Filter

                    </button>

                </div>

            </div>

        </form>


        {{-- TABLE --}}

        @if($items->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">


                    <thead>

                        <tr>

                            <th>Item</th>

                            <th>Category</th>

                            <th>Available Stock</th>

                            <th>Minimum Stock</th>

                            <th>Status</th>

                            <th class="text-end">

                                Actions

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($items as $item)

                            @php

                                $isOutOfStock =
                                    (int) $item->quantity <= 0;


                                $isLowStock =
                                    !$isOutOfStock
                                    &&
                                    (int) $item->quantity
                                    <=
                                    (int) $item->minimum_quantity;

                            @endphp


                            <tr>


                                {{-- ITEM --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $item->name }}

                                    </div>


                                    @if($item->description)

                                        <div class="small text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $item->description,
                                                60
                                            ) }}

                                        </div>

                                    @endif

                                </td>


                                {{-- CATEGORY --}}

                                <td>

                                    @if($item->category)

                                        <span
                                            class="
                                                badge
                                                bg-light
                                                text-dark
                                                border
                                            "
                                        >

                                            {{ $item->category->name }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            No Category

                                        </span>

                                    @endif

                                </td>


                                {{-- AVAILABLE STOCK --}}

                                <td>

                                    <span
                                        class="
                                            fw-bold
                                            fs-6
                                            @if($isOutOfStock)
                                                text-danger
                                            @elseif($isLowStock)
                                                text-warning
                                            @else
                                                text-success
                                            @endif
                                        "
                                    >

                                        {{ $item->quantity }}

                                    </span>


                                    <span class="text-muted">

                                        {{ $item->unit }}

                                    </span>

                                </td>


                                {{-- MINIMUM STOCK --}}

                                <td>

                                    {{ $item->minimum_quantity }}

                                    <span class="text-muted">

                                        {{ $item->unit }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if($isOutOfStock)

                                        <span
                                            class="
                                                badge
                                                bg-danger-subtle
                                                text-danger
                                            "
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-x-circle-fill
                                                    me-1
                                                "
                                            ></i>

                                            Out of Stock

                                        </span>


                                    @elseif($isLowStock)

                                        <span
                                            class="
                                                badge
                                                bg-warning-subtle
                                                text-warning-emphasis
                                            "
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-exclamation-triangle-fill
                                                    me-1
                                                "
                                            ></i>

                                            Low Stock

                                        </span>


                                    @else

                                        <span
                                            class="
                                                badge
                                                bg-success-subtle
                                                text-success
                                            "
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-check-circle-fill
                                                    me-1
                                                "
                                            ></i>

                                            In Stock

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTIONS --}}

                                <td class="text-end">


                                    <div
                                        class="
                                            d-flex
                                            justify-content-end
                                            flex-wrap
                                            gap-2
                                        "
                                    >


                                        {{-- VIEW --}}

                                        <a
                                            href="{{
                                                route(
                                                    'inventory.items.show',
                                                    $item
                                                )
                                            }}"
                                            class="
                                                btn
                                                btn-sm
                                                btn-outline-primary
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


                                        {{-- ISSUE ITEM --}}

                                        @if(!$isOutOfStock)

                                            <a
                                                href="{{
                                                    route(
                                                        'inventory.items.issue',
                                                        $item
                                                    )
                                                }}"
                                                class="
                                                    btn
                                                    btn-sm
                                                    btn-primary
                                                "
                                                title="Issue Item"
                                            >

                                                <i
                                                    class="
                                                        bi
                                                        bi-arrow-up-right-circle
                                                        me-1
                                                    "
                                                ></i>

                                                Issue

                                            </a>

                                        @else

                                            <button
                                                type="button"
                                                class="
                                                    btn
                                                    btn-sm
                                                    btn-secondary
                                                "
                                                disabled
                                                title="Item is out of stock"
                                            >

                                                <i
                                                    class="
                                                        bi
                                                        bi-arrow-up-right-circle
                                                        me-1
                                                    "
                                                ></i>

                                                Issue

                                            </button>

                                        @endif


                                        {{-- RESTOCK --}}

                                        <a
                                            href="{{
                                                route(
                                                    'inventory.items.restock',
                                                    $item
                                                )
                                            }}"
                                            class="
                                                btn
                                                btn-sm
                                                btn-outline-success
                                            "
                                            title="Restock Item"
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-box-arrow-in-down
                                                "
                                            ></i>

                                        </a>


                                        {{-- EDIT --}}

                                        <a
                                            href="{{
                                                route(
                                                    'inventory.items.edit',
                                                    $item
                                                )
                                            }}"
                                            class="
                                                btn
                                                btn-sm
                                                btn-outline-secondary
                                            "
                                            title="Edit Item"
                                        >

                                            <i
                                                class="
                                                    bi
                                                    bi-pencil-square
                                                "
                                            ></i>

                                        </a>


                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}

            <div
                class="
                    d-flex
                    justify-content-center
                    mt-4
                "
            >

                {{ $items->withQueryString()->links() }}

            </div>


        @else

            {{-- EMPTY STATE --}}

            <div
                class="
                    text-center
                    py-5
                    text-muted
                "
            >

                <i
                    class="
                        bi
                        bi-box-seam
                    "
                    style="font-size: 50px;"
                ></i>


                <h5 class="mt-3">

                    No Inventory Items Found

                </h5>


                <p>

                    There are currently no inventory items matching
                    your search.

                </p>


                <a
                    href="{{ route('inventory.items.create') }}"
                    class="btn btn-primary mt-2"
                >

                    <i
                        class="
                            bi
                            bi-plus-circle
                            me-2
                        "
                    ></i>

                    Add Inventory Item

                </a>

            </div>

        @endif


    </div>

</div>


<style>

    .page-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 20px;

        margin-bottom: 30px;

    }


    .page-title {

        display: flex;

        align-items: center;

        gap: 15px;

    }


    .page-title h1 {

        margin-bottom: 4px;

        font-size: 26px;

        font-weight: 700;

    }


    .page-title p {

        margin-bottom: 0;

        color: #64748B;

    }


    .page-title-icon {

        width: 55px;

        height: 55px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 15px;

        background: #EFF6FF;

        color: #2563EB;

        font-size: 24px;

    }


    @media (max-width: 768px) {

        .page-header {

            flex-direction: column;

            align-items: flex-start;

        }

    }

</style>

@endsection