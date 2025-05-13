@extends('backend.admin.layouts.master', ['page_slug' => 'subchildcategory'])
@section('title', 'Edit Sub Child Category')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Sub Child Category') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.sub-child-category.index',
                        'label' => 'Back',
                        'permissions' => ['sub-child-category-list',],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.sub-child-category.update', encrypt($subcategory->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Main Category') }}  <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="" selected disabled>{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $subcategory?->parent?->parent_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'category_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sub Category') }}  <span class="text-danger">*</span></label>
                            <select id="childrens" name="parent_id" class="form-control" disabled>
                                <option value="" selected disabled>{{ __('Select Sub Category') }}</option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'parent_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $subcategory->name }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Slug') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $subcategory->slug }}" id="slug" name="slug" class="form-control"
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
                            <input type="text" name="meta_title" value="{{ $subcategory->meta_title }}" class="form-control" placeholder="Enter meta title">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Meta Description') }}</label>
                            <textarea name="meta_description" class="form-control" placeholder="Enter meta description">{{$subcategory->meta_description}}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Enter description">{{$subcategory->description}}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- FilePond  --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image":"{{ $subcategory->modified_image }}",
            }
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);
            let route = "{{ route('axios.get-sub-categories') }}";
            $('#category_id').on('change', function() {
                getSubCategories($(this).val(), route);
            })
            if(`{{$subcategory?->parent_id && $subcategory?->parent?->parent_id}}`){
                 getSubCategories(`{{$subcategory?->parent?->parent_id}}`, route, `{{$subcategory?->parent_id}}`);
            }
        });
    </script>
    {{-- FilePond  --}}
@endpush
