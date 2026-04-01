<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions (Spatie Best Practice)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Dashboard & Analytics
        Permission::firstOrCreate(['name' => 'Dashboard-View']);
        Permission::firstOrCreate(['name' => 'Analytics-View']);

        // 2. Financial Records (Transactions) Management
        Permission::firstOrCreate(['name' => 'Transaction-Index']);
        Permission::firstOrCreate(['name' => 'Transaction-Create']);
        Permission::firstOrCreate(['name' => 'Transaction-Edit']);
        Permission::firstOrCreate(['name' => 'Transaction-View']);
        Permission::firstOrCreate(['name' => 'Transaction-Delete']);

        // 3. User Management (Admin Only)
        Permission::firstOrCreate(['name' => 'UserManagement-Index']);
        Permission::firstOrCreate(['name' => 'UserManagement-Create']);
        Permission::firstOrCreate(['name' => 'UserManagement-Edit']);
        Permission::firstOrCreate(['name' => 'UserManagement-View']);
        Permission::firstOrCreate(['name' => 'UserManagement-Delete']);

        // 4. Access Management (Roles/Permissions - Admin Only)
        Permission::firstOrCreate(['name' => 'AccessManagement-Index']);
        Permission::firstOrCreate(['name' => 'AccessManagement-Create']);
        Permission::firstOrCreate(['name' => 'AccessManagement-Edit']);
        Permission::firstOrCreate(['name' => 'AccessManagement-Delete']);
        Permission::firstOrCreate(['name' => 'AccessManagement-View']);

        // Fetch OR Create Roles safely (Fixes the Null error)
        $admin   = Role::firstOrCreate(['name' => 'Admin']);
        $analyst = Role::firstOrCreate(['name' => 'Analyst']);
        $viewer  = Role::firstOrCreate(['name' => 'Viewer']);

        // 1. Admin: Sync All permissions
        $allPermissions = Permission::all();
        $admin->syncPermissions($allPermissions);

        // 2. Analyst: Data analysis and record entry
        $analyst->syncPermissions([
            'Dashboard-View',
            'Analytics-View',
            'Transaction-Index',
            'Transaction-Create',
            'Transaction-Edit',
            'Transaction-View',
        ]);

        // 3. Viewer: Only basic viewing access (Read-only)
        $viewer->syncPermissions([
            'Dashboard-View',
            'Transaction-Index',
            'Analytics-View',
            'Transaction-View',
        ]);
    }
}
