<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempFile extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'path',
        'filename',
        'sort_order',

        'creater_id',
        'updater_id',
        'deleter_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'form_id',
        'from_type',
        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'creater_id' => 'integer',
        'updater_id' => 'integer',
        'deleter_id' => 'integer',
        'form_id' => 'integer',
    ];
    public function from()
    {
        return $this->morphTo();
    }
}
