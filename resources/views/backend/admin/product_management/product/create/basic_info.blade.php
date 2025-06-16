@extends('backend.admin.layouts.master', ['page_slug' => 'product', 'product_type' => $product_type ?? ''])
@section('title', 'Create Product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                        {{ __('Create Product') }}
                    </h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.index',
                        'params' => ['product_type' => request('product_type')],
                        'label' => 'Back',
                        'permissions' => ['product-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name"
                                class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                class="form-control" placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Length (m)') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('length_m') }}" name="length_m" class="form-control"
                                        placeholder="Enter length (m)">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'length_m']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Width (m)') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('width_m') }}" name="width_m" class="form-control"
                                        placeholder="Enter width (m)">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'width_m']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Height (m)') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('height_m') }}" name="height_m"
                                        class="form-control" placeholder="Enter height (m)">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'height_m']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Weight (kg)') }}</label>
                                    <input type="text" value="{{ old('weight_kg') }}" name="weight_kg"
                                        class="form-control" placeholder="Enter weight (kg)">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'weight_kg']" />
                                </div>
                            </div>




                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('SKU') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('sku') }}" name="sku" class="form-control"
                                        placeholder="Enter sku">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sku']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Stock Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('stock_no') }}" name="stock_no"
                                        class="form-control" placeholder="Enter stock number">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'stock_no']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Year') }} <span class="text-danger">*</span></label>
                                    <select name="year" class="form-control" id="year">
                                        <option value="" selected disabled>{{ __('Select Year') }}</option>
                                        @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'year']" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Product Type') }} <span class="text-danger">*</span></label>
                                    <select name="product_type" class="form-control">
                                        <option value="" selected hidden>{{ __('Select Product Type') }}</option>
                                        @if ($product_type)
                                            <option value="{{ $product_type }}" selected>
                                                {{ App\Models\Product::getProductTypes()["$product_type"] }}
                                            </option>
                                        @else
                                            @foreach (App\Models\Product::getProductTypes() as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('product_type') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('price') }}" name="price" class="form-control"
                                        placeholder="Enter price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Cost price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('cost_price') }}" name="cost_price"
                                        class="form-control" placeholder="Enter cost price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'cost_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sale price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('sale_price') }}" name="sale_price"
                                        class="form-control" placeholder="Enter sale price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sale_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Grade') }}</label>
                                    <input type="text" value="{{ old('grade') }}" name="grade"
                                        class="form-control" placeholder="Enter grade">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'grade']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Body') }}</label>
                                    <input type="text" value="{{ old('body') }}" name="body"
                                        class="form-control" placeholder="Enter body">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'body']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('First Registration') }}</label>
                                    <input type="text" value="{{ old('first_registration') }}"
                                        name="first_registration" class="form-control"
                                        placeholder="Enter first registration">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'first_registration']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <input type="text" value="{{ old('type') }}" name="type"
                                        class="form-control" placeholder="Enter type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Displacement') }}</label>
                                    <input type="text" value="{{ old('displacement') }}" name="displacement"
                                        class="form-control" placeholder="Enter displacement">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'displacement']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Capacity') }}</label>
                                    <input type="text" value="{{ old('capacity') }}" name="capacity"
                                        class="form-control" placeholder="Enter capacity">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'capacity']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Specification No') }}</label>
                                    <input type="text" value="{{ old('specification_no') }}" name="specification_no"
                                        class="form-control" placeholder="Enter specification no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'specification_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Classification No') }}</label>
                                    <input type="text" value="{{ old('classification_no') }}"
                                        name="classification_no" class="form-control"
                                        placeholder="Enter classification no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'classification_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Chassis No') }}</label>
                                    <input type="text" value="{{ old('chassis_no') }}" name="chassis_no"
                                        class="form-control" placeholder="Enter chassis no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'chassis_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Serial No') }}</label>
                                    <input type="text" value="{{ old('serial_no') }}" name="serial_no"
                                        class="form-control" placeholder="Enter serial no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'serial_no']" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" min="0" value="{{ old('quantity') }}" name="quantity"
                                        class="form-control" placeholder="Enter quantity">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'quantity']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Engine Type') }}</label>
                                    <input type="text" value="{{ old('engine_type') }}" name="engine_type"
                                        class="form-control" placeholder="Enter engine type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'engine_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Fuel Type') }}</label>
                                    <input type="text" value="{{ old('fuel_type') }}" name="fuel_type"
                                        class="form-control" placeholder="Enter fuel type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'fuel_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Color') }}</label>
                                    <input type="text" value="{{ old('color') }}" name="color"
                                        class="form-control" placeholder="Enter color">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'color']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Mileage') }}</label>
                                    <input type="text" value="{{ old('mileage') }}" name="mileage"
                                        class="form-control" placeholder="Enter mileage">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'mileage']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Odometer Replacement') }}</label>
                                    <input type="text" value="{{ old('odometer_replacement') }}"
                                        name="odometer_replacement" class="form-control"
                                        placeholder="Enter odometer replacement">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'odometer_replacement']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Streeing Wheel') }}</label>
                                    <input type="text" value="{{ old('steering_wheel') }}" name="steering_wheel"
                                        class="form-control" placeholder="Enter streeing wheel">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'steering_wheel']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Transmission') }}</label>
                                    <input type="text" value="{{ old('transmission') }}" name="transmission"
                                        class="form-control" placeholder="Enter transmission">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'transmission']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Drive System') }}</label>
                                    <input type="text" value="{{ old('drive_system') }}" name="drive_system"
                                        class="form-control" placeholder="Enter drive system">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'drive_system']" />
                                </div>
                            </div>
                            @if (isset($product_type) && $product_type == App\Models\Product::PRODUCT_TYPE_DROPSHIPPING)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Supplier Name') }} <span class="text-danger">*</span></label>
                                        <select name="supplier_id" class="form-control">
                                            <option value="" selected>{{ __('Select Supplier') }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->first_name }}</option>
                                            @endforeach
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'supplier_id']" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Product Source URL') }} <span class="text-danger">*</span></label>
                                        <input type="url" value="{{ old('source_url') }}" name="source_url"
                                            class="form-control" placeholder="Enter product source url">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'source_url']" />
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Remarks') }}</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter remarks">{{ old('remarks') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'remarks']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Sort Description') }}</label>
                                    <textarea name="short_description" class="form-control" placeholder="Enter sort description">{{ old('short_description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'short_description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Title') }}</label>
                                    <input type="text" value="{{ old('meta_title') }}" id="meta_title"
                                        name="meta_title" class="form-control" placeholder="Enter meta title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Description') }}</label>
                                    <textarea name="meta_description" class="form-control no-ckeditor5" id="meta_description" rows="6"
                                        placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Keywords') }}</label>
                                    <select name="meta_keywords[]" class="form-control" multiple>
                                        <option value="">{{ __('Add meta keywords') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_keywords.*']" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
@endpush
