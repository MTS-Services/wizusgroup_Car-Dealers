<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionBid extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount',
        'whatsapp_number',
        'is_winning',
        'is_buy_now',
        'ip_address',

        'creater_id',
        'updater_id',
        'deleter_id',
        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
