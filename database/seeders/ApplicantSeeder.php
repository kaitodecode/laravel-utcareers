<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\JobPostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with 'pelamar' role first - focused on heavy equipment, mining, and IT professionals
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
                'name' => 'Indira Sari Dewi',
                'email' => 'indira.dewi@email.com',
                'phone' => '+62-813-4567-8901',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Balikpapan Baru No. 123, Balikpapan, Kalimantan Timur 76127',
                'description' => 'Mining Engineer lulusan ITB dengan pengalaman 4 tahun di operasi tambang batubara. Menguasai MineSight dan Surpac untuk mine planning.'
            ],
            [
                'name' => 'Rizky Pratama Putra',
                'email' => 'rizky.pratama@email.com',
                'phone' => '+62-814-5678-9012',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Cyber 2 Tower No. 88, Jakarta Selatan 12950',
                'description' => 'IoT Engineer dengan expertise dalam embedded systems dan cloud computing. Berpengalaman mengembangkan solusi digitalisasi untuk industri manufaktur.'
            ],
            [
                'name' => 'Sari Wulandari',
                'email' => 'sari.wulandari@email.com',
                'phone' => '+62-815-6789-0123',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Veteran No. 234, Gresik, Jawa Timur 61122',
                'description' => 'SAP Consultant dengan sertifikasi SAP S/4HANA MM dan PP. Pengalaman 6 tahun implementasi ERP di industri manufaktur dan semen.'
            ],
            [
                'name' => 'Bambang Sutrisno',
                'email' => 'bambang.sutrisno@email.com',
                'phone' => '+62-816-7890-1234',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Soekarno Hatta Km. 25, Samarinda, Kalimantan Timur 75124',
                'description' => 'Safety & Health Officer dengan sertifikat Ahli K3 Umum dan NEBOSH. Pengalaman 10 tahun di industri pertambangan dan konstruksi.'
            ],
            [
                'name' => 'Dewi Kartika Sari',
                'email' => 'dewi.kartika@email.com',
                'phone' => '+62-817-8901-2345',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Kawasan Industri Pulogadung, Jakarta Timur 13920',
                'description' => 'Mechanical Engineer dengan spesialisasi hydraulic systems dan product design. Menguasai SolidWorks dan AutoCAD untuk engineering design.'
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@email.com',
                'phone' => '+62-818-9012-3456',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Pangeran Jayakarta No. 200, Jakarta Pusat 10730',
                'description' => 'Supply Chain Manager dengan pengalaman 12 tahun di industri otomotif dan alat berat. Expert dalam inventory optimization dan vendor management.'
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@email.com',
                'phone' => '+62-819-0123-4567',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Rasuna Said No. 100, Jakarta Selatan 12950',
                'description' => 'Field Service Engineer dengan pengalaman commissioning dan troubleshooting alat berat di site tambang. Mobile ke seluruh Indonesia.'
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@email.com',
                'phone' => '+62-820-1234-5678',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Sudirman No. 300, Palembang, Sumatera Selatan 30126',
                'description' => 'Geologist dengan pengalaman eksplorasi mineral dan evaluasi deposit batubara. Menguasai software geologi dan GIS mapping.'
            ],
            [
                'name' => 'Lisa Permata Sari',
                'email' => 'lisa.permata@email.com',
                'phone' => '+62-821-2345-6789',
                'password' => bcrypt('password123'),
                'role' => 'pelamar',
                'address' => 'Jl. Teknologi No. 150, Bandung, Jawa Barat 40132',
                'description' => 'Data Analyst dengan fokus pada predictive maintenance dan industrial IoT. Menguasai Python, R, dan machine learning untuk analisis data operasional.'
            ]
        ];

        foreach ($userData as $data) {
            $users[] = User::create($data);
        }

        $jobPostCategories = JobPostCategory::all();

        // Create applications with more realistic applications based on job types
        $applications = [
            // Heavy Equipment Mechanic applications
            [
                'user_id' => $users[0]->id, // Agus Setiawan (Heavy Equipment Mechanic)
                'job_post_category_id' => $jobPostCategories->skip(0)->first()->id,
                'status' => 'selection',
                'cv' => 'cv/agus_setiawan_mechanic_cv.pdf',
                'national_identity_card' => 'ktp/agus_setiawan_ktp.jpg'
            ],
            [
                'user_id' => $users[7]->id, // Fitri Handayani (Field Service Engineer)
                'job_post_category_id' => $jobPostCategories->skip(1)->first()->id,
                'status' => 'accepted',
                'cv' => 'cv/fitri_handayani_field_engineer_cv.pdf',
                'national_identity_card' => 'ktp/fitri_handayani_ktp.jpg'
            ],
            
            // Mining Engineer applications
            [
                'user_id' => $users[1]->id, // Indira Sari Dewi (Mining Engineer)
                'job_post_category_id' => $jobPostCategories->skip(2)->first()->id,
                'status' => 'pending',
                'cv' => 'cv/indira_dewi_mining_engineer_cv.pdf',
                'national_identity_card' => 'ktp/indira_dewi_ktp.jpg'
            ],
            [
                'user_id' => $users[8]->id, // Hendra Gunawan (Geologist)
                'job_post_category_id' => $jobPostCategories->skip(3)->first()->id,
                'status' => 'selection',
                'cv' => 'cv/hendra_gunawan_geologist_cv.pdf',
                'national_identity_card' => 'ktp/hendra_gunawan_ktp.jpg'
            ],
            
            // Safety Officer applications
            [
                'user_id' => $users[4]->id, // Bambang Sutrisno (Safety Officer)
                'job_post_category_id' => $jobPostCategories->skip(4)->first()->id,
                'status' => 'accepted',
                'cv' => 'cv/bambang_sutrisno_safety_cv.pdf',
                'national_identity_card' => 'ktp/bambang_sutrisno_ktp.jpg'
            ],
            
            // IT & Technology applications
            [
                'user_id' => $users[2]->id, // Rizky Pratama (IoT Engineer)
                'job_post_category_id' => $jobPostCategories->skip(5)->first()->id,
                'status' => 'selection',
                'cv' => 'cv/rizky_pratama_iot_engineer_cv.pdf',
                'national_identity_card' => 'ktp/rizky_pratama_ktp.jpg'
            ],
            [
                'user_id' => $users[3]->id, // Sari Wulandari (SAP Consultant)
                'job_post_category_id' => $jobPostCategories->skip(6)->first()->id ?? $jobPostCategories->first()->id,
                'status' => 'pending',
                'cv' => 'cv/sari_wulandari_sap_consultant_cv.pdf',
                'national_identity_card' => 'ktp/sari_wulandari_ktp.jpg'
            ],
            [
                'user_id' => $users[9]->id, // Lisa Permata (Data Analyst)
                'job_post_category_id' => $jobPostCategories->skip(7)->first()->id ?? $jobPostCategories->first()->id,
                'status' => 'rejected',
                'cv' => 'cv/lisa_permata_data_analyst_cv.pdf',
                'national_identity_card' => 'ktp/lisa_permata_ktp.jpg'
            ],
            
            // Engineering applications
            [
                'user_id' => $users[5]->id, // Dewi Kartika (Mechanical Engineer)
                'job_post_category_id' => $jobPostCategories->skip(8)->first()->id ?? $jobPostCategories->first()->id,
                'status' => 'selection',
                'cv' => 'cv/dewi_kartika_mechanical_engineer_cv.pdf',
                'national_identity_card' => 'ktp/dewi_kartika_ktp.jpg'
            ],
            
            // Supply Chain applications
            [
                'user_id' => $users[6]->id, // Eko Prasetyo (Supply Chain Manager)
                'job_post_category_id' => $jobPostCategories->skip(9)->first()->id ?? $jobPostCategories->first()->id,
                'status' => 'pending',
                'cv' => 'cv/eko_prasetyo_supply_chain_cv.pdf',
                'national_identity_card' => 'ktp/eko_prasetyo_ktp.jpg'
            ],
            
            // Cross applications (same person applying to multiple jobs)
            [
                'user_id' => $users[0]->id, // Agus Setiawan applying to another position
                'job_post_category_id' => $jobPostCategories->skip(1)->first()->id,
                'status' => 'pending',
                'cv' => 'cv/agus_setiawan_field_service_cv.pdf',
                'national_identity_card' => 'ktp/agus_setiawan_ktp.jpg'
            ],
            [
                'user_id' => $users[2]->id, // Rizky Pratama applying to another position
                'job_post_category_id' => $jobPostCategories->skip(6)->first()->id ?? $jobPostCategories->first()->id,
                'status' => 'rejected',
                'cv' => 'cv/rizky_pratama_erp_cv.pdf',
                'national_identity_card' => 'ktp/rizky_pratama_ktp.jpg'
            ]
        ];

        foreach ($applications as $application) {
            Applicant::create($application);
        }
    }
}
