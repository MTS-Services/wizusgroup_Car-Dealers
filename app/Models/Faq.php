<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'question',
        'answer',
        'type',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [

            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',
            'status_labels',

            'type_label',
        ]);
    }

    // ================= Status Functionality Start Here =================
    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;
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

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeDeactive($query)
    {
        return $query->where('status', self::STATUS_DEACTIVE);
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

    // ================= Status Functionality End Here =================

    // ================= Type Functionality End Here =================

    public const TYPE_GENERAL = 1;
    public const TYPE_PRIVACY = 2;
    public const TYPE_TERMS = 3;
    public const TYPE_CONTACT = 4;
    public const TYPE_ABOUT = 5;
    public const TYPE_PRODUCT = 6;

    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_GENERAL => 'General',
            self::TYPE_PRIVACY => 'Privacy',
            self::TYPE_TERMS => 'Terms',
            self::TYPE_CONTACT => 'Contact',
            self::TYPE_ABOUT => 'About',
            self::TYPE_PRODUCT => 'Product',
        ];
    }

    public function getTypeLabelsAttribute(): array
    {
        return self::getTypeLabels();
    }

    public function getTypeLabelAttribute(): string
    {
        return self::getTypeLabels()[$this->type] ?? 'Unknown';
    }

}
