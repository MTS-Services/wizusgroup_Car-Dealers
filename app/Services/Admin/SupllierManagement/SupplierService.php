<?php

namespace App\Services\Admin\SupllierManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    /**
     * Create a new class instance.
     */
   use FileManagementTrait;

    public function getSuppliers($orderby = 'sort_order', $order = 'asc')
    {
        return Supplier::orderBy($orderby, $order)->latest();
    }


     public function getSupplier(string $encryptedId): Supplier | Collection
    {
        return Supplier::findOrFail(decrypt($encryptedId));
    }
    public function getDeletedSupplier(string $encryptedId): Supplier | Collection
    {
        return Supplier::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createSupplier(array $data, $file = null): Supplier
    {
        return DB::transaction(function () use ($data, $file) {
            $data['created_by'] = admin()->id;
            if ($file) {
                $data['image'] = $this->handleFilepondFileUpload(Supplier::class, $file, admin(), 'suppliers/');
            }
            $supplier = Supplier::create($data);
            return $supplier;
        });
    }

    public function updateSupplier(Supplier $supplier, array $data, $file = null): Supplier
    {
        return DB::transaction(function () use ($supplier, $data, $file) {
            $data['password'] = $data['password'] ?? $supplier->password;
            $data['updated_by'] = admin()->id;
            if ($file) {
                $data['image'] = $this->handleFilepondFileUpload($supplier, $file, admin(), 'suppliers/');
            }
            $supplier->update($data);
            return $supplier;
        });
    }

    public function delete(Supplier $supplier): void
    {
        $supplier->update(['deleted_by' => admin()->id]);
        $supplier->delete();
    }

    public function restore(string $encryptedId): void
    {
        $supplier = $this->getDeletedSupplier($encryptedId);
        $supplier->update(['updated_by' => admin()->id]);
        $supplier->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $supplier = $this->getDeletedSupplier($encryptedId);
        if ($supplier->image) {
            $this->fileDelete($supplier->image);
        }
        $supplier->forceDelete();
    }

    public function toggleStatus(Supplier $supplier): void
    {
        $supplier->update( [
            'status' => !$supplier->status,
            'updated_by' => admin()->id
        ]);
    }
}
