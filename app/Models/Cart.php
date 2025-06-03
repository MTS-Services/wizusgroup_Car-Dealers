<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'user_id',
        'session_id',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    
}
