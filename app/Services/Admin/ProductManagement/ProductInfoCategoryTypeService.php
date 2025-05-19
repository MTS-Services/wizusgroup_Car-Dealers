<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\ProductInfoCategoryType;
use Illuminate\Database\Eloquent\Collection;

class ProductInfoCategoryTypeService
{
    /**
     * Create a new class instance.
     */
      public function getProInfoCatTypes($orderby = 'sort_order', $order = 'asc')
    {
        return ProductInfoCategoryType::orderBy($orderby, $order)->latest();
    }

    public function getProInfoCatType(string $encryptedId): ProductInfoCategoryType | Collection
    {
        return ProductInfoCategoryType::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedProInfoCatType(string $encryptedId): ProductInfoCategoryType | Collection
    {
        return ProductInfoCategoryType::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createProInfoCatType(array $data): ProductInfoCategoryType
    {
        $data['created_by'] = admin()->id;
        $product_info_category_type = ProductInfoCategoryType::create($data);
        return $product_info_category_type;
    }

    public function updateProInfoCatType(string $encryptedId, array $data): ProductInfoCategoryType
    {
        $product_info_category_type = $this->getProInfoCatType($encryptedId);
        $data['updated_by'] = admin()->id;
        $product_info_category_type->update($data);
        return $product_info_category_type;
    }

    public function deleteProInfoCatType(string $encryptedId): void
    {
        $product_info_category_type = $this->getProInfoCatType($encryptedId);
        $product_info_category_type->update(['deleted_by' => admin()->id]);
        $product_info_category_type->delete();
    }

    public function restoreProInfoCatType(string $encryptedId): void
    {
        $product_info_category_type = $this->getDeletedProInfoCatType($encryptedId);
        $product_info_category_type->update(['updated_by' => admin()->id]);
        $product_info_category_type->restore();
    }

    public function permanentDeleteProInfoCatType(string $encryptedId): void
    {
        $product_info_category_type = $this->getDeletedProInfoCatType($encryptedId);
        $product_info_category_type->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $product_info_category_type = $this->getProInfoCatType($encryptedId);
        $product_info_category_type->update([
            'updated_by' => admin()->id,
            'status' => !$product_info_category_type->status
        ]);
    }


}
