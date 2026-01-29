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

        // 1️⃣ Final Permissions List
        $permissions = [
            'dashboard-view',

            // Activity Logs
            'activity-log-list',
            'activity-log-view',
            'activity-log-delete',

            // Roles & Permissions
            'role-list',
            'role-manage',

            // Users
            'user-list',
            'user-manage',

            // Contact Inquiries
            'contact-inquiry-list',
            'contact-inquiry-view',
            'contact-inquiry-delete',

            // Inspection Inquiries
            'inspection-inquiry-list',
            'inspection-inquiry-view',
            'inspection-inquiry-delete',

            // Purchase Inquiries
            'purchase-inquiry-list',
            'purchase-inquiry-view',
            'purchase-inquiry-delete',

            // Sale Inquiries
            'sale-inquiry-list',
            'sale-inquiry-view',
            'sale-inquiry-delete',

            // Bids
            'bidding-list',
            'bidding-actions',

            // Makes
            'make-list',
            'make-actions',

            // Auctions
            'auction-list',
            'auction-view',
            'auction-create',
            'auction-edit',
            'auction-delete',

            // Inspection Reports
            'inspection-report-list',
            'inspection-report-view',
            'inspection-report-create',
            'inspection-report-edit',
            'inspection-report-delete',
            'inspection-report-generate-pdf',
            'inspection-report-share',
            'inspection-report-download',

            // Agents
            'dre-list',
            'dre-view',
            'dre-manage',

            // Packages
            'package-list',
            'package-create',
            'package-view',
            'package-edit',
            'package-delete',

            // Bookings
            'booking-list',
            'booking-view',
            'booking-edit',
            'booking-delete',

            // Invoices
            'invoice-list',
            'invoice-view',
            'invoice-create',
            'invoice-edit',
            'invoice-delete',

            // Appointments
            'appointment-list',
            'appointment-view',
            'appointment-manage',
        ];

        // 2️⃣ Create permissions for API guard
        foreach ($permissions as $p) {
            Permission::updateOrCreate(
                ['name' => $p, 'guard_name' => 'api'],
                []
            );
        }

        // 3️⃣ Roles
        $roles = [
            'super-admin' => Permission::where('guard_name', 'api')->pluck('name')->toArray(),

            // Customize these if needed
            'admin' => [
                'dashboard-view',

                // Activity Logs
                'activity-log-list',
                'activity-log-view',
                'activity-log-delete',

                // Roles & Permissions
                'role-list',
                'role-manage',

                // Users
                'user-list',
                'user-manage',

                // Contact Inquiries
                'contact-inquiry-list',
                'contact-inquiry-view',
                'contact-inquiry-delete',

                // Inspection Inquiries
                'inspection-inquiry-list',
                'inspection-inquiry-view',
                'inspection-inquiry-delete',

                // Purchase Inquiries
                'purchase-inquiry-list',
                'purchase-inquiry-view',
                'purchase-inquiry-delete',

                // Sale Inquiries
                'sale-inquiry-list',
                'sale-inquiry-view',
                'sale-inquiry-delete',

                // Bids
                'bidding-list',
                'bidding-actions',

                // Makes
                'make-list',
                'make-actions',

                // Auctions
                'auction-list',
                'auction-view',
                'auction-create',
                'auction-edit',
                'auction-delete',

                // Inspection Reports
                'inspection-report-list',
                'inspection-report-view',
                'inspection-report-create',
                'inspection-report-edit',
                'inspection-report-delete',
                'inspection-report-generate-pdf',
                'inspection-report-share',
                'inspection-report-download',

                // Agents
                'dre-list',
                'dre-view',
                'dre-manage',

                // Packages
                'package-list',
                'package-create',
                'package-view',
                'package-edit',
                'package-delete',

                // Bookings
                'booking-list',
                'booking-view',
                'booking-edit',
                'booking-delete',

                // Invoices
                'invoice-list',
                'invoice-view',
                'invoice-create',
                'invoice-edit',
                'invoice-delete',

                // Appointments
                'appointment-list',
                'appointment-view',
                'appointment-manage',
            ],
             'agent' => [
                'dashboard-view',

                // Activity Logs
                'activity-log-list',
                'activity-log-view',
                'activity-log-delete',

                // Roles & Permissions
                'role-list',
                'role-manage',

                // Users
                'user-list',
                'user-manage',

                // Contact Inquiries
                'contact-inquiry-list',
                'contact-inquiry-view',
                'contact-inquiry-delete',

                // Inspection Inquiries
                'inspection-inquiry-list',
                'inspection-inquiry-view',
                'inspection-inquiry-delete',

                // Purchase Inquiries
                'purchase-inquiry-list',
                'purchase-inquiry-view',
                'purchase-inquiry-delete',

                // Sale Inquiries
                'sale-inquiry-list',
                'sale-inquiry-view',
                'sale-inquiry-delete',

                // Bids
                'bidding-list',
                'bidding-actions',

                // Makes
                'make-list',
                'make-actions',

                // Auctions
                'auction-list',
                'auction-view',
                'auction-create',
                'auction-edit',
                'auction-delete',

                // Inspection Reports
                'inspection-report-list',
                'inspection-report-view',
                'inspection-report-create',
                'inspection-report-edit',
                'inspection-report-delete',
                'inspection-report-generate-pdf',
                'inspection-report-share',
                'inspection-report-download',

                // Agents
                'dre-list',
                'dre-view',
                'dre-manage',

                // Packages
                'package-list',
                'package-create',
                'package-view',
                'package-edit',
                'package-delete',

                // Bookings
                'booking-list',
                'booking-view',
                'booking-edit',
                'booking-delete',

                // Invoices
                'invoice-list',
                'invoice-view',
                'invoice-create',
                'invoice-edit',
                'invoice-delete',

                // Appointments
                'appointment-list',
                'appointment-view',
                'appointment-manage',
            ],


            'inspector' => [
                'dashboard-view',
                'inspection-report-list',
                'inspection-report-view',
                'inspection-report-edit',
                'inspection-report-create',
                'inspection-report-generate-pdf',
                'auction-list',
                'auction-view',
            ],

            'customer' => [
                'dashboard-view',

            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::updateOrCreate(['name' => $roleName, 'guard_name' => 'api']);

            if ($roleName === 'super-admin') {
                $role->syncPermissions(Permission::where('guard_name', 'api')->get());
            } else {
                $role->syncPermissions(Permission::whereIn('name', $rolePermissions)->where('guard_name', 'api')->get());
            }
        }
    }
}
