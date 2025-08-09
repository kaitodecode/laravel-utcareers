<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\JobPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some users first if they don't exist
        $users = [];
        $userData = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@email.com',
                'phone' => '081234567890',
                'password' => bcrypt('password'),
                'role' => 'pelamar',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'description' => 'Fresh graduate dengan passion di bidang teknologi'
            ],
            [
                'name' => 'Sari Dewi',
                'email' => 'sari.dewi@email.com',
                'phone' => '081234567891',
                'password' => bcrypt('password'),
                'role' => 'pelamar',
                'address' => 'Jl. Sudirman No. 456, Bandung',
                'description' => 'UI/UX Designer dengan 2 tahun pengalaman'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567892',
                'password' => bcrypt('password'),
                'role' => 'pelamar',
                'address' => 'Jl. Thamrin No. 789, Surabaya',
                'description' => 'Data Scientist dengan background matematika'
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya.putri@email.com',
                'phone' => '081234567893',
                'password' => bcrypt('password'),
                'role' => 'pelamar',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'description' => 'Mobile Developer dengan pengalaman Flutter'
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi.wijaya@email.com',
                'phone' => '081234567894',
                'password' => bcrypt('password'),
                'role' => 'pelamar',
                'address' => 'Jl. Pemuda No. 654, Semarang',
                'description' => 'Digital Marketing Specialist dengan track record yang baik'
            ]
        ];

        foreach ($userData as $data) {
            $users[] = User::create($data);
        }

        $jobPosts = JobPost::all();

        // Create applications
        $applications = [
            [
                'user_id' => $users[0]->id,
                'job_id' => $jobPosts->first()->id,
                'status' => 'pending',
                'cv' => 'cv/ahmad_rizki_cv.pdf',
                'national_identity_card' => 'ktp/ahmad_rizki_ktp.pdf'
            ],
            [
                'user_id' => $users[1]->id,
                'job_id' => $jobPosts->skip(1)->first()->id,
                'status' => 'selection',
                'cv' => 'cv/sari_dewi_cv.pdf',
                'national_identity_card' => 'ktp/sari_dewi_ktp.pdf'
            ],
            [
                'user_id' => $users[2]->id,
                'job_id' => $jobPosts->skip(2)->first()->id,
                'status' => 'pending',
                'cv' => 'cv/budi_santoso_cv.pdf',
                'national_identity_card' => 'ktp/budi_santoso_ktp.pdf'
            ],
            [
                'user_id' => $users[3]->id,
                'job_id' => $jobPosts->skip(3)->first()->id,
                'status' => 'accepted',
                'cv' => 'cv/maya_putri_cv.pdf',
                'national_identity_card' => 'ktp/maya_putri_ktp.pdf'
            ],
            [
                'user_id' => $users[4]->id,
                'job_id' => $jobPosts->skip(4)->first()->id,
                'status' => 'pending',
                'cv' => 'cv/andi_wijaya_cv.pdf',
                'national_identity_card' => 'ktp/andi_wijaya_ktp.pdf'
            ],
            [
                'user_id' => $users[0]->id,
                'job_id' => $jobPosts->skip(5)->first()->id,
                'status' => 'rejected',
                'cv' => 'cv/ahmad_rizki_cv.pdf',
                'national_identity_card' => 'ktp/ahmad_rizki_ktp.pdf'
            ]
        ];

        foreach ($applications as $application) {
            Applicant::create($application);
        }
    }
}
