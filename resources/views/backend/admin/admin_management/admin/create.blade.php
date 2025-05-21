@extends('backend.admin.layouts.master', ['page_slug' => 'admin'])
@section('title', 'Create Admin')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }} ">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Admin') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'am.admin.index',
                        'label' => 'Back',
                        'permissions' => ['admin-list', 'admin-details', 'admin-delete', 'admin-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('am.admin.store') }}" method="POST" enctype="multipart/form-data">
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Username') }}</label>
                                    <input type="text" value="{{ old('username') }}" name="username"
                                        class="form-control username" placeholder="Enter username">
                                    <span class="username-error invalid-feedback"></span>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'username']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Role') }} <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control">
                                        <option value="" selected hidden>{{ __('Select Role') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role') == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'role']" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="image" class="form-control filepond"
                                id="image" accept="image/jpeg, image/png, image/jpg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control" placeholder="Enter email">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'email']" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter password">
                                        <x-backend.show-password />
                                    </div>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'password']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Enter confirm password">
                                        <x-backend.show-password />
                                    </div>
                                </div>
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
            file_upload(["#image"],[],["image/jpeg", "image/png", "image/jpg"]);

            // username validation
            const username = $('.username');
            const error = $('.username-error');
            validateUsername(username, error);
        });
    </script>
    {{-- FilePond  --}}
@endpush
