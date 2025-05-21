<?php

namespace App\Services;

use App\Http\Traits\FileManagementTrait;
use App\Models\PersonalInformation;

class PersonalInformationService
{
    use FileManagementTrait;

    public function getUserPersonalInformations($orderby = 'sort_order', $order = 'asc')
    {
        return PersonalInformation::orderBy($orderby, $order)->personal()->latest();
    }

    public function UpdateUserInformation($data, $file = null)
    {
        $personal_info = $this->getUserPersonalInformations()->first();
        $data['updater_id'] = user()->id;
        $data['updater_type'] = get_class(user());
        $data['profile_id'] = user()->id;
        $data['profile_type'] = get_class(user());

        if (!$personal_info) {
            $personal_info->create($data);
        } else {
            $personal_info->update($data);
        }
        return $personal_info;
    }
}
