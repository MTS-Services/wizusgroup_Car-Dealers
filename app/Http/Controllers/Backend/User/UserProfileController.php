<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\User\UserPasswordUpdateRequest;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Traits\FileManagementTrait;
use App\Models\Address;
use App\Models\Country;
use App\Models\PersonalInformation;
use App\Models\User;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    use FileManagementTrait;
    public function profile()
    {
        $data['user'] = User::with('personalInformation')->findOrFail(user()->id);
        $data['address'] = Address::personal()->userAddresses()->first();
        $data['countries'] = Country::active()->select('id', 'name', 'slug')->orderBy('name')->get();
        return view('backend.user.dashboard', $data);
    }

    public function profileUpdate(UserProfileRequest $request)
    {
        $user_profile = User::findOrFail(user()->id);
        $user = $request->validated();
        $user['first_name'] = $request->first_name;
        $user['last_name'] = $request->last_name;
        $user['username'] = $request->username;
        $user['email'] = $request->email;
        $user['phone'] = $request->phone;
        $user['image'] = $request->image;
        $user['updater_id'] = user()->id;
        $user['updater_type'] = get_class(user());
        if (isset($request->image)) {
            $user['image'] = $this->handleFilepondFileUpload($user, $request->image, user(), 'users/');
        }

        $pesonal_info = PersonalInformation::userProfile()->first();
        $validated_info = $request->validated();
        $validated_info['dob'] = $request->dob;
        $validated_info['gender'] = $request->gender;
        $validated_info['father_name'] = $request->father_name;
        $validated_info['mother_name'] = $request->mother_name;
        $validated_info['emergency_phone'] = $request->emergency_phone;
        $validated_info['nationality'] = $request->nationality;
        $validated_info['bio'] = $request->bio;
        $validated_info['updater_id'] = user()->id;
        $validated_info['updater_type'] = get_class(user());
        $validated_info['profile_id'] = user()->id;
        $validated_info['profile_type'] = get_class(user());

        if (!$pesonal_info) {
            PersonalInformation::create($validated_info);
        }
        if (!$user) {
            $user_profile = User::create($user);
        }

        $user_profile->update($user);
        $pesonal_info->update($validated_info);

        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    public function addressUpdate(AddressRequest $request)
    {
        $validated = $request->validated();
        $validated['country_id'] = $request->country_id;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city_id;
        $validated['updater_id'] = user()->id;
        $validated['updater_type'] = get_class(user());
        $validated['profile_id'] = user()->id;
        $validated['profile_type'] = get_class(user());

        $validated['type'] = Address::TYPE_PERSONAL;
        $address = Address::personal()->userAddresses()->first();
        if (!$address) {
            Address::create($validated);
        } else {
            $address->update($validated);
        }

        session()->flash('success', 'Address updated successfully.');
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
