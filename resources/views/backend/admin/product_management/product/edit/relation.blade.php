@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Set Product Relations')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                        {{ __('Set Product Relations') }}
                    </h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.edit',
                        'params' => [encrypt($product->id)],
                        'label' => 'Back',
                        'permissions' => ['product-update'],
                    ]" />

                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.relation.update', encrypt($product->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Company') }} <span class="text-danger">*</span></label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="" selected disabled>
                                            {{ __('Select Company') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $product->company->id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'company_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-control"
                                        @if (!isset($product->brand?->id)) disabled @endif>
                                        <option value="" selected disabled>
                                            {{ __('Select Brand') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'brand_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Model') }}</label>
                                    <select name="model_id" class="form-control" id="model_id"
                                        @if (!isset($product->model?->id)) disabled @endif>
                                        <option value="" selected disabled>
                                            {{ __('Select Model') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'model_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Category') }}<span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" id="category_id"
                                        {{ $product->sub_category_id ?: 'selected' }}>
                                        <option selected disabled>{{ __('Select Category') }}
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category?->id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'category_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sub Category') }}<span class="text-danger">*</span></label>
                                    <select name="sub_category_id" id="childrens" class="form-control">
                                        <option value="{{ $product->sub_category_id }}" selected>
                                            {{ $product->sub_category?->name ?: __('Select Sub Category') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sub_category_id']" />
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
    <script>
        $(document).ready(function() {
            let sub_cat_route = "{{ route('axios.get-sub-categories') }}";
            $('#category_id').on('change', function() {
                getSubCategories($(this).val(), sub_cat_route);
            })

            let brand_route = "{{ route('axios.get-brands') }}";
            $('#company_id').on('change', function() {
                getBrands($(this).val(), brand_route);
            });
            let model_route = "{{ route('axios.get-models') }}";
            $('#brand_id').on('change', function() {
                getModels({
                    brandId: $(this).val(),
                    route: model_route
                });
            });
            let brand_id = ` {{ $product->brand?->id }}`;
            getBrands($('#company_id').val(), brand_route, brand_id);
            let model_id = ` {{ $product->model?->id }}`;
            getModels({
                companyId: $('#company_id').val(),
                brandId: $('#brand_id').val(),
                route: model_route,
                modelId: model_id
            });
            let sub_category_id = `{{ $product->subCategory?->id }}`;
            getSubCategories($('#category_id').val(), sub_cat_route, sub_category_id);
        });
    </script>
@endpush
