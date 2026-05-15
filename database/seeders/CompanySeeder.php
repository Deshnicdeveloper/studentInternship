<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'TechCorp Solutions',
                'address' => '123 Innovation Drive',
                'city' => 'Tech City',
                'phone' => '555-1000',
                'email' => 'hr@techcorp.test',
                'website' => 'https://techcorp.test',
                'description' => 'A leading technology company specializing in software development and IT consulting.',
                'is_active' => true,
            ],
            [
                'name' => 'DataFlow Systems',
                'address' => '456 Data Lane',
                'city' => 'Analytics Town',
                'phone' => '555-2000',
                'email' => 'careers@dataflow.test',
                'website' => 'https://dataflow.test',
                'description' => 'Data analytics and business intelligence solutions provider.',
                'is_active' => true,
            ],
            [
                'name' => 'CloudNet Industries',
                'address' => '789 Cloud Avenue',
                'city' => 'Server City',
                'phone' => '555-3000',
                'email' => 'internships@cloudnet.test',
                'website' => 'https://cloudnet.test',
                'description' => 'Cloud infrastructure and DevOps services company.',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
