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

    public function createCategory(array $data, $file = null): Category
    {
        $data['created_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload(Category::class, $file, admin(), 'categories/');
        }
        $category = Category::create($data);
        return $category;
    }

    public function updateCategory(Category $category, array $data, $file = null): Category
    {
        $data['updated_by'] = admin()->id;
        if ($file) {
            $data['image'] = $this->handleFilepondFileUpload($category, $file, admin(), 'categories/');
        }
        $category->update($data);
        return $category;
    }

    public function deleteCategory(Category $category): void
    {
        $category->update(['deleted_by' => admin()->id]);
        $category->delete();
    }

    public function restoreCategory(Category $category): void
    {
        $category->update(['updated_by' => admin()->id]);
        $category->restore();
    }

    public function permanentDeleteCategory(Category $category): void
    {
        if ($category->image) {
            $this->fileDelete($category->image);
        }
        $category->forceDelete();
    }

    public function toggleStatus(Category $category): void
    {
        $category->update([
            'updated_by' => admin()->id,
            'status' => !$category->status
        ]);
    }

    public function toggleFeature(Category $category): void
    {
        $category->update([
            'updated_by' => admin()->id,
            'is_featured' => !$category->is_featured
        ]);
    }


    // ================ Main Category Queries ================

    public function getCategory(string $encryptedId): Category | Collection
    {
        return Category::isMainCategory()->findOrFail(decrypt($encryptedId));
    }

    public function getDeletedCategory(string $encryptedId): Category | Collection
    {
        return Category::onlyTrashed()->isMainCategory()->findOrFail(decrypt($encryptedId));
    }

    // ================ Sub Category Queries ===============

    public function getSubCategory(string $encryptedId): Category | Collection
    {
        return Category::isSubCategory()->findOrFail(decrypt($encryptedId));
    }

    public function getDeletedSubCategory(string $encryptedId): Category | Collection
    {
        return Category::onlyTrashed()->isSubCategory()->findOrFail(decrypt($encryptedId));
    }

    // ================ Sub Child Category Queries ===============

    public function getSubChildCategory(string $encryptedId): Category | Collection
    {
        return Category::isSubChildCategory()->findOrFail(decrypt($encryptedId));
    }

    public function getDeletedSubChildCategory(string $encryptedId): Category | Collection
    {
        return Category::onlyTrashed()->isSubChildCategory()->findOrFail(decrypt($encryptedId));
    }
}
