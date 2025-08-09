<?php

namespace Database\Seeders;

use App\Models\Selection;
use App\Models\Applicant;
use App\Models\JobPostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get applicants for selection process
        $applicants = Applicant::where('status', 'selection')->get();
        
        $selections = [];
        
        foreach ($applicants as $applicant) {
            // Create basic selection stages for all applicants in selection
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_post_category_id' => $applicant->job_post_category_id,
                'stage' => 'portfolio',
                'status' => 'accepted',
                'attachment' => 'portfolio_reviews/portfolio_' . $applicant->id . '.pdf'
            ];
            
            $selections[] = [
                'applicant_id' => $applicant->id,
                'job_post_category_id' => $applicant->job_post_category_id,
                'stage' => 'interview',
                'status' => 'in_review',
                'attachment' => null
            ];
        }
        
        // Create selections one by one to handle UUID generation
        foreach ($selections as $selection) {
            Selection::create($selection);
        }
    }
}
