<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegionShippingTimeline extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'sort_order',
        'region_id',
        'min_days',
        'max_days',
        'ports',
        'description',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
    protected $appends = ['region_name'];

    public function getRegionNameAttribute()
    {
        return optional($this->region)->name;
    }
}
