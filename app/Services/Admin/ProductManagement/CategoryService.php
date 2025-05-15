<?php

namespace App\Services\Admin\ProductManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    use FileManagementTrait;

    public function getCategories($orderBy = 'sort_order', $order = 'asc')
    {
        return Category::orderBy($orderBy, $order)->latest();
    }

    public function getCategory(string $encryptedId): Category | Collection
    {
        return Category::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedCategory(string $encryptedId): Category | Collection
    {
        return Category::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createCategory(array $data, $file = null): Category
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(Category::class, $file, admin(), 'categories/');
        }
        $category = Category::create($data);
        return $category;
    }

    public function updateCategory(string $encryptedId, array $data, $file = null): Category
    {
        $category = $this->getCategory($encryptedId);
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($category, $file, admin(), 'categories/');
        }
        $category->update($data);
        return $category;
    }

    public function deleteCategory(string $encryptedId): void
    {
        $category = $this->getCategory($encryptedId);
        $category->update(['deleted_by' => admin()->id]);
        $category->delete();
    }

    public function restoreCategory(string $encryptedId): void
    {
        $category = $this->getDeletedCategory($encryptedId);
        $category->update(['updated_by' => admin()->id]);
        $category->restore();
    }

    public function permanentDeleteCategory(string $encryptedId): void
    {
        $category = $this->getDeletedCategory($encryptedId);
        if ($category->image) {
            $this->fileDelete($category->image);
        }
        $category->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $category = $this->getCategory($encryptedId);
        $category->update([
            'updated_by' => admin()->id,
            'status' => !$category->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $category = $this->getCategory($encryptedId);
        $category->update([
            'updated_by' => admin()->id,
            'is_featured' => !$category->is_featured
        ]);
    }
}
