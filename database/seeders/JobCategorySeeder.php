<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Heavy Equipment & Machinery
            'Heavy Equipment Operator',
            'Heavy Equipment Mechanic',
            'Heavy Equipment Sales',
            'Parts & Service Technician',
            'Equipment Maintenance Engineer',
            'Field Service Engineer',
            'Product Support Representative',
            
            // Mining Operations
            'Mining Engineer',
            'Geologist',
            'Mine Planning Specialist',
            'Safety & Health Officer',
            'Environmental Specialist',
            'Drilling Supervisor',
            'Blasting Engineer',
            'Mine Surveyor',
            'Coal Quality Analyst',
            'Production Supervisor',
            
            // IT & Technology
            'Software Developer',
            'System Administrator',
            'Network Engineer',
            'Database Administrator',
            'Cybersecurity Specialist',
            'Data Analyst',
            'IoT Engineer',
            'AI/ML Engineer',
            'DevOps Engineer',
            'Mobile App Developer',
            'Web Developer',
            'IT Support Specialist',
            'ERP Consultant',
            'Digital Transformation Specialist',
            
            // Engineering & Construction
            'Mechanical Engineer',
            'Electrical Engineer',
            'Civil Engineer',
            'Project Engineer',
            'Design Engineer',
            'Quality Control Engineer',
            'HSE Engineer',
            'Construction Manager',
            'Site Supervisor',
            
            // Business & Management
            'Project Manager',
            'Business Analyst',
            'Operations Manager',
            'Supply Chain Manager',
            'Procurement Specialist',
            'Finance Manager',
            'Human Resources',
            'Marketing Specialist',
            'Sales Manager',
            'Customer Service Representative',
            
            // Logistics & Transportation
            'Logistics Coordinator',
            'Fleet Manager',
            'Warehouse Supervisor',
            'Transportation Planner',
            'Inventory Control Specialist'
        ];

        foreach ($categories as $categoryName) {
            JobCategory::create([
                'name' => $categoryName
            ]);
        }
    }
}
