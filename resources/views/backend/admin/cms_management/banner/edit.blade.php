@extends('backend.admin.layouts.master', ['page_slug' => 'banner'])
@section('title', 'Edit Banner')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Banner') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.banner.index',
                        'label' => 'Back',
                        'permissions' => ['banner-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.banner.update', encrypt($banner->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $banner->title }}" id="title" name="title"
                                class="form-control" placeholder="Enter title">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'title']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Sub Title') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $banner->subtitle }}" name="subtitle" id="subtitle"
                                class="form-control" placeholder="Enter title">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'subtitle']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="uploadImage" data-actualName="image"
                                class="form-control filepond" id="image">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Url') }}</label>
                            <input type="text" name="url" value="{{ $banner->url }}" class="form-control"
                                placeholder="Enter url">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'url']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Start Date') }}</label>
                            <input type="date" name="start_date" value="{{ $banner->start_date }}" class="form-control"
                                placeholder="Enter date">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'start_date']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('End Date') }}</label>
                            <input type="date" name="end_date" value="{{ $banner->end_date }}" class="form-control"
                                placeholder="Enter date">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'end_date']" />
                        </div>

                        <div class="form-group float-end">
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
    {{-- FilePond  --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image": "{{ $banner->modified_image }}",
            }
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);
        });
    </script>
    {{-- FilePond  --}}
@endpush
