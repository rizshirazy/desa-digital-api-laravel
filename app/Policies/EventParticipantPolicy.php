<?php

namespace App\Policies;

use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventParticipantPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'event-participant-view');
    }

    public function view(User $user, EventParticipant $participant): bool
    {
        return $this->hasPermission($user, 'event-participant-view')
            && $participant->family?->user_id === $user->id;
    }

    public function create(User $user, string $headOfFamilyId): bool
    {
        return $this->hasPermission($user, 'event-participant-create')
            && $this->isOwner($user, $headOfFamilyId);
    }

    public function update(User $user, EventParticipant $participant): bool
    {
        return $this->hasPermission($user, 'event-participant-update')
            && $participant->family?->user_id === $user->id;
    }

    public function delete(User $user, EventParticipant $participant): bool
    {
        return $this->hasPermission($user, 'event-participant-delete')
            && $participant->family?->user_id === $user->id;
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
