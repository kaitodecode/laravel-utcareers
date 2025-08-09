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
            ['name' => 'Software Development'],
            ['name' => 'Web Development'],
            ['name' => 'Mobile Development'],
            ['name' => 'Data Science'],
            ['name' => 'UI/UX Design'],
            ['name' => 'Digital Marketing'],
            ['name' => 'Project Management'],
            ['name' => 'Quality Assurance'],
            ['name' => 'DevOps'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Business Analysis'],
            ['name' => 'Content Writing'],
            ['name' => 'Graphic Design'],
            ['name' => 'Sales & Marketing'],
            ['name' => 'Human Resources']
        ];

        foreach ($categories as $category) {
            JobCategory::create($category);
        }
    }
}
