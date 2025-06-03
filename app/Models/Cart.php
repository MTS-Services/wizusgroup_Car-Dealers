<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',

        'created_at',
        'updated_at',
        'deleted_at',
        
        'created_by',
        'updated_by',
        'deleted_by',
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
