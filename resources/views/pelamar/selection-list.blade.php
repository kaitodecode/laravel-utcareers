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
                        <p class="text-muted mb-0">Track your applications currently in selection process</p>
                    </div>
                    <a href="{{ route('pelamar.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        @endif

        @if($applications->count() > 0)
            <!-- Applications in Selection -->
            <div class="row">
                @foreach($applications as $application)
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <!-- Application Header -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                        <i class="fas fa-briefcase text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold text-dark mb-0">{{ $application->jobPostCategory->jobPost->title }}</h5>
                                        <p class="text-muted mb-0">{{ $application->jobPostCategory->jobPost->company->name }}</p>
                                    </div>
                                    <span class="badge {{ $application->status_badge }} ms-2">
                                        {{ $application->status_label }}
                                    </span>
                                </div>

                                <!-- Application Info -->
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Applied Date</small>
                                        <span class="fw-medium">{{ $application->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Category</small>
                                        <span class="fw-medium">{{ $application->jobPostCategory->jobCategory->name }}</span>
                                    </div>
                                </div>

                                <!-- Selection Progress -->
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2">Selection Progress</small>
                                    <div class="row">
                                        @php
                                            $stages = ['portfolio', 'interview', 'medical_checkup'];
                                            $stageLabels = [
                                                'portfolio' => 'Portfolio',
                                                'interview' => 'Interview',
                                                'medical_checkup' => 'Medical'
                                            ];
                                            $stageIcons = [
                                                'portfolio' => 'fas fa-folder-open',
                                                'interview' => 'fas fa-video',
                                                'medical_checkup' => 'fas fa-user-md'
                                            ];
                                        @endphp
                                        
                                        @foreach($stages as $index => $stage)
                                            @php
                                                $selection = $application->selections->where('stage', $stage)->first();
                                                $isCompleted = $selection && $selection->status === 'accepted';
                                                $isPending = $selection && $selection->status === 'pending';
                                                $isRejected = $selection && $selection->status === 'rejected';
                                                $isActive = !$selection && ($index === 0 || $application->selections->where('stage', $stages[$index-1])->where('status', 'accepted')->count() > 0);
                                            @endphp
                                            
                                            <div class="col-4 text-center">
                                                <div class="position-relative">
                                                    @if($isCompleted)
                                                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-check text-white" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    @elseif($isPending)
                                                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-clock text-white" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    @elseif($isRejected)
                                                        <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-times text-white" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    @elseif($isActive)
                                                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 32px; height: 32px;">
                                                            <i class="{{ $stageIcons[$stage] }} text-white" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    @else
                                                        <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-1" style="width: 32px; height: 32px;">
                                                            <i class="{{ $stageIcons[$stage] }} text-muted" style="font-size: 0.75rem;"></i>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($index < count($stages) - 1)
                                                        <div class="position-absolute top-50 start-100 translate-middle-y" style="width: 100%; height: 2px; background: {{ $isCompleted ? '#198754' : '#dee2e6' }}; z-index: -1;"></div>
                                                    @endif
                                                </div>
                                                <small class="text-muted d-block" style="font-size: 0.7rem;">{{ $stageLabels[$stage] }}</small>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Portfolio Upload Form (if pending) -->
                                @php
                                    $portfolioSelection = $application->selections->where('stage', 'portfolio')->first();
                                    $isPortfolioPending = $portfolioSelection && $portfolioSelection->status === 'pending';
                                @endphp
                                
                                @if($isPortfolioPending)
                                    <div class="mb-3">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Portfolio Required:</strong> Please upload your portfolio to proceed with the selection process.
                                        </div>
                                        
                                        <form action="{{ route('pelamar.upload-portfolio') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="applicant_id" value="{{ $application->id }}">
                                            
                                            <div class="mb-3">
                                                <label for="portfolio_file_{{ $application->id }}" class="form-label">
                                                    <i class="fas fa-upload me-2"></i>Upload Portfolio
                                                </label>
                                                <input type="file" class="form-control" id="portfolio_file_{{ $application->id }}" name="attachment" 
                                                       accept=".pdf,.doc,.docx,.zip,.rar" required>
                                                <div class="form-text">Accepted formats: PDF, DOC, DOCX, ZIP, RAR (Max: 10MB)</div>
                                            </div>
                                            
                                            <div class="d-grid gap-2 d-md-flex">
                                                <button type="submit" class="btn btn-success flex-fill">
                                                    <i class="fas fa-upload me-2"></i>Upload Portfolio
                                                </button>
                                                <a href="{{ route('pelamar.selection-process.detail', $application->id) }}" class="btn btn-outline-primary flex-fill">
                                                    <i class="fas fa-eye me-2"></i>View Details
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <!-- Action Button -->
                                    <div class="d-grid">
                                        <a href="{{ route('pelamar.selection-process.detail', $application->id) }}" class="btn btn-primary">
                                            <i class="fas fa-eye me-2"></i>View Details
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Applications in Selection -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-clipboard-list text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No Active Selection Process</h4>
                            <p class="text-muted">You don't have any applications currently in the selection process.</p>
                            <a href="{{ route('pelamar.applications') }}" class="btn btn-primary me-2">
                                <i class="fas fa-file-alt me-2"></i>View All Applications
                            </a>
                            <a href="{{ route('pelamar.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection