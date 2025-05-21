<?php

namespace App\Services;

use App\Http\Traits\FileManagementTrait;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressService
{
    use FileManagementTrait;

    public function getUserAddresses($orderby = 'sort_order', $order = 'asc')
    {
        return Address::orderBy($orderby, $order)->personal()->userAddresses()->latest();
    }
    public function getAdminAddresses($orderby = 'sort_order', $order = 'asc')
    {
        return Address::orderBy($orderby, $order)->personal()->adminAddresses()->latest();
    }

    public function getAddress(string $encryptedId): Address | Collection
    {
        return Address::findOrFail(decrypt($encryptedId));
    }

    public function updateUserAddress( $data, $file = null): Address
    {
        $address = $this->getUserAddresses()->first();
        $data['country_id'] = $data['country_id'];
        $data['state_id'] = $data['state_id'];
        $data['city_id'] = $data['city_id'];
        $data['updater_id'] = user()->id;
        $data['updater_type'] = get_class(user());
        $data['profile_id'] = user()->id;
        $data['profile_type'] = get_class(user());

        $data['type'] = Address::TYPE_PERSONAL;
        if (!$address) {
            Address::create($data);
        } else {
            $address->update($data);
        }
        return $address;
    }
}
