@extends('layouts.app')

@section('content')

<div class="page-header">

<div class="page-title">

    <div class="page-title-icon">

        <i class="bi bi-box-arrow-in-down"></i>

    </div>

    <div>

        <h1>Restock {{ $item->name }}</h1>

        <p>
            Add stock to this inventory item and record the restock history.
        </p>

    </div>

</div>


<div class="d-flex gap-2 flex-wrap">

    {{-- BACK TO ITEM --}}

    <a
        href="{{ route('inventory.items.show', $item) }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-2"></i>

        Back to Item

    </a>


    {{-- BACK TO INVENTORY --}}

    <a
        href="{{ route('inventory.index') }}"
        class="btn btn-outline-primary"
    >

        <i class="bi bi-box-seam me-2"></i>

        Inventory

    </a>

</div>
</div>

@if (session('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

    <i class="bi bi-check-circle-fill me-2"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    ></button>

</div>

@endif

@if (session('error'))

<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <i class="bi bi-exclamation-triangle-fill me-2"></i>

    {{ session('error') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    ></button>

</div>


@endif

@if ($errors->any())

<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <div class="fw-semibold mb-2">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        Please correct the following errors:

    </div>

    <ul class="mb-0">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    ></button>

</div>

@endif

<div class="row g-4">

{{-- RESTOCK FORM --}}

<div class="col-lg-8">

    <div class="modern-page-card">

        <div class="card-body p-4">

            <div class="mb-4">

                <h5 class="mb-1">

                    <i class="bi bi-box-arrow-in-down me-2"></i>

                    Restock Inventory

                </h5>

                <p class="text-muted mb-0">

                    Enter the quantity you want to add to the current stock.

                </p>

            </div>


            <form
                action="{{ route('inventory.items.restock.store', $item) }}"
                method="POST"
            >

                @csrf


                {{-- CURRENT STOCK --}}

                <div class="row g-4 mb-3">

                    <div class="col-md-6">

                        <label class="form-label">

                            Current Quantity

                        </label>

                        <div class="form-control bg-light">

                            <span class="fw-bold">

                                {{ $item->quantity }}

                            </span>

                            {{ $item->unit }}

                        </div>

                    </div>


                    {{-- MINIMUM STOCK --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Minimum Quantity

                        </label>

                        <div class="form-control bg-light">

                            <span class="fw-bold">

                                {{ $item->minimum_quantity }}

                            </span>

                            {{ $item->unit }}

                        </div>

                    </div>

                </div>


                {{-- RESTOCK QUANTITY --}}

                <div class="mb-4">

                    <label
                        for="quantity"
                        class="form-label fw-semibold"
                    >

                        Restock Quantity

                        <span class="text-danger">*</span>

                    </label>

                    <div class="input-group input-group-lg">

                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            class="form-control @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity') }}"
                            min="1"
                            step="1"
                            required
                            autofocus
                            placeholder="Enter quantity to add"
                        >

                        <span class="input-group-text">

                            {{ $item->unit }}

                        </span>

                        @error('quantity')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="form-text">

                        Example: If current stock is 10 and you restock 20,
                        the new stock will be 30.

                    </div>

                </div>


                {{-- PROJECTED STOCK --}}

                <div class="alert alert-info mb-4">

                    <div class="d-flex align-items-center">

                        <i
                            class="bi bi-calculator me-3"
                            style="font-size: 28px;"
                        ></i>

                        <div>

                            <div class="small text-muted">

                                Projected Quantity

                            </div>

                            <div
                                class="fw-bold fs-4"
                                id="projectedQuantity"
                            >

                                {{ $item->quantity }}

                                {{ $item->unit }}

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RESTOCK DATE --}}

                <div class="mb-4">

                    <label
                        for="restocked_date"
                        class="form-label fw-semibold"
                    >

                        Restock Date

                        <span class="text-danger">*</span>

                    </label>

                    <input
                        type="date"
                        name="restocked_date"
                        id="restocked_date"
                        class="form-control @error('restocked_date') is-invalid @enderror"
                        value="{{ old('restocked_date', now()->format('Y-m-d')) }}"
                        required
                    >

                    @error('restocked_date')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- REMARKS --}}

                <div class="mb-4">

                    <label
                        for="remarks"
                        class="form-label fw-semibold"
                    >

                        Remarks

                        <span class="text-muted fw-normal">
                            (Optional)
                        </span>

                    </label>

                    <textarea
                        name="remarks"
                        id="remarks"
                        class="form-control @error('remarks') is-invalid @enderror"
                        rows="4"
                        placeholder="Enter any additional information about this restock..."
                    >{{ old('remarks') }}</textarea>

                    @error('remarks')

                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- ACTIONS --}}

                <div class="d-flex gap-2 flex-wrap">

                    <button
                        type="submit"
                        class="btn btn-primary btn-lg"
                    >

                        <i class="bi bi-box-arrow-in-down me-2"></i>

                        Restock Item

                    </button>


                    <a
                        href="{{ route('inventory.items.show', $item) }}"
                        class="btn btn-outline-secondary btn-lg"
                    >

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ITEM SUMMARY --}}

