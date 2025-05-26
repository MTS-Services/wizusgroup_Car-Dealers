@extends('backend.admin.layouts.master', ['page_slug' => 'testimonial'])
@section('title', 'Testimonial create')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Testimonial') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.testimonial.index',
                        'label' => 'Back',
                        'permissions' => [
                            'testimonial-list',
                            'testimonial-details',
                            'testimonial-delete',
                            'testimonial-status',
                        ],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.testimonial.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left side - Form fields -->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __(' Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('author_name') }}" name="author_name"
                                                class="form-control" placeholder="Enter name">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_name']" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __(' Designation') }} <span class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('author_designation') }}"
                                                name="author_designation" class="form-control"
                                                placeholder="Enter designation">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_designation']" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __(' Country') }} <span class="text-danger">*</span></label>
                                            <input type="text" value="{{ old('author_country') }}" name="author_country"
                                                class="form-control" placeholder="Enter country">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_country']" />
                                        </div>
                                    </div>
                                    <!-- Add other form fields here as needed -->
                                </div>
                            </div>

                            <!-- Right side - Image upload -->
                            <div class="col-md-6">
                                <div class="form-group h-100"
                                    style="border:  padding: 20px; display: flex; flex-direction: column; justify-content: center; min-height: 100%;">
                                    <label>{{ __('Image') }}</label>
                                    <input type="file" name="uploadImage" data-actualName="author_image"
                                        class="form-control filepond" id="image" accept="image/*">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_image']" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Quote') }}</label>
                            <textarea name="quote" class="form-control" id="quote" placeholder="Enter Quote">{{ old('quote') }}</textarea>
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
    {{-- CKEditor5 --}}
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
