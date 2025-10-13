<?php

// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Define and create all permissions
        $permissions = [
            // Inspections
            'inspection-list',
            'inspection-view',
            'inspection-create',
            'inspection-edit',
            'inspection-delete',
            'inspection-approve',
            'inspection-assign',
            // Vehicles
            'vehicle-list',
            'vehicle-view',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
             //Contact Inquiry
            'contact-inquiry-list',
            'contact-inquiry-view',
            'contact-inquiry-edit',
            'contact-inquiry-delete',
             //Purchase Inquiry
            'purchase-inquiry-list',
            'purchase-inquiry-view',
            'purchase-inquiry-edit',
            'purchase-inquiry-delete',
             //Sale Inquiry
            'sale-inquiry-list',
            'sale-inquiry-view',
            'sale-inquiry-edit',
            'sale-inquiry-delete',
            //Makes
            'make-list',
            'make-actions',
            //Biddings
            'bidding-list',
            'bidding-actions',
            // Clients
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            // Reports
            'report-view',
            'report-download',
            'report-share',
            'report-delete',
            'report-edit',
            'report-create',
            'report-generate-pdf',
            // System & User Management
            'user-list',
            'system-settings',
            'user-manage',
            'role-list',
            'role-manage',
            'blog-list',
            'blog-manage',
            'testimonial-list',
            'testimonial-manage',
            'dashboard-view',
        ];

        foreach ($permissions as $permission) {
            // Use updateOrCreate to avoid errors on re-seeding
            Permission::updateOrCreate(['name' => $permission]);
        }

        // 3. Define Roles and Sync Permissions

        // A. Super-Admin Role (has all permissions)
        // Using PascalCase for role names is a common convention
        $superAdminRole = Role::updateOrCreate(['name' => 'super-admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // B. Admin Role (has most permissions, but not role management)
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminPermissions = [
            'dashboard-view',
            'inspection-list',
            'inspection-view',
            'inspection-delete',
            'inspection-approve',
            'inspection-assign',
            'vehicle-list',
            'vehicle-view',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'report-view',
            'report-download',
            'report-share',
            'report-delete',
            'report-edit',
            'report-create',
            'report-generate-pdf',
            'user-list',
            'user-manage',
            'bidding-list',
            'bidding-actions',
            'make-list',
            'make-actions',
            'role-list', // Can see roles but not manage them
        ];
        $adminRole->syncPermissions($adminPermissions);

        // C. Inspector Role (focused on conducting inspections)
        $inspectorRole = Role::updateOrCreate(['name' => 'inspector']);
        $inspectorPermissions = [
            'dashboard-view',
            'inspection-list',
            'inspection-view',
            'inspection-create',
            'inspection-edit',
            'inspection-delete', // Can only edit inspections they are assigned to (logic in policy/controller)
            'vehicle-list',
            'vehicle-view',
            'report-view',
            'report-download',
        ];
        $inspectorRole->syncPermissions($inspectorPermissions);


        // D. Customer/Client Role (view-only permissions)
        $customerRole = Role::updateOrCreate(['name' => 'customer']);
        $customerPermissions = [
            'dashboard-view', // A specific customer dashboard
            'inspection-list', // Note: You'll need to filter these to their own inspections in your controller/policy
            'inspection-view',
            'report-view',
            'report-download',
        ];
        $customerRole->syncPermissions($customerPermissions);
    }
}
