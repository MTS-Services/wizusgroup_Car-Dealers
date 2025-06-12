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
                    <form action="{{ route('gs.container.update', encrypt($container->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Shipping Port') }} <span class="text-danger">*</span></label>
                                        <select name="shipping_port" class="form-control" id="shipping_port">
                                            <option value="" selected hidden>{{ __('--Select Shipping Port--') }}
                                            </option>
                                            @foreach ($shipping_locations as $ship_port)
                                                <option value="{{ $ship_port->id }}"
                                                    {{ $container->shipping_port == $ship_port->id ? 'selected' : '' }}>
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
                                            @foreach ($shipping_locations as $des_port)
                                                <option value="{{ $des_port->id }}"
                                                    {{ $container->destination_port == $des_port->id ? 'selected' : '' }}>
                                                    {{ $des_port->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'destination_port']" />
                                    </div>

                                    {{-- Title --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $container->title }}" id="title" name="title"
                                            class="form-control" placeholder="Enter title">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'title']" />
                                    </div>

                                    {{-- Slug --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ $container->slug }}" id="slug" name="slug"
                                            class="form-control" placeholder="Enter slug">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                                    </div>
                                    {{-- Deadline --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Deadline') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="deadline"
                                            value="{{ inputDateFormat($container->deadline) }}" class="form-control">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'deadline']" />
                                    </div>
                                    {{-- Departure Date --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Departure Date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="departure_date"
                                            value="{{ inputDateFormat($container->departure_date) }}" class="form-control">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'departure_date']" />
                                    </div>
                                    {{-- Estimated Delivery Days --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Estimated Delivery Days') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="estimated_delivery_days" placeholder="Ex: 3-5 days"
                                            value="{{ $container->estimated_delivery_days }}" class="form-control">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'estimated_delivery_days']" />

                                    </div>
                                    {{-- Length --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Length (m)') }} </label>
                                        <input type="number" name="length_m" value="{{ $container->length_m }}"
                                            class="form-control" placeholder="Enter length in meter">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'length_m']" />
                                    </div>
                                    {{-- Width --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Width (m)') }} </label>
                                        <input type="number" name="width_m" value="{{ $container->width_m }}"
                                            class="form-control" placeholder="Enter width in meter">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'width_m']" />
                                    </div>

                                    {{-- Height --}}
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Height (m)') }} </label>
                                        <input type="number" name="height_m" value="{{ $container->height_m }}"
                                            class="form-control" placeholder="Enter height in meter">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'height_m']" />
                                    </div>
                                </div>

                            </div>
                            {{-- Image --}}
                            <div class="form-group col-md-3">
                                <label>{{ __('Container Image') }} </label>
                                <input type="file" name="image" class="form-control filepond" id="image"
                                    accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                            </div>
                            {{-- Max Weight --}}
                            <div class="form-group col-md-3">
                                <label>{{ __('Max Weight (kg)') }} </label>
                                <input type="number" name="max_weight_kg" value="{{ $container->max_weight_kg }}"
                                    class="form-control" placeholder="Enter max weight in kg">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'max_weight_kg']" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('Base Cost') }}</label>
                                <input type="number" name="base_cost" value="{{ $container->base_cost }}"
                                    class="form-control" placeholder="Enter base cost">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'base_cost']" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('Per Kg Cost') }}</label>
                                <input type="number" name="per_kg_cost" value="{{ $container->per_kg_cost }}"
                                    class="form-control" placeholder="Enter per kilogram cost">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'per_kg_cost']" />
                            </div>
                            <div class="form-group col-md-3">
                                <label>{{ __('Per Cubic Meter Cost') }}</label>
                                <input type="number" name="per_cbm_cost" value="{{ $container->per_cbm_cost }}"
                                    class="form-control" placeholder="Enter per cubic meter cost">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'per_cbm_cost']" />
                            </div>


                            {{-- <div class="card-body">
                                <h4>{{ __('Available For Shipping (optional)') }}</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="product_rows_container">
                                            @foreach ($container->containerProducts as $key => $containerProduct)
                                                <div class="row align-items-center product-row">
                                                    <div class="col-11">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label>{{ __('Product') }} </label>
                                                                <select
                                                                    name="container_products[{{ $key }}][product_id]"
                                                                    class="form-control">
                                                                    <option value=" " selected hidden>
                                                                        {{ __('--Select Product--') }}</option>
                                                                    @foreach ($products as $product)
                                                                        <option value="{{ $product->id }}"
                                                                            {{ $containerProduct->product_id == $product->id ? 'selected' : '' }}>
                                                                            {{ $product->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label>{{ __('Price') }} </label>
                                                                <input type="text"
                                                                    name="container_products[{{ $key }}][price]"
                                                                    placeholder="Enter price" class="form-control"
                                                                    value="{{ $containerProduct->price }}">
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                <label>{{ __('Reserve Price') }} </label>
                                                                <input type="text"
                                                                    name="container_products[{{ $key }}][reserve_price]"
                                                                    value="{{ $containerProduct->reserve_price }}"
                                                                    placeholder="Enter reserve price"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1">
                                                        @if ($key == 0)
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-primary add_more">{{ __('Add More') }}</a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger remove_row">{{ __('Remove') }}</a>
                                                        @endif
                                                    </div>
                                                    <x-feed-back-alert :datas="[
                                                        'errors' => $errors,
                                                        'field' => 'container_products.{{ $key }}.product_id',
                                                    ]" />
                                                    <x-feed-back-alert :datas="[
                                                        'errors' => $errors,
                                                        'field' => 'container_products.{{ $key }}.price',
                                                    ]" />
                                                    <x-feed-back-alert :datas="[
                                                        'errors' => $errors,
                                                        'field' =>
                                                            'container_products.{{ $key }}.reserve_price',
                                                    ]" />
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
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
            file_upload(["#image"], ["image/jpg, image/jpeg, image/png, image/webp, image/svg"], {
                "#image": `{{ $container->modified_image }}`
            });
        });
    </script>
    {{-- FilePond  --}}

    {{-- <script>
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
    </script> --}}
@endpush
