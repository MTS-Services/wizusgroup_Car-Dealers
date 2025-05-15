<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    use FileManagementTrait;

    public function getBrands($orderby = 'sort_order', $order = 'asc')
    {
        return Brand::orderBy($orderby, $order)->latest();
    }

    public function getBrand(string $encryptedId): Brand | Collection
    {
        return Brand::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedBrand(string $encryptedId): Brand | Collection
    {
        return Brand::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createBrand(array $data, $file = null): Brand
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(Brand::class, $file, admin(), 'brands/');
        }
        $brand = Brand::create($data);
        return $brand;
    }

    public function updateBrand(Brand $brand, array $data, $file = null): Brand
    {

        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($brand, $file, admin(), 'brands/');
        }
        $brand->update($data);
        return $brand;
    }

    public function deleteBrand(Brand $brand): void
    {
        $brand->update(['deleted_by' => admin()->id]);
        $brand->delete();
    }

    public function restoreBrand(string $encryptedId): void
    {
        $brand = $this->getDeletedBrand($encryptedId);
        $brand->update(['updated_by' => admin()->id]);
        $brand->restore();
    }

    public function permanentDeleteBrand(string $encryptedId): void
    {
        $brand = $this->getDeletedBrand($encryptedId);
        if ($brand->image) {
            $this->fileDelete($brand->image);
        }
        $brand->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $brand = $this->getBrand($encryptedId);
        $brand->update([
            'updated_by' => admin()->id,
            'status' => !$brand->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $brand = $this->getBrand($encryptedId);
        $brand->update([
            'updated_by' => admin()->id,
            'is_featured' => !$brand->is_featured
        ]);
    }
}
