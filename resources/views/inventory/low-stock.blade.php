@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div
            class="page-title-icon"
            style="
                background: #FFFBEB;
                color: #D97706;
            "
        >

            <i class="bi bi-exclamation-triangle-fill"></i>

        </div>

        <div>

            <h1>Low Stock Inventory</h1>

            <p>

                Items that have reached or fallen below their minimum stock level.

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


        @if ($items->count())


            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Item</th>

                            <th>Category</th>

                            <th>Type</th>

                            <th>Current Stock</th>

                            <th>Minimum Level</th>

                            <th>Status</th>

                            <th class="text-end">

                                Actions

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($items as $item)

                            <tr>

                                <td>

                                    <a
                                        href="{{ route('inventory.items.show', $item) }}"
                                        class="fw-semibold text-decoration-none"
                                    >

                                        {{ $item->name }}

                                    </a>

                                </td>


                                <td>

                                    {{ $item->category?->name ?? '—' }}

                                </td>


                                <td class="text-capitalize">

                                    {{ $item->category?->type ?? '—' }}

                                </td>


                                <td>

                                    <span
                                        class="
                                            fw-bold
                                            @if($item->quantity <= 0)
                                                text-danger
                                            @else
                                                text-warning
                                            @endif
                                        "
                                    >

                                        {{ $item->quantity }}

                                        {{ $item->unit }}

                                    </span>

                                </td>


                                <td>

                                    {{ $item->minimum_quantity }}

                                </td>


                                <td>

                                    @if ($item->quantity <= 0)

                                        <span class="badge bg-danger">

                                            Out of Stock

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Low Stock

                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    <div class="d-flex justify-content-end gap-2">


                                        <a
                                            href="{{ route('inventory.items.show', $item) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        @if ($item->quantity > 0)

                                            <a
                                                href="{{ route('inventory.items.issue', $item) }}"
                                                class="btn btn-sm btn-primary"
                                            >

                                                Issue

                                            </a>

                                        @endif


                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            <div class="mt-4">

                {{ $items->links() }}

            </div>


        @else


            <div class="text-center py-5">


                <div
                    class="
                        d-inline-flex
                        align-items-center
                        justify-content-center
                        rounded-circle
                        mb-3
                    "
                    style="
                        width: 75px;
                        height: 75px;
                        background: #ECFDF5;
                        color: #059669;
                        font-size: 32px;
                    "
                >

                    <i class="bi bi-check-circle-fill"></i>

                </div>


                <h5>

                    Inventory Stock Levels Are Healthy

                </h5>


                <p class="text-muted mb-0">

                    There are currently no items requiring stock attention.

                </p>


            </div>


        @endif


    </div>

</div>

@endsection