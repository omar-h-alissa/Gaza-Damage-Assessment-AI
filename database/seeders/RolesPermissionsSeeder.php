<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{

    public function run()
    {
        // تنظيف Cache القديم
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ----------------------------
        // Permissions
        // ----------------------------
        $permissions = [
            // Reports
            'report.create',
            'report.edit',
            'report.delete',
            'report.view',
            'report.approve',
            'report.assign_to_property',



            // Properties / العقارات
            'property.create',
            'property.edit',
            'property.delete',
            'property.view',

            // Users
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'user.assign_role',


            // Dashboard
            'dashboard.view',
            'dashboard.export',
        ];

        // إنشاء الـ Permissions مع guard_name = web
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // ----------------------------
        // Roles
        // ----------------------------
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $fieldOfficer = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $reviewer = Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);

        // ----------------------------
        // Assign Permissions to Roles
        // ----------------------------

        // Super Admin → كل شيء
        $superAdmin->givePermissionTo(Permission::all());

        // Admin
        $admin->givePermissionTo([
            // Reports
            'report.create',
            'report.edit',
            'report.delete',
            'report.view',
            'report.approve',
            'report.assign_to_property',


            // Properties
            'property.create',
            'property.edit',
            'property.delete',
            'property.view',


            // Dashboard
            'dashboard.view',
        ]);

        // Field Officer (المستخدم العادي)
        $fieldOfficer->givePermissionTo([
            'report.create',
            'report.view',
            'property.create',
            'property.edit',
            'property.delete',
            'property.view',
        ]);

        // Reviewer
        $reviewer->givePermissionTo([
            'report.view',
            'report.approve',
            'property.view',
        ]);


        // Viewer
        $viewer->givePermissionTo([
            'property.view',
            'dashboard.view',
        ]);
    }
}
