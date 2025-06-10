<?php

namespace App\Services\Admin\GroupShipping;

use App\Http\Traits\FileManagementTrait;
use App\Models\Container;
use App\Models\ContainerProduct;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ContainerService
{
    use FileManagementTrait;
    public function getContainers($orderby = 'sort_order', $order = 'asc')
    {
        return Container::orderBy($orderby, $order)->latest();
    }

    public function getContainer(string $encryptedId): Container|Collection
    {
        return Container::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedContainer(string $encryptedId): Container|Collection
    {
        return Container::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createContainer(array $data, $file = null): Container
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'containers');
        }
        $container = Container::create($data);
        return $container;
    }
    // public function createContainerProducts(array $data): ContainerProduct|Collection
    // {
    //     if (isset($data['key']) && $data['key'] == 0) {
    //         ContainerProduct::where('container_id', $data['container_id'])->delete();
    //     }
    //     $data['created_by'] = admin()->id;
    //     $container_product = ContainerProduct::updateOrCreate(['container_id' => $data['container_id'], 'product_id' => $data['product_id']], $data);
    //     return $container_product;

    // }

    public function updateContainer(string $encryptedId, array $data, $file = null, ): Container
    {
        $container = $this->getContainer($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $path = $this->handleFileUpload($file, 'containers');
            if ($container->image) {
                $this->fileDelete($container->image);
            }
            $data['image'] = $path;

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

    public function toggleStatus(string $encryptedId, string $status): void
    {
        $container = $this->getContainer($encryptedId);

        DB::transaction(function () use ($container, $status) {
            if (decrypt($status) == Container::STATUS_SHIPPED) {
                $container->load('orders');
                $container->orders()->update([
                    'status' => Order::STATUS_SHIPPED
                ]);
            }
            if (decrypt($status) == Container::STATUS_DELIVERED) {
                $container->load('orders');
                $container->orders()->update([
                    'status' => Order::STATUS_DELIVERED
                ]);
            }
            $container->update([
                'updated_by' => admin()->id,
                'status' => decrypt($status),
            ]);
        });


    }
}
