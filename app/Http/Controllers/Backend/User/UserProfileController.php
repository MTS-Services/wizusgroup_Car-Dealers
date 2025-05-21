<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\User\UserPasswordUpdateRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Services\AddressService;
use App\Services\Admin\Setup\CountryService;
use App\Services\Admin\UserManagement\UserService;
use App\Services\PersonalInformationService;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $addressService;
    protected $personalInformationService;
    protected $countryService;
    protected $userService;

    public function __construct(AddressService $addressService, PersonalInformationService $personalInformationService, CountryService $countryService, UserService $userService)
    {
        $this->addressService = $addressService;
        $this->personalInformationService = $personalInformationService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }
    public function profile()
    {
        $data['user'] = $this->userService->getUsers()->with('personalInformation')->first();
        $data['address'] = $this->addressService->getUserAddresses()->first();
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        return view('backend.user.dashboard', $data);
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $user = $this->userService->getUsers(user()->id);
        $validated = $request->validated();
        $file = $request->file('image');
        $this->userService->updateUserProfile($user, $validated, $file);
        // $user = $request->validated();
        // $user['first_name'] = $request->first_name;
        // $user['last_name'] = $request->last_name;
        // $user['username'] = $request->username;
        // $user['email'] = $request->email;
        // $user['phone'] = $request->phone;
        // $user['image'] = $request->image;
        // $user['updater_id'] = user()->id;
        // $user['updater_type'] = get_class(user());
        // if (isset($request->image)) {
        //     $user['image'] = $this->handleFilepondFileUpload($user, $request->image, user(), 'users/');
        // }

        $pesonal_info = PersonalInformation::userProfile()->first();
        $validated_info = $request->validated();
        $this->personalInformationService->UpdateUserInformation($pesonal_info, $validated_info);
        // $validated_info['dob'] = $request->dob;
        // $validated_info['gender'] = $request->gender;
        // $validated_info['father_name'] = $request->father_name;
        // $validated_info['mother_name'] = $request->mother_name;
        // $validated_info['emergency_phone'] = $request->emergency_phone;
        // $validated_info['nationality'] = $request->nationality;
        // $validated_info['bio'] = $request->bio;
        // $validated_info['updater_id'] = user()->id;
        // $validated_info['updater_type'] = get_class(user());
        // $validated_info['profile_id'] = user()->id;
        // $validated_info['profile_type'] = get_class(user());

        // if (!$pesonal_info) {
        //     PersonalInformation::create($validated_info);
        // }
        // if (!$user) {
        //     $user_profile = User::create($user);
        // }

        // // $user_profile->update($user);
        // $pesonal_info->update($validated_info);

        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    public function addressUpdate(AddressRequest $request)
    {
        try {
            $address = $this->addressService->getUserAddresses()->first();
            $validated = $request->validated();
            $this->addressService->updateUserAddress($address, $validated);
            session()->flash('success', 'Address updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Address update failed!');
            throw $th;
        }

        return redirect()->back();
    }
    public function passwordUpdate(UserPasswordUpdateRequest $request)
    {
        $user = User::findOrFail(user()->id);
        $validated = $request->validated();
        $user->update($validated);
        session()->flash('success', 'Password updated successfully.');
        return redirect()->back();
    }
}
