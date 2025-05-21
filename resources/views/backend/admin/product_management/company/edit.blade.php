@extends('backend.admin.layouts.master', ['page_slug' => 'company'])
@section('title', 'Edit Company')

@section('content')
<div class="row">
     <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Company') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.company.index',
                        'label' => 'Back',
                        'permissions' => ['company-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.company.update', encrypt($company->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $company->name) }}" id="title" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug', $company->slug) }}" id="slug" name="slug" class="form-control" placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>
                    {{-- Image --}}
                    <div class="form-group">
                        <label>{{ __('image') }}<span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="uploadImage" data-actualName="image"
                            class="form-control filepond" id="image">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                    </div>

                    {{-- Website --}}
                    <div class="form-group">
                        <label>{{ __('Website') }}</label>
                        <input type="url" value="{{ old('website', $company->website) }}" name="website" class="form-control" placeholder="Enter website">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'website']" />
                    </div>

                    {{-- Meta Title --}}
                    <div class="form-group">
                        <label>{{ __('Meta Title') }}</label>
                        <input type="text" value="{{ old('meta_title', $company->meta_title) }}" name="meta_title" class="form-control" placeholder="Enter meta title">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                    </div>

                    {{-- Meta Description --}}
                    <div class="form-group">
                        <label>{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" class="form-control" placeholder="Enter meta description">{{ old('meta_description', $company->meta_description) }}</textarea>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description', $company->description) }}</textarea>
                    </div>
                    {{-- Submit --}}
                    <div class="form-group float-end mt-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-backend.admin.documentation :document="$document" />
</div>
@endsection
@push('js')
<script src="{{ asset('ckEditor5/main.js') }}"></script>
{{-- FilePond  --}}
<script src="{{ asset('filepond/filepond.js') }}"></script>
<script>
        $(document).ready(function() {
            const existingFiles = {
                "#image":"{{ $company->modified_image }}",
            };
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);
        });
    </script>
{{-- FilePond  --}}
@endpush
