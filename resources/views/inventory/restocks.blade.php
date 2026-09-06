@extends('layouts.app')

@section('content')

<div class="page-header">

```
<div class="page-title">

    <div class="page-title-icon">

        <i class="bi bi-clock-history"></i>

    </div>

    <div>

        <h1>Inventory Restock History</h1>

        <p>
            View and monitor all inventory restocking records.
        </p>

    </div>

</div>


<div class="d-flex gap-2 flex-wrap">

    <a
        href="{{ route('inventory.index') }}"
        class="btn btn-outline-primary"
    >

        <i class="bi bi-box-seam me-2"></i>

        Inventory Dashboard

    </a>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- SUCCESS MESSAGE --}}
{{-- ========================================================= --}}

@if (session('success'))

```
<div
    class="alert alert-success alert-dismissible fade show"
    role="alert"
>

    <i class="bi bi-check-circle-fill me-2"></i>

    {{ session('success') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    ></button>

</div>
```

@endif

{{-- ========================================================= --}}
{{-- ERROR MESSAGE --}}
{{-- ========================================================= --}}

@if (session('error'))

```
<div
    class="alert alert-danger alert-dismissible fade show"
    role="alert"
>

    <i class="bi bi-exclamation-triangle-fill me-2"></i>

    {{ session('error') }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
    ></button>

</div>
```

@endif

{{-- ========================================================= --}}
{{-- STATISTICS --}}
{{-- ========================================================= --}}

<div class="row g-4 mb-4">

```
{{-- TOTAL RESTOCKED QUANTITY --}}

<div class="col-md-6">

    <div class="modern-page-card h-100">

        <div class="card-body">

            <div
                class="
                    d-flex
                    justify-content-between
                    align-items-center
                "
            >

                <div>

                    <div
                        class="text-muted small mb-2"
                    >

                        Total Quantity Restocked

                    </div>

                    <h2 class="mb-0 fw-bold">

                        {{ $totalRestockedQuantity }}

                    </h2>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-center
                    "
                    style="
                        width: 55px;
                        height: 55px;
                        border-radius: 15px;
                        background: #ECFDF5;
                        color: #059669;
                        font-size: 24px;
                    "
                >

                    <i
                        class="bi bi-box-arrow-in-down"
                    ></i>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- TOTAL RESTOCK RECORDS --}}

<div class="col-md-6">

    <div class="modern-page-card h-100">

        <div class="card-body">

            <div
                class="
                    d-flex
                    justify-content-between
                    align-items-center
                "
            >

                <div>

                    <div
                        class="text-muted small mb-2"
                    >

                        Total Restock Records

                    </div>

                    <h2 class="mb-0 fw-bold">

                        {{ $totalRestockRecords }}

                    </h2>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-center
                    "
                    style="
                        width: 55px;
                        height: 55px;
                        border-radius: 15px;
                        background: #EFF6FF;
                        color: #2563EB;
                        font-size: 24px;
                    "
                >

                    <i
                        class="bi bi-clock-history"
                    ></i>

                </div>

            </div>

        </div>

    </div>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- FILTERS --}}
{{-- ========================================================= --}}

<div class="modern-page-card mb-4">

```
<div class="card-body p-4">

    <form
        method="GET"
        action="{{ route('inventory.restocks') }}"
    >

        <div class="row g-3">


            {{-- SEARCH --}}

            <div class="col-md-4">

                <label
                    for="search"
                    class="form-label"
                >

                    Search Item

                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search inventory item..."
                >

            </div>


            {{-- INVENTORY TYPE --}}

            <div class="col-md-3">

                <label
                    for="type"
                    class="form-label"
                >

                    Inventory Type

                </label>

                <select
                    name="type"
                    id="type"
                    class="form-select"
                >

                    <option value="">

                        All Types

                    </option>


                    <option
                        value="teachers"
                        @selected(
                            request('type') === 'teachers'
                        )
                    >

                        Teachers

                    </option>


                    <option
                        value="laboratory"
                        @selected(
                            request('type') === 'laboratory'
                        )
                    >

                        Laboratory

                    </option>

                </select>

            </div>


            {{-- DATE FROM --}}

            <div class="col-md-2">

                <label
                    for="date_from"
                    class="form-label"
                >

                    Date From

                </label>

                <input
                    type="date"
                    name="date_from"
                    id="date_from"
                    class="form-control"
                    value="{{ request('date_from') }}"
                >

            </div>


            {{-- DATE TO --}}

            <div class="col-md-2">

                <label
                    for="date_to"
                    class="form-label"
                >

                    Date To

                </label>

                <input
                    type="date"
                    name="date_to"
                    id="date_to"
                    class="form-control"
                    value="{{ request('date_to') }}"
                >

            </div>


            {{-- BUTTONS --}}

            <div
                class="
                    col-md-1
                    d-flex
                    align-items-end
                "
            >

                <div
                    class="
                        d-flex
                        gap-2
                        w-100
                    "
                >

                    <button
                        type="submit"
                        class="btn btn-primary"
                        title="Apply Filters"
                    >

                        <i
                            class="bi bi-search"
                        ></i>

                    </button>


                    @if (
                        request('search')
                        ||
                        request('type')
                        ||
                        request('date_from')
                        ||
                        request('date_to')
                    )

                        <a
                            href="{{ route('inventory.restocks') }}"
                            class="btn btn-outline-secondary"
                            title="Clear Filters"
                        >

                            <i
                                class="bi bi-x-lg"
                            ></i>

                        </a>

                    @endif

                </div>

            </div>

        </div>

    </form>

</div>
```

