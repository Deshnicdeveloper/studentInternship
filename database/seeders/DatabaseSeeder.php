<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Create Admin User
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@sims.test',
            'password' => Hash::make('password'),
            'phone' => '123-456-7890',
            'department' => 'IT Department',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Coordinator User
        $coordinator = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'coordinator@sims.test',
            'password' => Hash::make('password'),
            'phone' => '123-456-7891',
            'department' => 'Computer Science',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $coordinator->assignRole('coordinator');

        // Create Supervisor Users
        $supervisor1 = User::create([
            'name' => 'John Smith',
            'email' => 'supervisor1@sims.test',
            'password' => Hash::make('password'),
            'phone' => '123-456-7892',
            'department' => 'Engineering',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $supervisor1->assignRole('supervisor');

        $supervisor2 = User::create([
            'name' => 'Emily Davis',
            'email' => 'supervisor2@sims.test',
            'password' => Hash::make('password'),
            'phone' => '123-456-7893',
            'department' => 'Software Development',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $supervisor2->assignRole('supervisor');

        // Create Student Users
        $students = [
            [
                'name' => 'Alice Brown',
                'email' => 'student1@sims.test',
                'student_id' => 'STU001',
                'department' => 'Computer Science',
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'student2@sims.test',
                'student_id' => 'STU002',
                'department' => 'Information Technology',
            ],
            [
                'name' => 'Carol Martinez',
                'email' => 'student3@sims.test',
                'student_id' => 'STU003',
                'department' => 'Computer Science',
            ],
            [
                'name' => 'David Lee',
                'email' => 'student4@sims.test',
                'student_id' => 'STU004',
                'department' => 'Software Engineering',
            ],
            [
                'name' => 'Eva Chen',
                'email' => 'student5@sims.test',
                'student_id' => 'STU005',
                'department' => 'Computer Science',
            ],
        ];

        foreach ($students as $studentData) {
            $student = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'student_id' => $studentData['student_id'],
                'phone' => '123-456-' . rand(1000, 9999),
                'department' => $studentData['department'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $student->assignRole('student');
        }

        // Create Companies
        $company1 = Company::create([
            'name' => 'TechCorp Solutions',
            'address' => '123 Innovation Drive, Silicon Valley, CA 94025',
            'industry' => 'Technology',
            'contact_person' => 'Michael Roberts',
            'contact_email' => 'hr@techcorp.com',
            'contact_phone' => '555-100-2000',
            'website' => 'https://www.techcorp.com',
            'is_active' => true,
        ]);

        $company2 = Company::create([
            'name' => 'DataDrive Analytics',
            'address' => '456 Data Street, Austin, TX 78701',
            'industry' => 'Data Science',
            'contact_person' => 'Jennifer White',
            'contact_email' => 'careers@datadrive.com',
            'contact_phone' => '555-200-3000',
            'website' => 'https://www.datadrive.com',
            'is_active' => true,
        ]);

        $company3 = Company::create([
            'name' => 'CloudNine Systems',
            'address' => '789 Cloud Avenue, Seattle, WA 98101',
            'industry' => 'Cloud Computing',
            'contact_person' => 'Robert Taylor',
            'contact_email' => 'internships@cloudnine.com',
            'contact_phone' => '555-300-4000',
            'website' => 'https://www.cloudnine.com',
            'is_active' => true,
        ]);

        // Create Internships
        Internship::create([
            'company_id' => $company1->id,
            'title' => 'Software Development Intern',
            'description' => 'Join our software development team to work on cutting-edge web applications. You will learn modern frameworks, best practices, and collaborate with experienced developers.',
            'slots' => 3,
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonths(4),
            'is_active' => true,
        ]);

        Internship::create([
            'company_id' => $company2->id,
            'title' => 'Data Analytics Intern',
            'description' => 'Work with our data science team to analyze large datasets, create visualizations, and help derive insights. Experience with Python and SQL is a plus.',
            'slots' => 2,
            'start_date' => now()->addMonth(),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Internship::create([
            'company_id' => $company3->id,
            'title' => 'Cloud Infrastructure Intern',
            'description' => 'Assist in managing and optimizing cloud infrastructure. Learn about AWS, Azure, and containerization technologies while working on real-world projects.',
            'slots' => 2,
            'start_date' => now()->addWeeks(2),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        // Seed default settings
        Setting::set('system_name', 'SIMS');
        Setting::set('contact_email', 'admin@sims.test');
        Setting::set('academic_year', '2025/2026');

        $this->command->info('Database seeded successfully!');
        $this->command->newLine();
        $this->command->info('Test Accounts:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@sims.test', 'password'],
                ['Coordinator', 'coordinator@sims.test', 'password'],
                ['Supervisor 1', 'supervisor1@sims.test', 'password'],
                ['Supervisor 2', 'supervisor2@sims.test', 'password'],
                ['Student 1', 'student1@sims.test', 'password'],
                ['Student 2', 'student2@sims.test', 'password'],
                ['Student 3', 'student3@sims.test', 'password'],
                ['Student 4', 'student4@sims.test', 'password'],
                ['Student 5', 'student5@sims.test', 'password'],
            ]
        );
    }
}
