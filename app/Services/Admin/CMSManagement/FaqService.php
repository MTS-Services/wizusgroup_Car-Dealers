<?php

namespace App\Services\Admin\CMSManagement;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\FileManagementTrait;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class FaqService
{
    use FileManagementTrait;

    public function getFaqs($orderby = 'sort_order', $order = 'asc')
    {
        return Faq::orderBy($orderby, $order)->latest();
    }

    public function getFaq(string $encryptedId): Faq | Collection
    {
        return Faq::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedFaq(string $encryptedId): Faq | Collection
    {
        return Faq::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createFaq(array $data, $file = null): Faq
    {
        $data['created_by'] = admin()->id;
        $faq = Faq::create($data);
        return $faq;
    }

    public function updateFaq(string $encryptedId, array $data, $file = null): Faq
    {
        $faq = $this->getFaq($encryptedId);
        $data['updated_by'] = admin()->id;
        $faq->update($data);
        return $faq;
    }

    public function deleteFaq(string $encryptedId): void
    {
        $faq = $this->getFaq($encryptedId);
        $faq->update(['deleted_by' => admin()->id]);
        $faq->delete();
    }

    public function restoreFaq(string $encryptedId): void
    {
        $faq = $this->getDeletedFaq($encryptedId);
        $faq->update(['updated_by' => admin()->id]);
        $faq->restore();
    }

    public function permanentDeleteFaq(string $encryptedId): void
    {
        $faq = $this->getDeletedFaq($encryptedId);
        $faq->forceDelete();
    }

    public function toggleStatus(string $encryptedId): void
    {
        $faq = $this->getFaq($encryptedId);
        $faq->update([
            'updated_by' => admin()->id,
            'status' => !$faq->status
        ]);
    }

    public function toggleFeature(string $encryptedId): void
    {
        $faq = $this->getFaq($encryptedId);
        $faq->update([
            'updated_by' => admin()->id,
            'is_featured' => !$faq->is_featured
        ]);
    }
}
