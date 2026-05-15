<?php

namespace Database\Seeders;

use App\Models\Internship;
use Illuminate\Database\Seeder;

class InternshipSeeder extends Seeder
{
    public function run(): void
    {
        $internships = [
            [
                'company_id' => 1,
                'title' => 'Software Developer Intern',
                'description' => 'Join our development team to work on cutting-edge web applications using Laravel and Vue.js.',
                'start_date' => now()->addMonths(1),
                'end_date' => now()->addMonths(4),
                'slots' => 3,
                'is_active' => true,
            ],
            [
                'company_id' => 2,
                'title' => 'Data Analyst Intern',
                'description' => 'Work with our data team to analyze large datasets and create insightful reports.',
                'start_date' => now()->addMonths(1),
                'end_date' => now()->addMonths(3),
                'slots' => 2,
                'is_active' => true,
            ],
            [
                'company_id' => 3,
                'title' => 'DevOps Engineer Intern',
                'description' => 'Learn about cloud infrastructure, CI/CD pipelines, and container orchestration.',
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(5),
                'slots' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($internships as $internship) {
            Internship::create($internship);
        }
    }
}
