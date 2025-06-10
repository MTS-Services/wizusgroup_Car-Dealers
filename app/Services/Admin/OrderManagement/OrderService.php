<?php

namespace App\Services\Admin\OrderManagement;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{

    public function getOrders($orderBy = 'sort_order', $order = 'asc')
    {
        return Order::orderBy($orderBy, $order)->latest();
    }
    public function getOrder(string $param, $type = 'encryptedId'): Order|Collection
    {
        return match ($type) {
            'encryptedId' => Order::findOrFail(decrypt($param)),
            default => Order::where($type, $param)->first(),
        };
    }
    // public function getDeletedAdmin(string $encryptedId): Admin|Collection
    // {
    //     return Admin::onlyTrashed()->findOrFail(decrypt($encryptedId));
    // }

    // public function createAdmin(array $data, $file = null): Admin
    // {
    //     return DB::transaction(function () use ($data, $file) {
    //         if ($file) {
    //             $data['image'] = $this->handleFileUpload($file, 'admins', $data['first_name']);
    //         }
    //         $data['created_by'] = admin()->id;
    //         $admin = Admin::create($data);
    //         $admin->assignRole($admin->role->name);
    //         return $admin;
    //     });
    // }

    // public function updateAdmin(Admin $admin, array $data, $file = null): Admin
    // {
    //     return DB::transaction(function () use ($admin, $data, $file) {
    //         $data['password'] = $data['password'] ?? $admin->password;
    //         $data['updated_by'] = admin()->id;
    //         if ($file) {
    //             $data['image'] = $this->handleFileUpload($file, 'admins', $data['first_name']);
    //             $this->fileDelete($admin->image);
    //         }
    //         $admin->update($data);
    //         $admin->syncRoles($admin->role->name);
    //         return $admin;
    //     });
    // }

    // public function delete(Admin $admin): void
    // {
    //     $admin->update(['deleted_by' => admin()->id]);
    //     $admin->delete();
    // }

    // public function restore(string $encryptedId): void
    // {
    //     $admin = $this->getDeletedAdmin($encryptedId);
    //     $admin->update(['updated_by' => admin()->id]);
    //     $admin->restore();
    // }

    // public function permanentDelete(string $encryptedId): void
    // {
    //     $admin = $this->getDeletedAdmin($encryptedId);
    //     if ($admin->image) {
    //         $this->fileDelete($admin->image);
    //     }
    //     $admin->forceDelete();
    // }

    // public function toggleStatus(Admin $admin): void
    // {
    //     $admin->update([
    //         'status' => !$admin->status,
    //         'updated_by' => admin()->id
    //     ]);
    // }
}
