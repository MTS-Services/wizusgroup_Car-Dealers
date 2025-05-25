<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\Admin\AdminPasswordUpdateRequest;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Http\Traits\FileManagementTrait;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Country;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;

class AdminProfileContoller extends Controller
{
    use FileManagementTrait;
    public function profile()
    {
        $data['admin'] = Admin::with('personalInformation')->findOrFail(admin()->id);
        $data['address'] = Address::personal()->adminAddresses()->first();
        $data['countries'] = Country::active()->select('id', 'name', 'slug')->orderBy('name')->get();
        return view('backend.admin.profile_management.profile', $data);
    }

    public function profileUpdate(AdminProfileRequest $request)
    {
        $admin = Admin::findOrFail(admin()->id);
        $validated = $request->validated();
        $validated['first_name'] = $request->first_name;
        $validated['last_name'] = $request->last_name;
        $validated['username'] = $request->username;
        $validated['email'] = $request->email;
        $validated['phone'] = $request->phone;
        $validated['updater_id'] = admin()->id;
        $validated['updater_type'] = get_class(admin());
        if($request->hasFile('image')) {
            $validated['image'] = $this->handleFileUpload($request->file('image'),  'admins', $validated['first_name']);
                $this->fileDelete($admin->image);
        }

        $admin_info = PersonalInformation::findOrFail(admin()->id);
        $validated_info = $request->validated();
        $validated_info['dob'] = $request->dob;
        $validated_info['gender'] = $request->gender;
        $validated_info['father_name'] = $request->father_name;
        $validated_info['mother_name'] = $request->mother_name;
        $validated_info['emergency_phone'] = $request->emergency_phone;
        $validated_info['nationality'] = $request->nationality;
        $validated_info['bio'] = $request->bio;
        $validated_info['updater_id'] = admin()->id;
        $validated_info['updater_type'] = get_class(admin());
        $validated_info['profile_id'] = admin()->id;
        $validated_info['profile_type'] = get_class(admin());

        if(!$admin_info) {
            PersonalInformation::create($validated_info);
        }
        if(!$admin){
            Admin::create($validated);
        }
        $admin->update($validated);
        $admin_info->update($validated_info);
        session()->flash('success', 'Profile updated successfully.');
        return redirect()->back();
    }
    public function addressUpdate(AddressRequest $request)
    {
        $validated = $request->validated();
        $validated['country_id'] = $request->country_id;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city;
        $validated['updater_id'] = admin()->id;
        $validated['updater_type'] = get_class(admin());
        $validated['profile_id'] = admin()->id;
        $validated['profile_type'] = get_class(admin());

        $validated['type'] = Address::TYPE_PERSONAL;
        $address = Address::personal()->adminAddresses()->first();
        if(!$address) {
            Address::create($validated);
        }
        else {
            $address->update($validated);
        }

        session()->flash('success', 'Address updated successfully.');
        return redirect()->back();
    }
    public function passwordUpdate(AdminPasswordUpdateRequest $request)
    {
        $admin = Admin::findOrFail(admin()->id);
        $validated = $request->validated();
        $admin->update($validated);
        session()->flash('success', 'Password updated successfully.');
        return redirect()->back();
    }
}
