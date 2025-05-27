<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContainerProduct extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'sort_order',
        'container_id',
        'product_id',
        'quantity',
        'price',
        'reserve_price',

        'created_by',
        'updated_by',
        'deleted_by',
    ];
    public function container()
    {
        return $this->belongsTo(Container::class, 'container_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
