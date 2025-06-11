@extends('backend.admin.layouts.master', ['page_slug' => "order_{$order->status_label}"])

@section('title', 'Order Details')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-info bg-opacity-10 border-info mb-4">
                <div class="card-body">
                    <h5 class="card-title text-info">🚢 {{ __('Shipping Route') }}</h5>
                    <div class="row text-center small">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('From') }}:</strong></p>
                            <p class="mb-0">{{ $order->shippingPort->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <span class="text-info h4 mb-0">→</span>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('To') }}:</strong></p>
                            <p class="mb-0">{{ $order->destinationPort->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="mb-0"><strong>{{ __('Container Type') }}:</strong>
                            {{ $order->container_type_label ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container Request Information -->
        <div class="col-md-6">
            @php
                $totalHeight = $order->items->sum(
                    fn($item) => optional($item->product)->height_m ? $item->product->height_m * $item->quantity : 0,
                );
                $totalWidth = $order->items->sum(
                    fn($item) => optional($item->product)->width_m ? $item->product->width_m * $item->quantity : 0,
                );
                $totalLength = $order->items->sum(
                    fn($item) => optional($item->product)->length_m ? $item->product->length_m * $item->quantity : 0,
                );
                $totalWeight = $order->items->sum(
                    fn($item) => optional($item->product)->weight_kg ? $item->product->weight_kg * $item->quantity : 0,
                );
                $totalCBM = $totalHeight * $totalWidth * $totalLength;
            @endphp
            <div class="card bg-warning bg-opacity-10 border-warning border-start border-4 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-warning">📏 {{ __('Requested Container Requirements') }}
                    </h5>
                    <div class="row small">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>{{ __('Minimum Length') }}:</strong>
                                {{ number_format($totalLength, 2) }} meters</p>
                            <p class="mb-2"><strong>{{ __('Minimum Width') }}:</strong>
                                {{ number_format($totalWidth, 2) }} meters</p>
                            <p class="mb-0"><strong>{{ __('Minimum Height') }}:</strong>
                                {{ number_format($totalHeight, 2) }} meters</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>{{ __('Minimum Weight Capacity') }}:</strong>
                                {{ number_format($totalWeight, 2) }} kg</p>
                            <p class="mb-2"><strong>{{ __('Estimated CBM') }}:</strong>
                                {{ number_format($totalCBM, 2) }} m³</p>
                            <p class="mb-0"><strong>{{ __('Container Type Preference') }}:</strong>
                                {{ $order->container_type_label ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Create Container') }}</h4>
                <x-backend.admin.button :datas="[
                    'routeName' => 'gs.container.index',
                    'label' => 'Back',
                    'permissions' => ['container-list'],
                ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('gs.container.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>{{ __('Shipping Port') }} <span class="text-danger">*</span></label>
                                    <select name="shipping_port" class="form-control" id="shipping_port">
                                        <option value="{{ $order->shippingPort?->id }}" selected disabled>
                                            {{ $order->shippingPort?->name }}
                                        </option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'shipping_port']" />
                                </div>

                                {{-- Destination Port --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Destination Port') }} <span class="text-danger">*</span></label>
                                    <select name="destination_port" class="form-control" id="destination_port">
                                        <option value="{{ $order->destinationPort?->id }}" selected disabled>
                                            {{ $order->destinationPort?->name }}
                                        </option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'destination_port']" />
                                </div>

                                {{-- Title --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('title') }}" id="title" name="title"
                                        class="form-control" placeholder="Enter title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'title']" />
                                </div>

                                {{-- Slug --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                        class="form-control" placeholder="Enter slug">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                                </div>
                                {{-- Deadline --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Deadline') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                                        class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'deadline']" />
                                </div>
                                {{-- Departure Date --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Departure Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="departure_date" value="{{ old('departure_date') }}"
                                        class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'departure_date']" />
                                </div>
                                {{-- Estimated Delivery Days --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Estimated Delivery Days') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="estimated_delivery_days" placeholder="Ex: 3-5 days"
                                        value="{{ old('estimated_delivery_days') }}" class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'estimated_delivery_days']" />

                                </div>
                                {{-- Length --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Length (m)') }}</label>
                                    <input type="number" name="length_m" value="{{ old('length_m') }}"
                                        class="form-control" placeholder="Enter length in meter">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'length_m']" />
                                </div>
                                {{-- Width --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Width (m)') }}</label>
                                    <input type="number" name="width_m" value="{{ old('width_m') }}" class="form-control"
                                        placeholder="Enter width in meter">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'width_m']" />
                                </div>

                                {{-- Height --}}
                                <div class="form-group col-md-6">
                                    <label>{{ __('Height (m)') }}</label>
                                    <input type="number" name="height_m" value="{{ old('height_m') }}"
                                        class="form-control" placeholder="Enter height in meter">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'height_m']" />
                                </div>
                                {{-- Max Weight --}}
                            </div>

                        </div>
                        {{-- Image --}}
                        <div class="form-group col-md-4">
                            <label>{{ __('Container Image') }}</label>
                            <input type="file" name="image" class="form-control filepond" id="image"
                                accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>

                        {{-- Max Weight --}}
                        <div class="form-group col-md-3">
                            <label>{{ __('Max Weight (kg)') }} </label>
                            <input type="number" name="max_weight_kg" value="{{ old('max_weight_kg') }}"
                                class="form-control" placeholder="Enter max weight in kg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'max_weight_kg']" />
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Base Cost') }}</label>
                            <input type="number" name="base_cost" value="{{ old('base_cost') }}" class="form-control"
                                placeholder="Enter base cost">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'base_cost']" />
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Per Kg Cost') }}</label>
                            <input type="number" name="per_kg_cost" value="{{ old('per_kg_cost') }}"
                                class="form-control" placeholder="Enter per kilogram cost">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'per_kg_cost']" />
                        </div>
                        <div class="form-group col-md-3">
                            <label>{{ __('Per Cubic Meter Cost') }}</label>
                            <input type="number" name="per_cbm_cost" value="{{ old('per_cbm_cost') }}"
                                class="form-control" placeholder="Enter per cubic meter cost">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'per_cbm_cost']" />
                        </div>
                    </div>
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                </form>
            </div>

        </div>
    </div>
    <x-backend.admin.documentation :document="$document" />
@endsection
@push('js')
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], ["image/jpg, image/jpeg, image/png, image/webp, image/svg"]);
        });
    </script>
@endpush
