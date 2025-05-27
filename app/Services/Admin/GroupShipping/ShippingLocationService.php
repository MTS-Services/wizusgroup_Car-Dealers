<?php

namespace App\Services\Admin\GroupShipping;

use App\Models\ShippingLocation;
use Illuminate\Database\Eloquent\Collection;

class ShippingLocationService
{
     public function getShippingLocations($orderby = 'sort_order', $order = 'asc')
    {
        return ShippingLocation::orderBy($orderby, $order)->latest();
    }

    public function getShippingLocation(string $encryptedId): ShippingLocation | Collection
    {
        return ShippingLocation::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedShippingLocation(string $encryptedId): ShippingLocation | Collection
    {
        return ShippingLocation::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createShippingLocation(array $data): ShippingLocation
    {
        $data['created_by'] = admin()->id;
        $shipping_location = ShippingLocation::create($data);
        return $shipping_location;
    }

    public function updateShippingLocation(string $encryptedId, array $data): ShippingLocation
    {
        $shipping_location = $this->getShippingLocation($encryptedId);
        $data['updated_by'] = admin()->id;
        $shipping_location->update($data);
        return $shipping_location;
    }

    public function deleteShippingLocation(string $encryptedId): void
    {
        $shipping_location = $this->getShippingLocation($encryptedId);
        $shipping_location->update(['deleted_by' => admin()->id]);
        $shipping_location->delete();
    }

    public function restore(string $encryptedId): void
    {
        $shipping_location = $this->getDeletedShippingLocation($encryptedId);
        $shipping_location->update(['updated_by' => admin()->id]);
        $shipping_location->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $shipping_location = $this->getDeletedShippingLocation($encryptedId);
        $shipping_location->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $shipping_location = $this->getShippingLocation($encryptedId);
        $shipping_location->update([
            'updated_by' => admin()->id,
            'status' => !$shipping_location->status
        ]);
    }

}
