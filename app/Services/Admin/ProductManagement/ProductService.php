<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\Product;

class ProductService
{
    public function getProducts($orderby = 'sort_order', $order = 'asc')
    {
        return Product::orderBy($orderby, $order)->latest();
    }

    public function getProduct(string $encryptedId)
    {
        return Product::findOrFail(decrypt($encryptedId));
    }
    public function getDeletedProduct(string $encryptedId)
    {
        return Product::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function store() {}
    public function update() {}
    public function delete(string $encryptedId)
    {
        $product =  $this->getProduct($encryptedId);
        $product->update(['deleted_by' => admin()->id]);
        $product->delete();
    }

    public function restore(Product $product)
    {
        $product->update(['deleted_by' => null]);
        $product->restore();
    }

    public function permanentDelete(Product $product)
    {
        $product->forceDelete();
    }
}
