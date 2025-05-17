<?php

namespace App\Services\Admin\CMSManagement;

use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Database\Eloquent\Collection;

class BannerService
{
    use FileManagementTrait;

    public function getBanners($orderby = 'sort_order', $order = 'asc')
    {
        return Banner::orderBy($orderby, $order)->latest();
    }

    public function getBanner(string $encryptedId): Banner | Collection
    {
        return Banner::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedBanner(string $encryptedId): Banner | Collection
    {
        return Banner::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createBanner(array $data, $file = null): Banner
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(Banner::class, $file, admin(), 'Banners/');
        }
        $Banner = Banner::create($data);
        return $Banner;
    }

    public function updateBanner(string $encryptedId, array $data, $file = null): Banner
    {
        $Banner = $this->getBanner($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($Banner, $file, admin(), 'Banner/');
        }
        $Banner->update($data);
        return $Banner;
    }

    public function deleteBanner(string $encryptedId): void
    {
        $Banner = $this->getBanner($encryptedId);
        $Banner->update(['deleted_by' => admin()->id]);
        $Banner->delete();
    }

    public function restoreBanner(string $encryptedId): void
    {
        $Banner = $this->getDeletedBanner($encryptedId);
        $Banner->update(['updated_by' => admin()->id]);
        $Banner->restore();
    }

    public function permanentDeleteBanner(string $encryptedId): void
    {
        $Banner = $this->getDeletedBanner($encryptedId);
        if ($Banner->image) {
            $this->fileDelete($Banner->image);
        }
        $Banner->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $Banner = $this->getBanner($encryptedId);
        $Banner->update([
            'updated_by' => admin()->id,
            'status' => !$Banner->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $Banner = $this->getBanner($encryptedId);
        $Banner->update([
            'updated_by' => admin()->id,
            'is_featured' => !$Banner->is_featured
        ]);
    }
}
