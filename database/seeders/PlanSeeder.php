<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{

    public function run(): void
    {
        Plan::create([
            'name' => 'Micro',
            'price' => 490,
            'billing_period' => 'yearly',
            'features' => [
                'ADA & WCAG 2.1 compliance',
                'Automated AI remediation',
                'Screen reader support',
                'Keyboard navigation',
                '24-hour updates'
            ],
            'is_popular' => false,
            'order' => 1
        ]);

        Plan::create([
            'name' => 'Growth',
            'price' => 1490,
            'billing_period' => 'yearly',
            'features' => [
                'Everything in Micro',
                'Priority support',
                'Custom branding',
                'Advanced analytics',
                'Litigation support'
            ],
            'is_popular' => false,
            'order' => 2
        ]);

        Plan::create([
            'name' => 'Scale',
            'price' => 3990,
            'billing_period' => 'yearly',
            'features' => [
                'Everything in Growth',
                'Expert manual testing',
                'Custom accessibility fixes',
                'Dedicated account manager',
                'White-label options'
            ],
            'is_popular' => true,
            'order' => 3
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'price' => 0,
            'billing_period' => 'yearly',
            'features' => [
                'Everything in Scale',
                'Custom SLA',
                'Multi-site management',
                'API access',
                'Training sessions'
            ],
            'is_popular' => false,
            'order' => 4
        ]);
    }
}
