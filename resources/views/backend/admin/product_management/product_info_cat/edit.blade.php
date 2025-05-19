@extends('backend.admin.layouts.master', ['page_slug' => 'product_info_cat'])
@section('title', 'Product Information Category Edit')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Product Information Category') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product-info-category.index',
                        'label' => 'Back',
                        'permissions' => ['product-info-category-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.product-info-category.update', encrypt($product_info_category->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $product_info_category->name) }}" id="title" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug', $product_info_category->slug) }}" id="slug" name="slug" class="form-control" placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    {{-- Submit --}}
                    <div class="form-group float-end mt-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

