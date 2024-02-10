<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
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
            'studentDashboard',
            'peerDashboard',
            'supervisorDashboard',
            'evaluation-list',
            'evaluation-user',
            'evaluation-create',
            'evaluation-edit',
            'evaluation-delete',
            'evaluate-form',
            'evaluate-answer',
            'settings-list',
            'settings-update'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
