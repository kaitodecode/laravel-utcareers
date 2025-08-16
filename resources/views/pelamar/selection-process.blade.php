@extends('layouts.applicant')

@section('title')
<i class="fas fa-tasks text-primary-custom"></i> Selection Process
@endsection

@push('styles')
<style>
    .page-header {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 2rem;
    }

    .step-card {
        transition: all 0.2s ease;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .step-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .step-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        position: relative;
    }

    .step-number {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #fff;
        border: 2px solid #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .progress-bar {
        background: #0d6efd;
        transition: width 0.4s ease;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        transition: border-color 0.2s ease;
        background: #f8f9fa;
    }

    .upload-zone:hover {
        border-color: #0d6efd;
    }

    .file-preview {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid #e9ecef;
    }

    .timeline-connector {
        position: absolute;
        top: 50%;
        right: -15px;
        width: 30px;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }

    .timeline-connector.active {
        background: #0d6efd;
    }

    @media (max-width: 768px) {
        .timeline-connector {
            display: none;
        }
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b3d7ff;
        color: #0c5460;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2 fw-bold text-dark">Selection Process</h1>
                <p class="mb-0 text-muted">Track your application progress through our selection stages</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('pelamar.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    @if ($applications->count() > 0)
    @foreach ($applications as $application)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-semibold">{{ $application->jobPostCategory->jobPost->title ?? 'Job Position' }}
                            </h5>
                            <p class="text-muted mb-0 small">
                                <i
                                    class="fas fa-building me-1"></i>{{ $application->jobPostCategory->jobPost->company->name ?? 'Company' }}
                                <span class="mx-2">•</span>
                                <i class="fas fa-calendar me-1"></i>Applied:
                                {{ $application->created_at ? $application->created_at->format('M d, Y') : '-' }}
                            </p>
                        </div>
                        <span
                            class="badge {{ $application->status_badge }}">{{ $application->status_label }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Selection Process Steps -->
                    <div class="row">
                        @php
                        $selections = $application->selections;
                        $portfolioSelection = $selections->where('stage', 'portfolio')->first();
                        $interviewSelection = $selections->where('stage', 'interview')->first();
                        $medicalSelection = $selections->where('stage', 'medical_checkup')->first();
                        @endphp

                        <!-- Step 1: Portfolio Selection -->
                        <div class="col-md-4 mb-4 position-relative">
                            <div
                                class="step-card card h-100 {{ $portfolioSelection ? ($portfolioSelection->status == 'accepted' ? 'border-success' : ($portfolioSelection->status == 'rejected' ? 'border-danger' : 'border-warning')) : '' }}">
                                <div class="card-body text-center">
                                    <div
                                        class="step-icon {{ $portfolioSelection ? ($portfolioSelection->status == 'accepted' ? 'bg-success' : ($portfolioSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning')) : 'bg-light' }}">
                                        @if ($portfolioSelection)
                                        @if ($portfolioSelection->status == 'accepted')
                                        <i class="fas fa-check text-white"
                                            style="font-size: 1.5rem;"></i>
                                        @elseif($portfolioSelection->status == 'rejected')
                                        <i class="fas fa-times text-white"
                                            style="font-size: 1.5rem;"></i>
                                        @else
                                        <i class="fas fa-clock text-white"
                                            style="font-size: 1.5rem;"></i>
                                        @endif
                                        @else
                                        <i class="fas fa-folder-open text-muted"
                                            style="font-size: 1.5rem;"></i>
                                        @endif
                                        <div
                                            class="step-number {{ $portfolioSelection ? ($portfolioSelection->status == 'accepted' ? 'text-success' : ($portfolioSelection->status == 'rejected' ? 'text-danger' : 'text-warning')) : 'text-muted' }}">
                                            1</div>
                                    </div>
                                    <h6 class="card-title fw-semibold mb-2">Portfolio Selection</h6>
                                    <p class="card-text text-muted small mb-3">Upload your portfolio documents
                                    </p>
                                    <div
                                        class="timeline-connector {{ $portfolioSelection && $portfolioSelection->status == 'accepted' ? 'active' : '' }}">
                                    </div>

                                    @if ($portfolioSelection)
                                    <span
                                        class="status-badge {{ $portfolioSelection->status == 'accepted' ? 'bg-success' : ($portfolioSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning') }} text-white mb-3">
                                        {{ ucfirst($portfolioSelection->status) }}
                                    </span>

                                    @if ($portfolioSelection->status == 'pending')
                                    @if ($portfolioSelection->attachment)
                                    <!-- Portfolio Already Uploaded - Show Current File and Replace Option -->
                                    <div class="mt-3">
                                        <div class="alert alert-info mb-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Portfolio Uploaded:</strong> Your portfolio is
                                            currently under review.
                                        </div>

                                        <!-- Current Portfolio File -->
                                        <div class="mb-4">
                                            <div class="file-preview shadow-sm rounded">
                                                <div class="d-flex align-items-center justify-content-between p-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                            <i class="fas fa-file-alt text-white fa-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold mb-1">Current Portfolio</h6>
                                                            <span class="text-muted d-block">
                                                                <i class="fas fa-clock me-1"></i>
                                                                Uploaded and under review
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <a href="{{ $portfolioSelection->attachment ?? '#' }}"
                                                        target="_blank"
                                                        class="btn btn-outline-primary {{ !$portfolioSelection->attachment ? 'disabled' : '' }}"
                                                        {{ !$portfolioSelection->attachment ? 'aria-disabled="true"' : '' }}>
                                                        <i class="fas fa-eye me-2"></i>
                                                        View File
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Replace Portfolio Form -->
                                        <div class="upload-zone">
                                            <form action="{{ route('pelamar.upload-document') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="applicant_id"
                                                    value="{{ $application->id }}">
                                                <input type="hidden" name="stage"
                                                    value="portfolio">

                                                <div class="mb-3">
                                                    <i class="fas fa-sync-alt text-primary mb-2"
                                                        style="font-size: 1.5rem;"></i>
                                                    <h6 class="mb-2">Replace Portfolio</h6>
                                                    <input type="file" class="form-control mb-2"
                                                        id="portfolio_replace_{{ $application->id }}"
                                                        name="attachment"
                                                        accept=".pdf,.doc,.docx,.zip,.rar" required>
                                                    <small class="text-muted">Supported: PDF, DOC,
                                                        DOCX, ZIP, RAR (Max: 10MB)</small>
                                                </div>

                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-sync-alt me-2"></i>Replace
                                                    Portfolio
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                    <!-- No Portfolio Uploaded Yet - Show Upload Form -->
                                    <div class="mt-3">
                                        <div class="upload-zone">
                                            <form action="{{ route('pelamar.upload-document') }}"
                                                method="POST" enctype="multipart/form-data"
                                                class="text-center">
                                                @csrf
                                                <input type="hidden" name="applicant_id"
                                                    value="{{ $application->id }}">
                                                <input type="hidden" name="stage"
                                                    value="portfolio">

                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <i class="fas fa-cloud-upload-alt text-primary"
                                                            style="font-size: 3rem;"></i>
                                                    </div>
                                                    <h6 class="text-primary mb-2">Upload Your
                                                        Portfolio</h6>
                                                    <p class="text-muted mb-3">Drag and drop your
                                                        file here or click to browse</p>

                                                    <input type="file" class="form-control"
                                                        id="portfolio_file_{{ $application->id }}"
                                                        name="attachment"
                                                        accept=".pdf,.doc,.docx,.zip,.rar"
                                                        required>
                                                    <div class="form-text mt-2">Supported: PDF,
                                                        DOC, DOCX, ZIP, RAR (Max: 10MB)</div>
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-primary btn-lg px-4">
                                                    <i class="fas fa-upload me-2"></i>Upload
                                                    Portfolio
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    @elseif($portfolioSelection->attachment)
                                    <!-- Portfolio with Non-Pending Status -->
                                    <div class="mb-3">
                                        <div class="file-preview">
                                            <div
                                                class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary rounded-circle p-2 me-3">
                                                        <i class="fas fa-file-alt text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Portfolio Document</h6>
                                                        <small
                                                            class="text-muted">{{ $portfolioSelection->status == 'accepted' ? 'Approved' : 'Reviewed' }}</small>
                                                    </div>
                                                </div>
                                                <a href="{{ $portfolioSelection->attachment_url ?? '#' }}"
                                                    target="_blank"
                                                    class="btn btn-outline-primary {{ !$portfolioSelection->attachment_url ? 'disabled' : '' }}">
                                                    <i class="fas fa-eye me-1"></i>View Portfolio
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#portfolioModal{{ $application->id }}">
                                        <i class="fas fa-upload me-2"></i>Upload Portfolio
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Interview Selection -->
                        <div class="col-md-4 mb-4 position-relative">
                            <div
                                class="step-card card h-100 border-2 {{ $interviewSelection ? ($interviewSelection->status == 'accepted' ? 'border-success' : ($interviewSelection->status == 'rejected' ? 'border-danger' : 'border-warning')) : 'border-secondary' }}">
                                <div class="card-body text-center">
                                    <div
                                        class="step-icon {{ $interviewSelection ? ($interviewSelection->status == 'accepted' ? 'bg-success' : ($interviewSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning')) : 'bg-secondary' }}">
                                        @if ($interviewSelection)
                                        @if ($interviewSelection->status == 'accepted')
                                        <i class="fas fa-check-circle text-white"
                                            style="font-size: 2rem;"></i>
                                        @elseif($interviewSelection->status == 'rejected')
                                        <i class="fas fa-times-circle text-white"
                                            style="font-size: 2rem;"></i>
                                        @else
                                        <i class="fas fa-clock text-white"
                                            style="font-size: 2rem;"></i>
                                        @endif
                                        @else
                                        <i class="fas fa-video text-white" style="font-size: 2rem;"></i>
                                        @endif
                                        <div
                                            class="step-number {{ $interviewSelection ? ($interviewSelection->status == 'accepted' ? 'text-success' : ($interviewSelection->status == 'rejected' ? 'text-danger' : 'text-warning')) : 'text-secondary' }}">
                                            2</div>
                                    </div>
                                    <h5 class="card-title fw-bold">Interview Selection</h5>
                                    <p class="card-text text-muted">Interview details will be provided by admin
                                    </p>
                                    <div
                                        class="timeline-connector {{ $interviewSelection && $interviewSelection->status == 'accepted' ? 'active' : '' }}">
                                    </div>

                                    @if ($interviewSelection)
                                    <span
                                        class="status-badge {{ $interviewSelection->status == 'accepted' ? 'bg-success' : ($interviewSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning') }} text-white mb-3">
                                        {{ ucfirst($interviewSelection->status) }}
                                    </span>
                                    @if ($interviewSelection->attachment)
                                    <div class="mb-3">
                                        <a href="{{ $interviewSelection->attachment }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Join Interview
                                        </a>
                                    </div>
                                    @endif
                                    @else
                                    <span class="text-muted">Waiting for portfolio approval</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Medical Checkup -->
                        <div class="col-md-4 mb-4">
                            <div
                                class="step-card card h-100 border-2 {{ $medicalSelection ? ($medicalSelection->status == 'accepted' ? 'border-success' : ($medicalSelection->status == 'rejected' ? 'border-danger' : 'border-warning')) : 'border-secondary' }}">
                                <div class="card-body text-center">
                                    <div
                                        class="step-icon {{ $medicalSelection ? ($medicalSelection->status == 'accepted' ? 'bg-success' : ($medicalSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning')) : 'bg-secondary' }}">
                                        @if ($medicalSelection)
                                        @if ($medicalSelection->status == 'accepted')
                                        <i class="fas fa-check-circle text-white"
                                            style="font-size: 2rem;"></i>
                                        @elseif($medicalSelection->status == 'rejected')
                                        <i class="fas fa-times-circle text-white"
                                            style="font-size: 2rem;"></i>
                                        @else
                                        <i class="fas fa-clock text-white"
                                            style="font-size: 2rem;"></i>
                                        @endif
                                        @else
                                        <i class="fas fa-heartbeat text-white"
                                            style="font-size: 2rem;"></i>
                                        @endif
                                        <div
                                            class="step-number {{ $medicalSelection ? ($medicalSelection->status == 'accepted' ? 'text-success' : ($medicalSelection->status == 'rejected' ? 'text-danger' : 'text-warning')) : 'text-secondary' }}">
                                            3</div>
                                    </div>
                                    <h5 class="card-title fw-bold">Medical Checkup</h5>
                                    <p class="card-text text-muted">Upload medical examination documents</p>

                                    @if (!$interviewSelection || $interviewSelection->status != 'accepted')
                                    <span class="text-muted">
                                        @if (!$interviewSelection)
                                        Waiting for interview scheduling
                                        @elseif($interviewSelection->status == 'pending')
                                        Interview pending approval
                                        @elseif($interviewSelection->status == 'rejected')
                                        Interview was rejected
                                        @else
                                        Waiting for interview completion
                                        @endif
                                    </span>
                                    @else
                                    @if ($medicalSelection)
                                    <span
                                        class="status-badge {{ $medicalSelection->status == 'accepted' ? 'bg-success' : ($medicalSelection->status == 'rejected' ? 'bg-danger' : 'bg-warning') }} text-white mb-3">
                                        {{ ucfirst($medicalSelection->status) }}
                                    </span>

                                    @if ($medicalSelection->status == 'pending')
                                    @if ($medicalSelection->attachment)
                                    <!-- Medical Report Already Uploaded - Show Current File and Replace Option -->
                                    <div class="mt-3">
                                        <div class="alert alert-info mb-3">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Medical Report Uploaded:</strong> Your medical report is
                                            currently under review.
                                        </div>

                                        <!-- Current Medical Report File -->
                                        <div class="mb-3">
                                            <div class="file-preview">
                                                <div
                                                    class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="bg-success rounded-circle p-2 me-3">
                                                            <i
                                                                class="fas fa-heartbeat text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Current Medical Report
                                                            </h6>
                                                            <small class="text-muted">Uploaded and
                                                                under review</small>
                                                        </div>
                                                    </div>
                                                    <a href="{{ $medicalSelection->attachment ?? '#' }}"
                                                        target="_blank"
                                                        class="btn btn-outline-success {{ !$medicalSelection->attachment ? 'disabled' : '' }}">
                                                        <i class="fas fa-eye me-1"></i>View Report
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Replace Medical Report Form -->
                                        <div class="upload-zone">
                                            <form action="{{ route('pelamar.upload-document') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="selection_id"
                                                    value="{{ $medicalSelection->id }}">
                                                <input type="hidden" name="stage"
                                                    value="medical_checkup">

                                                <div class="mb-3">
                                                    <i class="fas fa-sync-alt text-success mb-2"
                                                        style="font-size: 1.5rem;"></i>
                                                    <h6 class="mb-2">Replace Medical Report</h6>
                                                    <input type="file" class="form-control mb-2"
                                                        id="medical_replace_{{ $application->id }}"
                                                        name="attachment"
                                                        accept=".pdf,.doc,.docx" required>
                                                    <small class="text-muted">Supported: PDF, DOC,
                                                        DOCX (Max: 10MB)</small>
                                                </div>

                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fas fa-sync-alt me-2"></i>Replace
                                                    Medical Report
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                    <!-- No Medical Report Uploaded Yet - Show Upload Form -->
                                    <div class="mt-3">
                                        <div class="upload-zone">
                                            <form action="{{ route('pelamar.upload-document') }}"
                                                method="POST" enctype="multipart/form-data"
                                                class="text-center">
                                                @csrf
                                                <input type="hidden" name="applicant_id"
                                                    value="{{ $application->id }}">
                                                <input type="hidden" name="stage"
                                                    value="medical_checkup">

                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <i class="fas fa-cloud-upload-alt text-success"
                                                            style="font-size: 3rem;"></i>
                                                    </div>
                                                    <h6 class="text-success mb-2">Upload Your
                                                        Medical Report</h6>
                                                    <p class="text-muted mb-3">Drag and drop your
                                                        file here or click to browse</p>

                                                    <input type="file" class="form-control"
                                                        id="medical_file_{{ $application->id }}"
                                                        name="attachment"
                                                        accept=".pdf,.doc,.docx"
                                                        required>
                                                    <div class="form-text mt-2">Supported: PDF,
                                                        DOC, DOCX (Max: 10MB)</div>
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-success btn-lg px-4">
                                                    <i class="fas fa-upload me-2"></i>Upload
                                                    Medical Report
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    @elseif($medicalSelection->attachment)
                                    <!-- Medical Report with Non-Pending Status -->
                                    <div class="mb-3">
                                        <div class="file-preview">
                                            <div
                                                class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success rounded-circle p-2 me-3">
                                                        <i class="fas fa-heartbeat text-white"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Medical Report</h6>
                                                        <small
                                                            class="text-muted">{{ $medicalSelection->status == 'accepted' ? 'Approved' : 'Reviewed' }}</small>
                                                    </div>
                                                </div>
                                                <a href="{{ $medicalSelection->attachment_url ?? '#' }}"
                                                    target="_blank"
                                                    class="btn btn-outline-success {{ !$medicalSelection->attachment_url ? 'disabled' : '' }}">
                                                    <i class="fas fa-eye me-1"></i>View Report
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#medicalModal{{ $application->id }}">
                                        <i class="fas fa-upload me-2"></i>Upload Medical Report
                                    </button>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overall Progress -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Overall Progress</h6>
                                    @php
                                    $totalSteps = 3;
                                    $completedSteps = 0;
                                    if (
                                    $portfolioSelection &&
                                    $portfolioSelection->status == 'accepted'
                                    ) {
                                    $completedSteps++;
                                    }
                                    if (
                                    $interviewSelection &&
                                    $interviewSelection->status == 'accepted'
                                    ) {
                                    $completedSteps++;
                                    }
                                    if ($medicalSelection && $medicalSelection->status == 'accepted') {
                                    $completedSteps++;
                                    }
                                    $progressPercentage = ($completedSteps / $totalSteps) * 100;
                                    @endphp
                                    <div class="progress-modern mb-2">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $progressPercentage }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $completedSteps }} of {{ $totalSteps }}
                                        steps completed ({{ number_format($progressPercentage, 0) }}%)</small>

                                    @if ($completedSteps == $totalSteps)
                                    <div class="alert alert-success mt-3 mb-0 celebration-animation">
                                        <i class="fas fa-trophy me-2"></i><strong>Congratulations!</strong>
                                        You have successfully completed all selection stages.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Upload Modal -->
    <div class="modal fade" id="portfolioModal{{ $application->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0"
                    style="background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 15px 15px 0 0;">
                    <div class="text-white">
                        <h5 class="modal-title fw-bold mb-1">Upload Portfolio</h5>
                        <p class="mb-0 opacity-90">Share your best work with us</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pelamar.upload-document') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="applicant_id" value="{{ $application->id }}">
                    <input type="hidden" name="stage" value="portfolio">
                    <div class="modal-body p-4">
                        <div class="upload-zone mb-0">
                            <div class="mb-3">
                                <i class="fas fa-cloud-upload-alt text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="text-primary mb-2">Select Your Portfolio File</h6>
                            <p class="text-muted mb-3">Choose the file that best represents your work</p>

                            <input type="file" class="form-control" name="attachment" required
                                accept=".pdf,.doc,.docx,.zip,.rar">
                            <div class="form-text mt-2">Supported formats: PDF, DOC, DOCX, ZIP, RAR (Maximum
                                size: 10MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-upload me-2"></i>Upload Portfolio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Medical Upload Modal -->
    <div class="modal fade" id="medicalModal{{ $application->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0"
                    style="background: linear-gradient(135deg, #28a745, #20c997); border-radius: 15px 15px 0 0;">
                    <div class="text-white">
                        <h5 class="modal-title fw-bold mb-1">Upload Medical Report</h5>
                        <p class="mb-0 opacity-90">Submit your health examination results</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pelamar.upload-document') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="applicant_id" value="{{ $application->id }}">
                    <input type="hidden" name="stage" value="medical_checkup">
                    <div class="modal-body p-4">
                        <div class="upload-zone mb-0">
                            <div class="mb-3">
                                <i class="fas fa-heartbeat text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="text-success mb-2">Select Your Medical Report</h6>
                            <p class="text-muted mb-3">Upload your complete health examination document</p>

                            <input type="file" class="form-control" name="attachment" required
                                accept=".pdf,.doc,.docx">
                            <div class="form-text mt-2">Supported formats: PDF, DOC, DOCX (Maximum size: 10MB)
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-upload me-2"></i>Upload Medical Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle mx-auto"
                            style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-briefcase text-muted" style="font-size: 3rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-3">No Applications Found</h3>
                    <p class="text-muted mb-4 lead">You haven't submitted any job applications yet. Start your
                        career journey today!</p>
                    <a href="{{ route('pelamar.dashboard') }}" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-search me-2"></i>Browse Job Opportunities
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Add smooth animations and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Animate step cards on load
        const stepCards = document.querySelectorAll('.step-card');
        stepCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });

        // File input enhancement
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    const uploadZone = this.closest('.upload-zone');
                    if (uploadZone) {
                        const icon = uploadZone.querySelector('i');
                        const text = uploadZone.querySelector('h6, p');
                        if (icon) icon.className = 'fas fa-check-circle text-success';
                        if (text) text.textContent = `Selected: ${fileName}`;
                    }
                }
            });
        });

        // Progress bar animation
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });
    });
</script>
@endpush

@endsection