<div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
    <div class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 items-center gap-5 py-5 text-center">
            <p class="btn-item btn-primary w-full py-2 rounded-md btn_active" data-target="profile">
                Profile</p>
            <p class="btn-item btn-primary w-full py-2 rounded-md " data-target="address">
                Address</p>
            <p class="btn-item btn-primary w-full py-2 rounded-md " data-target="change-password">Change Password</p>
        </div>
    </div>

    <div class="w-full">
        <div class="min-h-[200px] rounded-lg  mt-5 p-5">
            <div id="profile" class="tab-pane block">
                {{-- Update Profile --}}
                {{-- <h3 class="text-xl font-semibold mb-4 uppercase">Update Profile</h3> --}}
                <div>
                    <form action="{{ route('user.profile.update', encrypt($user->id)) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <input type="file" name="image" class=" w-full  filepond" id="image"
                                    accept="image/jpeg, image/png, image/jpg, image/webp, image/svg">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'image']" />
                            </div>
                            <div class="flex flex-col gap-4">
                                <div>
                                    <label class="block pb-2">{{ __('First Name') }} <span
                                            class="text-text-danger">*</span></label>
                                    <input type="text" name="first_name" value="{{ $user?->first_name }}"
                                        class="input " placeholder="Enter your first name">
                                    <x-frontend.input-error :datas="[
                                        'errors' => $errors,
                                        'field' => 'first_name',
                                    ]" />
                                </div>

                                <div>
                                    <label class="block pb-2">{{ __('Last Name') }} <span
                                            class="text-text-danger">*</span></label>
                                    <input type="text" name="last_name" value="{{ $user?->last_name }}"
                                        class="input " placeholder="Enter your last name">
                                    <x-frontend.input-error :datas="[
                                        'errors' => $errors,
                                        'field' => 'last_name',
                                    ]" />
                                </div>

                                <div>
                                    <label class="block pb-2">{{ __('Username') }} <span
                                            class="text-text-danger">*</span></label>
                                    <input type="text" name="username" value="{{ $user?->username }}" class="input"
                                        placeholder="Enter your username">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'username']" />
                                </div>
                            </div>
                            <div>
                                <label class="block pb-2">{{ __('Email') }} <span
                                        class="text-text-danger">*</span></label>
                                <input type="email" name="email" value="{{ $user?->email }}" class="input"
                                    placeholder="Enter your email">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                            </div>
                            <div>
                                <label class="block pb-2">{{ __('Phone') }}</label>
                                <input type="text" name="phone" value="{{ $user?->phone }}" class="input"
                                    placeholder="Enter your phone">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'phone']" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Date of Birth') }}</label>
                                <input type="date" name="dob" value="{{ $user?->personalInformation?->dob }}"
                                    class="input">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'dob']" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Gender') }}</label>
                                <select name="gender" class="input">
                                    @foreach (App\Models\PersonalInformation::getGenderLabels() as $key => $gender)
                                        <option value="{{ $key }}"
                                            {{ $user?->personalInformation?->gender == $key ? 'selected' : '' }}>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'gender']" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Fathers Name') }}</label>
                                <input type="text" name="father_name"
                                    value="{{ $user?->personalInformation?->father_name }}" class="input"
                                    placeholder="Enter your father's name">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'father_name']" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Mothers Name') }}</label>
                                <input type="text" name="mother_name"
                                    value="{{ $user?->personalInformation?->mother_name }}" class="input"
                                    placeholder="Enter your mother's name">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'mother_name']" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Emergency Phone') }}</label>
                                <input type="text" name="emergency_phone"
                                    value="{{ $user?->personalInformation?->emergency_phone }}" class="input"
                                    placeholder="Enter your emergency phone">
                                <x-frontend.input-error :datas="[
                                    'errors' => $errors,
                                    'field' => 'emergency_phone',
                                ]" />
                            </div>

                            <div>
                                <label class="block pb-2">{{ __('Nationality') }}</label>
                                <input type="text" name="nationality"
                                    value="{{ $user?->personalInformation?->nationality }}" class="input"
                                    placeholder="Enter nationality">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'nationality']" />
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block pb-2">{{ __('Bio') }}</label>
                                <textarea name="bio" class="input h-20 p-3" rows="5" placeholder="Enter your bio">{{ $user?->personalInformation?->bio }}</textarea>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'bio']" />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-5 hover:bg-bg-tertiary">Update</button>
                    </form>
                </div>
            </div>
            <div id="address" class="tab-pane hidden">
                <div class="rounded-md shadow-card">
                    <div class="px-4 py-3 border border-b border-border-gray">
                        <h4 class="text-text-primary text-lg font-semibold">
                            {{ __('Profile Address') }}</h4>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('user.address.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block pb-2">{{ __('Country') }}
                                            <span class="text-text-danger">*</span></label>
                                        <select name="country_id" id="country" class="input">
                                            <option value="{{ $address?->country_id }}" selected hidden>
                                                {{ __('Select Country') }}
                                            </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $address?->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-frontend.input-error :datas="[
                                            'errors' => $errors,
                                            'field' => 'country_id',
                                        ]" />
                                    </div>

                                    <div>
                                        <label class="block pb-2">{{ __('State') }}</label>
                                        <select name="state" id="state" class="input" disabled>
                                            <option value="" selected hidden>
                                                {{ __('Select State') }}</option>
                                        </select>
                                        <x-frontend.input-error :datas="[
                                            'errors' => $errors,
                                            'field' => 'state',
                                        ]" />
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block pb-2">{{ __('City') }}
                                            <span class="text-text-danger">*</span></label>
                                        <select name="city" id="city" class="input" disabled>
                                            <option value="" selected hidden>
                                                {{ __('Select City') }}</option>
                                        </select>
                                        <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'city']" />
                                    </div>
                                    <div>
                                        <label class="block pb-2">{{ __('Postal Code') }}
                                            <span class="text-text-danger">*</span></label>
                                        <input type="text" name="postal_code"
                                            value="{{ $address->postal_code ?? old('postal_code') }}" class="input"
                                            placeholder="Enter postal code">
                                        <x-frontend.input-error :datas="[
                                            'errors' => $errors,
                                            'field' => 'postal_code',
                                        ]" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block pb-2">{{ __('Address Line 1') }}
                                        <span class="text-text-danger">*</span></label>
                                    <textarea name="address_line_1" id="address_line_1" rows="4" class="input h-20 p-3 no-ckeditor5"
                                        placeholder="Enter address">{{ $address->address_line_1 ?? old('address_line_1') }}</textarea>
                                    <x-frontend.input-error :datas="[
                                        'errors' => $errors,
                                        'field' => 'address_line_1',
                                    ]" />
                                </div>

                                <div>
                                    <label class="block pb-2">{{ __('Address Line 2') }}</label>
                                    <textarea name="address_line_2" id="address_line_2" rows="4" class="input h-20 p-3 no-ckeditor5"
                                        placeholder="Enter additional address">{{ $address->address_line_2 ?? old('address_line_2') }}</textarea>
                                    <x-frontend.input-error :datas="[
                                        'errors' => $errors,
                                        'field' => 'address_line_2',
                                    ]" />
                                </div>
                            </div>

                            <div class="mt-6 text-left">
                                <button class="btn btn-primary hover:bg-bg-tertiary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div id="change-password" class="tab-pane hidden">
                <div class="max-w-lg mx-auto">
                    <form action="{{ route('user.password.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Current Password') }}</label>
                                <input class="input rounded-md w-full" type="password" name="old_password"
                                    id="old_password">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'old_password']" />
                            </div>
                            <div>
                                <label for="password"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('New Password') }}</label>
                                <input class="input rounded-md w-full" type="password" name="password"
                                    id="new_password">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
                            </div>
                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Confirm New Password') }}</label>
                                <input class="input rounded-md w-full" type="password" name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5 hover:bg-bg-tertiary">Change
                            Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            $('.btn-item').on('click', function() {
                $('.btn-item').removeClass('btn_active');
                $(this).addClass('btn_active');

                const target = $(this).data('target');
                $('.tab-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });




            // Get Country States By Axios
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            let data_id = `{{ $address?->state_id ? $address?->state_id : $address?->city_id }}`;
            if (data_id) {
                getStatesOrCity($('#country').val(), route1, data_id);
            }
            if (`{{ $address?->state_id }}`) {
                getCities(`{{ $address?->state_id }}`, route2, `{{ $address?->city_id }}`);
            }

            // FilePond Upload
            const existingFiles = {
                "#image": "{{ $user->modified_image }}"
            };
            file_upload(["#image"], ["image/jpeg", "image/png", "image/jpg", "image/webp", "image/svg"],
                existingFiles);
        })
    </script>
@endpush
