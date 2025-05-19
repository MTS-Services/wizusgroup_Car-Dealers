<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductInfoCategory extends BaseModel
{
    protected $fillable = [
        'sort_order',

        'name',
        'slug',
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
        ]);
    }

    public function catagoryTypes():HasMany
    {
        return $this->hasMany(ProductInfoCategoryType::class,'product_info_cat_id','id');
    }
    public function activeTypes():HasMany
    {
        return $this->types()->active();
    }

     public function features():HasMany
    {
        return $this->hasMany(ProductInfoCategoryTypeFeature::class,'product_info_cat_id','id');
    }
    public function activeFeatures():HasMany
    {
        return $this->types()->active();
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

    // Status btn labels
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Deactive',
            self::STATUS_DEACTIVE => 'Active',
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
        return $this->status == self::STATUS_ACTIVE ? 'bg-success' : 'bg-warning';
    }

    // Accessor for status label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for status btn color
    public function getStatusBtnColorAttribute(): string
    {
        return $this->status == self::STATUS_ACTIVE ? 'btn btn-warning': 'btn btn-success';
    }

      public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeDeactive($query)
    {
        return $query->where('status', self::STATUS_DEACTIVE);
    }
}
