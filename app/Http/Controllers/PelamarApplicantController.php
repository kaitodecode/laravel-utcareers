<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Selection;
use App\UploadToS3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PelamarApplicantController extends Controller
{
    use UploadToS3;
    /**
     * Display the dashboard for applicants.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if (!$applicant) {
            return redirect()->route('login')->with('error', 'Applicant profile not found.');
        }

        // Get all applicant records for this user (these are the applications)
        $applications = Applicant::where('user_id', $user->id)->with([
            'jobPostCategory.jobPost.company',
            'jobPostCategory.jobCategory',
            'selections'
        ])->latest()->get();

        // Calculate statistics
        $totalApplications = $applications->count();
        $pendingApplications = $applications->where('status', 'pending')->count();
        $inSelectionApplications = $applications->where('status', 'selection')->count();
        $acceptedApplications = $applications->where('status', 'accepted')->count();

        // Get recent applications (last 5)
        $recentApplications = $applications->take(5);

        // Get active selections (applications in selection process)
        $activeSelections = $applications->where('status', 'selection');

        return view('pelamar.dashboard', compact(
            'totalApplications',
            'pendingApplications', 
            'inSelectionApplications',
            'acceptedApplications',
            'recentApplications',
            'activeSelections'
        ));
    }

    /**
     * Display all applications for the applicant.
     */
    public function applications()
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if (!$applicant) {
            return redirect()->route('login')->with('error', 'Applicant profile not found.');
        }

        $applications = Applicant::where('user_id', $user->id)->with([
            'jobPostCategory.jobPost.company',
            'jobPostCategory.jobCategory',
            'selections'
        ])->latest()->paginate(10);

        return view('pelamar.applications', compact('applications'));
    }

    /**
     * Display selection process for all applications or specific application.
     */
    public function selectionProcess($applicationId = null)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if (!$applicant) {
            return redirect()->route('login')->with('error', 'Applicant profile not found.');
        }

        if ($applicationId) {
            // Show specific application selection process
            $application = Applicant::where('user_id', $user->id)->with([
                'jobPostCategory.jobPost.company',
                'jobPostCategory.jobCategory',
                'selections'
            ])->findOrFail($applicationId);

            // Generate S3 URLs for attachments
            foreach ($application->selections as $selection) {
                if ($selection->attachment) {
                    $selection->attachment_url = $this->getAttachmentUrl($selection->attachment);
                }
            }

            return view('pelamar.applicant', compact('application'));
        } else {
            // Show all applications with their selection process
            $applications = Applicant::where('user_id', $user->id)->with([
                'jobPostCategory.jobPost.company',
                'jobPostCategory.jobCategory',
                'selections'
            ])->latest()->get();

            // Generate S3 URLs for attachments
            foreach ($applications as $application) {
                foreach ($application->selections as $selection) {
                    if ($selection->attachment) {
                        $selection->attachment_url = $this->getAttachmentUrl($selection->attachment);
                    }
                }
            }

            return view('pelamar.selection-process', compact('applications'));
        }
    }

    /**
     * Upload document for selection stage.
     */
    public function uploadDocument(Request $request)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if (!$applicant) {
            return redirect()->route('login')->with('error', 'Applicant profile not found.');
        }

        // Get parameters from request
        $applicationId = $request->input('applicant_id');
        $stage = $request->input('stage');

        // Validate the application belongs to the applicant
        $application = Applicant::where('user_id', $user->id)->findOrFail($applicationId);

        // Validate stage
        if (!in_array($stage, ['portfolio', 'medical_checkup'])) {
            return back()->with('error', 'Invalid selection stage.');
        }

        // Validate file upload
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'stage' => 'required|in:portfolio,medical_checkup',
            'attachment' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240' // 10MB max
        ]);

        // Check if stage is accessible
        if ($stage === 'medical_checkup') {
            $interviewSelection = $application->selections()->where('stage', 'interview')->first();
            if (!$interviewSelection || $interviewSelection->status !== 'accepted') {
                return back()->with('error', 'Medical checkup stage is not yet available.');
            }
        }

        try {
            // Upload file to S3 using trait
            $file = $request->file('attachment');
            $path = $this->uploadSelectionDocument($file, (int)$applicationId, $stage);

            if (!$path) {
                return back()->with('error', 'Failed to upload document to cloud storage. Please try again.');
            }

            // Create or update selection record
            $selection = Selection::updateOrCreate(
                [
                    'applicant_id' => $applicationId,
                    'stage' => $stage
                ],
                [
                    'job_post_category_id' => $application->job_post_category_id,
                    'attachment' => $path,
                    'status' => 'pending'
                ]
            );

            // Check if all selection stages are completed and accepted
            $this->checkAndUpdateApplicationStatus($application);

            $stageLabel = $stage === 'portfolio' ? 'Portfolio' : 'Medical Report';
            return back()->with('success', $stageLabel . ' uploaded successfully and is pending review.');

        } catch (\Exception $e) {
            Log::error('Document upload error: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload document. Please try again.');
        }
    }

    /**
     * Upload portfolio document specifically.
     */
    public function uploadPortfolio(Request $request)
    {
        $user = Auth::user();
        $applicant = Applicant::where('user_id', $user->id)->first();
        
        if (!$applicant) {
            return redirect()->route('login')->with('error', 'Applicant profile not found.');
        }

        // Get parameters from request
        $applicationId = $request->input('applicant_id');

        // Validate the application belongs to the applicant
        $application = Applicant::where('user_id', $user->id)->findOrFail($applicationId);

        // Validate file upload
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'attachment' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:10240' // 10MB max
        ]);

        try {
            // Upload portfolio file to S3 using trait
            $file = $request->file('attachment');
            $path = $this->uploadSelectionDocument($file, (int)$applicationId, 'portfolio');

            if (!$path) {
                return back()->with('error', 'Failed to upload portfolio to cloud storage. Please try again.');
            }

            // Create or update selection record for portfolio stage
            $selection = Selection::updateOrCreate(
                [
                    'applicant_id' => $applicationId,
                    'stage' => 'portfolio'
                ],
                [
                    'job_post_category_id' => $application->job_post_category_id,
                    'attachment' => $path,
                    'status' => 'pending'
                ]
            );

            // Update application status to 'selection' if it's still 'pending'
            if ($application->status === 'pending') {
                $application->update(['status' => 'selection']);
            }

            return back()->with('success', 'Portfolio uploaded successfully and is pending review.');

        } catch (\Exception $e) {
            Log::error('Portfolio upload error: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload portfolio. Please try again.');
        }
    }

    /**
     * Get S3 URL for attachment
     *
     * @param string $path
     * @return string|null
     */
    public function getAttachmentUrl($path)
    {
        if (!$path) {
            return null;
        }

        // Generate temporary signed URL for private files (valid for 1 hour)
        return $this->getS3Url($path, true, 3600);
    }

    /**
     * Check if all selection stages are completed and update application status
     */
    private function checkAndUpdateApplicationStatus($application)
    {
        $stages = ['portfolio', 'interview', 'medical_checkup'];
        $allStagesAccepted = true;

        foreach ($stages as $stage) {
            $selection = $application->selections()->where('stage', $stage)->first();
            if (!$selection || $selection->status !== 'accepted') {
                $allStagesAccepted = false;
                break;
            }
        }

        if ($allStagesAccepted) {
            $application->update(['status' => 'accepted']);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->dashboard();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        //
    }
}
