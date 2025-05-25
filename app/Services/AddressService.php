<?php

namespace App\Services;

use App\Http\Traits\FileManagementTrait;
use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressService
{
    use FileManagementTrait;

    public function getAddresses($orderby = 'sort_order', $order = 'asc')
    {
        return Address::orderBy($orderby, $order)->personal()->latest();
    }

    public function getAddress(string $encryptedId): Address | Collection
    {
        return Address::findOrFail(decrypt($encryptedId));
    }

    public function updateAddress(Address $address, array $data, $file = null): Address
    {
        $data['state_id'] = $data['state'] ?? null;
        $data['city_id'] = $data['city'];
        $data['updater_id'] = user()->id;
        $data['updater_type'] = get_class(user());
        $data['profile_id'] = user()->id;
        $data['profile_type'] = get_class(user());
        $data['type'] = Address::TYPE_PERSONAL;

        if (!$address) {
            Address::create($data);
        }
        $address->update($data);
        return $address;
    }
}
