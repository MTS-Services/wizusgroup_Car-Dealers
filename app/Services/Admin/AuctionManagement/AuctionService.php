<?php

namespace App\Services\Admin\AuctionManagement;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Collection;

class AuctionService
{
    public function getAuctions($orderBy = 'sort_order', $order = 'asc')
    {
        return Auction::orderBy($orderBy, $order)->latest();
    }

    public function getAuction(string $encryptedId)
    {
        return Auction::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedAuction(string $encryptedId): Auction | Collection
    {
        return Auction::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function create(array $data)
    {
        $data['created_by'] = admin()->id;
        return Auction::create($data);
    }

    public function update(string $encryptedId, array $data): Auction
    {
        $auction = $this->getAuction($encryptedId);
        $data['updated_by'] = admin()->id;
        $auction->update($data);
        return $auction;
    }

    public function delete(string $encryptedId): void
    {
        $auction = $this->getAuction($encryptedId);
        $auction->update(['deleted_by' => admin()->id]);
        $auction->delete();
    }

    public function restore(string $encryptedId): void
    {
        $auction = $this->getDeletedAuction($encryptedId);
        $auction->update(['updated_by' => admin()->id]);
        $auction->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $auction = $this->getDeletedAuction($encryptedId);
        $auction->forceDelete();
    }

    public function toggleFeature(string $encryptedId): void
    {
        $auction = $this->getAuction($encryptedId);
        $auction->update([
            'updated_by' => admin()->id,
            'is_featured' => !$auction->is_featured
        ]);
    }
}
