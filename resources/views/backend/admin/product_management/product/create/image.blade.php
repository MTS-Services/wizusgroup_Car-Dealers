
@extends('backend.admin.layouts.master', ['page_slug' => 'product'])
@section('title', 'Set Product Images')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                        {{ __('Set Product Images') }}
                    </h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.product.relation',
                        'params' => ['product' => encrypt($product->id)],
                        'label' => 'Back',
                        'permissions' => ['product-create'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.product.image.store', encrypt($product->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Primary image') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image" accept="image/jpeg, image/png, image/jpg, image/webp, image/svg" class="form-control filepond" id="image">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>
                        <div class="form-group">
                            <label for="images">{{ __('Images') }}</label>
                            <input type="file" name="images[]" accept="image/jpeg, image/png, image/jpg, image/webp, image/svg"  class="form-control filepond" multiple id="images">
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
            const existingFiles = {
                "#image":"{{ $product?->primaryImage?->first()?->modified_image }}",
            }
            const existingMultiFiles = {
                "#images":@json($product->nonPrimayImages->map(fn ($img) => $img->modified_image)->toArray()),
            }
            console.log(existingMultiFiles);

            file_upload(["#image"],['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'], existingFiles);
            file_upload(["#images"],['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'], existingMultiFiles, true);

            // const existingFiles = {
            //     "#image": "{{ $product?->primaryImage?->first()?->modified_image }}",
            //     "#images": @json($product->nonPrimayImages->map(fn ($img) => $img->modified_image)->toArray()),
            // };
            // console.log(existingFiles);


            // const multipleConfig = {
            //     "#image": false,
            //     "#images": true
            // };

            // file_upload(["#image", "#images"], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'], existingFiles, multipleConfig);
        });
    </script>
@endpush
