<?php

    namespace App\Services\Admin\UserManagement;

    use App\Http\Traits\FileManagementTrait;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\DB;


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
    $data['created_by'] = user()->id;
    if ($file) {
        $data['image'] = $this->handleFilepondFileUpload(User::class, $file, user(), 'users/');
    }
    return User::create($data);
}
public function updateUser(User $user, array $data, $file = null): User
{
    $data['password'] = $data['password'] ?? $user->password;
    $data['updated_by'] = user()->id;
    if ($file) {
        $data['image'] = $this->handleFilepondFileUpload($user, $file, user(), 'users/');
    }
    $user->update($data);
    return $user;
}
public function delete(User $user): void
{
    $user->update(['deleted_by' => user()->id]);
    $user->delete();
}
public function restore(string $encryptedId): void
{
    $user = $this->getDeletedUser($encryptedId);
    $user->update(['updated_by' => user()->id]);
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
    $user->update( [
    'status' => !$user->status,
    'updated_by' => user()->id
    ]);
}
}
