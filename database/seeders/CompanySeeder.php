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
            // Parent Company
            [
                'name' => 'PT United Tractors Tbk',
                'email' => 'careers@unitedtractors.com',
                'phone' => '+62-21-2924-1000',
                'website' => 'https://www.unitedtractors.com',
                'logo' => 'logos/united-tractors.png',
                'address' => 'Gedung Menara Karya, Jl. H.R. Rasuna Said Blok X-5 Kav. 1-2, Jakarta Selatan 12950',
                'description' => 'United Tractors adalah distributor tunggal alat berat terbesar di Indonesia dan salah satu distributor Caterpillar terbesar di dunia.',
                'company_type' => 'parent',
                'business_sector' => 'heavy_equipment',
                'parent_company_id' => null,
                'is_active' => true
            ],
            // Heavy Equipment Subsidiaries
            [
                'name' => 'PT Trakindo Utama',
                'email' => 'hr@trakindo.co.id',
                'phone' => '+62-21-2924-2000',
                'website' => 'https://www.trakindo.co.id',
                'logo' => 'logos/trakindo.png',
                'address' => 'Jl. Raya Bekasi Km. 22, Cakung, Jakarta Timur 13910',
                'description' => 'Distributor resmi alat berat Caterpillar di Indonesia dengan layanan penjualan, sewa, dan purna jual.',
                'company_type' => 'subsidiary',
                'business_sector' => 'heavy_equipment',
                'parent_company_id' => null,
                'is_active' => true
            ],
            // Mining Subsidiaries
            [
                'name' => 'PT Pamapersada Nusantara',
                'email' => 'recruitment@pama.co.id',
                'phone' => '+62-21-2924-3000',
                'website' => 'https://www.pama.co.id',
                'logo' => 'logos/pamapersada.png',
                'address' => 'Gedung Menara Karya Lt. 8, Jl. H.R. Rasuna Said Blok X-5 Kav. 1-2, Jakarta Selatan 12950',
                'description' => 'Perusahaan kontraktor pertambangan terkemuka yang menyediakan jasa penambangan batubara dan mineral.',
                'company_type' => 'subsidiary',
                'business_sector' => 'mining',
                'parent_company_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'PT Acset Indonusa',
                'email' => 'careers@acset.co.id',
                'phone' => '+62-542-7361-200',
                'website' => 'https://www.acset.co.id',
                'logo' => 'logos/acset.png',
                'address' => 'Jl. Soekarno Hatta Km. 15, Balikpapan, Kalimantan Timur 76127',
                'description' => 'Perusahaan kontraktor pertambangan yang mengkhususkan diri dalam penambangan batubara.',
                'company_type' => 'subsidiary',
                'business_sector' => 'mining',
                'parent_company_id' => null,
                'is_active' => true
            ],
            // IT & Technology Subsidiaries
            [
                'name' => 'PT United Tractors Semen Gresik',
                'email' => 'it-careers@utsg.co.id',
                'phone' => '+62-31-3981-9000',
                'website' => 'https://www.utsg.co.id',
                'logo' => 'logos/utsg.png',
                'address' => 'Jl. Veteran, Gresik, Jawa Timur 61122',
                'description' => 'Perusahaan semen yang mengintegrasikan teknologi digital dalam operasional dan manajemen.',
                'company_type' => 'subsidiary',
                'business_sector' => 'it_technology',
                'parent_company_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'PT UT Digital Solutions',
                'email' => 'tech-jobs@utdigital.co.id',
                'phone' => '+62-21-2924-4000',
                'website' => 'https://www.utdigital.co.id',
                'logo' => 'logos/ut-digital.png',
                'address' => 'Gedung Cyber 2 Tower, Jl. H.R. Rasuna Said, Jakarta Selatan 12950',
                'description' => 'Divisi teknologi digital United Tractors yang fokus pada pengembangan solusi IoT, AI, dan digitalisasi industri.',
                'company_type' => 'subsidiary',
                'business_sector' => 'it_technology',
                'parent_company_id' => null,
                'is_active' => true
            ],
            // Construction & Logistics
            [
                'name' => 'PT United Tractors Pandu Engineering',
                'email' => 'jobs@utpe.co.id',
                'phone' => '+62-21-2924-5000',
                'website' => 'https://www.utpe.co.id',
                'logo' => 'logos/utpe.png',
                'address' => 'Kawasan Industri Pulogadung, Jakarta Timur 13920',
                'description' => 'Perusahaan engineering dan konstruksi yang menyediakan solusi infrastruktur untuk industri pertambangan dan konstruksi.',
                'company_type' => 'subsidiary',
                'business_sector' => 'construction',
                'parent_company_id' => null,
                'is_active' => true
            ],
            [
                'name' => 'PT Intraco Penta',
                'email' => 'hr@intracoPenta.com',
                'phone' => '+62-21-2924-6000',
                'website' => 'https://www.intracopenta.com',
                'logo' => 'logos/intraco-penta.png',
                'address' => 'Jl. Pangeran Jayakarta No. 117, Jakarta Pusat 10730',
                'description' => 'Distributor alat berat dan kendaraan komersial dengan fokus pada logistik dan transportasi.',
                'company_type' => 'subsidiary',
                'business_sector' => 'logistics',
                'parent_company_id' => null,
                'is_active' => true
            ]
        ];

        foreach ($companies as $companyData) {
            Company::create($companyData);
        }
    }
}
