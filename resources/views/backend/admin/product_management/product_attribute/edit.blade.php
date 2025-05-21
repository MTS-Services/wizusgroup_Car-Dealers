@extends('backend.admin.layouts.master', ['page_slug' => 'product_attribute'])
@section('title', 'Edit Product Attribute')
@section('content')
    <div class="row">
         <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Product Attribute') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product-attribute.index',
                        'label' => 'Back',
                        'permissions' => ['product_attribute-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product-attribute.update', encrypt($product_attribute->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $product_attribute->name }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-backend.admin.documentation :document="$document" />
    </div>
@endsection
