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

    public function getDeletedshipping_location(string $encryptedId): ShippingLocation | Collection
    {
        return ShippingLocation::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createshipping_location(array $data, $file = null): ShippingLocation
    {
        $data['created_by'] = admin()->id;
        $shipping_location = ShippingLocation::create($data);
        return $shipping_location;
    }

    public function updateshipping_location(string $encryptedId, array $data, $file = null): ShippingLocation
    {
        $shipping_location = $this->getShippingLocation($encryptedId);
        $data['updated_by'] = admin()->id;
        $shipping_location->update($data);
        return $shipping_location;
    }

    public function deleteshipping_location(string $encryptedId): void
    {
        $shipping_location = $this->getShippingLocation($encryptedId);
        $shipping_location->update(['deleted_by' => admin()->id]);
        $shipping_location->delete();
    }

    public function restoreshipping_location(string $encryptedId): void
    {
        $shipping_location = $this->getDeletedshipping_location($encryptedId);
        $shipping_location->update(['updated_by' => admin()->id]);
        $shipping_location->restore();
    }

    public function permanentDeleteshipping_location(string $encryptedId): void
    {
        $shipping_location = $this->getDeletedshipping_location($encryptedId);
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
