@extends('layouts.applicant')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #ffd401 0%, #ffed4e 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="h3 fw-bold text-dark mb-2">
                                    <i class="fas fa-hand-wave me-2"></i>
                                    Welcome back, {{ auth()->user()->name }}!
                                </h1>
                                <p class="text-dark mb-0 opacity-75">
                                    Track your application progress and manage your career journey with UT Careers.
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-user-tie" style="font-size: 4rem; color: rgba(0,0,0,0.1);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-file-alt text-primary fs-4"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-1">{{ $totalApplications }}</h3>
                        <p class="text-muted mb-0">Total Applications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock text-warning fs-4"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-1">{{ $pendingApplications }}</h3>
                        <p class="text-muted mb-0">Pending Review</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-tasks text-info fs-4"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-1">{{ $inSelectionApplications }}</h3>
                        <p class="text-muted mb-0">In Selection</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-1">{{ $acceptedApplications }}</h3>
                        <p class="text-muted mb-0">Accepted</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications & Selection Process -->
        <div class="row">
            <!-- Recent Applications -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">Recent Applications</h5>
                            <a href="{{ route('pelamar.applications') }}" class="btn btn-sm btn-outline-primary">
                                View All <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentApplications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Position</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentApplications as $application)
                                            <tr>
                                                <td>
                                                    <div class="fw-medium text-dark">{{ $application->jobPostCategory->jobPost->title }}</div>
                                                    <small class="text-muted">{{ $application->jobPostCategory->jobCategory->name }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded p-1 me-2">
                                                            <i class="fas fa-building text-primary"></i>
                                                        </div>
                                                        {{ $application->jobPostCategory->jobPost->company->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $application->status_badge }} bg-opacity-10 text-{{ $application->status_badge }} border border-{{ $application->status_badge }}">
                                                        {{ $application->status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $application->created_at }}</small>
                                                </td>

                                                <td>
                                                    @if($application->status === 'selection')
                                                        <a href="{{ route('pelamar.selection-process.detail', $application->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-3">No applications yet</h6>
                                <p class="text-muted">Start applying for jobs to see your applications here.</p>
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Browse Jobs
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold text-dark mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('pelamar.applications') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-alt me-3"></i>
                                    <span>My Applications</span>
                                </div>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('pelamar.selection-process') }}" class="btn btn-outline-info d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tasks me-3"></i>
                                    <span>Selection Process</span>
                                </div>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-briefcase me-3"></i>
                                    <span>Browse Jobs</span>
                                </div>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user me-3"></i>
                                    <span>Update Profile</span>
                                </div>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selection Progress for Active Applications -->
        @if($activeSelections->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="fw-bold text-dark mb-0">Active Selection Processes</h5>
                        </div>
                        <div class="card-body">
                            @foreach($activeSelections as $application)
                                <div class="border rounded p-4 mb-3">
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-8">
                                            <h6 class="fw-bold text-dark mb-1">{{ $application->jobPostCategory->jobPost->title }}</h6>
                                            <p class="text-muted mb-0">{{ $application->jobPostCategory->jobPost->company->name }}</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="{{ route('pelamar.selection-process.detail', $application->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Selection Progress -->
                                    <div class="row">
                                        @php
                                            $stages = ['portfolio', 'interview', 'medical_checkup'];
                                            $stageLabels = [
                                                'portfolio' => 'Portfolio Review',
                                                'interview' => 'Interview',
                                                'medical_checkup' => 'Medical Checkup'
                                            ];
                                        @endphp
                                        
                                        @foreach($stages as $index => $stage)
                                            @php
                                                $selection = $application->selections->where('stage', $stage)->first();
                                                $isCompleted = $selection && $selection->status === 'accepted';
                                                $isCurrent = $selection && in_array($selection->status, ['pending', 'in_review']);
                                                $isRejected = $selection && $selection->status === 'rejected';
                                            @endphp
                                            
                                            <div class="col-md-4 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        @if($isCompleted)
                                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-check text-white"></i>
                                                            </div>
                                                        @elseif($isCurrent)
                                                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-clock text-white"></i>
                                                            </div>
                                                        @elseif($isRejected)
                                                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-times text-white"></i>
                                                            </div>
                                                        @else
                                                            <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="fas fa-circle text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium text-dark">{{ $stageLabels[$stage] }}</div>
                                                        <small class="text-muted">
                                                            @if($isCompleted)
                                                                Completed
                                                            @elseif($isCurrent)
                                                                {{ ucfirst(str_replace('_', ' ', $selection->status)) }}
                                                            @elseif($isRejected)
                                                                Rejected
                                                            @else
                                                                Waiting
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection