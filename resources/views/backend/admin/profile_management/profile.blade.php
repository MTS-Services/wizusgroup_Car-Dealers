@extends('backend.admin.layouts.master', ['page_slug' => 'admin_profile'])

@section('title', 'Admin Profile')

@push('css')
    <style>
        .card {
            border-radius: 10px;
        }

        .form-control {
            border-radius: 6px;
            box-shadow: none;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .btn {
            border-radius: 6px;
        }

        .text-danger {
            font-size: 0.875rem;
        }

        .btn_item {
            background: linear-gradient(to right, #8a41d8, #a201ffcb);
            color: white;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
        }

        .btn_item:hover {
            opacity: 0.8;
            cursor: pointer
        }

        .active.btn_item {
            background: linear-gradient(to right, #DC2626, #a201ffcb);
        }

        .card-header {
            background: linear-gradient(to right, #8a41d8, #a201ffcb);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2" data-bs-target="profile">profile</p>
                    <p class="btn_item w-100 py-2 active" data-bs-target="address">Address</p>
                    <p class="btn_item w-100 py-2" data-bs-target="change-password">Change Password</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <div id="profile" class="tab-pane">
                        {{-- Profile Edit Card --}}
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header">
                                    <h4 class="mb-0 py-2 text-white">Profile</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('seller.profile.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            {{-- Profile Details --}}
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
                    <div id="address" class="tab-pane active">
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
                                                    <select name="country_id" id="country" class="form-control">
                                                        <option value="{{ $address?->country_id }}" selected hidden>{{ __('Select Country') }}
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
                                                    <select name="state" id="state" class="form-control" disabled>
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
                                                    <select name="city" id="city" class="form-control" disabled>
                                                        <option value="" selected hidden>{{ __("Select City") }}
                                                        </option>
                                                    </select>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'city']" />
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label>{{ __('Operation Area') }} <span class="text-danger">*</span></label>
                                                    <select name="operation_area" id="operation_area" class="form-control"
                                                        disabled>
                                                        <option value="" selected hidden>{{ __('Select Area') }}
                                                        </option>
                                                    </select>
                                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'operation_area']" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Address Line 1') }} <span class="text-danger">*</span></label>
                                            <textarea name="address_line_1" class="form-control no-ckeditor5" id="address_line_1" cols="30" rows="10">{{ $address->address_line_1 ?? old('address_line_1') }}</textarea>
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address_line_1']" />
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>{{ __('Address Line 2') }}</label>
                                            <textarea name="address_line_2" class="form-control no-ckeditor5" id="address_line_2" cols="30"
                                                rows="10">{{ $address->address_line_2 ?? old('address_line_2') }}</textarea>
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address_line_2']" />
                                        </div>
                                        {{-- postal code --}}
                                        <div class="col-6 mb-3">
                                            <label>{{ __('Postal Code') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="postal_code" value="{{ $address->postal_code ?? old('postal_code') }}"
                                                placeholder="Enter postal code" class="form-control">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'postal_code']" />
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
                // Remove 'active' from all nav items
                $('.btn_item').removeClass('active');

                // Add 'active' to the clicked nav item
                $(this).addClass('active');

                // Get the target tab ID from data-bs-target attribute
                const target = $(this).data('bs-target');

                // Hide all tab panes
                $('.tab-pane').removeClass('active');

                // Show the target tab pane
                $('#' + target).addClass('active');
            });
        });
        // Get Country States By Axios
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
            if(data_id){
                 getStatesOrCity($('#country').val(), route1, data_id);
            }
           
            if (`{{ $address?->state_id }}`) {
                getCities(`{{ $address?->state_id }}`, route2, `{{ $address?->city_id }}`);
            }
            if(`{{ $address?->city_id }}`){
            getOperationAreas(`{{ $address?->city_id }}`, route3,
                `{{ $address?->operation_area_id }}`);
            }
        });
    </script>
    {{-- FilePond  --}}
@endpush
