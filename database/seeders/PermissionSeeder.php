<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dashboard & Analytics
        Permission::firstOrCreate(['name' => 'view-dashboard']);
        Permission::firstOrCreate(['name' => 'view-analytics']); // For charts/trends (Analyst & Admin only)

        // 2. Financial Records (Transactions) Management
        // 'Order' ki jagah 'FinancialRecord' ya 'Transaction' use karein
        Permission::firstOrCreate(['name' => 'transaction-index']);
        Permission::firstOrCreate(['name' => 'transaction-create']);
        Permission::firstOrCreate(['name' => 'transaction-edit']);
        Permission::firstOrCreate(['name' => 'transaction-view']);
        Permission::firstOrCreate(['name' => 'transaction-delete']);
        Permission::firstOrCreate(['name' => 'transaction-export']); // Like 'DownloadPdf' but for finance reports

        // 3. User Management (Admin Only)
        Permission::firstOrCreate(['name' => 'user-index']);
        Permission::firstOrCreate(['name' => 'user-create']);
        Permission::firstOrCreate(['name' => 'user-edit']);
        Permission::firstOrCreate(['name' => 'user-delete']);
        Permission::firstOrCreate(['name' => 'user-toggle-status']); // For Active/Inactive status requirement

        // 4. Access Management (Roles/Permissions - Admin Only)
        Permission::firstOrCreate(['name' => 'access-control-view']);
        Permission::firstOrCreate(['name' => 'access-control-manage']);

        // Roles fetch karein (Ya create karein agar nahi hain)
        // $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin      = Role::where('name', 'Admin')->first();
        $analyst    = Role::where('name', 'Analyst')->first();
        $viewer     = Role::where('name', 'Viewer')->first();

        // 1. Super Admin: Sare permissions sync kar do
        // $allPermissions = Permission::all();
        // $superAdmin->syncPermissions($allPermissions);

        // 2. Admin: Finance records + User management ka pura control
        $admin->syncPermissions([
            'view-dashboard',
            'view-analytics',
            'transaction-index',
            'transaction-create',
            'transaction-edit',
            'transaction-view',
            'transaction-delete',
            'transaction-export',
            'user-index',
            'user-create',
            'user-edit',
            'user-delete',
            'user-toggle-status',
        ]);

        // 3. Analyst: Data analysis aur record entry (Lekin delete ya user management nahi)
        $analyst->syncPermissions([
            'view-dashboard',
            'view-analytics',
            'transaction-index',
            'transaction-view',
            'transaction-create',
            'transaction-export',
        ]);

        // 4. Viewer: Sirf basic viewing access (Read-only)
        $viewer->syncPermissions([
            'view-dashboard',
            'transaction-index',
            'transaction-view',
        ]);
    }
}