</div>

{{-- ========================================================= --}}
{{-- RESTOCK HISTORY TABLE --}}
{{-- ========================================================= --}}

<div class="modern-page-card">

```
<div class="card-body p-0">


    <div
        class="
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
            gap-3
            p-4
            border-bottom
        "
    >

        <div>

            <h5 class="mb-1">

                Restock Records

            </h5>

            <p
                class="
                    text-muted
                    mb-0
                "
            >

                Inventory stock additions and restocking history.

            </p>

        </div>

    </div>


    @if ($restocks->count() > 0)

        <div class="table-responsive">

            <table
                class="
                    table
                    align-middle
                    mb-0
                "
            >

                <thead
                    class="table-light"
                >

                    <tr>

                        <th>

                            Item

                        </th>

                        <th>

                            Category

                        </th>

                        <th>

                            Type

                        </th>

                        <th>

                            Quantity Added

                        </th>

                        <th>

                            Restock Date

                        </th>

                        <th>

                            Remarks

                        </th>

                        <th
                            class="text-end"
                        >

                            Action

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($restocks as $restock)

                        <tr>


                            {{-- ITEM --}}

                            <td>

                                @if ($restock->item)

                                    <div
                                        class="
                                            fw-semibold
                                        "
                                    >

                                        {{ $restock->item->name }}

                                    </div>


                                    <div
                                        class="
                                            text-muted
                                            small
                                        "
                                    >

                                        {{ $restock->item->unit }}

                                    </div>

                                @else

                                    <span
                                        class="
                                            text-muted
                                        "
                                    >

                                        Deleted Item

                                    </span>

                                @endif

                            </td>


                            {{-- CATEGORY --}}

                            <td>

                                {{ $restock->item?->category?->name ?? 'No Category' }}

                            </td>


                            {{-- TYPE --}}

                            <td>

                                @if (
                                    $restock->item?->category?->type
                                    === 'teachers'
                                )

                                    <span
                                        class="
                                            badge
                                            bg-primary-subtle
                                            text-primary
                                        "
                                    >

                                        Teachers

                                    </span>

                                @elseif (
                                    $restock->item?->category?->type
                                    === 'laboratory'
                                )

                                    <span
                                        class="
                                            badge
                                            bg-success-subtle
                                            text-success
                                        "
                                    >

                                        Laboratory

                                    </span>

                                @else

                                    <span
                                        class="
                                            badge
                                            bg-secondary
                                        "
                                    >

                                        N/A

                                    </span>

                                @endif

                            </td>


                            {{-- QUANTITY --}}

                            <td>

                                <span
                                    class="
                                        fw-bold
                                        text-success
                                    "
                                >

                                    +{{ $restock->quantity }}

                                </span>


                                @if ($restock->item)

                                    <span
                                        class="
                                            text-muted
                                            small
                                        "
                                    >

                                        {{ $restock->item->unit }}

                                    </span>

                                @endif

                            </td>


                            {{-- DATE --}}

                            <td>

                                @if (
                                    $restock->restocked_date
                                )

                                    {{ \Carbon\Carbon::parse($restock->restocked_date)->format('d M Y') }}

                                @else

                                    N/A

                                @endif

                            </td>


                            {{-- REMARKS --}}

                            <td>

                                @if (
                                    $restock->remarks
                                )

                                    <span
                                        title="{{ $restock->remarks }}"
                                    >

                                        {{ \Illuminate\Support\Str::limit($restock->remarks, 50) }}

                                    </span>

                                @else

                                    <span
                                        class="
                                            text-muted
                                        "
                                    >

                                        —

                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td
                                class="text-end"
                            >

                                @if ($restock->item)

                                    <a
                                        href="{{ route('inventory.items.show', $restock->item) }}"
                                        class="
                                            btn
                                            btn-sm
                                            btn-outline-primary
                                        "
                                    >

                                        <i
                                            class="
                                                bi
                                                bi-eye
                                            "
                                        ></i>

                                        View Item

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- ========================================================= --}}
        {{-- PAGINATION --}}
        {{-- ========================================================= --}}

        @if (
            $restocks->hasPages()
        )

            <div
                class="
                    p-4
                    border-top
                "
            >

                {{ $restocks->links() }}

            </div>

        @endif


    @else

        {{-- ========================================================= --}}
        {{-- EMPTY STATE --}}
        {{-- ========================================================= --}}

        <div
            class="
                text-center
                py-5
                px-4
            "
        >

            <div
                style="
                    width: 80px;
                    height: 80px;
                    border-radius: 50%;
                    background: #F1F5F9;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 20px;
                    font-size: 32px;
                    color: #64748B;
                "
            >

                <i
                    class="
                        bi
                        bi-box-arrow-in-down
                    "
                ></i>

            </div>


            <h5>

                No Restock Records Found

            </h5>


            <p
                class="
                    text-muted
                    mb-0
                "
            >

                No inventory restock records match your current filters.

            </p>

        </div>

    @endif

</div>
```

</div>

@endsection
