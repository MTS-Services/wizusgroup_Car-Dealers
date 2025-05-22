<?php

namespace App\Services\Admin\AuctionManagement;

use App\Models\Auction;

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

    public function create(array $data)
    {
        $data['created_by'] = admin()->id;
        return Auction::create($data);
    }
}
