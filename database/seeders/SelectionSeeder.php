<?php

namespace Database\Seeders;

use App\Models\Selection;
use App\Models\Applicant;
use App\Models\JobPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicants = Applicant::where('status', 'selection')->get();
        $jobPosts = JobPost::all();

        $selections = [
            [
                'applicant_id' => $applicants->first()->id,
                'job_id' => $applicants->first()->job_id,
                'stage' => 'portfolio',
                'status' => 'accepted',
                'attachment' => 'portfolio/sari_dewi_portfolio.pdf'
            ],
            [
                'applicant_id' => $applicants->first()->id,
                'job_id' => $applicants->first()->job_id,
                'stage' => 'interview',
                'status' => 'in_review',
                'attachment' => null
            ]
        ];

        // Add some selections for accepted applicants
        $acceptedApplicants = Applicant::where('status', 'accepted')->get();
        foreach ($acceptedApplicants as $applicant) {
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_id' => $applicant->job_id,
                'stage' => 'portfolio',
                'status' => 'accepted',
                'attachment' => 'portfolio/portfolio_' . $applicant->id . '.pdf'
            ];
            
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_id' => $applicant->job_id,
                'stage' => 'interview',
                'status' => 'accepted',
                'attachment' => null
            ];
            
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_id' => $applicant->job_id,
                'stage' => 'medical_checkup',
                'status' => 'accepted',
                'attachment' => 'medical/medical_' . $applicant->id . '.pdf'
            ];
        }

        // Add some selections for rejected applicants
        $rejectedApplicants = Applicant::where('status', 'rejected')->get();
        foreach ($rejectedApplicants as $applicant) {
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_id' => $applicant->job_id,
                'stage' => 'portfolio',
                'status' => 'rejected',
                'attachment' => 'portfolio/portfolio_' . $applicant->id . '.pdf'
            ];
        }

        foreach ($selections as $selection) {
            Selection::create($selection);
        }
    }
}
