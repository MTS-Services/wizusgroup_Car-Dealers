@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Create Product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Product') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.index',
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('SKU') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('sku') }}" name="sku" class="form-control"
                                        placeholder="Enter sku">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sku']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Stock Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('stock_no') }}" name="stock_no" class="form-control"
                                        placeholder="Enter stock number">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'stock_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Grade') }}</label>
                                    <input type="text" value="{{ old('grade') }}" name="grade" class="form-control"
                                        placeholder="Enter grade">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'grade']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Body') }}</label>
                                    <input type="text" value="{{ old('body') }}" name="body" class="form-control"
                                        placeholder="Enter body">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'body']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('First Registration') }}</label>
                                    <input type="text" value="{{ old('first_registration') }}" name="first_registration"
                                        class="form-control" placeholder="Enter first registration">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'first_registration']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <input type="text" value="{{ old('type') }}" name="type" class="form-control"
                                        placeholder="Enter type">
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
                                    <input type="text" value="{{ old('classification_no') }}" name="classification_no"
                                        class="form-control" placeholder="Enter classification no">
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
                                    <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('price') }}" name="price"
                                        class="form-control" placeholder="Enter price">
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
                                    <input type="text" value="{{ old('streeing_wheel') }}" name="streeing_wheel"
                                        class="form-control" placeholder="Enter streeing wheel">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'streeing_wheel']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Transmission') }}</label>
                                    <input type="text" value="{{ old('transmisison') }}" name="transmisison"
                                        class="form-control" placeholder="Enter transmisison">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'transmisison']" />
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Supplier Name') }}</label>
                                    <select name="supplier_id" class="form-control">
                                        <option value="">Select Supplier</option>
                                        <option value="1">Supplier 1</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'drive_system']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Meta Keywords') }}</label>
                                    <select name="meta_keywords[]" class="form-control" multiple>
                                        <option value="">Select Keywords</option>
                                        <option value="1">Keywords 1</option>
                                        <option value="2">Keywords 2</option>
                                        <option value="3">Keywords 3</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'drive_system']" />
                                </div>
                            </div>
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
                                    <textarea name="sort_description" class="form-control" placeholder="Enter sort description">{{ old('sort_description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sort_description']" />
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
                                    <input type="text" value="{{ old('meta_title') }}" name="meta_title"
                                        class="form-control" placeholder="Enter meta title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Description') }}</label>
                                    <textarea name="meta_description" class="form-control no-ckeditor5" rows="10"
                                        placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- FilePond  --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], "uploadImage", "admin", [], false);
        });
    </script>
    {{-- FilePond  --}}
@endpush
