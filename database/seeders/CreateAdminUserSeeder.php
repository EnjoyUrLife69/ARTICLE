<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = Permission::pluck('id', 'id')->all();

        // Create Super Admin User
        $superAdminUser = User::create([
            'name' => 'Prince Meow Meow III',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt(']'),
            'image' => 'default.jpg',
        ]);

        // Create Super Admin Role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions($permissions); // Assign all permissions
        $superAdminUser->assignRole([$superAdminRole->id]);

        // Create Writer Role and Permissions
        $writerRole = Role::create(['name' => 'Writer']);
        $writerPermissions = [
            'user-list', 'article-list', 'article-create', 'article-edit',
            'user-edit', 'article-delete',
        ]; // Example of writer permissions, you can adjust as needed
        $writerRole->syncPermissions($writerPermissions);

        // Create Writer User (Optional)
        $writerUser = User::create([
            'name' => 'Queen Elizabeth II',
            'email' => 'writer@gmail.com',
            'password' => bcrypt(']'),
            'image' => 'default.jpg',
        ]);
        $writerUser->assignRole([$writerRole->id]);

        // Create Guest Role (No permissions)
        $guestRole = Role::create(['name' => 'Guest']);
        // Guest role does not need permissions, but you can assign read-only ones if necessary
        $guestRole->syncPermissions([]); // No permissions for guest

        // Create Guest User (Optional)
        $guestUser = User::create([
            'name' => 'King Arthur IV',
            'email' => 'guest@gmail.com',
            'password' => bcrypt(']'),
            'image' => 'default.jpg',
        ]);
        $guestUser->assignRole([$guestRole->id]);
    }
}
