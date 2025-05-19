<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends BaseModel
{
     protected $fillable = [
        'sort_order',
        'product_id',
        'image',
        'status',
        'is_primary',
        'alt',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }




    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [

            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',
            'status_labels',

            'primary_label',
            'primary_color',
            'primary_btn_label',
            'primary_btn_color',
            'primary_labels',
        ]);
    }
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
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeDeactive($query)
    {
        return $query->where('status', self::STATUS_DEACTIVE);
    }


    public const IS_PRIMARY = 1;
    public const NOT_PRIMARY = 0;
    // Primary labels
    public static function getPrimaryLabels(): array
    {
        return [
            self::IS_PRIMARY => 'Primary',
            self::NOT_PRIMARY => 'Not Primary',
        ];
    }



    // Primary colors
    public static function getPrimaryColors(): array
    {
        return [
            self::IS_PRIMARY => 'bg-success', // Green for active
            self::NOT_PRIMARY => 'bg-info', // Red for deactive
        ];
    }

    // Primary btn labels
    public static function getPrimaryBtnLabels(): array
    {
        return [
            self::IS_PRIMARY => 'Deactive',
            self::NOT_PRIMARY => 'Active',
        ];
    }

    // Primary btn colors
    public static function getPrimaryBtnColors(): array
    {
        return [
            self::IS_PRIMARY => 'btn btn-info', // Green for active
            self::NOT_PRIMARY => 'btn btn-success', // Red for deactive
        ];
    }

    // Accessor for Primary labels
    public function getPrimaryLabelsAttribute(): array
    {
        return self::getPrimaryLabels();
    }

    // Accessor for Primary label
    public function getPrimaryLabelAttribute(): string
    {
        return self::getPrimaryLabels()[$this->is_primary] ?? 'Unknown';
    }
    // Accessor for Primary color
    public function getPrimaryColorAttribute(): string
    {
        return self::getPrimaryColors()[$this->is_primary] ?? 'bg-secondary';
    }

    // Accessor for Primary label
    public function getPrimaryBtnLabelAttribute(): string
    {
        return self::getPrimaryBtnLabels()[$this->is_primary] ?? 'Unknown';
    }

    // Accessor for Primary btn color
    public function getPrimaryBtnColorAttribute(): string
    {
        return self::getPrimaryBtnColors()[$this->is_primary] ?? 'btn btn-secondary';
    }
    public function scopePrimary($query)
    {
        return $query->where('is_primary', self::IS_PRIMARY);
    }
    public function scopeNotPrimary($query)
    {
        return $query->where('is_primary', self::NOT_PRIMARY);
    }
}
