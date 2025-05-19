<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInformation extends BaseModel
{

     protected $fillable = [
        'sort_order',
        'product_id',
        'product_info_cat_id',
        'product_info_cat_type_id',
        'product_info_cat_type_feature_id',
        'remarks',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function infoCategory(): BelongsTo
    {
        return $this->belongsTo(ProductInfoCategory::class, 'product_info_cat_id');
    }

    public function infoCategoryType(): BelongsTo
    {
        return $this->belongsTo(ProductInfoCategoryType::class, 'product_info_cat_type_id');
    }

    public function infoCategoryTypeFeature(): BelongsTo
    {
        return $this->belongsTo(ProductInfoCategoryTypeFeature::class, 'product_info_cat_type_feature_id');
    }
}
