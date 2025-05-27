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
                        'routeName' => $product->updated_by ? 'pm.product.edit' : 'pm.product.create',
                        'params' => $product->updated_by ? ['product' => encrypt($product->id)] : [],
                        'label' => 'Back',
                        'permissions' => $product->updated_by ? ['product-update'] : ['product-create'],
                    ]" />
                </div>
                <div class="card-body">
                   <form action="{{ route('pm.product.relation.store', encrypt($product->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Company') }} <span class="text-danger">*</span></label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="" selected disabled>{{ __('Select Company') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id', $product?->company?->id) == $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'company_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Brand') }}</label>
                                    <select name="brand_id" id="brand_id" class="form-control" disabled>
                                        <option value="" selected disabled>{{ __('Select Brand') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'brand_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Model') }}</label>
                                    <select name="model_id" class="form-control" id="model_id" disabled>
                                        <option value="" selected disabled>{{ __('Select Model') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'model_id']" />
                                </div>
                            </div>
                            @if(isset($not_used))
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Tax Class') }}</label>
                                        <select name="tax_class_id" id="tax_class_id" class="form-control">
                                            <option value="" selected disabled>{{ __('Select Tax Class') }}</option>
                                            @foreach ($tax_classes as $tax_class)
                                                <option value="{{ $tax_class->id }}">{{ $tax_class->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'tax_class_id']" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Tax Rate') }}</label>
                                        <select name="tax_rate_id" class="form-control" id="tax_rate_id" disabled>
                                            <option value="" selected disabled>{{ __('Select Tax Rate') }}</option>
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'tax_rate_id']" />
                                    </div>
                                </div> --}}
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Category') }}<span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option value="" selected disabled>{{ __('Select Category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product?->category?->id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'category_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Sub Category') }}<span class="text-danger">*</span></label>
                                    <select name="sub_category_id" id="childrens" class="form-control" disabled>
                                        <option value="" selected>{{ __('Select Sub Category') }}</option>
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sub_category_id']" />
                                </div>
                            </div>
                            @if(isset($not_used))
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Sub Child Category') }}</label>
                                        <select name="sub_child_category_id" class="form-control" disabled id="sub_childrens">
                                            <option value="" selected>{{ __('Select Sub Child Category') }}</option>
                                        </select>
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sub_child_category_id']" />
                                    </div>
                                </div> --}}
                            @endif
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

            if(`{{$product?->subCategory?->id}}`){
                getSubCategories($('#category_id').val(), sub_cat_route, `{{$product?->subCategory?->id}}`);

            }

            let brand_route = "{{ route('axios.get-brands') }}";
            $('#company_id').on('change', function() {
                getBrands($(this).val(), brand_route);
            });

            if(`{{$product?->brand?->id}}`){
                getBrands($('#company_id').val(), brand_route, `{{$product?->brand?->id}}`);
            }


            let model_route = "{{ route('axios.get-models') }}";
            $('#brand_id').on('change', function() {
                getModels({
                    brandId: $(this).val(),
                    route: model_route
                });
            });

            if(`{{$product?->model?->id}}`){
                getModels({
                    brandId: `{{$product?->brand?->id}}`,
                    route: model_route,
                    modelId: `{{$product?->model?->id}}`
                });
            }
        });
    </script>
@endpush
