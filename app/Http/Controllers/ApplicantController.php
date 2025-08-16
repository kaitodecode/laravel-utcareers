<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Company;
use App\Models\Selection;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\UpdateApplicantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Applicant::with(['user', 'jobPostCategory.jobPost.company', 'selections']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by company
        if ($request->filled('company_id')) {
            $query->whereHas('jobPostCategory.jobPost', function($q) use ($request) {
                $q->where('company_id', $request->company_id);
            });
        }

        $applicants = $query->paginate(10);
        $companies = Company::all();
        
        return view("admin.applicant", compact("applicants", "companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantRequest $request)
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
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantRequest $request, Applicant $applicant)
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

    /**
     * Get applicant selections for modal display
     */
    public function getSelections(Applicant $applicant)
    {
        $applicant->load([
            'user',
            'jobPostCategory.jobPost.company',
            'jobPostCategory.jobCategory',
            'selections' => function($query) {
                $query->orderBy('created_at', 'asc');
            }
        ]);

        return response()->json([
            'applicant' => $applicant,
            'selections' => $applicant->selections
        ]);
    }

    /**
     * Update selection status and notes
     */
public function updateSelection(Request $request, Applicant $applicant, $selection = null)
{
    $request->validate([
        'status' => 'required|in:pending,in_review,accepted,rejected',
    ]);



    // If selection ID is 0 or selection doesn't exist, we need to determine the stage
    if (!$selection || $selection === '0') {
        // Determine which stage we're updating based on the form context
        // For now, let's assume it's portfolio stage if no selection exists
        $stage = $request->input('stage', 'portfolio');
        
        // Find or create the selection for this stage
        $selectionModel = $applicant->selections()->where('stage', $stage)->first();
        
        if (!$selectionModel) {
            // Create new selection if it doesn't exist using UUID
            $selectionModel = Selection::create([
                'id' => Str::uuid(),
                'applicant_id' => $applicant->id,
                'job_post_category_id' => $applicant->job_post_category_id,
                'stage' => $stage,
                'status' => 'pending',
            ]);
        }
    } else {
        // If selection is passed as UUID, find the model
        if (is_string($selection)) {
            $selectionModel = Selection::where('id', $selection)->firstOrFail();
        } else {
            $selectionModel = $selection;
        }
    }

    // Get all selections for this applicant ordered by stage
    $selections = $applicant->selections()->orderBy('stage', 'asc')->get();

    // Handle rejections for different stages
    if ($request->status === 'rejected') {
        switch ($selectionModel->stage) {
            case 'portfolio':
                // Reject all subsequent stages after portfolio
                $selections->whereNotIn('stage', ['portfolio'])
                          ->each(fn($sel) => $sel->update(['status' => 'rejected']));
                break;
                
            case 'interview':
                // Reject medical checkup stage
                $selections->where('stage', 'medical_checkup')
                          ->each(fn($sel) => $sel->update(['status' => 'rejected']));
                break;
        }
        
        // Update applicant status to rejected
        $applicant->update(['status' => 'rejected']);
    }

    // Update the current selection
    $selectionModel->update(['status' => $request->status]);

    // Check if all stages are completed and update application status
    if ($selectionModel->stage === 'medical_checkup' && $selectionModel->status === 'accepted') {
        $selectionModel->jobPostCategory->required_count -= 1;
        $selectionModel->jobPostCategory->save();
    }
    return redirect()->back()->with('success', 'Selection updated successfully');
}

    /**
     * Upload interview details by admin
     */
    public function uploadInterviewDetails(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'interview_url' => 'required|url'
        ]);

        $applicant = Applicant::findOrFail($request->applicant_id);
        
        // Check if portfolio stage is accepted
        $portfolioSelection = $applicant->selections()->where('stage', 'portfolio')->where('status', 'accepted')->first();
        if (!$portfolioSelection) {
            return back()->with('error', 'Portfolio must be accepted before scheduling interview.');
        }

        // Create or update interview selection
        $interviewSelection = Selection::updateOrCreate(
            [
                'applicant_id' => $request->applicant_id,
                'stage' => 'interview'
            ],
            [
                'job_post_category_id' => $applicant->job_post_category_id,
                'attachment' => $request->interview_url,
                'status' => 'pending'
            ]
        );

        return back()->with('success', 'Interview details uploaded successfully.');
    }

    /**
     * Approve medical document
     */
public function approveMedicalDocument(Request $request)
{
    try {
        $request->validate([
            'selection_id' => 'required|exists:selections,id',
            'status' => 'required|in:accepted,rejected'
        ]);
        
        $selection = Selection::findOrFail($request->selection_id);
        
        if ($selection->stage !== 'medical_checkup') {
            throw new \Exception('Invalid selection stage.');
        }
        
        $selection->update(['status' => $request->status]);
        // Check if all stages are completed and update application status
        $applicant = $selection->applicant;

        if ($request->status === 'rejected') {
            $applicant->update(['status' => 'rejected']);
        }
        
        $this->checkAndUpdateApplicationStatus($applicant);
        
        $statusLabel = $request->status === 'accepted' ? 'approved' : 'rejected';
        
        $jobPostCategory = $selection->jobPostCategory;
        $jobPostCategory->update(['required_count'=> $jobPostCategory->required_count - 1]);
        $jobPostCategory->save();
        
        return back()->with('success', "Medical document has been {$statusLabel}.");

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return back()->with('error', 'Selection not found.');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

    /**
     * Check if all selection stages are completed and update application status
     */
    private function checkAndUpdateApplicationStatus($applicant)
    {
        $stages = ['portfolio', 'interview', 'medical_checkup'];
        $allStagesAccepted = true;

        foreach ($stages as $stage) {
            $selection = $applicant->selections()->where('stage', $stage)->first();
            if (!$selection || $selection->status !== 'accepted') {
                $allStagesAccepted = false;
                break;
            }
        }

        if ($allStagesAccepted) {
            $applicant->update(['status' => 'accepted']);
        }
    }
}
