<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRelation extends BaseModel
{
     protected $fillable = [
        'sort_order',
        'product_id',
        'company_id',
        'brand_id',
        'model_id',
        'tax_class_id',
        'tax_rate_id',
        'category_id',
        'sub_category_id',
        'sub_child_category_id',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function model()
    {
        return $this->belongsTo(Brand::class, 'model_id');
    }

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class,'tax_class_id');
    }

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class,'tax_rate_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }
    public function subChildCategory()
    {
        return $this->belongsTo(Category::class,'sub_child_category_id');
    }
}
