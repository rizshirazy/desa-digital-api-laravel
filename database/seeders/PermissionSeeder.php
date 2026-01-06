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
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'family-member' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'social-assistance' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'social-assistance-ricipient' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'event' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'event-participant' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'development' => [
            'list',
            'view',
            'create',
            'update',
            'delete',
        ],
        'development-applicant' => [
            'list',
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