<div class="col-lg-4">

    <div class="modern-page-card">

        <div class="card-body p-4">

            <div class="text-muted small mb-2">

                Inventory Item

            </div>

            <h4 class="mb-3">

                {{ $item->name }}

            </h4>


            <div class="mb-3">

                <div class="text-muted small">

                    Category

                </div>

                <div class="fw-semibold">

                    {{ $item->category?->name ?? 'No Category' }}

                </div>

            </div>


            <div class="mb-3">

                <div class="text-muted small">

                    Inventory Type

                </div>

                <div class="fw-semibold text-capitalize">

                    {{ $item->category?->type ?? 'N/A' }}

                </div>

            </div>


            <hr>


            <div class="text-muted small mb-1">

                Current Stock

            </div>

            <div class="fw-bold fs-2">

                {{ $item->quantity }}

            </div>

            <div class="text-muted">

                {{ $item->unit }}

            </div>


            <hr>


            {{-- STOCK STATUS --}}

            <div class="text-muted small mb-2">

                Current Stock Status

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

        </div>

    </div>


    {{-- HOW RESTOCK WORKS --}}

    <div class="modern-page-card mt-4">

        <div class="card-body p-4">

            <h6 class="mb-3">

                <i class="bi bi-info-circle me-2"></i>

                How Restocking Works

            </h6>


            <div class="small text-muted">

                <p class="mb-2">

                    The quantity you enter will be <strong>added</strong>
                    to the current inventory quantity.

                </p>

                <p class="mb-2">

                    For example:

                </p>

                <div class="bg-light rounded p-3 mb-2">

                    Current stock:

                    <strong>{{ $item->quantity }}</strong>

                    {{ $item->unit }}

                    <br>

                    Restock:

                    <strong>20</strong>

                    {{ $item->unit }}

                    <br>

                    <hr class="my-2">

                    New stock:

                    <strong>{{ $item->quantity + 20 }}</strong>

                    {{ $item->unit }}

                </div>

                <p class="mb-0">

                    A restock history record will also be saved for
                    this item.

                </p>

            </div>

        </div>

    </div>

</div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const quantityInput =
            document.getElementById('quantity');

        const projectedQuantity =
            document.getElementById('projectedQuantity');

        const currentQuantity =
            {{ (int) $item->quantity }};

        const unit =
            @json($item->unit);


        function updateProjectedQuantity() {

            const restockQuantity =
                parseInt(quantityInput.value, 10) || 0;

            const newQuantity =
                currentQuantity + restockQuantity;

            projectedQuantity.textContent =
                newQuantity + ' ' + unit;

        }


        quantityInput.addEventListener(
            'input',
            updateProjectedQuantity
        );


        updateProjectedQuantity();

    });

</script>

@endsection
