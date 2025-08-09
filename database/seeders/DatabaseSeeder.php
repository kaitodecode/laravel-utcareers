<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin UTCareers',
            'email' => 'admin@utcareers.com',
            'phone' => '081234567899',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'address' => 'Jl. Admin No. 1, Jakarta',
            'description' => 'Administrator sistem UTCareers',
            'verified_at' => now(),

        ]);

        User::create([
            'name' => 'User UTCareers',
            'email' => 'user@utcareers.com',
            'phone' => '6289518210175',
            'password' => bcrypt('password'),
            'role' => 'pelamar',
            'address' => 'Jl. User No. 1, Jakarta',
            'description' => 'User sistem UTCareers',
            'verified_at' => now(),
        ]);

        // Run seeders in correct order
        $this->call([
            CompanySeeder::class,
            JobCategorySeeder::class,
            JobPostSeeder::class,
            ApplicantSeeder::class,
            SelectionSeeder::class,
        ]);
    }
}
