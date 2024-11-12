<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // List
            'user-list',
            'role-list',
            'categorie-list',
            'article-list',

            // Edit
            'user-edit',
            'role-edit',
            'categorie-edit',
            'article-edit',

            // Create
            'user-create',
            'role-create',
            'categorie-create',
            'article-create',

            // Delete
            'user-delete',
            'role-delete',
            'categorie-delete',
            'article-delete',

            // Accept Request
            'accept-request',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

    }
}
