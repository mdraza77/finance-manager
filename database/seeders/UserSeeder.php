<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define roles from your image
        $roles = [
            'Admin',
            'Analyst',
            'Viewer',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $permissions = Permission::pluck('id')->all();
            $role->syncPermissions($permissions);
        }

        // 3. Define dummy users for each role
        $users = [
            [
                'name' => 'Md Raza',
                'email' => 'admin@gmail.com',
                'role' => 'Admin'
            ]
        ];

        // 4. Create Users and Assign Roles
        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']], // Unique key to find the user
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('Success2026$')
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}
