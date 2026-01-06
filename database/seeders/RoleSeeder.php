<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::findOrCreate('admin', 'sanctum')->givePermissionTo(Permission::all());

        Role::findOrCreate('head-of-family', 'sanctum')->givePermissionTo([
            'dashboard-view',

            'family-member-list',
            'family-member-view',
            'family-member-create',
            'family-member-update',
            'family-member-delete',

            'social-assistance-list',
            'social-assistance-view',

            'social-assistance-ricipient-list',
            'social-assistance-ricipient-view',
            'social-assistance-ricipient-create',
            'social-assistance-ricipient-update',
            'social-assistance-ricipient-delete',

            'event-list',
            'event-view',

            'event-participant-list',
            'event-participant-view',
            'event-participant-create',
            'event-participant-update',
            'event-participant-delete',

            'development-list',
            'development-view',

            'development-applicant-list',
            'development-applicant-view',
            'development-applicant-create',
            'development-applicant-update',
            'development-applicant-delete',

            'profile-view',
        ]);
    }
}
