<?php

namespace App\Services\Admin\ProductManagement;

use App\Models\ProductInfoCategoryTypeFeature;

class ProductInfoCategoryTypeFeatureService
{

        public function getProInfoCatTypeFeatures($orderby = 'sort_order', $order = 'asc')
    {
        return ProductInfoCategoryTypeFeature::orderBy($orderby, $order)->latest();
    }

    // public function getModel(string $encryptedId): Model | Collection
    // {
    //     return ProductInfoCategoryTypeFeature::findOrFail(decrypt($encryptedId));
    // }

    // public function getDeletedModel(string $encryptedId): Model | Collection
    // {
    //     return ProductInfoCategoryTypeFeature::onlyTrashed()->findOrFail(decrypt($encryptedId));
    // }

    public function createProInfoCatTypeFeature(array $data): ProductInfoCategoryTypeFeature
    {
        $data['created_by'] = admin()->id;
        $feature = ProductInfoCategoryTypeFeature::create($data);
        return $feature;
    }

    // public function updateModel(string $encryptedId, array $data, $file = null): ProductInfoCategoryTypeFeature
    // {
    //     $model = $this->getModel($encryptedId);
    //     $data['updated_by'] = admin()->id;
    //     if ($file) {
    //         $data['image'] = $this->handleFilepondFileUpload($model, $file, admin(), 'brands/');
    //     }
    //     $model->update($data);
    //     return $model;
    // }

    // public function deleteModel(string $encryptedId): void
    // {
    //     $model = $this->getModel($encryptedId);
    //     $model->update(['deleted_by' => admin()->id]);
    //     $model->delete();
    // }

    // public function restoreModel(string $encryptedId): void
    // {
    //     $model = $this->getDeletedModel($encryptedId);
    //     $model->update(['updated_by' => admin()->id]);
    //     $model->restore();
    // }

    // public function permanentDeleteModel(string $encryptedId): void
    // {
    //     $model = $this->getDeletedModel($encryptedId);
    //     if ($model->image) {
    //         $this->fileDelete($model->image);
    //     }
    //     $model->forceDelete();
    // }

    // public function toggleStatus(string $encryptedId): void
    // {
    //     $model = $this->getModel($encryptedId);
    //     $model->update([
    //         'updated_by' => admin()->id,
    //         'status' => !$model->status
    //     ]);
    // }

    // public function toggleFeature(string $encryptedId): void
    // {
    //     $model = $this->getModel($encryptedId);
    //     $model->update([
    //         'updated_by' => admin()->id,
    //         'is_featured' => !$model->is_featured
    //     ]);
    // }

}
