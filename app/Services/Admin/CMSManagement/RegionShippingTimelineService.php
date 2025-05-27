<?php

namespace App\Services\Admin\CMSManagement;

use App\Models\RegionShippingTimeline;
use Illuminate\Database\Eloquent\Collection;

class RegionShippingTimelineService
{
    
    public function getRegionShippingTimelines($orderby = 'sort_order', $order = 'asc')
    {
        return RegionShippingTimeline::orderBy($orderby, $order)->latest();
    }

     public function getRegionShippingTimeline(string $encryptedId): RegionShippingTimeline | Collection
    {
        return RegionShippingTimeline::findOrFail(decrypt($encryptedId));
    }

    public function getDeleted(string $encryptedId): RegionShippingTimeline | Collection
    {
        return RegionShippingTimeline::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createRegionShippingTimeline(array $data): RegionShippingTimeline
    {
        $data['created_by'] = admin()->id;
        $region = RegionShippingTimeline::create($data);
        return $region;
    }
    public function updateRegionShippingTimeline(string $encryptedId, array $data): RegionShippingTimeline
    {
        $region = $this->getRegionShippingTimeline($encryptedId);
        $data['updated_by'] = admin()->id;
        $region->update($data);
        return $region;
    }
    public function delete(string $encryptedId): void
    {
        $region = $this->getRegionShippingTimeline($encryptedId);
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
}
