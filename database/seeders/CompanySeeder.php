<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'PT Teknologi Maju Indonesia',
                'email' => 'hr@tekno-maju.co.id',
                'phone' => '021-12345678',
                'website' => 'https://www.tekno-maju.co.id',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta 10220'
            ],
            [
                'name' => 'CV Digital Kreatif Nusantara',
                'email' => 'recruitment@digitalkreatif.com',
                'phone' => '022-87654321',
                'website' => 'https://www.digitalkreatif.com',
                'address' => 'Jl. Dago No. 45, Bandung, Jawa Barat 40135'
            ],
            [
                'name' => 'PT Inovasi Solusi Bisnis',
                'email' => 'careers@inovasibisnis.co.id',
                'phone' => '031-11223344',
                'website' => 'https://www.inovasibisnis.co.id',
                'address' => 'Jl. Tunjungan No. 67, Surabaya, Jawa Timur 60261'
            ],
            [
                'name' => 'Startup Tech Solutions',
                'email' => 'jobs@startuptech.id',
                'phone' => '0274-556677',
                'website' => 'https://www.startuptech.id',
                'address' => 'Jl. Malioboro No. 89, Yogyakarta, DI Yogyakarta 55213'
            ],
            [
                'name' => 'PT Media Digital Indonesia',
                'email' => 'hr@mediadigital.co.id',
                'phone' => '024-998877',
                'website' => 'https://www.mediadigital.co.id',
                'address' => 'Jl. Pemuda No. 234, Semarang, Jawa Tengah 50132'
            ]
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
