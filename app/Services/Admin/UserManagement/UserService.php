<?php

namespace App\Services\Admin\UserManagement;

use App\Http\Traits\FileManagementTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{

    use FileManagementTrait;

    public function getUsers($orderBy = 'sort_order', $order = 'asc')
    {
        return User::orderBy($orderBy, $order)->latest();
    }

    public function getUser(string $encryptedId): User | Collection
    {
        return User::findOrFail(decrypt($encryptedId));
    }

    public function getDeletedUser(string $encryptedId): User | Collection
    {
        return User::onlyTrashed()->findOrFail(decrypt($encryptedId));
    }

    public function createUser(array $data, $file = null): User
    {
        $data['creater_id'] = admin()->id;
        $data['creater_type'] = get_class(admin());
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'users');
        }
        return User::create($data);
    }
    public function updateUser(User $user, array $data, $file = null): User
    {
        $data['password'] = $data['password'] ?? $user->password;
        $data['updater_id'] = admin()->id;
        $data['updater_type'] = get_class(admin());
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'users');
            $this->fileDelete($user->image);
        }
        $user->update($data);
        return $user;
    }
    public function delete(User $user): void
    {
        $user->update([
            'deleter_id' => admin()->id,
            'deleter_type' => get_class(admin()),
        ]);
        $user->delete();
    }

    public function restore(string $encryptedId): void
    {
        $user = $this->getDeletedUser($encryptedId);
        $user->update([
            'updater_id' => admin()->id,
            'updater_type' => get_class(admin())
        ]);
        $user->restore();
    }
    public function permanentDelete(string $encryptedId): void
    {
        $user = $this->getDeletedUser($encryptedId);
        if ($user->image) {
            $this->fileDelete($user->image);
        }
        $user->forceDelete();
    }
    public function toggleStatus(User $user): void
    {
        $user->update([
            'status' => !$user->status,
            'updater_id' => admin()->id,
            'updater_type' => get_class(admin())
        ]);
    }

    public function updateUserProfile( User $user, array $data, $file = null) :User
    {
        $data['updater_id'] = user()->id;
        $data['updater_type'] = get_class(user());
        if ($file) {
            $data['image'] = $this->handleFileUpload($file, 'users_profile');
            $this->fileDelete($user->image);
        }
        $user->update($data);
        return $user;
    }
}
