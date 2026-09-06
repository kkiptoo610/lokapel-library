@extends('layouts.app')

@section('content')

<div class="page-header">

    <div class="page-title">

        <div class="page-title-icon">

            <i class="bi bi-pencil-square"></i>

        </div>

        <div>

            <h1>Edit Inventory Item</h1>

            <p>

                Update inventory information and stock levels.

            </p>

        </div>

    </div>


    <a
        href="{{ route('inventory.items.show', $item) }}"
        class="btn btn-outline-secondary"
    >

        <i class="bi bi-arrow-left me-2"></i>

        Back

    </a>

</div>


<div class="modern-page-card">

    <div class="card-body p-4 p-md-5">


        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>

                            {{ $error }}

                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('inventory.items.update', $item) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="row g-4">


                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Category

                    </label>


                    <select
                        name="inventory_category_id"
                        class="form-select"
                        required
                    >

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'inventory_category_id',
                                        $item->inventory_category_id
                                    ) == $category->id
                                )
                            >

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-md-6">

                    <label class="form-label fw-semibold">

                        Item Name

                    </label>


                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $item->name) }}"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">

                        Unit

                    </label>


                    <input
                        type="text"
                        name="unit"
                        value="{{ old('unit', $item->unit) }}"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">

                        Current Quantity

                    </label>


                    <input
                        type="number"
                        name="quantity"
                        value="{{ old('quantity', $item->quantity) }}"
                        min="0"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-md-4">

                    <label class="form-label fw-semibold">

                        Minimum Quantity

                    </label>


                    <input
                        type="number"
                        name="minimum_quantity"
                        value="{{ old('minimum_quantity', $item->minimum_quantity) }}"
                        min="0"
                        class="form-control"
                        required
                    >

                </div>


                <div class="col-12">

                    <label class="form-label fw-semibold">

                        Description

                    </label>


                    <textarea
                        name="description"
                        rows="5"
                        class="form-control"
                    >{{ old('description', $item->description) }}</textarea>

                </div>


                <div class="col-12">

                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ route('inventory.items.show', $item) }}"
                            class="btn btn-outline-secondary"
                        >

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-check-circle me-2"></i>

                            Update Item

                        </button>

                    </div>

                </div>


            </div>

        </form>

    </div>

</div>

@endsection