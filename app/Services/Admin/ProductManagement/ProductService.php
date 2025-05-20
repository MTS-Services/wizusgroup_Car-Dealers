<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\Product;

class ProductService
{
    public function getProducts($orderby = 'sort_order', $order = 'asc')
    {
        return Product::orderBy($orderby, $order)->latest();
    }

    public function getProduct(string $encryptedId): Product
    {
        return Product::findOrFail(decrypt($encryptedId));
    }
    public function getDeletedProduct(string $encryptedId): Product
    {
        return Product::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }


    public function basicInfoCreate(array $data): Product
    {
        $data['created_by'] = admin()->id;
        $data['status'] = Product::STATUS_DEACTIVE;
        $data['entry_status'] = Product::ENTRY_STATUS_RELATION;
        $data['meta_keywords'] = json_encode($data['meta_keywords']);
        return Product::create($data);
    }
    public function update(string $encryptedId, array $data): Product
    {
        $product = $this->getProduct($encryptedId);
        $data['updated_by'] = admin()->id;
        $product->update($data);
        return $product;
    }
    public function delete(string $encryptedId): void
    {
        $product =  $this->getProduct($encryptedId);
        $product->update(['deleted_by' => admin()->id]);
        $product->delete();
    }

    public function restore(Product $product): void
    {
        $product->update(['deleted_by' => null]);
        $product->restore();
    }

    public function permanentDelete(Product $product): void
    {
        $product->forceDelete();
    }
}
