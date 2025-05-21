<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\ProductInfoCategory;
use Illuminate\Database\Eloquent\Collection;

class ProductInfoCategoryService
{
    /**
     * Create a new class instance.
     */
    public function getProductInfoCats($orderby = 'sort_order', $order = 'asc')
    {
        return ProductInfoCategory::orderBy($orderby, $order)->latest();
    }

    public function getProductInfoCat(string $encryptedId): ProductInfoCategory | Collection
    {
        return ProductInfoCategory::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedProductInfoCat(string $encryptedId): ProductInfoCategory | Collection
    {
        return ProductInfoCategory::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createProductInfoCat(array $data): ProductInfoCategory

    {    $data['created_by'] = admin()->id;
        $product_info_category = ProductInfoCategory::create($data);
        return $product_info_category;
    }

    public function updateProductInfoCat(string $encryptedId, array $data): ProductInfoCategory
    {
        $product_info_category = $this->getProductInfoCat($encryptedId);
        $data['updated_by'] = admin()->id;
        $product_info_category->update($data);
        return $product_info_category;
    }

    public function deleteProductInfoCat(string $encryptedId): void
    {
        $product_info_category = $this->getProductInfoCat($encryptedId);
        $product_info_category->update(['deleted_by' => admin()->id]);
        $product_info_category->delete();
    }

    public function restoreProductInfoCat(string $encryptedId): void
    {
        $product_info_category = $this->getDeletedProductInfoCat($encryptedId);
        $product_info_category->update(['updated_by' => admin()->id]);
        $product_info_category->restore();
    }

    public function permanentDeleteCompany(string $encryptedId): void
    {
        $product_info_category = $this->getDeletedProductInfoCat($encryptedId);
        $product_info_category->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $product_info_category = $this->getProductInfoCat($encryptedId);
        $product_info_category->update([
            'updated_by' => admin()->id,
            'status' => !$product_info_category->status
        ]);
    }


}
