<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $roles = ['admin', 'coordinator', 'supervisor', 'student'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            // User permissions
            'view users', 'create users', 'edit users', 'delete users',
            // Company permissions
            'view companies', 'create companies', 'edit companies', 'delete companies',
            // Internship permissions
            'view internships', 'create internships', 'edit internships', 'delete internships',
            // Application permissions
            'view applications', 'create applications', 'approve applications', 'reject applications',
            // Placement permissions
            'view placements', 'create placements', 'edit placements', 'delete placements',
            // Logbook permissions
            'view logbooks', 'create logbooks', 'edit logbooks', 'approve logbooks',
            // Evaluation permissions
            'view evaluations', 'create evaluations', 'edit evaluations',
            // Document permissions
            'view documents', 'upload documents', 'delete documents',
            // Settings permissions
            'view settings', 'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $coordinatorRole = Role::findByName('coordinator');
        $coordinatorRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view companies', 'create companies', 'edit companies',
            'view internships', 'create internships', 'edit internships',
            'view applications', 'approve applications', 'reject applications',
            'view placements', 'create placements', 'edit placements',
            'view logbooks', 'approve logbooks',
            'view evaluations', 'create evaluations',
            'view documents', 'upload documents',
        ]);

        $supervisorRole = Role::findByName('supervisor');
        $supervisorRole->givePermissionTo([
            'view placements',
            'view logbooks', 'approve logbooks',
            'view evaluations', 'create evaluations', 'edit evaluations',
            'view documents',
        ]);

        $studentRole = Role::findByName('student');
        $studentRole->givePermissionTo([
            'view internships',
            'view applications', 'create applications',
            'view placements',
            'view logbooks', 'create logbooks', 'edit logbooks',
            'view evaluations',
            'view documents', 'upload documents',
        ]);
    }
}
