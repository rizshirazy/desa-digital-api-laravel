<?php

namespace App\Policies;

use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyMemberPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'family-member-list');
    }

    public function view(User $user, FamilyMember $familyMember): bool
    {
        return $this->hasPermission($user, 'family-member-view')
            && ($familyMember->user_id === $user->id
                || $familyMember->headOfFamily?->user_id === $user->id);
    }

    public function create(User $user, string $headOfFamilyId): bool
    {
        return $this->hasPermission($user, 'family-member-create')
            && $this->isOwner($user, $headOfFamilyId);
    }

    public function update(User $user, FamilyMember $familyMember): bool
    {
        return $this->hasPermission($user, 'family-member-update')
            && ($familyMember->user_id === $user->id
                || $familyMember->headOfFamily?->user_id === $user->id);
    }

    public function delete(User $user, FamilyMember $familyMember): bool
    {
        return $this->hasPermission($user, 'family-member-delete')
            && ($familyMember->user_id === $user->id
                || $familyMember->headOfFamily?->user_id === $user->id);
    }

    private function isOwner(User $user, string $headOfFamilyId): bool
    {
        return $user->headOfFamily?->id === $headOfFamilyId;
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, 'sanctum');
    }
}
