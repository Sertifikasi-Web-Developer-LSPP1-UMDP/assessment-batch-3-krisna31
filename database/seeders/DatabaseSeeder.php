<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Permissions
        $permissions = [
            [
                'name' => 'manage-users',
                'display_name' => 'Manage Users',
                'description' => 'Manage Users',
            ],
            [
                'name' => 'manage-announcements',
                'display_name' => 'Manage Announcements',
                'description' => 'Manage Announcements',
            ],
            [
                'name' => 'verifikasi-user',
                'display_name' => 'Verifikasi User',
                'description' => 'Verifikasi User',
            ],
            [
                'name' => 'update-status-user',
                'display_name' => 'Update Status User',
                'description' => 'Update Status User',
            ],
            [
                'name' => 'manage-laratrust',
                'display_name' => 'Manage Laratrust',
                'description' => 'Manage Laratrust',
            ],
            [
                'name' => 'view-users',
                'display_name' => 'View Users',
                'description' => 'View Users',
            ],
        ];

        foreach ($permissions as $permissionData) {
            Permission::create($permissionData);
        }

        // Roles
        $mahasiswaRole = Role::create([
            'id' => 1,
            'name' => 'mahasiswa',
            'display_name' => 'Mahasiswa',
            'description' => 'Mahasiswa Role',
        ]);

        $adminRole = Role::create([
            'id' => 2,
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Admin Role',
        ]);

        // Assign all permissions to admin
        $adminRole->permissions()->sync(Permission::all()->pluck('id')->toArray());

        // Create admin user and assign admin role
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
            'status_pendaftaran' => 'Admin',
        ]);

        $adminUser->addRole($adminRole);
    }
}
