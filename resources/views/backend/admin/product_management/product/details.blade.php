@extends('backend.admin.layouts.master', ['page_slug' => 'product'])

@section('title', $product->name)
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
@endpush
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
                        <a href="{{ route('pm.product.index', ['product_type' => request('product_type')]) }}" class="btn_item p-2">{{ __('Back') }}</a>
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
                                            <div class="col-md-6">
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
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <h5 class="mb-3">Description</h5>
                                                    <div class="border p-3 rounded">{!! $product->description !!}</div>
                                                </div>

                                                <div class="table-responsive mb-4">
                                                    <h5 class="mb-3">Pricing</h5>
                                                    <table class="table table-bordered table-striped align-middle">
                                                        <tbody>
                                                            <tr>
                                                                <th>Cost Price</th>
                                                                <td>${{ number_format($product->cost_price, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Price</th>
                                                                <td>${{ number_format($product->price, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sale Price</th>
                                                                <td>${{ number_format($product->sale_price, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Stock Quantity</th>
                                                                <td>{{ $product->quantity }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="table-responsive mb-4">
                                                    <h5 class="mb-3">Product Flags</h5>
                                                    <table class="table table-bordered table-striped align-middle">
                                                        <tbody>
                                                            <tr>
                                                                <th>Status</th>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $product->status_color }}">{{ $product->status_label }}</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Featured</th>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $product->featured_color }}">{{ $product->featured_btn_label }}</span>
                                                                </td>
                                                            </tr>
                                                            {{-- Add more flags if needed --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
                                                        <td>{{ $product->subCategory?->name ?? 'N/A' }}</td>
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
                                        <div class="imagePreviewDiv d-inline-block">
                                            <div id="lightbox" class="lightbox">
                                                <div class="lightbox-content">
                                                    <img src="{{ $product->primaryImage?->first()?->modified_image }}"
                                                        class="lightbox_image">
                                                </div>
                                                <div class="close_button fa-beat">X</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ __('Images') }}</h4>
                                        @foreach ($product->images as $image)
                                            <div class="imagePreviewDiv d-inline-block">
                                                <div id="lightbox" class="lightbox">
                                                    <div class="lightbox-content">
                                                        <img src="{{ $image->modified_image }}" class="lightbox_image">
                                                    </div>
                                                    <div class="close_button fa-beat">X</div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Informations --}}
                        <div id="informations" class="tab-pane">
                            <div class="mb-5">
                                @foreach ($product->productInformations as $info)
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="card-title h5">{{ __('Informations') }}</div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th>Information Category</th>
                                                            <td>{{ $info->infoCategory?->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Description</th>
                                                            <td>{!! $info->description !!}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
