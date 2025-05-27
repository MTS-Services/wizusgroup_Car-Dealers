@extends('backend.admin.layouts.master', ['page_slug' => 'product'])

@section('title', $product->name)

@section('content')
    <div class="container-fluid">
        <div class="row product_tabs">
            <div class="col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2 m-0 active" data-bs-target="basic">{{ __('Basic Information') }}</p>
                    <p class="btn_item w-100 py-2 m-0 " data-bs-target="relations">{{ __('Relations') }}</p>
                    <p class="btn_item w-100 py-2 m-0" data-bs-target="images">{{ __('Images Gallery') }}</p>
                    <p class="btn_item w-100 py-2 m-0" data-bs-target="informations">{{ __('Informations') }}</p>
                    <div class="ms-5">
                        <a href="{{ route('pm.product.index') }}" class="btn_item p-2">{{ __('Back') }}</a>
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

                                        <div class="table-responsive mb-4">
                                            <h5 class="mb-3">Product Information</h5>
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Slug</th>
                                                        <td>{{ $product->slug }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>SKU</th>
                                                        <td>{{ $product->sku }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Stock No</th>
                                                        <td>{{ $product->stock_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Chassis No</th>
                                                        <td>{{ $product->chassis_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Serial No</th>
                                                        <td>{{ $product->serial_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Type</th>
                                                        <td>{{ $product->type }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fuel Type</th>
                                                        <td>{{ $product->fuel_type }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Displacement</th>
                                                        <td>{{ $product->displacement }}cc</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Capacity</th>
                                                        <td>{{ $product->capacity }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Specification No</th>
                                                        <td>{{ $product->specification_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Classification No</th>
                                                        <td>{{ $product->classification_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>First Registration</th>
                                                        <td>{{ $product->first_registration }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mb-4">
                                            <h5 class="mb-3">Description</h5>
                                            <p class="border p-3 rounded">{{ $product->description }}</p>
                                        </div>

                                        <div class="table-responsive mb-4">
                                            <h5 class="mb-3">Pricing</h5>
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Price</th>
                                                        <td>${{ number_format($product->price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cost Price</th>
                                                        <td>${{ number_format($product->cost_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sale Price</th>
                                                        <td>${{ number_format($product->sale_price, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Quantity Available</th>
                                                        <td>{{ $product->quantity }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive mb-4">
                                            <h5 class="mb-3">Product Flags</h5>
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Featured</th>
                                                        <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                                                    </tr>
                                                    {{-- Add more flags if needed --}}
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <h5 class="mb-3">Meta Information</h5>
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th>Meta Title</th>
                                                        <td>{{ $product->meta_title ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Meta Description</th>
                                                        <td>{{ $product->meta_description ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Meta Keywords</th>
                                                        <td>{{ $product->meta_keywords ?? 'N/A' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Relations --}}
                        <div id="relations" class="tab-pane ">
                            <div class="mb-5">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __('Relations') }}</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="w-25">Company</th>
                                                        <td>{{ $product->company?->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Brand</th>
                                                        <td>{{ $product->brand?->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Model</th>
                                                        <td>{{ $product->model?->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Category</th>
                                                        <td>{{ $product->category?->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sub Category</th>
                                                        <td>{{ $product->sub_category?->name ?? 'N/A' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Images Gallery --}}
                        <div id="images" class="tab-pane">
                            <div class="mb-5">
                                <div class="card shadow">
                                    <h2 class="text-center m-0 p-2">{{ __('Images Gallery') }}</h2>
                                    <div class="card-body">
                                        <h4>{{ __('Primary Image') }}</h4>
                                        <img src="{{ $product->primaryImage->first()?->modified_image }}"
                                            alt="{{ $image->alt ?? $product->name }}">
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ __('Images') }}</h4>
                                        @foreach ($product->images as $image)
                                            <img src="{{ $image->modified_image }}"
                                                alt="{{ $image->alt ?? $product->name }}">
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Informations --}}
                        <div id="informations" class="tab-pane">
                            <div class="mb-5">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="card-title">{{ __('Informations') }}</div>
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Product
                                                            Information Catigory:
                                                        </strong>
                                                        {{ $product->infoCategory->name ?? 'N/A' }}</li>
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Product
                                                            Information Catigory Type:
                                                        </strong>{{ $product->infoCategoryType->name ?? 'N/A' }}</li>
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Product
                                                            Information Catigory Type Feature:
                                                        </strong>{{ $product->infoCategoryTypeFeature->name ?? 'N/A' }}
                                                    </li>
                                                    <li class="list-group-item"><strong class="me-2 mb-0 h5">Description:
                                                        </strong>{{ $product->description ?? 'N/A' }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
