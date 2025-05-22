<?php

namespace App\Services\Admin\CMSManagement;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    /**
     * Create a new class instance.
     */
       public function getContacts($orderby = 'sort_order', $order = 'asc')
    {
        return Contact::orderBy($orderby, $order)->latest();
    }
     public function getContact(string $encryptedId): Contact | Collection
    {
        return Contact::findOrFail(decrypt($encryptedId));
    }

     public function createContact(array $data): Contact
    {
        // $data['open_by'] = admin()->id;
        $contact = Contact::create($data);
        return $contact;
    }

    public function toggleStatus(string $encryptedId): void
    {
        $contacat = $this->getContact($encryptedId);
        $contacat->update([
            'open_by' => admin()->id,
            'status' => !$contacat->status
        ]);
    }

     public function delete(string $encryptedId): void
    {
        $contacat = $this->getContact($encryptedId);
        $contacat->update(['deleter_id' => admin()->id]);
        $contacat->delete();
    }
     public function getDeletedContact(string $encryptedId): Contact | Collection
    {
        return Contact::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }
    public function restore(string $encryptedId): void
    {
        $contacat = $this->getDeletedContact($encryptedId);
        $contacat->update(['updated_by' => admin()->id]);
        $contacat->restore();
    }

    public function permanentDelete(string $encryptedId): void
    {
        $contacat = $this->getDeletedContact($encryptedId);
        $contacat->forceDelete();
    }

}
