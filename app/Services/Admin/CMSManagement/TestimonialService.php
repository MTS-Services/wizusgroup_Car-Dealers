<?php

namespace App\Services\Admin\CMSManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\Testimonial;
use App\View\Components\Frontend\Test;

class TestimonialService
{
    /**
     * Create a new class instance.
     */
    use FileManagementTrait;

    public function getTestimonials($orderby = 'sort_order', $order = 'asc')
    {
        return Testimonial::orderBy($orderby, $order)->latest();
    }

    // public function getUser(string $encryptedId): User | Collection
    // {
    //     return User::findOrFail(decrypt($encryptedId));
    // }

    // public function getDeletedUser(string $encryptedId): User | Collection
    // {
    //     return User::onlyTrashed()->findOrFail(decrypt($encryptedId));
    // }

    public function createTestimonial(array $data, $file = null): Testimonial
    {
        $data['creater_id'] = admin()->id;
        $data['creater_type'] = get_class(admin());
        if ($file) {
            $data['author_image'] = $this->handleFilepondFileUpload(Testimonial::class, $file, admin(), 'testimonials/');
        }
        return Testimonial::create($data);
    }
    // public function updateUser(User $user, array $data, $file = null): User
    // {
    //     $data['password'] = $data['password'] ?? $user->password;
    //     $data['updater_id'] = admin()->id;
    //     $data['updater_type'] = get_class(admin());
    //     if ($file) {
    //         $data['image'] = $this->handleFilepondFileUpload($user, $file, user(), 'users/');
    //     }
    //     $user->update($data);
    //     return $user;
    // }
    // public function delete(User $user): void
    // {
    //     $user->update([
    //         'deleter_id' => admin()->id,
    //         'deleter_type' => get_class(admin()),
    //     ]);
    //     $user->delete();
    // }

    // public function restore(string $encryptedId): void
    // {
    //     $user = $this->getDeletedUser($encryptedId);
    //     $user->update([
    //         'updater_id' => admin()->id,
    //         'updater_type' => get_class(admin())
    //     ]);
    //     $user->restore();
    // }
    // public function permanentDelete(string $encryptedId): void
    // {
    //     $user = $this->getDeletedUser($encryptedId);
    //     if ($user->image) {
    //         $this->fileDelete($user->image);
    //     }
    //     $user->forceDelete();
    // }
    // public function toggleStatus(User $user): void
    // {
    //     $user->update([
    //         'status' => !$user->status,
    //         'updater_id' => admin()->id,
    //         'updater_type' => get_class(admin())
    //     ]);
    // }
}
