<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\ProductInfoCategoryTypeFeature;
use Illuminate\Database\Eloquent\Collection;

class ProductInfoCategoryTypeFeatureService
{

        public function getProInfoCatTypeFeatures($orderby = 'sort_order', $order = 'asc')
    {
        return ProductInfoCategoryTypeFeature::orderBy($orderby, $order)->latest();
    }

    public function getProInfoCatTypeFeature(string $encryptedId): ProductInfoCategoryTypeFeature | Collection
    {
        return ProductInfoCategoryTypeFeature::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedProInfoCatTypeFeature(string $encryptedId): ProductInfoCategoryTypeFeature | Collection
    {
        return ProductInfoCategoryTypeFeature::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createProInfoCatTypeFeature(array $data): ProductInfoCategoryTypeFeature
    {
        $data['created_by'] = admin()->id;
        $feature = ProductInfoCategoryTypeFeature::create($data);
        return $feature;
    }

    public function updateProInfoCatTypeFeature(string $encryptedId, array $data): ProductInfoCategoryTypeFeature
    {
        $model = $this->getProInfoCatTypeFeature($encryptedId);
        $data['updated_by'] = admin()->id;
        $model->update($data);
        return $model;
    }

    public function deleteProInfoCatTypeFeature(string $encryptedId): void
    {
        $model = $this->getProInfoCatTypeFeature($encryptedId);
        $model->update(['deleted_by' => admin()->id]);
        $model->delete();
    }

    public function restoreModel(string $encryptedId): void
    {
        $model = $this->getDeletedProInfoCatTypeFeature($encryptedId);
        $model->update(['updated_by' => admin()->id]);
        $model->restore();
    }

    public function permanentDeleteModel(string $encryptedId): void
    {
        $model = $this->getDeletedProInfoCatTypeFeature($encryptedId);
        $model->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $model = $this->getProInfoCatTypeFeature($encryptedId);
        $model->update([
            'updated_by' => admin()->id,
            'status' => !$model->status
        ]);
    }

    // public function toggleFeature(string $encryptedId): void
    // {
    //     $model = $this->getModel($encryptedId);
    //     $model->update([
    //         'updated_by' => admin()->id,
    //         'is_featured' => !$model->is_featured
    //     ]);
    // }

}
