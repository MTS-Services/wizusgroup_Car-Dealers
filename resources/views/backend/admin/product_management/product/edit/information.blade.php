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
                    <form action="{{ route('pm.product.info.update', $product_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                <select name="product_info_cat_type_feature_id" class="form-control"
                                    id="product_info_cat_type_feature_id" disabled>
                                    <option value="" selected hidden>
                                        {{ __('Select Product Info Category Type Feature') }}
                                    </option>
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_type_feature_id']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Information') }}<span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('description') }}" name="description"
                                    class="form-control" placeholder="Enter information">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                            </div>
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update Information">
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <form action="{{ route('pm.product.info.remarks.store', $product_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <h4 class="cart-title">
                                                {{ __('Set Product Remarks') }}
                                            </h4>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Product Info Category') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="product_info_cat" class="form-control">
                                                <option value="" selected hidden>
                                                    {{ __('Select Product Info Category') }}
                                                </option>
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
                                        <div class="form-group float-end">
                                            <input type="submit" class="btn btn-primary" value="Add Remarks">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('pm.product.info.files.store', $product_id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <h4 class="cart-title">
                                                {{ __('Set Product Documents') }}
                                            </h4>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Product Info Category') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="product_info_cat" class="form-control">
                                                <option value="" selected hidden>
                                                    {{ __('Select Product Info Category') }}
                                                </option>
                                                @foreach ($info_categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('product_info_cat') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat']" />
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="file"
                                                accept="application/pdf, application/doc, application/docx, application/xls, application/xlsx"
                                                class="form-control filepond" id="file">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'file']" />
                                        </div>
                                        <div class="form-group float-end">
                                            <input type="submit" class="btn btn-primary" value="Add File">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 form-group float-end">
                            <div class="form-group float-end">
                                <a href="{{ route('pm.product.index') }}"
                                    class="btn btn-secondary">{{ __('Finish') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.admin.product_management.product.create.information_list', ['infos' => $infos])

@endsection
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#file"], ['application/pdf', 'application/doc', 'application/docx', 'application/xls', 'application/xlsx'] );
        })
    </script>
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
