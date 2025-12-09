<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::create([
            'title' => 'Automated AI Remediation',
            'description' => 'Cutting-edge AI technology that automatically scans and fixes accessibility issues on your website every 24 hours.',
            'icon' => 'robot',
            'order' => 1,
            'is_active' => true
        ]);

        Service::create([
            'title' => 'Expert Testing & Custom Fixes',
            'description' => 'Manual testing of key user flows with custom accessibility fixes to close gaps that automation cannot handle.',
            'icon' => 'users',
            'order' => 2,
            'is_active' => true
        ]);

        Service::create([
            'title' => 'Litigation Support',
            'description' => 'Dedicated case manager, detailed claims analysis, ADA attorney consultation, plus financial protection pledge.',
            'icon' => 'shield',
            'order' => 3,
            'is_active' => true
        ]);

        Service::create([
            'title' => 'VPAT Documentation',
            'description' => 'Comprehensive Voluntary Product Accessibility Template to document your compliance status.',
            'icon' => 'file-text',
            'order' => 4,
            'is_active' => true
        ]);

        Service::create([
            'title' => 'User Testing',
            'description' => 'Real end-user testing with people with disabilities to ensure optimal accessibility.',
            'icon' => 'check-circle',
            'order' => 5,
            'is_active' => true
        ]);

        Service::create([
            'title' => 'Expert Audit',
            'description' => 'Comprehensive manual accessibility audit conducted by certified accessibility experts.',
            'icon' => 'search',
            'order' => 6,
            'is_active' => true
        ]);
    }
}
