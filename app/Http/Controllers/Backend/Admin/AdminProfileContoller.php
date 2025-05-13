<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\Admin\AdminPasswordUpdateRequest;
use App\Models\Address;
use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;

class AdminProfileContoller extends Controller
{
    public function profile()
    {
        $data['address'] = Address::personal()->adminAddresses()->first();
        $data['countries'] = Country::active()->select('id', 'name', 'slug')->orderBy('name')->get();
        return view('backend.admin.profile_management.profile', $data);
    }

    public function profileUpdate($request) {}
    public function addressUpdate(AddressRequest $request)
    {
        $validated = $request->validated();
        $validated['country_id'] = $request->country_id;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city_id;
        $validated['operation_area_id'] = $request->operation_area;
        $validated['operation_sub_area_id'] = $request->operation_sub_area;
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
