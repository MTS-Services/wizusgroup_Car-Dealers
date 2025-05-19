<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\ProductInfoCategoryType;

class ProductInfoCategoryTypeService
{
    /**
     * Create a new class instance.
     */
      public function getProInfoCatTypes($orderby = 'sort_order', $order = 'asc')
    {
        return ProductInfoCategoryType::orderBy($orderby, $order)->latest();
    }

    // public function getBrand(string $encryptedId): ProductInfoCategoryType | Collection
    // {
    //     return ProductInfoCategoryType::findOrFail(decrypt($encryptedId));
    // }

    // public function getDeletedBrand(string $encryptedId): ProductInfoCategoryType | Collection
    // {
    //     return ProductInfoCategoryType::onlyTrashed()->findOrFail(decrypt($encryptedId));
    // }

    public function createProInfoCatType(array $data): ProductInfoCategoryType
    {
        $data['created_by'] = admin()->id;
        $brand = ProductInfoCategoryType::create($data);
        return $brand;
    }

    // public function updateBrand(string $encryptedId, array $data, $file = null): ProductInfoCategoryType
    // {
    //     $brand = $this->getBrand($encryptedId);
    //     $data['updated_by'] = admin()->id;
    //     if ($file) {
    //         $data['image'] = $this->handleFilepondFileUpload($brand, $file, admin(), 'brands/');
    //     }
    //     $brand->update($data);
    //     return $brand;
    // }

    // public function deleteBrand(string $encryptedId): void
    // {
    //     $brand = $this->getBrand($encryptedId);
    //     $brand->update(['deleted_by' => admin()->id]);
    //     $brand->delete();
    // }

    // public function restoreBrand(string $encryptedId): void
    // {
    //     $brand = $this->getDeletedBrand($encryptedId);
    //     $brand->update(['updated_by' => admin()->id]);
    //     $brand->restore();
    // }

    // public function permanentDeleteBrand(string $encryptedId): void
    // {
    //     $brand = $this->getDeletedBrand($encryptedId);
    //     if ($brand->image) {
    //         $this->fileDelete($brand->image);
    //     }
    //     $brand->forceDelete();
    // }

    // public function toggleStatus(string $encryptedId): void
    // {
    //     $brand = $this->getBrand($encryptedId);
    //     $brand->update([
    //         'updated_by' => admin()->id,
    //         'status' => !$brand->status
    //     ]);
    // }

    // public function toggleFeature(string $encryptedId): void
    // {
    //     $brand = $this->getBrand($encryptedId);
    //     $brand->update([
    //         'updated_by' => admin()->id,
    //         'is_featured' => !$brand->is_featured
    //     ]);
    // }
}
