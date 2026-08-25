<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::firstOrCreate(
            ['title' => 'Qanun Marketplace'],
            [
                'sub_title' => 'Avianicare online shop, trusted for pet lovers',
                'category_tags' => 'Product Design, Custom Development',
                'description' => 'A comprehensive digital marketplace and legal platform built for scale, featuring high performance search, seamless payments, and intuitive user workflows.',
                'live_website_url' => 'https://example.com',
                'live_mobile_app_url' => 'https://example.com/app',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        \App\Models\Project::firstOrCreate(
            ['title' => 'Website redesign for United Finance Ltd'],
            [
                'sub_title' => 'Celebrating 35 Years of Financial Growth',
                'category_tags' => 'Website, UI UX Design, B2B Project',
                'description' => 'Complete modern corporate website overhaul for United Finance Ltd, streamlining customer deposit schemes, DPS portals, and financial advisory services.',
                'live_website_url' => 'https://example.com',
                'live_mobile_app_url' => null,
                'sort_order' => 2,
                'is_featured' => true,
            ]
        );

        \App\Models\Project::firstOrCreate(
            ['title' => 'Avianicare Mobile App'],
            [
                'sub_title' => 'Pet care marketplace & online pharmacy app',
                'category_tags' => 'Mobile App, Custom Solution',
                'description' => 'One-stop market for pet lovers offering mobile VET clinic booking, pet accessories, food delivery, and digital health records.',
                'live_website_url' => 'https://example.com',
                'live_mobile_app_url' => 'https://example.com/app',
                'sort_order' => 3,
                'is_featured' => true,
            ]
        );
    }
}
