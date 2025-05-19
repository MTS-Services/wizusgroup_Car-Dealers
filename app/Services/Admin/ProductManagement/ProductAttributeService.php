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
            $data['image'] = $this->handleFilepondFileUpload(ProductAttribute::class, $file, admin(), 'companies/');
        }
       $tax_class = ProductAttribute::create($data);
        return$tax_class;
    }

    public function updateProductAttribute(string $encryptedId, array $data, $file = null): ProductAttribute
    {
       $tax_class = $this->getProductAttribute($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($tax_class, $file, admin(), 'companies/');
        }
       $tax_class->update($data);
        return$tax_class;
    }

    public function deleteProductAttribute(string $encryptedId): void
    {
       $tax_class = $this->getProductAttribute($encryptedId);
       $tax_class->update(['deleted_by' => admin()->id]);
       $tax_class->delete();
    }

    public function restoreProductAttribute(string $encryptedId): void
    {
       $tax_class = $this->getDeletedProductAttribute($encryptedId);
       $tax_class->update(['updated_by' => admin()->id]);
       $tax_class->restore();
    }

    public function permanentDeleteProductAttribute(string $encryptedId): void
    {
       $tax_class = $this->getDeletedProductAttribute($encryptedId);
        if ($tax_class->image) {
            $this->fileDelete($tax_class->image);
        }
       $tax_class->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
       $tax_class = $this->getProductAttribute($encryptedId);
       $tax_class->update([
            'updated_by' => admin()->id,
            'status' => !$tax_class->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
       $tax_class = $this->getProductAttribute($encryptedId);
       $tax_class->update([
            'updated_by' => admin()->id,
            'is_featured' => !$tax_class->is_featured
        ]);
    }
}

