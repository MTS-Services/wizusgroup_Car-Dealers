<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'description',

        
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
