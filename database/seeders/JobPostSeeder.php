<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\JobPostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        $categories = JobCategory::all();

        $jobPosts = [
            // Heavy Equipment Jobs
            [
                'company_id' => $companies->where('name', 'PT Trakindo Utama')->first()->id,
                'title' => 'Heavy Equipment Mechanic - Caterpillar Specialist',
                'thumbnail' => 'heavy-equipment-mechanic.jpg',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->where('name', 'PT United Tractors Tbk')->first()->id,
                'title' => 'Field Service Engineer - Mining Equipment',
                'thumbnail' => 'field-service-engineer.jpg',
                'status' => 'active'
            ],
            
            // Mining Jobs
            [
                'company_id' => $companies->where('name', 'PT Pamapersada Nusantara')->first()->id,
                'title' => 'Mining Engineer - Coal Operations',
                'thumbnail' => 'mining-engineer.jpg',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->where('name', 'PT Acset Indonusa')->first()->id,
                'title' => 'Safety & Health Officer - Mining Operations',
                'thumbnail' => 'safety-health-officer.jpg',
                'status' => 'active'
            ],
            
            // IT & Technology Jobs
            [
                'company_id' => $companies->where('name', 'PT UT Digital Solutions')->first()->id,
                'title' => 'IoT Engineer - Industrial Digitalization',
                'thumbnail' => 'iot-engineer.jpg',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->where('name', 'PT United Tractors Semen Gresik')->first()->id,
                'title' => 'ERP Consultant - SAP Implementation',
                'thumbnail' => 'erp-consultant.jpg',
                'status' => 'active'
            ],
            
            // Engineering & Construction
            [
                'company_id' => $companies->where('name', 'PT United Tractors Pandu Engineering')->first()->id,
                'title' => 'Mechanical Engineer - Heavy Equipment Design',
                'thumbnail' => 'mechanical-engineer.jpg',
                'status' => 'active'
            ],
            
            // Logistics & Business
            [
                'company_id' => $companies->where('name', 'PT Intraco Penta')->first()->id,
                'title' => 'Supply Chain Manager - Heavy Equipment Parts',
                'thumbnail' => 'supply-chain-manager.jpg',
                'status' => 'active'
            ]
        ];

        foreach ($jobPosts as $jobData) {
            $jobPost = JobPost::create($jobData);
            
            // Attach specific job categories based on job title
            $jobTitle = $jobData['title'];
            $attachments = [];
            
            if (str_contains($jobTitle, 'Heavy Equipment Mechanic')) {
                $attachments = [
                    ['category' => 'Heavy Equipment Mechanic', 'type' => 'full_time', 'count' => 3],
                    ['category' => 'Parts & Service Technician', 'type' => 'full_time', 'count' => 2]
                ];
            } elseif (str_contains($jobTitle, 'Field Service Engineer')) {
                $attachments = [
                    ['category' => 'Field Service Engineer', 'type' => 'full_time', 'count' => 2],
                    ['category' => 'Equipment Maintenance Engineer', 'type' => 'full_time', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'Mining Engineer')) {
                $attachments = [
                    ['category' => 'Mining Engineer', 'type' => 'full_time', 'count' => 2],
                    ['category' => 'Mine Planning Specialist', 'type' => 'full_time', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'Safety & Health Officer')) {
                $attachments = [
                    ['category' => 'Safety & Health Officer', 'type' => 'full_time', 'count' => 1],
                    ['category' => 'Environmental Specialist', 'type' => 'contract', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'IoT Engineer')) {
                $attachments = [
                    ['category' => 'IoT Engineer', 'type' => 'full_time', 'count' => 2],
                    ['category' => 'Software Developer', 'type' => 'full_time', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'ERP Consultant')) {
                $attachments = [
                    ['category' => 'ERP Consultant', 'type' => 'contract', 'count' => 1],
                    ['category' => 'Business Analyst', 'type' => 'full_time', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'Mechanical Engineer')) {
                $attachments = [
                    ['category' => 'Mechanical Engineer', 'type' => 'full_time', 'count' => 2],
                    ['category' => 'Design Engineer', 'type' => 'full_time', 'count' => 1]
                ];
            } elseif (str_contains($jobTitle, 'Supply Chain Manager')) {
                $attachments = [
                    ['category' => 'Supply Chain Manager', 'type' => 'full_time', 'count' => 1],
                    ['category' => 'Procurement Specialist', 'type' => 'full_time', 'count' => 2]
                ];
            }
            
            foreach ($attachments as $attachment) {
                $category = $categories->where('name', $attachment['category'])->first();
                if ($category) {
                    JobPostCategory::create([
                        'job_post_id' => $jobPost->id,
                        'job_category_id' => $category->id,
                        'type' => $attachment['type'],
                        'required_count' => $attachment['count']
                    ]);
                }
            }
        }
    }
}
