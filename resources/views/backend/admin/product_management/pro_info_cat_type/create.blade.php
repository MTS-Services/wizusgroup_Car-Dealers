@extends('backend.admin.layouts.master', ['page_slug' => 'product_info_cat_type'])
@section('title', 'Product Information Category Type List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Create Product Info Category Type') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product-info-category-type.index',
                        'label' => 'Back',
                        'permissions' => ['product-info-category-type-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.product-info-category-type.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Product Info Category') }} <span class="text-danger">*</span></label>
                        <select name="product_info_cat_id" class="form-control" id="product_info_cat_id">
                            <option value="" selected hidden>{{__('--Select Product Info Category--')}}</option>
                            @foreach ($product_info_cats as $product_info_cat)
                                <option value="{{$product_info_cat->id}}" {{ old('product_info_cat_id') == $product_info_cat->id ? 'selected' : ''}}>{{ $product_info_cat->name }}</option>
                            @endforeach
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_id']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                            placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                            placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
