<?php

namespace App\Services\Admin\AuctionManagement;

use App\Models\Auction;

class AuctionService
{
    public function getAuctions($orderBy = 'sort_order', $order = 'asc')
    {
        return Auction::orderBy($orderBy, $order)->latest();
    }

    public function getAuction($id)
    {
        return Auction::findOrFail($id);
    }
}
