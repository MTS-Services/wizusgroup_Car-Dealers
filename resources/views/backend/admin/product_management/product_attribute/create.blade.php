@extends('backend.admin.layouts.master', ['page_slug' => 'product_attribute'])
@section('title', 'Create Category')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Product Attribute') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product-attribute.index',
                        'label' => 'Back',
                        'permissions' => ['product_attribute-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product-attribute.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
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
