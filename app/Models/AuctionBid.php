<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionBid extends BaseModel
{
    use HasFactory;

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }
}
