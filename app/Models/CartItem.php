<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'price',
        'quantity',
        'total', // Ensure this is calculated or handled in mutator/accessor if needed
        'sort_order', // Add if you intend to fill it

        'crater_id',
        'crater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            $item->total = $item->price * $item->quantity;
        });

        static::updating(function ($item) {
            $item->total = $item->price * $item->quantity;
        });
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
