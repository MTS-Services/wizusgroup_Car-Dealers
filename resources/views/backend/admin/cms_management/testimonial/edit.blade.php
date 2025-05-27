@extends('backend.admin.layouts.master', ['page_slug' => 'testimonial'])
@section('title', 'Testimonial Edit')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Testimonial') }}</h4>
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
                    <form action="{{ route('cms.testimonial.update', encrypt($testimonial->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('Author Name') }} <span class="text-danger">*</span></label>
                                            <input type="text"
                                                value="{{ old('author_name', $testimonial->author_name) }}"
                                                name="author_name" class="form-control" placeholder="Enter name">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_name']" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('Author Designation') }} <span class="text-danger">*</span></label>
                                            <input type="text"
                                                value="{{ old('author_designation', $testimonial->author_designation) }}"
                                                name="author_designation" class="form-control"
                                                placeholder="Enter designation">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_designation']" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('Author Country') }} <span class="text-danger">*</span></label>
                                            <input type="text"
                                                value="{{ old('author_country', $testimonial->author_country) }}"
                                                name="author_country" class="form-control" placeholder="Enter country">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_country']" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group h-100"
                                    style="border:  padding: 20px; display: flex; flex-direction: column; justify-content: center; min-height: 100%;">
                                    <label>{{ __('Author Image') }}<span class="text-danger">*</span></label>
                                    <input type="file" accept="image/jpeg, image/png, image/jpg, image/webp, image/svg"
                                        name="author_image" class="form-control filepond" id="image">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'author_image']" />
                                </div>
                            </div>
                        </div>




                     
                        <div class="form-group">
                            <label>{{ __('Author Quote') }} <span class="text-danger">*</span></label>
                            <textarea name="quote" class="form-control no-ckeditor5" placeholder="Enter quote">{{ old('quote', $testimonial->quote) }}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'quote']" />
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
    {{-- CKEditor5 --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    {{-- FilePond  --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image": "{{ $testimonial->modified_image }}",
            }
            file_upload(["#image"], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'], existingFiles);
        });
    </script>
@endpush
