<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Collection;

class ProductAttributeService
{
   use FileManagementTrait;

    public function getProductAttributes($orderby = 'sort_order', $order = 'asc')
    {
        return ProductAttribute::orderBy($orderby, $order)->latest();
    }

    public function getProductAttribute(string $encryptedId): ProductAttribute | Collection
    {
        return ProductAttribute::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedProductAttribute(string $encryptedId): ProductAttribute | Collection
    {
        return ProductAttribute::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createProductAttribute(array $data, $file = null): ProductAttribute
    {
        $data['creater_type'] = get_class(admin());
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(ProductAttribute::class, $file, admin(), 'Product Attribute/');
        }
       $product_attribute = ProductAttribute::create($data);
        return $product_attribute;
    }

    public function updateProductAttribute(string $encryptedId, array $data, $file = null): ProductAttribute
    {
       $product_attribute = $this->getProductAttribute($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($product_attribute, $file, admin(), 'Product Attribute/');
        }
       $product_attribute->update($data);
        return $product_attribute;
    }

    public function deleteProductAttribute(string $encryptedId): void
    {
       $product_attribute = $this->getProductAttribute($encryptedId);
       $product_attribute->update(['deleted_by' => admin()->id]);
       $product_attribute->delete();
    }

    public function restoreProductAttribute(string $encryptedId): void
    {
       $product_attribute = $this->getDeletedProductAttribute($encryptedId);
       $product_attribute->update(['updated_by' => admin()->id]);
       $product_attribute->restore();
    }

    public function permanentDeleteProductAttribute(string $encryptedId): void
    {
       $product_attribute = $this->getDeletedProductAttribute($encryptedId);
        if ($product_attribute->image) {
            $this->fileDelete($product_attribute->image);
        }
       $product_attribute->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
       $product_attribute = $this->getProductAttribute($encryptedId);
       $product_attribute->update([
            'updated_by' => admin()->id,
            'status' => !$product_attribute->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
       $product_attribute = $this->getProductAttribute($encryptedId);
       $product_attribute->update([
            'updated_by' => admin()->id,
            'is_featured' => !$product_attribute->is_featured
        ]);
    }
}

