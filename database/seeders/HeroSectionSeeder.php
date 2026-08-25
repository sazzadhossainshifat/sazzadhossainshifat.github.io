<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\HeroSection::firstOrCreate(
            ['id' => 1],
            [
                'brand_name' => "Sazzad's Dev.",
                'name' => "Sazzad Hossain",
                'work_details' => "Senior Full-Stack Developer & AI Engineer",
                'description' => "I build scalable, modern web applications and AI-driven solutions tailored for modern businesses.",
                'consultancy_button_text' => "GET FREE CONSULTANCY",
                'consultancy_button_url' => "#contact",
                'talk_button_text' => "LET'S TALK",
                'talk_button_url' => "#contact",
                'avatar_path' => null,
                'video_path' => null,
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('admin'),
            ]
        );
    }
}
