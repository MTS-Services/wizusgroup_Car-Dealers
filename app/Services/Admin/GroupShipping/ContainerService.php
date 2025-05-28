<?php

namespace App\Services\Admin\GroupShipping;

use App\Http\Traits\FileManagementTrait;
use App\Models\Container;
use Illuminate\Database\Eloquent\Collection;

class ContainerService
{
    use FileManagementTrait;
     public function getContainers($orderby = 'sort_order', $order = 'asc')
    {
        return Container::orderBy($orderby, $order)->latest();
    }

    public function getContainer(string $encryptedId): Container | Collection
    {
        return Container::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedContainer(string $encryptedId): Container | Collection
    {
        return Container::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createContainer(array $data, $file = null): Container
    {
        $data['created_by'] = admin()->id;
         if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'brands');
        }
        $container = Container::create($data);
        return $container;
    }

    public function updateContainer(string $encryptedId, array $data , $file = null): Container
    {
        $container = $this->getContainer($encryptedId);
        $data['updated_by'] = admin()->id;
         if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'brands');
            $this->fileDelete($container->image);
        }
        $container->update($data);
        return $container;
    }

    public function deleteContainer(string $encryptedId): void
    {
        $container = $this->getContainer($encryptedId);
        $container->update(['deleted_by' => admin()->id]);
        $container->delete();
    }

    public function restore(string $encryptedId): void
    {
        $container = $this->getDeletedContainer($encryptedId);
        $container->update(['updated_by' => admin()->id]);
        $container->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $container = $this->getDeletedContainer($encryptedId);
         if ($container->image) {
            $this->fileDelete($container->image);
        }
        $container->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $container = $this->getContainer($encryptedId);
        $container->update([
            'updated_by' => admin()->id,
            'status' => !$container->status
        ]);
    }
}
