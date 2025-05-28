<?php

namespace App\Services;

use App\Http\Traits\FileManagementTrait;
use App\Models\PersonalInformation;
use Illuminate\Database\Eloquent\Collection;

class PersonalInformationService
{
    use FileManagementTrait;

    public function getUserPersonalInformations($orderby = 'sort_order', $order = 'asc')
    {
        return PersonalInformation::orderBy($orderby, $order)->latest();
    }
    public function getPersonalInformation(string $encryptedId): PersonalInformation | Collection
    {
        return PersonalInformation::findOrFail(decrypt($encryptedId));
    }

   public function updatePersonalInformation($personalInformation, $validated)
    {
        $personalInformation->update($validated);
    }
}
