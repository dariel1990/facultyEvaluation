<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminPermissions = [
            'dashboard',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'period-list',
            'period-create',
            'period-edit',
            'period-delete',
            'class-list',
            'class-create',
            'class-edit',
            'class-delete',
            'criteria-list',
            'criteria-create',
            'criteria-edit',
            'criteria-delete',
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            'faculty-list',
            'faculty-create',
            'faculty-edit',
            'faculty-delete',
            'question-list',
            'question-create',
            'question-edit',
            'question-delete',
            'student-list',
            'student-create',
            'student-edit',
            'student-delete',
            'subject-list',
            'subject-create',
            'subject-edit',
            'subject-delete',
            'supervisor-list',
            'supervisor-create',
            'supervisor-edit',
            'supervisor-delete',
            'subject-student-list',
            'subject-student-import',
            'dashboard',
            'evaluation-list',
            'evaluation-create',
            'evaluation-edit',
            'evaluation-delete',
            'settings-list',
            'settings-update'
        ];
        foreach ($adminPermissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $studentPermissions = [
            'studentDashboard',
            'evaluation-user',
            'evaluate-form',
            'evaluate-answer',
        ];
        foreach ($studentPermissions as $permission) {
            $studentRole->givePermissionTo($permission);
        }

        $peerRole = Role::firstOrCreate(['name' => 'Peer']);
        $peerPermissions = [
            'peerDashboard',
            'evaluation-user',
            'evaluate-form',
            'evaluate-answer',
        ];
        foreach ($peerPermissions as $permission) {
            $peerRole->givePermissionTo($permission);
        }

        $supervisorRole = Role::firstOrCreate(['name' => 'Supervisor']);
        $supervisorPermissions = [
            'supervisorDashboard',
            'evaluation-user',
            'evaluate-form',
            'evaluate-answer',
        ];
        foreach ($supervisorPermissions as $permission) {
            $supervisorRole->givePermissionTo($permission);
        }
    }
}
