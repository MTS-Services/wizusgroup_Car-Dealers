<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Model;
use Illuminate\Database\Eloquent\Collection;

class ModelService
{
    use FileManagementTrait;

    public function getModels($orderby = 'sort_order', $order = 'asc')
    {
        return Model::orderBy($orderby, $order)->latest();
    }

    public function getModel(string $encryptedId): Model | Collection
    {
        return Model::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedModel(string $encryptedId): Model | Collection
    {
        return Model::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createModel(array $data, $file = null): Model
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFileUpload($file,'models');
        }
        $model = Model::create($data);
        return $model;
    }

    public function updateModel(string $encryptedId, array $data, $file = null): Model
    {
        $model = $this->getModel($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'models');
            $this->fileDelete($model->image);
        }
        $model->update($data);
        return $model;
    }

    public function deleteModel(string $encryptedId): void
    {
        $model = $this->getModel($encryptedId);
        $model->update(['deleted_by' => admin()->id]);
        $model->delete();
    }

    public function restoreModel(string $encryptedId): void
    {
        $model = $this->getDeletedModel($encryptedId);
        $model->update(['updated_by' => admin()->id]);
        $model->restore();
    }

    public function permanentDeleteModel(string $encryptedId): void
    {
        $model = $this->getDeletedModel($encryptedId);
        if ($model->image) {
            $this->fileDelete($model->image);
        }
        $model->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $model = $this->getModel($encryptedId);
        $model->update([
            'updated_by' => admin()->id,
            'status' => !$model->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $model = $this->getModel($encryptedId);
        $model->update([
            'updated_by' => admin()->id,
            'is_featured' => !$model->is_featured
        ]);
    }
}
