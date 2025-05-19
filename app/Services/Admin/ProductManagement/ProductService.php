<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\Product;

class ProductService
{
    public function getProducts($orderby = 'sort_order', $order = 'asc')
    {
        return Product::orderBy($orderby, $order)->latest();
    }
}
