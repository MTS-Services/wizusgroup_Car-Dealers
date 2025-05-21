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
                $data['image'] = $this->handleFileUpload($file,  'banners');
        }
        $banner = Banner::create($data);
        return $banner;
    }

    public function updateBanner(string $encryptedId, array $data, $file = null): Banner
    {
        $banner = $this->getBanner($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
                $data['image'] = $this->handleFileUpload($file,  'banners');
                $this->fileDelete($banner->image);
        }
        $banner->update($data);
        return $banner;
    }

    public function deleteBanner(string $encryptedId): void
    {
        $banner = $this->getBanner($encryptedId);
        $banner->update(['deleted_by' => admin()->id]);
        $banner->delete();
    }

    public function restoreBanner(string $encryptedId): void
    {
        $banner = $this->getDeletedBanner($encryptedId);
        $banner->update(['updated_by' => admin()->id]);
        $banner->restore();
    }

    public function permanentDeleteBanner(string $encryptedId): void
    {
        $banner = $this->getDeletedBanner($encryptedId);
        if ($banner->image) {
            $this->fileDelete($banner->image);
        }
        $banner->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $banner = $this->getBanner($encryptedId);
        $banner->update([
            'updated_by' => admin()->id,
            'status' => !$banner->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $banner = $this->getBanner($encryptedId);
        $banner->update([
            'updated_by' => admin()->id,
            'is_featured' => !$banner->is_featured
        ]);
    }
}
