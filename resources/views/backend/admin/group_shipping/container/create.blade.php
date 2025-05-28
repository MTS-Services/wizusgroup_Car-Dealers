@extends('backend.admin.layouts.master', ['page_slug' => 'container'])
@section('title', 'Create Container')
@section('content')
    <div class="row">
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
                                            <option value="" selected hidden>{{ __('--Select Shipping Port--') }}
                                            </option>
                                            @foreach ($shippingLocations as $ship_port)
                                                <option value="{{ $ship_port->id }}"
                                                    {{ old('shipping_port') == $ship_port->id ? 'selected' : '' }}>
                                                    {{ $ship_port->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'shipping_port']" />
                                    </div>

                                    {{-- Destination Port --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Destination Port') }} <span class="text-danger">*</span></label>
                                        <select name="destination_port" class="form-control" id="destination_port">
                                            <option value="" selected hidden>{{ __('--Select Destination Port--') }}
                                            </option>
                                            @foreach ($shippingLocations as $des_port)
                                                <option value="{{ $des_port->id }}"
                                                    {{ old('destination_port') == $des_port->id ? 'selected' : '' }}>
                                                    {{ $des_port->name }}
                                                </option>
                                            @endforeach
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
                                    {{-- Length --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Length (cm)') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="length_cm" value="{{ old('length_cm') }}"
                                            class="form-control" placeholder="Enter length in cm">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'length_cm']" />
                                    </div>
                                    {{-- Width --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Width (cm)') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="width_cm" value="{{ old('width_cm') }}"
                                            class="form-control" placeholder="Enter width in cm">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'width_cm']" />
                                    </div>

                                    {{-- Height --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Height (cm)') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="height_cm" value="{{ old('height_cm') }}"
                                            class="form-control" placeholder="Enter height in cm">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'height_cm']" />
                                    </div>
                                    {{-- Max Weight --}}
                                    <div class="form-group col-12">
                                        <label>{{ __('Max Weight (kg)') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="max_weight_kg" value="{{ old('max_weight_kg') }}"
                                            class="form-control" placeholder="Enter max weight in kg">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'max_weight_kg']" />
                                    </div>
                                </div>

                            </div>
                            {{-- Image --}}
                            <div class="form-group col-md-4">
                                <label>{{ __('Container Image') }} <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control filepond" id="image"
                                    accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                            </div>


                            <div class="card-body">
                                <h4>{{ __('Set Container Eligibility') }}</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="product_rows_container">
                                            <div class="row align-items-center product-row">
                                                <div class="col-11">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>{{ __('Product') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="container_products[0][product_id]"
                                                                class="form-control">
                                                                <option value=" " selected hidden>
                                                                    {{ __('--Select Product--') }}</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}">
                                                                        {{ $product->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_id']" />
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>{{ __('Price') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="container_products[0][price]"
                                                                placeholder="Enter price" class="form-control">
                                                            <small>{{ __('Per Quantity') }}</small>
                                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'price']" />
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>{{ __('Reserve Price') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                name="container_products[0][reserve_price]"
                                                                placeholder="Enter reserve price" class="form-control">
                                                            <small>{{ __('Per Quantity') }}</small>
                                                            <x-feed-back-alert :datas="[
                                                                'errors' => $errors,
                                                                'field' => 'reserve_price',
                                                            ]" />
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>{{ __('Quantity') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="container_products[0][quantity]"
                                                                placeholder="Enter quantity" class="form-control">
                                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'quantity']" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-primary add_more">{{ __('Add More') }}</a>
                                                </div>
                                                <x-feed-back-alert :datas="[
                                                    'errors' => $errors,
                                                    'field' => 'container_products.*.product_id',
                                                ]" />
                                                <x-feed-back-alert :datas="[
                                                    'errors' => $errors,
                                                    'field' => 'container_products.*.price',
                                                ]" />
                                                <x-feed-back-alert :datas="[
                                                    'errors' => $errors,
                                                    'field' => 'container_products.*.reserve_price',
                                                ]" />
                                                <x-feed-back-alert :datas="[
                                                    'errors' => $errors,
                                                    'field' => 'container_products.*.quantity',
                                                ]" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    </div>
@endsection
@push('js')
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], ["image/jpg, image/jpeg, image/png, image/webp, image/svg"]);
        });
    </script>
    {{-- FilePond  --}}

    <script>
        $(document).ready(function() {
            let index = 1;

            // Add More
            $('.add_more').on('click', function() {
                const $originalRow = $('.product-row').first();
                const $clone = $originalRow.clone();

                // Update names with current index
                $clone.find('select, input').each(function() {
                    let name = $(this).attr('name');
                    name = name.replace(/\[\d+\]/, `[${index}]`);
                    $(this).attr('name', name).val('');
                });

                // Re-fill select with original options
                const originalSelectHTML = $originalRow.find('select').html();
                $clone.find('select').html(originalSelectHTML);

                $clone.find('.add_more').addClass('remove_row').html('Remove').removeClass('add_more')
                    .removeClass('btn-primary').addClass('btn-danger'); // show remove button
                $('.product_rows_container').append($clone);
                index++;
            });

            // Remove Row and Rearrange
            $(document).on('click', '.remove_row', function() {
                $(this).closest('.product-row').remove();
                rearrangeIndexes();
            });

            // Function to rearrange indexes
            function rearrangeIndexes() {
                $('.product-row').each(function(i) {
                    $(this).find('select, input').each(function() {
                        const name = $(this).attr('name');
                        const newName = name.replace(/\[\d+\]/, `[${i}]`);
                        $(this).attr('name', newName);
                    });
                });

                // Update index counter
                index = $('.product-row').length;
            }
        });
    </script>
@endpush
