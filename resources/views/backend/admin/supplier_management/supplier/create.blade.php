@extends('backend.admin.layouts.master', ['page_slug' => 'supplier'])
@section('title', 'Supplier Create')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Admin') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'sm.supplier.index',
                        'label' => 'Back',
                        'permissions' => ['supplier-list', 'supplier-details', 'supplier-delete', 'supplier-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('sm.supplier.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('First Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('first_name') }}" name="first_name"
                                        class="form-control" placeholder="Enter first name">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'first_name']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('last_name') }}" name="last_name"
                                        class="form-control" placeholder="Enter last name">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'last_name']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                        placeholder="Enter email">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'email']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Phone') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                        placeholder="Enter phone number">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'phone']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Website') }} <span class="text-danger">*</span></label>
                                    <input type="url" name="website" value="{{ old('website') }}" class="form-control"
                                        placeholder="Enter website url">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'website']" />
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control filepond" id="image"
                                accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('Address') }} <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control no-ckeditor5" placeholder="Enter address">{{ old('address') }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'website']" />
                            </div>
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Create">
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
                "#image": "{{ old('image') }}",
            }
            file_upload(["#image"], ["image/jpeg", "image/png", "image/jpg", "image/webp", "image/svg"],
                existingFiles);

            // username validation
            const username = $('.username');
            const error = $('.username-error');
            validateUsername(username, error);
        });
    </script>
    {{-- FilePond  --}}
@endpush
