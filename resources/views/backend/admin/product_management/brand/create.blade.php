@extends('backend.admin.layouts.master', ['page_slug' => 'brand'])
@section('title', 'Create Brand')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Create Brand') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.brand.index',
                        'label' => 'Back',
                        'permissions' => ['brand-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Company') }} <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control" id="company_id">
                            <option value="" selected hidden>{{__('--Select Company--')}}</option>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}" {{ old('company_id') == $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'company_id']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                            placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                            placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    {{-- Image --}}
                    <div class="form-group">
                        <label>{{ __('Image') }}<span class="text-danger">*</span></label>
                        <input type="file" name="uploadImage" data-actualName="image" class="form-control filepond"
                            id="image" accept="image/*">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                    </div>
                    <div class="form-group">
                        <label>{{__('Website')}}</label>
                        <input type="url" value="{{ old('website') }}" id="website" name="website" class="form-control"
                            placeholder="Enter website">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'website']" />
                    </div>
                    <div class="form-group">
                        <label>{{__('Meta Title')}}</label>
                        <input type="text" value="{{ old('meta_title') }}" id="meta_title" name="meta_title" class="form-control"
                            placeholder="Enter meta title">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                    </div>
                    {{-- Meta_description --}}
                    <div class="form-group">
                        <label>{{__('Meta_description')}}</label>
                        <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Enter meta_description">{{old('meta_description')}}</textarea>
                    </div>
                    {{-- Description --}}
                    <div class="form-group">
                        <label>{{__('Description')}}</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Enter description">{{old('description')}}</textarea>
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
<script src="{{ asset('ckEditor5/main.js') }}"></script>
{{-- FilePond  --}}
<script src="{{ asset('filepond/filepond.js') }}"></script>
<script>
    $(document).ready(function() {
        file_upload(["#image"], "uploadImage", "admin", [], false);
    });
</script>
{{-- FilePond  --}}
@endpush
