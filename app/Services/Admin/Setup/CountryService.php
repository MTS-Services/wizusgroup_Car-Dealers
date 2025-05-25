<?php

namespace App\Services\Admin\Setup;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Database\Eloquent\Collection;

class CountryService
{
    use FileManagementTrait;

    public function getCountrys($orderby = 'sort_order', $order = 'asc')
    {
        return Country::orderBy($orderby, $order)->latest();
    }

    public function getCountry(string $encryptedId): Country | Collection
    {
        return Country::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedCountry(string $encryptedId): Country | Collection
    {
        return Country::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createCountry(array $data, $file = null): Country
    {
        $data['created_by'] = admin()->id;
        $country = Country::create($data);
        return $country;
    }

    public function updateCountry(string $encryptedId, array $data, $file = null): Country
    {
        $country = $this->getCountry($encryptedId);
        $data['updated_by'] = admin()->id;
        $country->update($data);
        return $country;
    }

    public function deleteCountry(string $encryptedId): void
    {
        $country = $this->getCountry($encryptedId);
        $country->update(['deleted_by' => admin()->id]);
        $country->delete();
    }

    public function restoreCountry(string $encryptedId): void
    {
        $country = $this->getDeletedCountry($encryptedId);
        $country->update(['updated_by' => admin()->id]);
        $country->restore();
    }

    public function permanentDeleteCountry(string $encryptedId): void
    {
        $country = $this->getDeletedCountry($encryptedId);
        $country->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $country = $this->getCountry($encryptedId);
        $country->update([
            'updated_by' => admin()->id,
            'status' => !$country->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $country = $this->getCountry($encryptedId);
        $country->update([
            'updated_by' => admin()->id,
            'is_featured' => !$country->is_featured
        ]);
    }
}
