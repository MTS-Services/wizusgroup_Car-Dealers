<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'price',
        'quantity',
        'total', // Ensure this is calculated or handled in mutator/accessor if needed
        'sort_order', // Add if you intend to fill it

        'crater_id',
        'crater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        // Eager load primaryImage and model for convenience when fetching cart items
        return $this->belongsTo(Product::class)->with(['primaryImage', 'model']);
    }

    // Optional: Mutator to ensure 'total' is always calculated on save
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;
        // Ensure product relationship is loaded before calculating total
        if ($this->product) {
            $this->attributes['total'] = $this->price * $value;
        }
    }

    // Optional: Mutator to ensure 'price' is set from product if not explicitly provided
    public function setProductIdAttribute($value)
    {
        $this->attributes['product_id'] = $value;
        // Set the price from the product if it's being set for the first time
        if (!$this->exists && $product = Product::find($value)) {
            $this->attributes['price'] = $product->price;
        }
    }
}
