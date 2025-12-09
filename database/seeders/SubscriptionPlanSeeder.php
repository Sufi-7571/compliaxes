<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Free',
            'price' => 0,
            'max_websites' => 1,
            'scans_per_week' => 1,
            'pdf_export' => false,
            'fix_suggestions' => false,
            'api_access' => false,
            'issue_history' => false,
            'priority_scanning' => false,
            'max_pages_per_scan' => 5
        ]);

        SubscriptionPlan::create([
            'name' => 'Basic',
            'price' => 29.99,
            'max_websites' => 3,
            'scans_per_week' => null,
            'pdf_export' => true,
            'fix_suggestions' => true,
            'api_access' => false,
            'issue_history' => true,
            'priority_scanning' => false,
            'max_pages_per_scan' => 20
        ]);

        SubscriptionPlan::create([
            'name' => 'Pro',
            'price' => 99.99,
            'max_websites' => 20,
            'scans_per_week' => null, 
            'pdf_export' => true,
            'fix_suggestions' => true,
            'api_access' => true,
            'issue_history' => true,
            'priority_scanning' => true,
            'max_pages_per_scan' => 50
        ]);
    }
}
