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

                            <div class="w-full">  
                                <span class="label block">{{ __('Language') }}<span class="text-red-500">*</span></span>
                                <div class="input justify-between flex-wrap py-2 px-5 h-fit">
                                    @foreach (App\Models\PersonalInformation::getLanguages() as $key => $language)
                                        <label for="language-{{ $key }}" class="flex items-center gap-2">
                                            <input type="radio" name="language" value="{{ $key }}"
                                                class="radio radio-xs radio-info" @checked(old('language', App\Models\PersonalInformation::LANGUAGE_ENGLISH) == $key)
                                                id="language-{{ $key }}" />  
                                            <span>{{ $language }}</span>
                                        </label>
                                    @endforeach 
                                </div>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'language']" />
                            </div>

                            {{-- Password Field --}}

                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="w-full">
                                <span class="label">{{ __('Password') }}<span class="text-red-500">*</span></span>
                                <label class="input relative">
                                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                            stroke="currentColor">
                                            <path
                                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                                            </path>
                                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor">
                                            </circle>
                                        </g> 
                                    </svg>   
                                    <input type="password" placeholder="Password" name="password" />
                                    <button type="button"
                                        class="showpassword absolute top-1/2 right-1 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full text-text-primary dark:text-text-light hover:text-text-secondary transition-all duration-300 ease-linear">
                                        <i class="fa-regular fa-eye-slash w-4 h-4"></i>
                                    </button>
                                </label>    
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
                            </div>
                            <div class="w-full">
                                <span class="label">{{ __('Confirm Password') }}<span class="text-red-500">*</span></span>
                                <label class="input relative">
                                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                            stroke="currentColor">
                                            <path
                                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                                            </path>
                                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor">
                                            </circle>
                                        </g>
                                    </svg>
                                    <input type="password" placeholder="Confirm Password" name="password_confirmation" />
                                    <button type="button"
                                        class="showpassword absolute top-1/2 right-1 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full text-text-primary dark:text-text-light hover:text-text-secondary transition-all duration-300 ease-linear">
                                        <i class="fa-regular fa-eye-slash w-4 h-4"></i>
                                    </button>
                                </label>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password_confirmation']" />
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
                                <label class="block pb-2">{{ __('Nationality') }}</label>
                                <input type="text" name="nationality"
                                    value="{{ $user?->personalInformation?->nationality }}" class="input"
                                    placeholder="Enter nationality">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'nationality']" />
                            </div>

                            {{-- Gender and Country --}}
                                <div class="flex flex-col md:flex-row gap-3">
                                    <div class="w-full">
                                        <span class="label block">{{ __('Gender') }}<span class="text-red-500">*</span></span>
                                        <div class="input justify-between flex-wrap py-2 px-5 h-fit">
                                            @foreach (App\Models\User::getGenderLabels() as $key => $gender)
                                                <label for="gender-{{ $key }}" class="flex items-center gap-2">
                                                    <input type="radio" name="gender" value="{{ $key }}"
                                                        class="radio radio-xs radio-info" @checked(old('gender', App\Models\AuthBaseModel::GENDER_OTHERS) == $key)
                                                        id="gender-{{ $key }}" />
                                                    <span>{{ $gender }}</span>
                                                </label>   
                                            @endforeach
                                        </div>
                                        <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'gender']" />
                                    </div> 
                                    <div class="w-full">   
                                        <span class="label">{{ __('Country') }}<span class="text-red-500">*</span></span>

                                        <select name="country_id" class="select" id="country">
                                            <option value="" disabled selected>{{ __('Select country') }}</option>
                                            @foreach (App\Models\Country::active()->get() as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'country_id']" />
                                    </div>
                                </div>      

                                 {{-- State and City --}}
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('State') }}<span class="text-red-500">*</span></span>
                                    <select name="state_id" class="select" disabled id="state">
                                        <option value="" disabled selected>{{ __('Select state') }}</option>
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'state_id']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('City') }}<span class="text-red-500">*</span></span>
                                    <select name="city_id" class="select" disabled id="city">
                                        <option value="" disabled selected>{{ __('Select state') }}</option>
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'city_id']" />
                                </div>
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

                            {{-- Street Address and Postal Code --}}
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('Street Address') }}<span class="text-red-500">*</span></span>
                                    <input type="text" name="address_line_1" placeholder="Street Address" value="{{ old('address_line_1') }}"
                                        class="input">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'address_line_1']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Postal or ZIP Code') }}<span
                                            class="text-red-500">*</span></span>
                                    <input type="text" class="input" placeholder="000-000"
                                        value="{{ old('postal_code') }}" name="postal_code" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'postal_code']" />
                                </div> 
                            </div>

                            {{-- Phone Number --}} 
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('Tel (first contact)') }}<span
                                            class="text-red-500">*</span></span>
                                    <input type="text" class="input" value="{{ old('phone') }}"
                                        placeholder="000-0000-0000" name="phone" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'phone']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Tel (second contact)') }}</span>
                                    <input type="text" class="input" value="{{ old('phone_2') }}"
                                        placeholder="000-0000-0000" name="phone_2" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'phone_2']" />
                                </div>
                            </div>

                            {{-- Company name and Occupation --}}
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('Company Name') }}</span>
                                    <input type="text" placeholder="Company name" value="{{ old('company_name') }}"
                                        name="company_name" class="input" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company_name']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Occupation') }} <span class="text-red-500">*</span></span>
                                    <input type="text" placeholder="Company name" value="{{ old('occupation') }}"
                                        name="occupation" class="input" />

                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'occupation']" />
                                </div> 
                            </div>   
                            
                            {{-- Date of birth and Business Type --}}
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('Date of Birth') }}<span class="text-red-500">*</span></span>
                                    <input type="date" placeholder="dd-mm-yyyy" value="{{ old('dob') }}"
                                        name="dob" class="input py-0 px-4" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'dob']" />
                                </div>
                                <div class="w-full">
                                    <span class="label block">{{ __('Business Type') }}<span
                                            class="text-red-500">*</span></span>
                                    <div class="input justify-between flex-wrap py-2 px-5 h-fit">
                                        @foreach (App\Models\User::getBusinessTypes() as $key => $type)
                                            <label for="type-{{ $key }}" class="flex items-center gap-2">
                                                <input type="radio" name="business_type" value="{{ $key }}"
                                                    class="radio radio-xs radio-info" @checked(old('business_type') == $key)
                                                    id="type-{{ $key }}" />
                                                <span>{{ $type }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'business_type']" />
                                </div>
                            </div>
                            
                             {{-- Business Name and Information --}}
                            <div class="flex flex-col  ">
                                <div class="w-full">
                                    <span class="label">{{ __('Business Name') }} <span class="text-red-500">*</span></span>
                                    <select name="business_name" class="select">
                                        <option value="" disabled selected>{{ __('Select Business Name') }}</option>
                                        @foreach (App\Models\User::getBusinessNames() as $key => $type)
                                            <option value="{{ $key }}"
                                                {{ old('business_name') == $key ? 'selected' : '' }}>
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'business_name']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">
                                        {{ __('Additional Information') }}
                                        <span class="text-sm text-gray-500">
                                            ({{ __('Only required if "Other" is selected') }})
                                        </span>
                                    </span>
                                    <input type="text" placeholder="Business Information"
                                        value="{{ old('business_information') }}" name="business_information" class="input"
                                        disabled />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'business_information']" />
                                </div>
                            </div>

                            {{-- Business Line and Receive Promotion Emails --}}
                            <div class="flex flex-col   gap-3 ">
                                <div class="w-full">
                                    <span class="label">{{ __('Business Line') }} <span class="text-red-500">*</span></span>
                                    <select name="business_line" class="select">
                                        <option value="" disabled selected>{{ __('Select Business Line') }}</option>
                                        @foreach (App\Models\User::getBusinessLines() as $key => $line)
                                            <option value="{{ $key }}"
                                                {{ old('business_line') == $key ? 'selected' : '' }}>
                                                {{ $line }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'business_line']" />
                                </div>
                                <div class="w-full">
                                    <span class="label block">{{ __('Receive Promotion Emails?') }}<span
                                            class="text-red-500">*</span></span>
                                    <div class="input justify-between flex-wrap py-2 px-5 h-fit">
                                        @foreach (App\Models\User::getReceivePromotionEmails() as $key => $promotional_email)
                                            <label for="promotional_email-{{ $key }}"
                                                class="flex items-center gap-2">
                                                <input type="radio" name="receive_promotion_email"
                                                    value="{{ $key }}" class="radio radio-xs radio-info"
                                                    @checked(old('receive_promotion_email') == $key) id="promotional_email-{{ $key }}" />
                                                <span>{{ $promotional_email }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'receive_promotion_email']" />
                                </div>
                            </div>

                            {{-- How did you hear about us and For Friend and Other --}}
                            <div class="flex flex-col  ">
                                <div class="w-full">
                                    <span class="label">{{ __('How did you hear about us') }} <span
                                            class="text-red-500">*</span></span>
                                    <select name="how_know" class="select">
                                        <option value="" disabled selected>{{ __('How did you hear about us') }}
                                        </option>
                                        @foreach (App\Models\User::getKnows() as $key => $know)
                                            <option value="{{ $key }}"
                                                {{ old('how_know') == $key ? 'selected' : '' }}>
                                                {{ $know }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'how_know']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Please Provide Details for Friend or Other') }} <span
                                            class="text-red-500">*</span></span>
                                    <input type="text" placeholder="Please Enter the Details"
                                        value="{{ old('how_know_detail') }}" name="how_know_detail" class="input"
                                        disabled />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'how_know_detail']" />
                                </div>
                            </div>

                            {{-- ID Registration and Dealer Registration Permit --}}
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('ID Registration') }}</span>
                                    <input type="file" name="id_registration_info" class="form-control filepond"
                                        id="id_registration_info" accept="application/pdf">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'id_registration_info']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Dealer Registration Permit') }}</span>
                                    <input type="file" name="dealer_registration_permit" class="form-control filepond"
                                        id="dealer_registration_permit" accept="application/pdf">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'dealer_registration_permit']" />
                                </div>
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

            <div>
                    <div class="divider">{{ __('Or sign up with') }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="#" class="btn-primary rounded-md w-full gap-3">
                            <i class='bx bxl-google text-2xl'></i> {{ __('Google') }}
                        </a>
                        <a href="#" class="btn-secondary rounded-md w-full gap-3">
                            <i class='bx bxl-facebook text-2xl'></i> {{ __('Facebook') }}
                        </a>
                    </div>
                    <p class="text-center text-sm mt-4">
                        {{ __('Already have an account?') }} <a href="{{ route('login') }}"
                            class="text-text-tertiary font-medium">
                            {{ __('Sign in') }} </a>
                    </p>
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
