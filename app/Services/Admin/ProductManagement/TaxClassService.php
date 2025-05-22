<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\TaxClass;
use Illuminate\Database\Eloquent\Collection;

class TaxClassService
{
   use FileManagementTrait;

    public function getTaxClasses($orderby = 'sort_order', $order = 'asc')
    {
        return TaxClass::orderBy($orderby, $order)->latest();
    }

    public function getTaxClass(string $encryptedId): TaxClass | Collection
    {
        return TaxClass::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedTaxClass(string $encryptedId): TaxClass | Collection
    {
        return TaxClass::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createTaxClass(array $data, $file = null): TaxClass
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(TaxClass::class, $file, admin(), 'companies/');
        }
       $tax_class = TaxClass::create($data);
        return$tax_class;
    }

    public function updateTaxClass(string $encryptedId, array $data, $file = null): TaxClass
    {
       $tax_class = $this->getTaxClass($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($tax_class, $file, admin(), 'companies/');
        }
       $tax_class->update($data);
        return$tax_class;
    }

    public function deleteTaxClass(string $encryptedId): void
    {
       $tax_class = $this->getTaxClass($encryptedId);
       $tax_class->update(['deleted_by' => admin()->id]);
       $tax_class->delete();
    }

    public function restoreTaxClass(string $encryptedId): void
    {
       $tax_class = $this->getDeletedTaxClass($encryptedId);
       $tax_class->update(['updated_by' => admin()->id]);
       $tax_class->restore();
    }

    public function permanentDeleteTaxClass(string $encryptedId): void
    {
       $tax_class = $this->getDeletedTaxClass($encryptedId);
        if ($tax_class->image) {
            $this->fileDelete($tax_class->image);
        }
       $tax_class->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
       $tax_class = $this->getTaxClass($encryptedId);
       $tax_class->update([
            'updated_by' => admin()->id,
            'status' => !$tax_class->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
       $tax_class = $this->getTaxClass($encryptedId);
       $tax_class->update([
            'updated_by' => admin()->id,
            'is_featured' => !$tax_class->is_featured
        ]);
    }
}
