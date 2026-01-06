<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'profile-view');
    }

    public function view(User $user, Profile $profile): bool
    {
        return $this->hasPermission($user, 'profile-view');
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'profile-create');
    }

    public function update(User $user, Profile $profile): bool
    {
        return $this->hasPermission($user, 'profile-update');
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, 'sanctum');
    }
}
