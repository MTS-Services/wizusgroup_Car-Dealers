<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Country;
use App\Models\TaxRate;
use Illuminate\Database\Eloquent\Collection;

class TaxRateService
{
    use FileManagementTrait;

    public function getTaxRated($orderby = 'sort_order', $order = 'asc')
    {
        return TaxRate::orderBy($orderby, $order)->latest();
    }

    public function getTaxRate(string $encryptedId): TaxRate | Collection
    {
        return TaxRate::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedTaxRate(string $encryptedId): TaxRate | Collection
    {
        return TaxRate::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }


    public function createTaxRate(array $data, $file = null): TaxRate
    {
        $data['created_by'] = admin()->id;
        $data['tax_class_id'] = $data['tax_class'];
        $data['country_id'] = $data['country'];
        $data['state_id'] = $data['state'] ?? null;
        $data['city_id'] = $data['city'];
        $tax_rate = TaxRate::create($data);
        return $tax_rate;
    }

    public function updateTaxRate(string $encryptedId, array $data, $file = null): TaxRate
    {
        $tax_rate = $this->getTaxRate($encryptedId);
        $data['tax_class_id'] = $data['tax_class'];
        $data['country_id'] = $data['country'];
        $data['state_id'] = $data['state'] ?? null;
        $data['city_id'] = $data['city'];
        $data['updated_by'] = admin()->id;
        $tax_rate->update($data);
        return $tax_rate;
    }

    public function deleteTaxRate(string $encryptedId): void
    {
        $tax_rate = $this->getTaxRate($encryptedId);
        $tax_rate->update(['deleted_by' => admin()->id]);
        $tax_rate->delete();
    }

    public function restoreTaxRate(string $encryptedId): void
    {
        $tax_rate = $this->getDeletedTaxRate($encryptedId);
        $tax_rate->update(['updated_by' => admin()->id]);
        $tax_rate->restore();
    }

    public function permanentDeleteTaxRate(string $encryptedId): void
    {
        $tax_rate = $this->getDeletedTaxRate($encryptedId);
        if ($tax_rate->image) {
            $this->fileDelete($tax_rate->image);
        }
        $tax_rate->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $tax_rate = $this->getTaxRate($encryptedId);
        $tax_rate->update([
            'updated_by' => admin()->id,
            'status' => !$tax_rate->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $tax_rate = $this->getTaxRate($encryptedId);
        $tax_rate->update([
            'updated_by' => admin()->id,
            'is_featured' => !$tax_rate->is_featured
        ]);
    }
}
