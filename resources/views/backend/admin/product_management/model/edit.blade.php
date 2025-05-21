@extends('backend.admin.layouts.master', ['page_slug' => 'model'])
@section('title', 'Edit Model')

@section('content')
<div class="row">
     <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
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
                        <label>{{ __('Company') }} <span class="text-danger">*</span></label>
                        <select name="company_id" class="form-control" id="company_id">
                            <option value="" selected hidden>{{__('Select Company')}}</option>
                            @foreach ($companies as $company)
                                <option value="{{$company->id}}" {{ $model->company_id == $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'company_id']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Brand') }} <span class="text-danger">*</span></label>
                        <select name="brand_id" class="form-control" id="brand_id" disabled>
                            <option value="" selected hidden>{{__('Select Brand')}}</option>
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'brand_id']" />
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
                "#image":"{{ $model->modified_image }}",
            };
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);

            let route = "{{ route('axios.get-brands') }}";
             $('#company_id').on('change', function() {
                getBrands($(this).val(), route);
            });
            getBrands(`{{$model->company_id}}`, route, `{{$model->brand_id}}`);
        });
    </script>
{{-- FilePond  --}}
@endpush
