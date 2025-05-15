@extends('backend.admin.layouts.master', ['page_slug' => 'model'])
@section('title', 'Edit Model')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Model') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.model.index',
                        'label' => 'Back',
                        'permissions' => ['model-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.model.update', encrypt($model->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>{{ __('Brand') }} <span class="text-danger">*</span></label>
                        <select name="brand_id" class="form-control" id="brand_id">
                            <option value="" selected hidden>{{__('Select Brand')}}</option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}" {{ $model->brand_id == $brand->id ? 'selected' : ''}}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $model->name) }}" id="title" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug', $model->slug) }}" id="slug" name="slug" class="form-control" placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('image') }}<span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="uploadImage" data-actualName="image"
                            class="form-control filepond" id="image">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Meta Title') }}</label>
                        <input type="text" value="{{ old('meta_title', $model->meta_title) }}" name="meta_title" class="form-control" placeholder="Enter meta title">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" class="form-control" placeholder="Enter meta description">{{ old('meta_description', $model->meta_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description', $model->description) }}</textarea>
                    </div>
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
                "#image":"{{ $model->modified_image }}",
            };
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);
        });
    </script>
{{-- FilePond  --}}
@endpush
