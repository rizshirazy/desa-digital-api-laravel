<?php

namespace App\Policies;

use App\Models\SocialAssistanceRecipient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SocialAssistanceRecipientPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'social-assistance-ricipient-view');
    }

    public function view(User $user, SocialAssistanceRecipient $recipient): bool
    {
        return $this->hasPermission($user, 'social-assistance-ricipient-view')
            && $recipient->family?->user_id === $user->id;
    }

    public function create(User $user, string $headOfFamilyId): bool
    {
        return $this->hasPermission($user, 'social-assistance-ricipient-create')
            && $this->isOwner($user, $headOfFamilyId);
    }

    public function update(User $user, SocialAssistanceRecipient $recipient): bool
    {
        return $this->hasPermission($user, 'social-assistance-ricipient-update')
            && $recipient->family?->user_id === $user->id;
    }

    public function delete(User $user, SocialAssistanceRecipient $recipient): bool
    {
        return $this->hasPermission($user, 'social-assistance-ricipient-delete')
            && $recipient->family?->user_id === $user->id;
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
