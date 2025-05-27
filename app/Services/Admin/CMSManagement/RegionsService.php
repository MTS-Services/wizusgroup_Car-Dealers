<?php

namespace App\Services\Admin\CMSManagement;

use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

class RegionsService
{

    public function getRegions($orderby = 'sort_order', $order = 'asc')
    {
        return Region::orderBy($orderby, $order)->latest();
    }

    public function getRegion(string $encryptedId): Region | Collection
    {
        return Region::findOrFail(decrypt($encryptedId));
    }

    public function getDeleted(string $encryptedId): Region | Collection
    {
        return Region::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createRegion(array $data): Region
    {
        $data['created_by'] = admin()->id;
        $region = Region::create($data);
        return $region;
    }
    public function updateRegion(string $encryptedId, array $data): Region
    {
        $region = $this->getRegion($encryptedId);
        $data['updated_by'] = admin()->id;
        $region->update($data);
        return $region;
    }
    public function delete(string $encryptedId): void
    {
        $region = $this->getRegion($encryptedId);
        $region->update(['deleted_by' => admin()->id]);
        $region->delete();
    }

    public function restore(string $encryptedId): void
    {
        $user = $this->getDeleted($encryptedId);
        $user->update([
            'updated_by' => admin()->id,
        ]);
        $user->restore();
    }
    public function permanentDelete(string $encryptedId): void
    {
        $user = $this->getDeleted($encryptedId);
        $user->forceDelete();
    }

    public function toggleStatus(Region $region): void
    {
        $region->update([
            'updated_by' => admin()->id,
            'status' => !$region->status
        ]);
    }
    
}
