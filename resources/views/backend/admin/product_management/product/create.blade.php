@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Create Product')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Product') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.index',
                        'label' => 'Back',
                        'permissions' => ['product-list'],
                    ]" />
                </div>
                <div class="card-body">
                    @if (isset($product) && $product['entry_status'] == App\Models\Product::ENTRY_STATUS_INFORMATION)
                        @include('backend.admin.product_management.product.includes.information')
                    @elseif (isset($product) && $product['entry_status'] == App\Models\Product::ENTRY_STATUS_IMAGE)
                        @include('backend.admin.product_management.product.includes.image')
                    @elseif (isset($product) && $product['entry_status'] == App\Models\Product::ENTRY_STATUS_RELATION)
                        @include('backend.admin.product_management.product.includes.relation')
                        @else
                        @include('backend.admin.product_management.product.includes.relation')
                        {{-- @include('backend.admin.product_management.product.includes.basic_info') --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- FilePond  --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], "uploadImage", "admin", [], false);
        });
    </script>
    {{-- FilePond  --}}
@endpush
