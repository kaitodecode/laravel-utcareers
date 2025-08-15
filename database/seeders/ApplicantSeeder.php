<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\JobPostCategory;
use App\Models\Selection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with 'pelamar' role first
        $users = [];
        $userData = [
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@email.com',
                'phone' => '+62-812-3456-7890',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Industri Raya No. 45, Cakung, Jakarta Timur 13910',
                'description' => 'Heavy Equipment Mechanic dengan 8 tahun pengalaman maintenance Caterpillar excavator dan bulldozer. Bersertifikat Caterpillar Service Technician.'
            ],
            [
                'name' => 'Sari Dewi',
                'email' => 'sari.dewi@email.com', 
                'phone' => '+62-813-4567-8901',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat 10220',
                'description' => 'Software Developer dengan 5 tahun pengalaman dalam pengembangan aplikasi web menggunakan Laravel dan React.'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '+62-814-5678-9012', 
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Gatot Subroto No. 456, Jakarta Selatan 12930',
                'description' => 'Mining Engineer dengan 10 tahun pengalaman dalam operasi tambang batubara dan mineral.'
            ],
            [
                'name' => 'Rina Kartika',
                'email' => 'rina.kartika@email.com',
                'phone' => '+62-815-6789-0123',
                'password' => bcrypt('password123'),
                'role' => 'pelamar', 
                'address' => 'Jl. HR Rasuna Said No. 789, Jakarta Selatan 12940',
                'description' => 'Data Analyst dengan 4 tahun pengalaman dalam analisis data dan business intelligence.'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@email.com',
                'phone' => '+62-816-7890-1234',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Thamrin No. 321, Jakarta Pusat 10230',
                'description' => 'Mechanical Engineer dengan 7 tahun pengalaman dalam maintenance dan repair heavy machinery.'
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya.putri@email.com',
                'phone' => '+62-817-8901-2345',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Kebon Jeruk No. 567, Jakarta Barat 11530',
                'description' => 'Human Resource Manager dengan 6 tahun pengalaman dalam recruitment dan employee relations.'
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@email.com',
                'phone' => '+62-818-9012-3456',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Pemuda No. 789, Jakarta Timur 13220',
                'description' => 'Electrical Engineer dengan 9 tahun pengalaman dalam industrial automation dan power systems.'
            ],
            [
                'name' => 'Nina Safitri',
                'email' => 'nina.safitri@email.com',
                'phone' => '+62-819-0123-4567',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Hayam Wuruk No. 234, Jakarta Pusat 10120',
                'description' => 'Marketing Manager dengan 7 tahun pengalaman dalam digital marketing dan brand development.'
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@email.com',
                'phone' => '+62-820-1234-5678',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Mangga Dua No. 345, Jakarta Utara 14430',
                'description' => 'Supply Chain Manager dengan 8 tahun pengalaman dalam logistics dan inventory management.'
            ],
            [
                'name' => 'Lisa Anggraini',
                'email' => 'lisa.anggraini@email.com',
                'phone' => '+62-821-2345-6789',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Pluit Raya No. 678, Jakarta Utara 14450',
                'description' => 'Financial Analyst dengan 5 tahun pengalaman dalam investment banking dan financial modeling.'
            ]
        ];

        // Create users and store them
        foreach ($userData as $data) {
            $users[] = User::create($data);
        }

        // Get all job post categories
        $jobPostCategories = JobPostCategory::all();
        
        // Define selection stages and statuses
        $stages = ['portfolio', 'interview', 'medical_checkup'];
        $statuses = ['pending', 'in_review', 'accepted', 'rejected'];

        // For each user, create at least 2 applicants
        foreach ($users as $user) {
            // Create 2-3 applicants for each user
            $applicantCount = rand(2, 3);
            
            for ($i = 1; $i <= $applicantCount; $i++) {
                $applicant = Applicant::create([
                    'user_id' => $user->id,
                    'job_post_category_id' => $jobPostCategories->random()->id,
                    'status' => 'pending',
                    'cv' => 'cv/cv_' . $user->name . '_' . $i . '.pdf',
                    'national_identity_card' => 'ktp/ktp_' . $user->name . '_' . $i . '.pdf',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Create exactly 3 selections for each applicant with different states
                foreach ($stages as $index => $stage) {
                    // Ensure different statuses for each selection
                    
                    Selection::create([
                        'applicant_id' => $applicant->id,
                        'job_post_category_id' => $applicant->job_post_category_id,
                        'stage' => $stage,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}
