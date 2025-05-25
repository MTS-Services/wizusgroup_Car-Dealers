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
        $data['address'] = $this->addressService->getAddresses()->userAddresses()->first();
        $data['countries'] = $this->countryService->getCountrys()->active()->get();
        return view('backend.user.dashboard', $data);
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $validated = $request->validated();
        $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
        $this->userService->updateUserProfile(user(), $validated , $file);

        $this->personalInformationService->updatePersonalInformation(user()->personalInformation, $validated);

        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    public function addressUpdate(AddressRequest $request)
    {
        // dd($request->all());
        try {
            $address = $this->addressService->getAddresses()->userAddresses()->first();
            $validated = $request->validated();
            $this->addressService->updateAddress($address, $validated);
            session()->flash('success', 'Address updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Address update failed!');
            throw $th;
        }
        return redirect()->back();
    }
    public function passwordUpdate(UserPasswordUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->userService->updateUserPassword(user(), $validated);
            session()->flash('success', 'Password updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Password update failed!');
            throw $th;
        }
        return redirect()->back();
    }
}
