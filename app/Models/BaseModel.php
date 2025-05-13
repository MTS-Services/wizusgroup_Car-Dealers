<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory, SoftDeletes;


    public function creater_admin()
    {
        return $this->belongsTo(Admin::class, 'created_by')->select(['id', 'first_name', 'last_name']);
    }

    public function updater_admin()
    {
        return $this->belongsTo(Admin::class, 'updated_by')->select(['id', 'first_name', 'last_name']);
    }

    public function deleter_admin()
    {
        return $this->belongsTo(Admin::class, 'deleted_by')->select(['id', 'first_name', 'last_name']);
    }

    public function creater()
    {
        return $this->morphTo();
    }
    public function updater()
    {
        return $this->morphTo();
    }
    public function deleter()
    {
        return $this->morphTo();
    }
    protected $appends = [
        'creater_name',
        'updater_name',
        'deleter_name',

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
    ];
    // Accessor for creater
    public function getCreaterNameAttribute()
    {
        return $this->creater_admin?->full_name
            ?? $this->creater?->full_name
            ?? "System Generate";
    }

    // Accessor for updater
    public function getUpdaterNameAttribute()
    {
        return $this->updater_admin?->full_name
            ?? $this->updater?->full_name
            ?? "Null";
    }

    // Accessor for deleter
    public function getDeleterNameAttribute()
    {
        return $this->deleter_admin?->full_name
            ?? $this->deleter?->full_name
            ?? "Null";
    }

    // Accessor for created time
    public function getCreatedAtFormattedAttribute()
    {
        return timeFormat($this->created_at);
    }

    // Accessor for updated time
    public function getUpdatedAtFormattedAttribute()
    {
        return $this->created_at != $this->updated_at ? timeFormat($this->updated_at) : 'Null';
    }

    // Accessor for deleted time
    public function getDeletedAtFormattedAttribute()
    {
        return $this->deleted_at ? timeFormat($this->deleted_at) : 'Null';
    }

    // Accessor for created time human readable
    public function getCreatedAtHumanAttribute()
    {
        return timeFormatHuman($this->created_at);
    }

    // Accessor for updated time human readable
    public function getUpdatedAtHumanAttribute()
    {
        return $this->created_at != $this->updated_at ? timeFormatHuman($this->updated_at) : 'Null';
    }

    // Accessor for deleted time human readable
    public function getDeletedAtHumanAttribute()
    {
        return $this->deleted_at ? timeFormatHuman($this->deleted_at) : 'Null';
    }
}
