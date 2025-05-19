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
                    @include('backend.admin.product_management.product.includes.basic_info')
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
