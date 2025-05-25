@extends('backend.admin.layouts.master', ['page_slug' => 'product_attribute_value'])
@section('title', 'Edit Attribute Value')
@section('content')
    <div class="row">
         <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Attribute Value') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product-attr-value.index',
                        'label' => 'Back',
                        'permissions' => ['product_attribute_value-list',],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product-attr-value.update', encrypt($product_attribute_value->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label>{{ __('Product Name') }}  <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-control">
                                <option value="" selected disabled>{{ __('Select Attribute Value Name') }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ $product_attribute_value->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Product Attribute Name') }}  <span class="text-danger">*</span></label>
                            <select name="product_attribute_id" class="form-control">
                                <option value="" selected disabled>{{ __('Select Attribute Value Name') }}</option>
                                @foreach ($product_attributes as $product_attribute)
                                    <option value="{{ $product_attribute->id }}" {{ $product_attribute_value->product_attribute_id == $product_attribute->id ? 'selected' : '' }}>
                                        {{ $product_attribute->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_attribute_id']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Value') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $product_attribute_value->value }}" id="title" name="value" class="form-control"
                                placeholder="Enter value">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'value']" />
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
