@extends('backend.admin.layouts.master', ['page_slug' => 'product'])

@section('title', $product->name)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="product_tabs col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2 active" data-bs-target="basic">{{ __('Basic Information') }}</p>
                    <p class="btn_item w-100 py-2 " data-bs-target="relations">{{ __('Relations') }}</p>
                    <p class="btn_item w-100 py-2" data-bs-target="images">{{ __('Images Gallery') }}</p>
                    <p class="btn_item w-100 py-2" data-bs-target="informations">{{ __('Informations') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div id="basic" class="tab-pane active">
                        <div class="mb-5">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h1 class="card-title mb-4">{{ $product->name }}</h1>

                                    <div class="row">
                                        <!-- Product Information -->
                                        <div class="col-md-6 mb-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Slug: </strong>
                                                    {{ $product->slug }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Stock keeping unit: </strong>
                                                    {{ $product->sku }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Stock No: </strong>
                                                    {{ $product->stock_no }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Chassis No: </strong>
                                                    {{ $product->chassis_no }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Serial No: </strong>
                                                    {{ $product->serial_no }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Type: </strong>
                                                    {{ $product->type }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Fuel Type: </strong>
                                                    {{ $product->fuel_type }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Displacement: </strong>
                                                    {{ $product->displacement }}cc</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Capacity: </strong>
                                                    {{ $product->capacity }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Specification No:
                                                    </strong>
                                                    {{ $product->specification_no }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Classification: </strong>
                                                    {{ $product->classification_no }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">First Registration:
                                                    </strong>
                                                    {{ $product->first_registration }}</li>
                                            </ul>
                                        </div>

                                        <!-- Description and Pricing -->
                                        <div class="col-md-6 mb-4">
                                            <h4>Description</h4>
                                            <p class="border p-3 rounded">
                                                {{ $product->description }}</p>

                                            <h4 class="mt-4">Pricing</h4>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Price: </strong>
                                                    ${{ number_format($product->price, 2) }}</li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Cost Price: </strong>
                                                    ${{ number_format($product->cost_price, 2) }}
                                                </li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Sale Price: </strong>
                                                    ${{ number_format($product->sale_price, 2) }}
                                                </li>
                                                <li class="list-group-item"><strong class="me-2 mb-0 h5">Quantity Available:
                                                    </strong>
                                                    {{ $product->quantity }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <!-- Status Flags -->
                                            <div class="mt-4">
                                                <h4>Product Flags</h4>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item h5">Allow Backorder: <strong
                                                            class="ms-2 h6">{{ $product->allow_backorder ? 'Allowed' : 'Not Allowed' }}</strong>
                                                    </li>
                                                    <li class="list-group-item h5">Status: <strong class="ms-2 h6">
                                                            {{ $product->status ? 'Active' : 'Inactive' }}</strong>
                                                    </li>
                                                    <li class="list-group-item h5">Featured: <strong class="ms-2 h6">
                                                            {{ $product->is_featured ? 'Yes' : 'No' }}</strong>
                                                    </li>
                                                    <li class="list-group-item h5">Dropshipping: <strong class="ms-2 h6">
                                                            {{ $product->is_dropshipping ? 'Yes' : 'No' }}</strong>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <!-- Meta Info -->
                                            <div class="mt-4">
                                                <h4>Meta Information</h4>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Title:</strong>
                                                        {{ $product->meta_title ?? 'N/A' }}</li>
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Description:</strong>
                                                        {{ $product->meta_description ?? 'N/A' }}</li>
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Keywords:</strong>
                                                        {{ $product->meta_keywords ?? 'N/A' }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Profile Address --}}
                    <div id="relations" class="tab-pane ">
                        <div class="mb-5">
                            <div class="card shadow">
                                <h2 class="text-center m-0 p-2">Relations</h2>
                            </div>
                        </div>
                    </div>

                    {{-- Images Gallery --}}
                    <div id="images" class="tab-pane">
                        <div class="mb-5">
                            <div class="card shadow">
                                <h2 class="text-center m-0 p-2">Images Gallery</h2>
                            </div>
                        </div>
                    </div>
                    {{-- Informations --}}
                    <div id="informations" class="tab-pane">
                        <div class="mb-5">
                            <div class="card shadow">
                                <h2 class="text-center m-0 p-2">Informations</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // Handle click on tab items
            $('.btn_item').on('click', function() {
                $('.btn_item').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('.tab-pane').removeClass('active');

                $('#' + target).addClass('active');
            });
        });
    </script>
@endpush
