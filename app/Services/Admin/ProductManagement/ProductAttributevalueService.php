<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\Collection;

class ProductAttributeValueService
{
   use FileManagementTrait;

    public function getProductAttributeValues($orderby = 'sort_order', $order = 'asc')
    {
        return ProductAttributeValue::orderBy($orderby, $order)->latest();
    }

    public function getProductAttributeValue(string $encryptedId): ProductAttributeValue | Collection
    {
        return ProductAttributeValue::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedProductAttributeValue(string $encryptedId): ProductAttributeValue | Collection
    {
        return ProductAttributeValue::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createProductAttributeValue(array $data, $file = null): ProductAttributeValue
    {
        $data['creater_type'] = get_class(admin());
        $data['created_by'] = admin()->id;
       $product_attr_value = ProductAttributeValue::create($data);
        return $product_attr_value;
    }

    public function updateProductAttributeValue(string $encryptedId, array $data, $file = null): ProductAttributeValue
    {
       $product_attr_value = $this->getProductAttributeValue($encryptedId);
        $data['updated_by'] = admin()->id;
       $product_attr_value->update($data);
        return $product_attr_value;
    }

    public function deleteProductAttributeValue(string $encryptedId): void
    {
       $product_attr_value = $this->getProductAttributeValue($encryptedId);
       $product_attr_value->update(['deleted_by' => admin()->id]);
       $product_attr_value->delete();
    }

    public function restoreProductAttributeValue(string $encryptedId): void
    {
       $product_attr_value = $this->getDeletedProductAttributeValue($encryptedId);
       $product_attr_value->update(['updated_by' => admin()->id]);
       $product_attr_value->restore();
    }

    public function permanentDeleteProductAttributeValue(string $encryptedId): void
    {
       $product_attr_value = $this->getDeletedProductAttributeValue($encryptedId);
        if ($product_attr_value->image) {
            $this->fileDelete($product_attr_value->image);
        }
       $product_attr_value->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
       $product_attr_value = $this->getProductAttributeValue($encryptedId);
       $product_attr_value->update([
            'updated_by' => admin()->id,
            'status' => !$product_attr_value->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
       $product_attr_value = $this->getProductAttributeValue($encryptedId);
       $product_attr_value->update([
            'updated_by' => admin()->id,
            'is_featured' => !$product_attr_value->is_featured
        ]);
    }
}
