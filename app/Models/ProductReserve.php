<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReserve extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'reserve_price',
        'status',
        'reserve_at',
        'expire_at',
        'note',

        'sort_order',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
