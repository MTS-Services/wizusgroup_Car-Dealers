<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documentation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'title',
        'key',
        'type',
        'documentation',

        'created_by',
        'updated_by',
        'deleted_by',
    ];


}
