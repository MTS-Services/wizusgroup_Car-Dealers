<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends AuthBaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'first_name',
        'last_name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'image',
        'status',

        'created_by',
        'update_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'integer',
            'username' => 'string',
        ];
    }
}
