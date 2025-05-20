@extends('backend.admin.layouts.master', ['page_slug' => 'admin_profile'])

@section('title', 'Admin Profile')

@push('css')
    <style>
        .card {
            border-radius: 10px;
            background-color: #1a1a1a;
            color: #e0e0e0;
        }

        .form-control {
            border-radius: 6px;
            box-shadow: none;
            background-color: #222222;
            color: #f1f1f1;
            border: 1px solid #333;
        }

        .form-group input,
        .form-group select {
            height: 40px;
        }

        .card-header {
            background-color: #18181800;
            border-bottom: 1px solid #2a2a2a;
            border-radius: 10px 10px 0 0 !important;
            color: #ffffff;
        }

        .btn {
            border-radius: 6px;
        }

        .text-danger {
            font-size: 0.875rem;
            color: #ff4d4f;
        }

        .btn_item {
            background: linear-gradient(to right, #1f0036, #37006d);
            color: white;
            border: 1px solid #444;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
        }

        .btn_item:hover {
            background: linear-gradient(to right, #37006d, #1f0036);
            opacity: 0.9;
            cursor: pointer;
        }

        .active.btn_item {
            background: linear-gradient(to right, #0972C1, #37006d);
        }

        .card-header {
            background: linear-gradient(to right, #1f0036, #37006d);
            color: #ffffff;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2 active" data-bs-target="profile">profile</p>
                    <p class="btn_item w-100 py-2 " data-bs-target="address">Address</p>
                    <p class="btn_item w-100 py-2" data-bs-target="change-password">Change Password</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div id="profile" class="tab-pane active">
                        {{-- Profile Edit Card --}}
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header">
                                    <h4 class="mb-0 py-2 text-white">Profile</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.profile.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        {{-- Profile Details --}}
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <input type="file" name="uploadImage" data-actualName="image"
                                                                class="filepond" id="image" accept="image/*">
                                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label>{{ __('First Name') }} <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="first_name"
                                                                    value="{{ $admin?->first_name }}" class="form-control"
                                                                    placeholder="Enter your first name">
                                                                <x-feed-back-alert :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'first_name',
                                                                ]" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label>{{ __('Last Name') }} <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="last_name"
                                                                    value="{{ $admin?->last_name }}" class="form-control"
                                                                    placeholder="Enter your last name">
                                                                <x-feed-back-alert :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'last_name',
                                                                ]" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label>{{ __('Username') }} <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="username"
                                                                    value="{{ $admin?->username }}" class="form-control"
                                                                    placeholder="Enter your username">
                                                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'username']" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" value="{{ $admin?->email }}"
                                                        class="form-control" placeholder="Enter your email">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'email']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Phone') }}</label>
                                                    <input type="text" name="phone" value="{{ $admin?->phone }}"
                                                        class="form-control" placeholder="Enter your phone">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'phone']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Date of Birth') }}</label>
                                                    <input type="date" name="dob" value="{{ $admin?->personalInformation?->dob }}"
                                                        class="form-control">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'dob']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <div class="form-group">
                                                        <label for="gender"
                                                            class="form-label">{{ __('Gender') }}</label>
                                                        <select name="gender" id="gender" class="form-select">
                                                            @foreach (App\Models\PersonalInformation::getGenderLabels() as $key => $gender)
                                                                <option value="{{ $key }}"
                                                                    {{ $admin?->personalInformation?->gender == $key ? 'selected' : '' }}>
                                                                    {{ $gender }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'gender']" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Fathers Name') }}</label>
                                                    <input type="text" name="father_name"
                                                        value="{{ $admin?->personalInformation?->father_name }}"
                                                        class="form-control" placeholder="Enter your fathers name">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'father_name']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Mothers Name') }}</label>
                                                    <input type="text" name="mother_name"
                                                        value="{{ $admin?->personalInformation?->mother_name }}"
                                                        class="form-control" placeholder="Enter your mothers name">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'mother_name']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Emergency Phone') }}</label>
                                                    <input type="text" name="emergency_phone"
                                                        value="{{ $admin?->personalInformation?->emergency_phone }}"
                                                        class="form-control" placeholder="Enter your emergency phone">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'bio']" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Nationality') }}</label>
                                                    <input type="text" name="nationality"
                                                        value="{{ $admin?->personalInformation?->nationality }}"
                                                        class="form-control" placeholder="Enter name">
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'nationality']" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mb-3">
                                                    <label>{{ __('Bio') }}</label>
                                                    <textarea name="bio" class="form-control p-3" rows="5" placeholder="Enter your bio">{{ $admin?->personalInformation?->bio }}</textarea>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'bio']" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right mt-4">
                                            <button class="btn btn-primary px-4">{{ __('Update Profile') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Profile Address --}}
                    <div id="address" class="tab-pane ">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4 class="mb-0 py-2 text-white">{{ __('Profile Address') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.address.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="row">
                                                <div class="col-6 form-group">
                                                    <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                                                    <select name="country_id" id="country" class="form-select">
                                                        <option value="{{ $address?->country_id }}" selected hidden>
                                                            {{ __('Select Country') }}
                                                        </option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ $address?->country_id == $country->id ? 'selected' : '' }}>
                                                                {{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'country_id']" />
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>{{ __('State') }}</label>
                                                    <select name="state" id="state" class="form-select" disabled>
                                                        <option value="" selected hidden>{{ __('Select State') }}
                                                        </option>
                                                    </select>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'state']" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="row">
                                                <div class="col-6 form-group">
                                                    <label>{{ __('City') }} <span class="text-danger">*</span></label>
                                                    <select name="city" id="city" class="form-select" disabled>
                                                        <option value="" selected hidden>{{ __('Select City') }}
                                                        </option>
                                                    </select>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'city']" />
                                                </div>
                                                {{-- postal code --}}
                                                <div class="col-6 mb-3">
                                                    <div class="form-group">
                                                        <label>{{ __('Postal Code') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="postal_code"
                                                            value="{{ $address->postal_code ?? old('postal_code') }}"
                                                            placeholder="Enter postal code" class="form-control">
                                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'postal_code']" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Address Line 1') }} <span class="text-danger">*</span></label>
                                            <textarea name="address_line_1" class="form-control no-ckeditor5" id="address_line_1" cols="30"
                                                rows="5">{{ $address->address_line_1 ?? old('address_line_1') }}</textarea>
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address_line_1']" />
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Address Line 2') }}</label>
                                            <textarea name="address_line_2" class="form-control no-ckeditor5" id="address_line_2" cols="30"
                                                rows="5">{{ $address->address_line_2 ?? old('address_line_2') }}</textarea>
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address_line_2']" />
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-success px-4">{{ __('Update') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Password Change Card --}}
                    <div id="change-password" class="tab-pane">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4 class="mb-0 py-2 text-white">{{ __('Change Password') }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.password.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Current Password') }} <span class="text-danger">*</span></label>
                                            <input type="password" name="old_password" class="form-control">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'old_password']" />
                                        </div>


                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('New Password') }}</label>
                                            <input type="password" name="password" class="form-control">
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Confirm New Password') }}</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                            @error('password_confirmation')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-success px-4">{{ __('Change Password') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js-links')
    {{-- FilePond  --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            // Handle click on nav items
            $('.btn_item').on('click', function() {
                $('.btn_item').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('.tab-pane').removeClass('active');

                $('#' + target).addClass('active');
            });
        });
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-states-or-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            let route3 = "{{ route('axios.get-operation-areas') }}";
            $('#city').on('change', function() {
                getOperationAreas($(this).val(), route3);
            });

            let data_id =
                `{{ $address?->state_id ? $address?->state_id : $address?->city_id }}`;
            if (data_id) {
                getStatesOrCity($('#country').val(), route1, data_id);
            }

            if (`{{ $address?->state_id }}`) {
                getCities(`{{ $address?->state_id }}`, route2, `{{ $address?->city_id }}`);
            }
            if (`{{ $address?->city_id }}`) {
                getOperationAreas(`{{ $address?->city_id }}`, route3,
                    `{{ $address?->operation_area_id }}`);
            }
        });
    </script>
    {{-- FilePond  --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image": "{{ $admin->modified_image }}",
            }
            file_upload(["#image"], "uploadImage", "admin", existingFiles, false);
        });
    </script>
    {{-- FilePond  --}}
@endpush
