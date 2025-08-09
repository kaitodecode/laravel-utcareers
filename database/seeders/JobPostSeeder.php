<?php

namespace Database\Seeders;

use App\Models\JobPost;
use App\Models\Company;
use App\Models\JobCategory;
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
            [
                'company_id' => $companies->first()->id,
                'title' => 'Senior Full Stack Developer',
                'description' => 'Kami mencari Senior Full Stack Developer yang berpengalaman untuk bergabung dengan tim pengembangan kami. Kandidat ideal memiliki pengalaman dalam pengembangan aplikasi web modern.',
                'requirements' => 'Minimal 5 tahun pengalaman dalam pengembangan web, Menguasai JavaScript, PHP, React, Laravel, Pengalaman dengan database MySQL/PostgreSQL, Familiar dengan Git dan metodologi Agile',
                'benefits' => 'Gaji kompetitif, Asuransi kesehatan, Flexible working hours, Remote work option, Training dan sertifikasi',
                'type' => 'full_time',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->skip(1)->first()->id,
                'title' => 'UI/UX Designer',
                'description' => 'Bergabunglah dengan tim kreatif kami sebagai UI/UX Designer. Anda akan bertanggung jawab untuk merancang antarmuka pengguna yang menarik dan user experience yang optimal.',
                'requirements' => 'Minimal 3 tahun pengalaman dalam UI/UX Design, Menguasai Figma, Adobe XD, Sketch, Pemahaman tentang design thinking dan user research, Portfolio yang kuat',
                'benefits' => 'Lingkungan kerja kreatif, Pelatihan design terbaru, Bonus performance, Fasilitas gym, Snack unlimited',
                'type' => 'full_time',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->skip(2)->first()->id,
                'title' => 'Data Scientist',
                'description' => 'Kami membutuhkan Data Scientist untuk menganalisis data bisnis dan memberikan insights yang valuable untuk pengambilan keputusan strategis.',
                'requirements' => 'Minimal S1 Statistik/Matematika/Computer Science, Menguasai Python, R, SQL, Pengalaman dengan machine learning, Familiar dengan tools seperti Pandas, NumPy, Scikit-learn',
                'benefits' => 'Gaji menarik, Bonus tahunan, Kesempatan conference internasional, Work from home, Medical allowance',
                'type' => 'full_time',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->skip(3)->first()->id,
                'title' => 'Mobile App Developer',
                'description' => 'Posisi untuk Mobile App Developer yang akan mengembangkan aplikasi mobile innovative untuk platform Android dan iOS.',
                'requirements' => 'Pengalaman minimal 2 tahun dalam mobile development, Menguasai Flutter atau React Native, Familiar dengan native development (Kotlin/Swift), Pengalaman dengan REST API integration',
                'benefits' => 'Startup environment, Equity options, Flexible schedule, Learning budget, Team building activities',
                'type' => 'full_time',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->skip(4)->first()->id,
                'title' => 'Digital Marketing Specialist',
                'description' => 'Kami mencari Digital Marketing Specialist yang akan mengelola strategi pemasaran digital dan meningkatkan brand awareness perusahaan.',
                'requirements' => 'Minimal 2 tahun pengalaman digital marketing, Menguasai Google Ads, Facebook Ads, SEO/SEM, Familiar dengan analytics tools, Kemampuan copywriting yang baik',
                'benefits' => 'Bonus target, Training marketing terbaru, Laptop dan tools premium, Allowance transport, Career development',
                'type' => 'full_time',
                'status' => 'active'
            ],
            [
                'company_id' => $companies->first()->id,
                'title' => 'Frontend Developer (Remote)',
                'description' => 'Posisi remote untuk Frontend Developer yang akan fokus pada pengembangan antarmuka pengguna yang responsive dan modern.',
                'requirements' => 'Minimal 3 tahun pengalaman frontend development, Expert dalam HTML, CSS, JavaScript, Menguasai React atau Vue.js, Pengalaman dengan responsive design',
                'benefits' => 'Full remote work, Flexible hours, Internet allowance, Annual company retreat, Professional development budget',
                'type' => 'remote',
                'status' => 'active'
            ]
        ];

        foreach ($jobPosts as $jobData) {
            $jobPost = JobPost::create($jobData);
            
            // Attach random categories to each job post
            $randomCategories = $categories->random(rand(1, 3));
            $jobPost->jobCategories()->attach($randomCategories->pluck('id'));
        }
    }
}
