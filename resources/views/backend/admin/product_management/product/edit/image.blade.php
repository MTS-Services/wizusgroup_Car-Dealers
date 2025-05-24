
@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Edit Product Images')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                        {{ __('Edit Product Images') }}
                    </h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.image.update',
                        'params' => ['product' => $product_id],
                        'label' => 'Back',
                        'permissions' => ['product-update'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.image.update', $product_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Primary image') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image" accept="image/jpeg, image/png, image/jpg, image/webp, image/svg" class="form-control filepond" id="image"
                                accept="image/*">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>
                        <div class="form-group">
                            <label for="images">{{ __('Images') }}</label>
                            <input type="file" name="images[]" accept="image/jpeg, image/png, image/jpg, image/webp, image/svg"  class="form-control filepond" multiple id="images"
                                accept="image/*">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'images.*']" />
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'images']" />
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
    {{-- FilePond  --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], [], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg']);
            file_upload(["#images"], [], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'], true);
        });
    </script>
@endpush
