@extends('layouts.applicant')

@section('title', 'Selection Process')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">Selection Process</h1>
                        <p class="text-muted mb-0">Track your application progress through each selection stage</p>
                    </div>
                    <a href="{{ route('pelamar.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(isset($application))
            <!-- Application Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                            <i class="fas fa-briefcase text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0">{{ $application->jobPostCategory->jobPost->title }}</h5>
                                            <p class="text-muted mb-0">{{ $application->jobPostCategory->jobPost->company->name }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            Applied: {{ $application->created_at->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $application->jobPostCategory->jobCategory->name }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="badge bg-{{ $application->status_badge }} bg-opacity-10 text-{{ $application->status_badge }} border border-{{ $application->status_badge }} px-3 py-2">
                                        {{ $application->status_label }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selection Stages -->
            <div class="row">
                <div class="col-12">
                    @php
                        $stages = [
                            'portfolio' => [
                                'title' => 'Portfolio Review',
                                'description' => 'Upload your portfolio documents for review',
                                'icon' => 'fas fa-folder-open',
                                'color' => 'primary'
                            ],
                            'interview' => [
                                'title' => 'Interview',
                                'description' => 'Participate in the interview process',
                                'icon' => 'fas fa-video',
                                'color' => 'info'
                            ],
                            'medical_checkup' => [
                                'title' => 'Medical Checkup',
                                'description' => 'Complete medical examination and upload results',
                                'icon' => 'fas fa-user-md',
                                'color' => 'success'
                            ]
                        ];
                    @endphp

                    @foreach($stages as $stageKey => $stageInfo)
                        @php
                            $selection = $application->selections->where('stage', $stageKey)->first();
                            $isCompleted = $selection && $selection->status === 'accepted';
                            $isCurrent = $selection && in_array($selection->status, ['pending', 'in_review']);
                            $isRejected = $selection && $selection->status === 'rejected';
                            $isWaiting = !$selection;
                            
                            // Determine if this stage is accessible
                            $isAccessible = false;
                            if ($stageKey === 'portfolio') {
                                $isAccessible = true;
                            } elseif ($stageKey === 'interview') {
                                $portfolioSelection = $application->selections->where('stage', 'portfolio')->first();
                                $isAccessible = $portfolioSelection && $portfolioSelection->status === 'accepted';
                            } elseif ($stageKey === 'medical_checkup') {
                                $interviewSelection = $application->selections->where('stage', 'interview')->first();
                                $isAccessible = $interviewSelection && $interviewSelection->status === 'accepted';
                            }
                        @endphp

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-1">
                                        <div class="text-center">
                                            @if($isCompleted)
                                                <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-check text-white"></i>
                                                </div>
                                            @elseif($isCurrent)
                                                <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-clock text-white"></i>
                                                </div>
                                            @elseif($isRejected)
                                                <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fas fa-times text-white"></i>
                                                </div>
                                            @else
                                                <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="{{ $stageInfo['icon'] }} text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h5 class="fw-bold text-dark mb-1">{{ $stageInfo['title'] }}</h5>
                                        <p class="text-muted mb-2">{{ $stageInfo['description'] }}</p>
                                        
                                        @if($selection)
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-{{ $selection->status === 'accepted' ? 'success' : ($selection->status === 'rejected' ? 'danger' : 'warning') }} bg-opacity-10 text-{{ $selection->status === 'accepted' ? 'success' : ($selection->status === 'rejected' ? 'danger' : 'warning') }} border border-{{ $selection->status === 'accepted' ? 'success' : ($selection->status === 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $selection->status)) }}
                                                </span>
                                                @if($selection->updated_at)
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $selection->updated_at->format('d M Y, H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">
                                                Waiting
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-end">
                                        @if($stageKey === 'portfolio' && $isAccessible)
                                            @if(!$selection || $selection->status === 'pending')
                                                <button class="btn btn-{{ $stageInfo['color'] }}" data-bs-toggle="modal" data-bs-target="#portfolioModal">
                                                    <i class="fas fa-upload me-2"></i>Upload Portfolio
                                                </button>
                                            @elseif($selection->attachment)
                                                <div class="d-flex gap-2">
                                                    <a href="{{ $selection->attachment_url ?? '#' }}" target="_blank" class="btn btn-outline-primary btn-sm {{ !$selection->attachment_url ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                    @if($selection->status === 'pending')
                                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#portfolioModal">
                                                            <i class="fas fa-edit me-1"></i>Update
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        @elseif($stageKey === 'interview' && $selection && $selection->attachment)
                                            <div class="text-end">
                                                <p class="mb-1 fw-medium text-dark">Interview Details:</p>
                                                <a href="{{ $selection->attachment }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-video me-1"></i>Join Interview
                                                </a>
                                            </div>
                                        @elseif($stageKey === 'medical_checkup' && $isAccessible)
                                            @if(!$selection || $selection->status === 'pending')
                                                <button class="btn btn-{{ $stageInfo['color'] }}" data-bs-toggle="modal" data-bs-target="#medicalModal">
                                                    <i class="fas fa-upload me-2"></i>Upload Medical Report
                                                </button>
                                            @elseif($selection->attachment)
                                                <div class="d-flex gap-2">
                                                    <a href="{{ $selection->attachment_url ?? '#' }}" target="_blank" class="btn btn-outline-primary btn-sm {{ !$selection->attachment_url ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye me-1"></i>View
                                                    </a>
                                                    @if($selection->status === 'pending')
                                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#medicalModal">
                                                            <i class="fas fa-edit me-1"></i>Update
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Not available yet</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($selection && $selection->notes)
                                    <div class="row mt-3">
                                        <div class="col-md-11 offset-md-1">
                                            <div class="alert alert-info mb-0">
                                                <strong>Notes:</strong> {{ $selection->notes }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Application Selected -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-clipboard-list text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No Selection Process</h4>
                            <p class="text-muted">You don't have any active selection processes at the moment.</p>
                            <a href="{{ route('pelamar.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(isset($application))
        <!-- Portfolio Upload Modal -->
        <div class="modal fade" id="portfolioModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Portfolio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('pelamar.selection.upload', ['application' => $application->id, 'stage' => 'portfolio']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="portfolio_file" class="form-label">Portfolio Document</label>
                                <input type="file" class="form-control" id="portfolio_file" name="attachment" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max: 10MB)</div>
                            </div>
                            <div class="mb-3">
                                <label for="portfolio_notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="portfolio_notes" name="notes" rows="3" placeholder="Add any additional information about your portfolio..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload Portfolio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Medical Report Upload Modal -->
        <div class="modal fade" id="medicalModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Medical Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('pelamar.selection.upload', ['application' => $application->id, 'stage' => 'medical_checkup']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="medical_file" class="form-label">Medical Report</label>
                                <input type="file" class="form-control" id="medical_file" name="attachment" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max: 10MB)</div>
                            </div>
                            <div class="mb-3">
                                <label for="medical_notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="medical_notes" name="notes" rows="3" placeholder="Add any additional information about your medical report..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload me-2"></i>Upload Medical Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }
        });
    }, 5000);
</script>
@endpush