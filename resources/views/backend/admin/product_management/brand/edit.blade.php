@extends('backend.admin.layouts.master', ['page_slug' => 'brand'])
@section('title', 'Edit Brand')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Brand') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.brand.index',
                        'label' => 'Back',
                        'permissions' => ['brand-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.brand.update', encrypt($brand->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $brand->name) }}" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug', $brand->slug) }}" name="slug" class="form-control" placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    {{-- Logo --}}
                    <div class="form-group">
                        <label>{{ __('Logo') }}<span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="uploadImage" data-actualName="logo"
                            class="form-control filepond" id="logo">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'logo']" />
                    </div>

                    {{-- Website --}}
                    <div class="form-group">
                        <label>{{ __('Website') }}</label>
                        <input type="url" value="{{ old('website', $brand->website) }}" name="website" class="form-control" placeholder="Enter website">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'website']" />
                    </div>

                    {{-- Meta Title --}}
                    <div class="form-group">
                        <label>{{ __('Meta Title') }}</label>
                        <input type="text" value="{{ old('meta_title', $brand->meta_title) }}" name="meta_title" class="form-control" placeholder="Enter meta title">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                    </div>

                    {{-- Meta Description --}}
                    <div class="form-group">
                        <label>{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" class="form-control" placeholder="Enter meta description">{{ old('meta_description', $brand->meta_description) }}</textarea>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description', $brand->description) }}</textarea>
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
@push('js')
<script src="{{ asset('ckEditor5/main.js') }}"></script>
{{-- FilePond  --}}
<script src="{{ asset('filepond/filepond.js') }}"></script>
<script>
        $(document).ready(function() {
            const existingFiles = {
                "#logo":"{{ $brand->modified_logo }}",
            };
            file_upload(["#logo"], "uploadImage", "admin", existingFiles, false);
        });
    </script>
{{-- FilePond  --}}
@endpush
