<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'dashboard' => [
            'view',
        ],
        'head-of-family' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'family-member' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'social-assistance' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'social-assistance-ricipient' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'event' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'event-participant' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'development' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'development-applicant' => [
            'view',
            'create',
            'update',
            'delete',
        ],
        'profile' => [
            'view',
            'create',
            'update',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::findOrCreate($key . '-' . $permission, 'sanctum');
            }
        }
    }
}
