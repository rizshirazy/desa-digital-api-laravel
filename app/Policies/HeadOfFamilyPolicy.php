<?php

namespace App\Policies;

use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HeadOfFamilyPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'head-of-family-list');
    }

    public function view(User $user, HeadOfFamily $headOfFamily): bool
    {
        return $this->hasPermission($user, 'head-of-family-view')
            && $headOfFamily->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'head-of-family-create');
    }

    public function update(User $user, HeadOfFamily $headOfFamily): bool
    {
        return $this->hasPermission($user, 'head-of-family-update')
            && $headOfFamily->user_id === $user->id;
    }

    public function delete(User $user, HeadOfFamily $headOfFamily): bool
    {
        return $this->hasPermission($user, 'head-of-family-delete')
            && $headOfFamily->user_id === $user->id;
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, 'sanctum');
    }
}
