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
                        'params' => ['product' => $product_id, 'product_type' => request('product_type')],
                        'label' => 'Back',
                        'permissions' => ['product-create'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.info.store', $product_id) }}" method="POST"
                        enctype="multipart/form-data">
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
                                <label>{{ __('File') }}</label>
                                <input type="file" name="file"
                                    accept="application/pdf, application/doc, application/docx, application/xls, application/xlsx"
                                    class="form-control filepond" id="file">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'file']" />
                            </div>

                            <div class="form-group">
                                <label>{{ __('Information') }}<span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id="description" placeholder="Enter description"></textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                            </div>
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Add Information">
                        </div>
                        <div class="col-12 form-group float-end">
                            <div class="form-group float-end">
                                <a href="{{ route('pm.product.entry_complete', ['product' => $product_id, 'product_type' => request('product_type')]) }}"
                                    class="btn btn-secondary">{{ __('Finish') }}</a>
                            </div>
                        </div>
                    </form>
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
            file_upload(["#file"], ['application/pdf', 'application/doc', 'application/docx', 'application/xls',
                'application/xlsx'
            ]);
        })
    </script>
@endpush
