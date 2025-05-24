@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Edit Product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Product') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.index',
                        'label' => 'Back',
                        'permissions' => ['Product-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.update', encrypt($product->id)) }}" id="productForm') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $product->name }}" id="title" name="name"
                                class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $product->slug }}" id="slug" name="slug"
                                class="form-control" placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('SKU') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $product->sku }}" name="sku" class="form-control"
                                        placeholder="Enter sku">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sku']" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Stock Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $product->stock_no }}" name="stock_no" class="form-control"
                                        placeholder="Enter stock number">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'stock_no']" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Year') }} <span class="text-danger">*</span></label>
                                    <select name="year" class="form-control" id="year">
                                        <option value="" selected disabled>{{ __('Select Year') }}</option>
                                        @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}" {{ $product->year == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'year']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Product Type') }} <span class="text-danger">*</span></label>
                                    <select name="product_type" class="form-control">
                                        <option value="" selected disabled>{{ __('Select Product Type') }}</option>
                                        @foreach (App\Models\Product::getProductTypes() as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $product->product_type == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $product->price }}" name="price" class="form-control"
                                        placeholder="Enter price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Cost price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $product->cost_price }}" name="cost_price"
                                        class="form-control" placeholder="Enter cost price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'cost_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sale price') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $product->sale_price }}" name="sale_price"
                                        class="form-control" placeholder="Enter sale price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sale_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Grade') }}</label>
                                    <input type="text" value="{{ $product->grade }}" name="grade" class="form-control"
                                        placeholder="Enter grade">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'grade']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Body') }}</label>
                                    <input type="text" value="{{ $product->body }}" name="body" class="form-control"
                                        placeholder="Enter body">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'body']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('First Registration') }}</label>
                                    <input type="text" value="{{ $product->first_registration }}" name="first_registration"
                                        class="form-control" placeholder="Enter first registration">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'first_registration']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <input type="text" value="{{ $product->type }}" name="type"
                                        class="form-control" placeholder="Enter type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Displacement') }}</label>
                                    <input type="text" value="{{ $product->displacement }}" name="displacement"
                                        class="form-control" placeholder="Enter displacement">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'displacement']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Capacity') }}</label>
                                    <input type="text" value="{{ $product->capacity }}" name="capacity"
                                        class="form-control" placeholder="Enter capacity">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'capacity']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Specification No') }}</label>
                                    <input type="text" value="{{ $product->specification_no }}" name="specification_no"
                                        class="form-control" placeholder="Enter specification no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'specification_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Classification No') }}</label>
                                    <input type="text" value="{{ $product->classification_no }}"
                                        name="classification_no" class="form-control"
                                        placeholder="Enter classification no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'classification_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Chassis No') }}</label>
                                    <input type="text" value="{{ $product->chassis_no }}" name="chassis_no"
                                        class="form-control" placeholder="Enter chassis no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'chassis_no']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Serial No') }}</label>
                                    <input type="text" value="{{ $product->serial_no }}" name="serial_no"
                                        class="form-control" placeholder="Enter serial no">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'serial_no']" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" min="0" value="{{ $product->quantity }}" name="quantity"
                                        class="form-control" placeholder="Enter quantity">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'quantity']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Engine Type') }}</label>
                                    <input type="text" value="{{ $product->engine_type }}" name="engine_type"
                                        class="form-control" placeholder="Enter engine type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'engine_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Fuel Type') }}</label>
                                    <input type="text" value="{{ $product->fuel_type }}" name="fuel_type"
                                        class="form-control" placeholder="Enter fuel type">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'fuel_type']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Color') }}</label>
                                    <input type="text" value="{{ $product->color }}" name="color"
                                        class="form-control" placeholder="Enter color">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'color']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Mileage') }}</label>
                                    <input type="text" value="{{ $product->mileage }}" name="mileage"
                                        class="form-control" placeholder="Enter mileage">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'mileage']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Odometer Replacement') }}</label>
                                    <input type="text" value="{{ $product->odometer_replacement }}"
                                        name="odometer_replacement" class="form-control"
                                        placeholder="Enter odometer replacement">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'odometer_replacement']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Streeing Wheel') }}</label>
                                    <input type="text" value="{{ $product->streeing_wheel }}" name="streeing_wheel"
                                        class="form-control" placeholder="Enter streeing wheel">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'streeing_wheel']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Transmission') }}</label>
                                    <input type="text" value="{{ $product->transmisison }}" name="transmisison"
                                        class="form-control" placeholder="Enter transmisison">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'transmisison']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Drive System') }}</label>
                                    <input type="text" value="{{ $product->drive_system }}" name="drive_system"
                                        class="form-control" placeholder="Enter drive system">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'drive_system']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Supplier Name') }}</label>
                                    <select name="supplier_id" class="form-control">
                                        <option value="" selected>{{ $product->supplier?->first_name ?: __('Select Supplier') }}</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->first_name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'supplier_id']" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Remarks') }}</label>
                                    <textarea name="remarks" class="form-control" placeholder="Enter remarks">{{ $product->remarks }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'remarks']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Sort Description') }}</label>
                                    <textarea name="sort_description" class="form-control" placeholder="Enter sort description">{{ $product->sort_description }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sort_description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" placeholder="Enter description">{{ $product->description }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Title') }}</label>
                                    <input type="text" value="{{ $product->meta_title }}" name="meta_title"
                                        class="form-control" placeholder="Enter meta title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Description') }}</label>
                                    <textarea name="meta_description" class="form-control no-ckeditor5" rows="6"
                                        placeholder="Enter meta description">{{ $product->meta_description }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta Keywords') }}</label>
                                    <select name="meta_keywords[]" class="form-control" multiple>
                                        <option value="">{{ $product->meta_keywords }}</option>
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
