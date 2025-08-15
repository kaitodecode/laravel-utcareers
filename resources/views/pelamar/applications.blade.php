@extends('layouts.applicant')

@section('title', 'My Applications')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-dark mb-1">My Applications</h1>
                        <p class="text-muted mb-0">View and track all your job applications</p>
                    </div>
                    <a href="{{ route('pelamar.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if($applications->count() > 0)
            <!-- Applications List -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 px-4 py-3">Job Position</th>
                                            <th class="border-0 px-4 py-3">Company</th>
                                            <th class="border-0 px-4 py-3">Category</th>
                                            <th class="border-0 px-4 py-3">Applied Date</th>
                                            <th class="border-0 px-4 py-3">Status</th>
                                            <th class="border-0 px-4 py-3">Selection Progress</th>
                                            <th class="border-0 px-4 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($applications as $application)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                                                            <i class="fas fa-briefcase text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="fw-bold text-dark mb-0">{{ $application->jobPostCategory->jobPost->title }}</h6>
                                                            <small class="text-muted">{{ Str::limit($application->jobPostCategory->jobPost->description, 50) }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="fw-medium">{{ $application->jobPostCategory->jobPost->company->name }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="badge bg-light text-dark">{{ $application->jobPostCategory->jobCategory->name }}</span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="text-muted">{{ $application->created_at->format('d M Y') }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="badge {{ $application->status_badge }}">
                                                        {{ $application->status_label }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($application->status === 'selection')
                                                        @php
                                                            $stages = ['portfolio', 'interview', 'medical_checkup'];
                                                            $completedStages = 0;
                                                            foreach($stages as $stage) {
                                                                $selection = $application->selections->where('stage', $stage)->first();
                                                                if($selection && $selection->status === 'accepted') {
                                                                    $completedStages++;
                                                                }
                                                            }
                                                            $progressPercentage = ($completedStages / count($stages)) * 100;
                                                        @endphp
                                                        
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress me-2" style="width: 80px; height: 8px;">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressPercentage }}%"></div>
                                                            </div>
                                                            <small class="text-muted">{{ $completedStages }}/{{ count($stages) }}</small>
                                                        </div>
                                                        <small class="text-muted d-block">{{ $completedStages === 0 ? 'Portfolio Review' : ($completedStages === 1 ? 'Interview' : ($completedStages === 2 ? 'Medical Checkup' : 'Completed')) }}</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    @if($application->status === 'selection')
                                                        <a href="{{ route('pelamar.selection-process.detail', $application->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye me-1"></i>View Process
                                                        </a>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                                            <i class="fas fa-eye me-1"></i>View Details
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    @if($applications->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $applications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- No Applications -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-file-alt text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No Applications Yet</h4>
                            <p class="text-muted">You haven't applied for any jobs yet. Start exploring opportunities!</p>
                            <a href="#" class="btn btn-primary me-2">
                                <i class="fas fa-search me-2"></i>Browse Jobs
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