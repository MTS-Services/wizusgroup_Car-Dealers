<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthBaseModel extends Authenticatable
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

    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;

    public const VERIFIED = 1;
    public const UNVERIFIED = 0;

    // Gender constants
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHERS = 3;

    protected $appends = [
        'status_label',
        'status_color',
        'status_btn_label',
        'status_btn_color',
        'status_labels',
        'modified_image',

        'full_name',

        'verify_label',
        'verify_color',

        'gender_label',
        'gender_color',
        'gender_labels',

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

    // Status labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'Deactive',
        ];
    }

    // Status colors
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'bg-success', // Green for active
            self::STATUS_DEACTIVE => 'bg-warning', // Red for deactive
        ];
    }

    // Status btn labels
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Deactive',
            self::STATUS_DEACTIVE => 'Active',
        ];
    }

    // Status btn colors
    public static function getStatusBtnColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'btn btn-warning', // Green for active
            self::STATUS_DEACTIVE => 'btn btn-success', // Red for deactive
        ];
    }

    // Accessor for status labels
    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }

    // Accessor for status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }
    // Accessor for status color
    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    // Accessor for status label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for status btn color
    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn btn-secondary';
    }



    //======================================================================

    // Varify labels
    public static function getVerifyLabels(): array
    {
        return [
            self::VERIFIED => 'Verified',
            self::UNVERIFIED => 'Unverified',
        ];
    }

    // Varify colors
    public static function getVerifyColors(): array
    {
        return [
            self::VERIFIED => 'bg-success', // Green for verified
            self::UNVERIFIED => 'bg-danger', // Red for unverified
        ];
    }
    // Accessor for Varify label
    public function getVerifyLabelAttribute(): string
    {
        return self::getVerifyLabels()[$this->is_verify] ?? 'Unknown';
    }
    // Accessor for Varify color
    public function getVerifyColorAttribute(): string
    {
        return self::getVerifyColors()[$this->is_verify] ?? 'bg-secondary';
    }
    // =======================================================================

    // Gender labels
    public static function getGenderLabels(): array
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHERS => 'Others',
        ];
    }

    // Gender colors
    public static function getGenderColors(): array
    {
        return [
            self::GENDER_MALE => 'badge bg-primary',   // Blue for male
            self::GENDER_FEMALE => 'badge bg-warning', // Yellow for female
            self::GENDER_OTHERS => 'badge bg-info',    // Light blue for others
        ];
    }

    // Accessor for gender labels

    public function getGenderLabelsAttribute(): array
    {
        return self::getGenderLabels();
    }


    // Accessor for gender label
    public function getGenderLabelAttribute(): string
    {
        return self::getGenderLabels()[$this->gender] ?? 'Unknown';
    }

    // Accessor for gender color
    public function getGenderColorAttribute(): string
    {
        return self::getGenderColors()[$this->gender] ?? 'bg-secondary';
    }

    // Active scope
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeDeactive($query)
    {
        return $query->where('status', self::STATUS_DEACTIVE);
    }

    // Verified scope
    public function scopeVerified($query)
    {
        return $query->where('verified', self::VERIFIED);
    }
    public function scopeUnverified($query)
    {
        return $query->where('verified', self::UNVERIFIED);
    }

    // Gender scope
    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

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

    // Accessor for modified image
    public function getModifiedImageAttribute()
    {
        return auth_storage_url($this->image, $this->gender);
    }

    // Get Full Name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
