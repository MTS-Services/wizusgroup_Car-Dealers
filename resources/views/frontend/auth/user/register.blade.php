@extends('frontend.layouts.app')
@section('content')
    <section class="py-20">
        <div class="container">
            <div
                class="shadow-shadowPrimary shadow-shadow-dark/10 dark:shadow-shadow-light/10 rounded-2xl w-full overflow-hidden bg-bg-white dark:bg-bg-dark-tertiary p-5">
                <h2 class="text-3xl font-semibold text-center mb-6">{{ __('Start Your Journey with Us') }}</h2>
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-5">
                        {{-- Name Field --}}
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="w-full">
                                <label class="w-full">
                                    <span class="label">{{ __('First Name') }} <span class="text-red-500">*</span></span>
                                    <input type="text" placeholder="First Name" name="first_name"
                                        value="{{ old('first_name') }}" class="input" />
                                </label>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'first_name']" />
                            </div>
                            <div class="w-full">
                                <label class="w-full">
                                    <span class="label">{{ __('Last Name') }} <span class="text-red-500">*</span></span>
                                    <input type="text" placeholder="Last Name" value="{{ old('last_name') }}"
                                        name="last_name" class="input" />
                                </label>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'last_name']" />
                            </div>
                        </div>

                        {{-- Email And Language --}}
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="w-full">
                                <span class="label">{{ __('Email') }}<span class="text-red-500">*</span></span>
                                <label class="input">
                                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                            stroke="currentColor">
                                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </g>
                                    </svg>
                                    <input type="email" placeholder="example@gmail.com" value="{{ old('email') }}"
                                        name="email" />
                                </label>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
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

                        {{-- Street Address and Postal Code --}}
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="w-full">
                                <span class="label">{{ __('Street Address') }}<span class="text-red-500">*</span></span>
                                <input type="text" name="address_line_1" placeholder="Street Address"
                                    value="{{ old('address_line_1') }}" class="input">
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
                        @if (isset($not_use))
                            {{-- <div class="flex flex-col md:flex-row gap-3">
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

                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="w-full">
                                    <span class="label">{{ __('Company Name') }}</span>
                                    <input type="text" placeholder="Company name" value="{{ old('company_name') }}"
                                        name="company_name" class="input" />
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company_name']" />
                                </div>
                                <div class="w-full">
                                    <span class="label">{{ __('Occupation') }} <span
                                            class="text-red-500">*</span></span>
                                    <input type="text" placeholder="Company name" value="{{ old('occupation') }}"
                                        name="occupation" class="input" />

                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'occupation']" />
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row gap-3">
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


                            <div class="flex flex-col md:flex-row gap-3">
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


                            <div class="flex flex-col md:flex-row gap-3">
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

                             --}}
                        @endif
                        <div class="flex flex-col items-center md:flex-row gap-3">
                            <div class="w-full text-end">
                                <label class="flex items-center gap-2 justify-end">
                                    <span class="label block" for="accept_terms">{{ __('Accept Terms') }}<span
                                            class="text-red-500">*</span></span>
                                    <input type="radio" class="radio radio-xs radio-info" name="accept_terms"
                                        value="{{ App\Models\User::ACCEPT_TERMS }}" id="accept_terms"
                                        @checked(old('accept_terms') == App\Models\User::ACCEPT_TERMS) />
                                </label>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'accept_terms']" />
                            </div>
                            <div class="w-full">
                                <button type="submit" class="btn-primary">{{ __('Register') }}</button>
                            </div>
                        </div>
                    </div>
                </form>

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
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('frontend/js/password.js') }}"></script>
    {{-- FilePond  --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#id_registration_info"], ["application/pdf"]);
            file_upload(["#dealer_registration_permit"], ["application/pdf"]);
        });
    </script>
    {{-- FilePond  --}}


    <script>
        $(document).ready(function() {
            //  Business Information
            const $businessName = $('select[name="business_name"]');
            const $businessInfo = $('input[name="business_information"]');

            function toggleBusinessInfo() {
                if ($businessName.val() === "{{ \App\Models\User::BUSINESS_NAME_OTHER }}") {
                    $businessInfo.prop('disabled', false);
                } else {
                    $businessInfo.prop('disabled', true).val('');
                }
            }
            toggleBusinessInfo();
            $businessName.on('change', toggleBusinessInfo);

            // How Hear About Us
            const $howKnow = $('select[name="how_know"]');
            const $howKnowDetail = $('input[name="how_know_detail"]');

            function toggleHowKnowDetail() {
                if ($howKnow.val() === "{{ \App\Models\User::KNOW_OTHER }}" || $howKnow.val() ===
                    "{{ \App\Models\User::KNOW_FRIEND }}") {
                    $howKnowDetail.prop('disabled', false);
                } else {
                    $howKnowDetail.prop('disabled', true).val('');
                }
            }
            toggleHowKnowDetail();
            $howKnow.on('change', toggleHowKnowDetail);
        });
    </script>

    <script>
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            getStatesOrCity($('#country').val(), route1, '{{ old('state_id') }}');
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            if (`{{ old('state_id') }}`) {
                getCities(`{{ old('state_id') }}`, route2, `{{ old('city_id') }}`);
            }
        })
    </script>
@endpush
