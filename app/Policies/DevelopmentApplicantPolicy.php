<?php

namespace App\Policies;

use App\Models\DevelopmentApplicant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevelopmentApplicantPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $this->hasPermission($user, 'development-applicant-view');
    }

    public function view(User $user, DevelopmentApplicant $developmentApplicant): bool
    {
        return $this->hasPermission($user, 'development-applicant-view')
            && $developmentApplicant->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $this->hasPermission($user, 'development-applicant-create');
    }

    public function update(User $user, DevelopmentApplicant $developmentApplicant): bool
    {
        return $this->hasPermission($user, 'development-applicant-update')
            && $developmentApplicant->user_id === $user->id;
    }

    public function delete(User $user, DevelopmentApplicant $developmentApplicant): bool
    {
        return $this->hasPermission($user, 'development-applicant-delete')
            && $developmentApplicant->user_id === $user->id;
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, 'sanctum');
    }
}
