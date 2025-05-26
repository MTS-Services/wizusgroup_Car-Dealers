<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctionWatcher extends BaseModel
{
    use HasFactory;
    protected $fillable =
    [
        'sort_order',
        'user_id',
        'auction_id',

        'created_at',
        'updated_at',
        'deleted_at',

        'updated_by',
        'created_by',
        'deleted_by',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
