<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Metadata\Test;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'client_name' => 'Jane Doe',
            'client_company' => 'Tech Solutions',
            'client_position' => 'CTO',
            'client_logo' => 'logos/tech_solutions.png',
            'testimonial_text' => 'CompliAxes has transformed our compliance processes. Highly recommended!',
            'rating' => 5,
            'is_active' => true
        ]);

        Testimonial::create([
            'client_name' => 'John Smith',
            'client_company' => 'Innovatech',
            'client_position' => 'CEO',
            'client_logo' => 'logos/innovatech.png',
            'testimonial_text' => 'The team at CompliAxes is exceptional. Their expertise is unmatched.',
            'rating' => 4,
            'is_active' => true
        ]);

        Testimonial::create([
            'client_name' => 'Emily Johnson',
            'client_company' => 'Creative Minds',
            'client_position' => 'Marketing Director',
            'client_logo' => 'logos/creative_minds.png',
            'testimonial_text' => 'Our experience with CompliAxes has been fantastic. They truly care about their clients.',
            'rating' => 5,
            'is_active' => true
        ]);

        Testimonial::create([
            'client_name' => 'Michael Brown',
            'client_company' => 'NextGen Corp',
            'client_position' => 'Product Manager',
            'client_logo' => 'logos/nextgen_corp.png',
            'testimonial_text' => 'Reliable and efficient service from CompliAxes. They exceeded our expectations.',
            'rating' => 4,
            'is_active' => true
        ]);
    }
}
