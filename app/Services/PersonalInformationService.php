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

   public function updatePersonalInformation(PersonalInformation $personalInformation, $validated)
    {
        $personalInformation->update($validated);
    }
}
