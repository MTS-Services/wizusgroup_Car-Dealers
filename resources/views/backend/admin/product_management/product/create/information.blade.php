@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Set Product Information')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                            {{ __('Set Product Information') }}
                    </h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.image',
                        'params' => ['product' => $product_id],
                        'label' => 'Back',
                        'permissions' => ['product-create'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.info.store', $product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group">
                                <label>{{ __('Product Info Category') }} <span class="text-danger">*</span></label>
                                <select name="product_info_cat_id" class="form-control" id="product_info_cat_id">
                                    <option value="" selected hidden>{{ __('Select Product Info Category') }}</option>
                                    @foreach ($info_categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('product_info_cat_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_id']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Product Info Category Type') }}<span class="text-danger">*</span></label>
                                <select name="product_info_cat_type_id" class="form-control" id="product_info_cat_type_id"
                                    disabled>
                                    <option value="" selected hidden>{{ __('Select Product Info Category Type') }}
                                    </option>
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_type_id']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Product Info Category Type Feature') }}</label>
                                <select name="product_info_cat_type_feature_id" class="form-control" id="product_info_cat_type_feature_id"
                                    disabled>
                                    <option value="" selected hidden>{{ __('Select Product Info Category Type Feature') }}
                                    </option>
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_type_feature_id']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Information') }}<span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('description') }}" name="description" class="form-control" placeholder="Enter information">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                            </div>
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Add Information">
                        </div>
                    </form>
                </div>
                 <div class="card-body">
                    <form action="{{ route('pm.product.info.remarks.store', $product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group">
                                <label>{{ __('Product Info Category') }} <span class="text-danger">*</span></label>
                                <select name="product_info_cat" class="form-control">
                                    <option value="" selected hidden>{{ __('Select Product Info Category') }}</option>
                                    @foreach ($info_categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('product_info_cat') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Remarks') }}<span class="text-danger">*</span></label>
                                <textarea name="remarks" class="form-control" placeholder="Enter remarks">{{ old('remarks') }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'remarks']" />
                            </div>
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Add Remarks">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#product_info_cat_id').on('change', function() {
                let route = "{{ route('axios.get-info-cat-types') }}";
                getInfoCatTypes($(this).val(), route);
            });
            $('#product_info_cat_type_id').on('change', function() {
                let route = "{{ route('axios.get-info-cat-type-features') }}";
                getInfoCatTypeFeatures($(this).val(), route);
            });
        });
    </script>
@endpush
