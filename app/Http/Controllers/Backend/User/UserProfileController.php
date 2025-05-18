<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profile()
    {

        $data['user'] = User::with('personalInformation')->findOrFail(user()->id);
        // $data['address'] = Address::personal()->userAddresses()->first();
        $data['countries'] = Country::active()->select('id', 'name', 'slug')->orderBy('name')->get();
        return view('backend.user.dashboard', $data);
    }

   public function profileUpdate(UserProfileRequest $request)
    {
        $user = User::findOrFail(user()->id);
        $validated = $request->all();
        if(!$user){
            $user = User::create($validated);
        }else{
            $user->update($validated);
        }
        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    // public function addressUpdate(AddressRequest $request)
    // {
    //     $validated = $request->validated();
    //     $validated['country_id'] = $request->country_id;
    //     $validated['state_id'] = $request->state;
    //     $validated['city_id'] = $request->city_id;
    //     $validated['operation_area_id'] = $request->operation_area;
    //     $validated['operation_sub_area_id'] = $request->operation_sub_area;
    //     $validated['updater_id'] = user()->id;
    //     $validated['updater_type'] = get_class(user());
    //     $validated['profile_id'] = user()->id;
    //     $validated['profile_type'] = get_class(user());

    //     $validated['type'] = Address::TYPE_PERSONAL;
    //     $address = Address::personal()->userAddresses()->first();
    //     if (!$address) {
    //         Address::create($validated);
    //     } else {
    //         $address->update($validated);
    //     }

    //     session()->flash('success', 'Address updated successfully.');
    //     return redirect()->back();
    // }
    // public function passwordUpdate(userPasswordUpdateRequest $request)
    // {
    //     $user = user::findOrFail(user()->id);
    //     $validated = $request->validated();
    //     $user->update($validated);
    //     session()->flash('success', 'Password updated successfully.');
    //     return redirect()->back();
    // }
}
