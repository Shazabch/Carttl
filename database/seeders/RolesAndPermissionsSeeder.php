<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1️⃣ All defined permissions
        $permissions = [
            // Inspections
            'inspection-list', 'inspection-view', 'inspection-create', 'inspection-edit', 'inspection-delete',
            'inspection-approve', 'inspection-assign',

            // Vehicles
            'vehicle-list', 'vehicle-view', 'vehicle-create', 'vehicle-edit', 'vehicle-delete',

            // Contact Inquiry
            'contact-inquiry-list', 'contact-inquiry-view', 'contact-inquiry-edit', 'contact-inquiry-delete',

            // Purchase Inquiry
            'purchase-inquiry-list', 'purchase-inquiry-view', 'purchase-inquiry-edit', 'purchase-inquiry-delete',

            // Sale Inquiry
            'sale-inquiry-list', 'sale-inquiry-view', 'sale-inquiry-edit', 'sale-inquiry-delete',

            // Makes
            'make-list', 'make-actions',

            // Biddings
            'bidding-list', 'bidding-actions',

            // Clients
            'client-list', 'client-create', 'client-edit', 'client-delete',

            // Reports
            'report-view', 'report-download', 'report-share', 'report-delete',
            'report-edit', 'report-create', 'report-generate-pdf',

            // System & User Management
            'user-list', 'system-settings', 'user-manage',
            'role-list', 'role-manage',
            'blog-list', 'blog-manage',
            'testimonial-list', 'testimonial-manage',
            'dashboard-view',
        ];

        // 2️⃣ Create/Update permissions for both guards (web + api)
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                []
            );
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'api'],
                []
            );
        }

        // 3️⃣ Create/Update Roles for both guards

        $roles = [
            'super-admin' => Permission::all()->pluck('name')->toArray(),
            'admin' => [
                'dashboard-view', 'inspection-list', 'inspection-view', 'inspection-delete',
                'inspection-approve', 'inspection-assign', 'vehicle-list', 'vehicle-view',
                'vehicle-create', 'vehicle-edit', 'vehicle-delete', 'client-list', 'client-create',
                'client-edit', 'client-delete', 'report-view', 'report-download', 'report-share',
                'report-delete', 'report-edit', 'report-create', 'report-generate-pdf',
                'user-list', 'user-manage', 'bidding-list', 'bidding-actions',
                'make-list', 'make-actions', 'role-list',
            ],
            'inspector' => [
                'dashboard-view', 'inspection-list', 'inspection-view', 'inspection-create',
                'inspection-edit', 'inspection-delete', 'vehicle-list', 'vehicle-view',
                'report-view', 'report-download',
            ],
            'customer' => [
                'dashboard-view', 'inspection-list', 'inspection-view',
                'report-view', 'report-download',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            // Create for web guard
            $roleWeb = Role::updateOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            if ($roleName === 'super-admin') {
                $roleWeb->syncPermissions(Permission::where('guard_name', 'web')->get());
            } else {
                $roleWeb->syncPermissions(Permission::whereIn('name', $rolePermissions)->where('guard_name', 'web')->get());
            }

            // Create for api guard
            $roleApi = Role::updateOrCreate(['name' => $roleName, 'guard_name' => 'api']);
            if ($roleName === 'super-admin') {
                $roleApi->syncPermissions(Permission::where('guard_name', 'api')->get());
            } else {
                $roleApi->syncPermissions(Permission::whereIn('name', $rolePermissions)->where('guard_name', 'api')->get());
            }
        }
    }
}
