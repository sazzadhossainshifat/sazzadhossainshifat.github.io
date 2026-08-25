<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Experience::firstOrCreate(
            ['company_name' => 'Softvence Agency'],
            [
                'location' => 'Dhaka',
                'designation' => 'Mid-level Laravel Developer',
                'duration' => 'July 2025 - Present',
                'sort_order' => 1,
            ]
        );

        \App\Models\Experience::firstOrCreate(
            ['company_name' => 'Infolook'],
            [
                'location' => 'Dhaka',
                'designation' => 'Laravel Developer / Project Lead',
                'duration' => 'July 2023 - June 2025',
                'sort_order' => 2,
            ]
        );

        \App\Models\Experience::firstOrCreate(
            ['company_name' => 'Astha Insight'],
            [
                'location' => 'Rajshahi',
                'designation' => 'Back-End Developer',
                'duration' => 'December 2024 - July 2025',
                'sort_order' => 3,
            ]
        );
    }
}
