<?php

namespace App\Services\Admin;

use App\Http\Traits\FileManagementTrait;
use App\Models\Documentation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DocumentationService
{
    /**
     * Create a new class instance.
     */
 use FileManagementTrait;
     public function getDocumentations($orderBy = 'sort_order', $order = 'asc')
    {
        return Documentation::orderBy($orderBy, $order)->latest();
    }
    public function getDocumentation(string $encryptedId): Documentation | Collection
    {
        return Documentation::findOrFail(decrypt($encryptedId));
    }
    public function getDeletedDocumentation(string $encryptedId): Documentation | Collection
    {
        return Documentation::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createDocumentation(array $data): Documentation
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = admin()->id;
            $doc = Documentation::create($data);
            return $doc;
        });
    }



    public function updateDocumentation(Documentation $doc, array $data, $file = null): Documentation
    {
        return DB::transaction(function () use ($doc, $data, $file) {
            $data['updated_by'] = admin()->id;
            $doc->update($data);
            return $doc;
        });
    }

    public function delete(Documentation $doc): void
    {
        $doc->update(['deleted_by' => admin()->id]);
        $doc->delete();
    }

    public function restore(string $encryptedId): void
    {
        $doc = $this->getDeletedDocumentation($encryptedId);
        $doc->update(['updated_by' => admin()->id]);
        $doc->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $doc = $this->getDeletedDocumentation($encryptedId);
        $doc->forceDelete();
    }

    // public function toggleStatus(Admin $doc): void
    // {
    //     $doc->update( [
    //         'status' => !$doc->status,
    //         'updated_by' => admin()->id
    //     ]);
    // }
}
