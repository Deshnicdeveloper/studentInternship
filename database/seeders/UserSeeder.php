<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@sims.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Coordinator
        $coordinator = User::create([
            'name' => 'John Coordinator',
            'email' => 'coordinator@sims.test',
            'password' => Hash::make('password'),
            'phone' => '555-0101',
            'department' => 'Computer Science',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);
        $coordinator->assignRole('coordinator');

        // Supervisors
        $supervisors = [
            ['name' => 'Sarah Supervisor', 'email' => 'supervisor1@sims.test', 'phone' => '555-0201'],
            ['name' => 'Mike Manager', 'email' => 'supervisor2@sims.test', 'phone' => '555-0202'],
        ];
        foreach ($supervisors as $data) {
            $supervisor = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => $data['phone'],
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            $supervisor->assignRole('supervisor');
        }

        // Students
        $students = [
            ['name' => 'Alice Student', 'email' => 'student1@sims.test', 'student_id' => 'STU001', 'department' => 'Computer Science'],
            ['name' => 'Bob Learner', 'email' => 'student2@sims.test', 'student_id' => 'STU002', 'department' => 'Information Technology'],
            ['name' => 'Carol Intern', 'email' => 'student3@sims.test', 'student_id' => 'STU003', 'department' => 'Computer Science'],
            ['name' => 'David Scholar', 'email' => 'student4@sims.test', 'student_id' => 'STU004', 'department' => 'Software Engineering'],
            ['name' => 'Eve Trainee', 'email' => 'student5@sims.test', 'student_id' => 'STU005', 'department' => 'Computer Science'],
        ];
        foreach ($students as $data) {
            $student = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'student_id' => $data['student_id'],
                'department' => $data['department'],
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            $student->assignRole('student');
        }
    }
}
