<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Model extends BaseModel
{
     protected $fillable = [
        'sort_order',
        'brand_id',
        'name',
        'slug',
        'image',
        'status',
        'is_featured',
        'meta_title',
        'meta_description',
        'description',


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

            'featured_labels',
            'featured_label',
            'featured_color',
            'featured_btn_label',
            'featured_btn_color',

            'modified_image',
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

    // ================= Status Functionality End Here =================

    public const NOT_FEATURED = 0;
    public const FEATURED = 1;

    // Feature labels
    public static function getFeaturedLabels(): array
    {
        return [
            self::NOT_FEATURED => 'No',
            self::FEATURED => 'Yes',
        ];
    }



    // Featured colors
    public static function getFeaturedColors(): array
    {
        return [
            self::NOT_FEATURED => 'bg-warning',
            self::FEATURED => 'bg-info',
        ];
    }

    // Featured btn labels
    public static function getFeaturedBtnLabels(): array
    {
        return [
            self::NOT_FEATURED => 'Make Featured',
            self::FEATURED => 'Remove From Featured',
        ];
    }

    // Featured btn colors
    public static function getFeaturedBtnColors(): array
    {
        return [
            self::NOT_FEATURED => 'btn btn-info',
            self::FEATURED => 'btn btn-warning',
        ];
    }

    // Accessor for featured labels
    public function getFeaturedLabelsAttribute(): array
    {
        return self::getFeaturedLabels();
    }

    // Accessor for featured label
    public function getFeaturedLabelAttribute(): string
    {
        return self::getFeaturedLabels()[$this->is_featured] ?? 'Unknown';
    }
    // Accessor for featured color
    public function getFeaturedColorAttribute(): string
    {
        return self::getFeaturedColors()[$this->is_featured] ?? 'bg-secondary';
    }

    // Accessor for featured label
    public function getFeaturedBtnLabelAttribute(): string
    {
        return self::getFeaturedBtnLabels()[$this->is_featured] ?? 'Unknown';
    }

    // Accessor for featured btn color
    public function getFeaturedBtnColorAttribute(): string
    {
        return self::getFeaturedBtnColors()[$this->is_featured] ?? 'btn btn-secondary';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', self::FEATURED);
    }
    public function scopeNotFeatured($query)
    {
        return $query->where('is_featured', self::NOT_FEATURED);
    }

    // Modify Image
    public function getModifiedImageAttribute()
    {
        return storage_url($this->image);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
