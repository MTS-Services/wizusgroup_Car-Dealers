@extends('backend.admin.layouts.master', ['page_slug' => 'subcategory'])
@section('title', 'Create Sub Category')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Sub Category') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.sub-category.index',
                        'label' => 'Back',
                        'permissions' => ['sub-category-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.sub-category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Category') }}  <span class="text-danger">*</span></label>
                            <select name="parent_id" class="form-control">
                                <option value="" selected disabled>{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'parent_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Slug') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                                placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="uploadImage" data-actualName="image" class="form-control filepond"
                                id="image" accept="image/*">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Meta Title') }}</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="Enter meta title">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Meta Description') }}</label>
                            <textarea name="meta_description" class="form-control" placeholder="Enter meta description">{{old('meta_description')}}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Enter description">{{old('description')}}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
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
