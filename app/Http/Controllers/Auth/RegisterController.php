<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AuthBaseModel;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        return route('verification.notice');
    }

    public function showRegistrationForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.profile');
        }
        return view('frontend.auth.user.register');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'gender' => [
                'required',
                'integer',
                Rule::in([
                    AuthBaseModel::GENDER_MALE,
                    AuthBaseModel::GENDER_FEMALE,
                    AuthBaseModel::GENDER_OTHERS,
                ]),
            ],
            'language' => [
                'required',
                'integer',
                Rule::in([
                    PersonalInformation::LANGUAGE_ENGLISH,
                    PersonalInformation::LANGUAGE_FRENCH,
                    PersonalInformation::LANGUAGE_ARGENTINE,
                ]),
            ],
            'country_id' => ['required', 'integer', Rule::exists('countries', 'id')],
            'state_id' => ['nullable', 'integer', Rule::exists('states', 'id')],
            'city_id' => ['required', 'integer', Rule::exists('cities', 'id')],
            'postal_code' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'phone_2' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'occupation' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'business_type' => [
                'required',
                'integer',
                Rule::in([
                    User::BUSINESS_TYPE_INDIVIDUAL,
                    User::BUSINESS_TYPE_CORPORATE,
                ])
            ],
            'business_name' => [
                'required',
                'integer',
                Rule::in([
                    User::BUSINESS_NAME_AUCTION_BUSINESS,
                    User::BUSINESS_NAME_BROKERS,
                    User::BUSINESS_NAME_DEMOLITION_PARTS,
                    User::BUSINESS_NAME_OTHER,
                    User::BUSINESS_NAME_SHEET_METAL,
                    User::BUSINESS_NAME_SIDE_JOB,
                    User::BUSINESS_NAME_USED_CAR_DEALER,
                    User::BUSINESS_NAME_USED_CAR_EXPORT,
                    User::BUSINESS_NAME_USED_CAR_IMPORT,
                ]),
            ],
            'business_information' => ['required', 'sometimes', 'string'],
            'business_line' => [
                'required',
                'integer',
                Rule::in([
                    User::BUSINESS_LINE_AUTO_PART,
                    User::BUSINESS_LINE_CONSTRUCTION,
                    User::BUSINESS_LINE_DAMAGED_CAR,
                    User::BUSINESS_LINE_FARM_MACHINE,
                    User::BUSINESS_LINE_FORKLIFT,
                    User::BUSINESS_LINE_TRUCK_BUS,
                    User::BUSINESS_LINE_USED_CAR,
                ]),
            ],
            'receive_promotion_email' => [
                'required',
                'boolean',
                Rule::in([
                    User::RECEIVE_PROMOTION_EMAIL,
                    User::NOT_RECEIVE_PROMOTION_EMAIL
                ]),
            ],
            'how_know' => [
                'required',
                'integer',
                Rule::in([
                    User::KNOW_AGENT,
                    User::KNOW_FACEBOOK,
                    User::KNOW_FRIEND,
                    User::KNOW_INSTAGRAM,
                    User::KNOW_LINKEDIN,
                    User::KNOW_OTHER,
                    User::KNOW_SEARCH,
                    User::KNOW_STAFF,
                    User::KNOW_TWITTER,
                    User::KNOW_YOUTUBE,
                ]),
            ],
            'how_know_detail' => ['required', 'sometimes', 'string'],
            'id_registration_info' => ['nullable', 'mimes:pdf', 'max:5120'],
            'dealer_registration_permit' => ['nullable', 'mimes:pdf', 'max:5120'],
            'accept_terms' => ['required', 'boolean', Rule::in([User::ACCEPT_TERMS])],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return dd($data);
        // return User::create([
        //     'first_name' => $data['first_name'],
        //     'last_name' => $data['last_name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
