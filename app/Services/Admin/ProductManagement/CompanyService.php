<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
   use FileManagementTrait;

    public function getCompanies($orderby = 'sort_order', $order = 'asc')
    {
        return Company::orderBy($orderby, $order)->latest();
    }

    public function getCompany(string $encryptedId): Company | Collection
    {
        return Company::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedCompany(string $encryptedId): Company | Collection
    {
        return Company::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createCompany(array $data, $file = null): Company
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFileUpload( $file, 'companies');
        }
        $company = Company::create($data);
        return $company;
    }

    public function updateCompany(string $encryptedId, array $data, $file = null): Company
    {
        $company = $this->getCompany($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'companies');
            $this->fileDelete($company->image);
        }
        $company->update($data);
        return $company;
    }

    public function deleteCompany(string $encryptedId): void
    {
        $company = $this->getCompany($encryptedId);
        $company->update(['deleted_by' => admin()->id]);
        $company->delete();
    }

    public function restoreCompany(string $encryptedId): void
    {
        $company = $this->getDeletedCompany($encryptedId);
        $company->update(['updated_by' => admin()->id]);
        $company->restore();
    }

    public function permanentDeleteCompany(string $encryptedId): void
    {
        $company = $this->getDeletedCompany($encryptedId);
        if ($company->image) {
            $this->fileDelete($company->image);
        }
        $company->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $company = $this->getCompany($encryptedId);
        $company->update([
            'updated_by' => admin()->id,
            'status' => !$company->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $company = $this->getCompany($encryptedId);
        $company->update([
            'updated_by' => admin()->id,
            'is_featured' => !$company->is_featured
        ]);
    }
}
