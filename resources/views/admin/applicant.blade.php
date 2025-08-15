@extends('layouts.admin')

@section('title', 'Applicant Management')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-1">Applicant Management</h1>
                <p class="text-muted mb-0">Manage job applicants and their selection process</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('applicants.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-medium text-dark">Search</label>
                        <div class="position-relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name or email..." class="form-control ps-5"
                                style="border-color: #dee2e6; border-radius: 0.5rem;">
                            <i class="fas fa-search position-absolute text-muted"
                                style="left: 12px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-medium text-dark">Status</label>
                        <select name="status" class="form-select" style="border-color: #dee2e6; border-radius: 0.5rem;">
                            <option value="">All Status</option>
                            @foreach (['pending' => 'Pending', 'selection' => 'In Selection', 'accepted' => 'Accepted', 'rejected' => 'Rejected'] as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Company Filter -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-medium text-dark">Company</label>
                        <select name="company_id" class="form-select" style="border-color: #dee2e6; border-radius: 0.5rem;">
                            <option value="">All Companies</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="col-12 col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn w-100 fw-medium"
                            style="background-color: #ffd401; color: black; border-radius: 0.5rem; border: none;">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applicants Table -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Applicant</th>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Job Position</th>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Company</th>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Status</th>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Applied Date</th>
                            <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $applicant)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-25 d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <span class="text-dark fw-medium small">
                                                {{ strtoupper(substr($applicant->user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div class="ms-3">
                                            <div class="small fw-medium text-dark">{{ $applicant->user->name }}</div>
                                            <div class="small text-muted">{{ $applicant->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="small fw-medium text-dark">
                                        {{ $applicant->jobPostCategory->jobPost->title }}</div>
                                    <div class="small text-muted">{{ $applicant->jobPostCategory->jobCategory->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="small text-dark">{{ $applicant->jobPostCategory->jobPost->company->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="badge 
                                    @if ($applicant->status == 'pending') bg-warning text-dark
                                    @elseif($applicant->status == 'selection') bg-primary
                                    @elseif($applicant->status == 'accepted') bg-success
                                    @else bg-danger @endif">
                                        {{ $applicant->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 small text-muted">
                                    {{ optional($applicant->created_at)->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex gap-2">
                                        <a {{-- href="{{ route('admin.applicants.selections', $applicant->id) }}"  --}} class="btn btn-link btn-sm p-0 text-primary"
                                            data-bs-toggle="modal" data-bs-target="#selectionModal{{ $applicant->id }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-link btn-sm p-0 text-primary"
                                            data-bs-toggle="modal" data-bs-target="#documentModal"
                                            data-document-url="{{ $applicant->cv }}" data-document-title="CV">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                        <button type="button" class="btn btn-link btn-sm p-0 text-success"
                                            data-bs-toggle="modal" data-bs-target="#documentModal"
                                            data-document-url="{{ $applicant->national_identity_card }}"
                                            data-document-title="ID Card">
                                            <i class="fas fa-id-card"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Selection Modal for each applicant -->
                            <div class="modal fade" id="selectionModal{{ $applicant->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Selection Process</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                <div class="bg-light rounded p-3">
                                                    <h6 class="fw-semibold mb-2">Applicant Information</h6>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small><strong>Name:</strong>
                                                                {{ $applicant->user->name }}</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small><strong>Email:</strong>
                                                                {{ $applicant->user->email }}</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small><strong>Position:</strong>
                                                                {{ $applicant->jobPostCategory->jobPost->title }}</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small><strong>Company:</strong>
                                                                {{ $applicant->jobPostCategory->jobPost->company->name }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h6 class="fw-semibold mb-3">Selection Timeline</h6>
                                                <div class="d-flex flex-column gap-3">
                                                    @php
                                                        $stages = ['portfolio', 'interview', 'medical_checkup'];
                                                        $lastPassedIndex = -1;

                                                        foreach ($applicant->selections as $selection) {
                                                            $currentIndex = array_search($selection->stage, $stages);
                                                            if (
                                                                $selection->status == 'accepted' &&
                                                                $currentIndex > $lastPassedIndex
                                                            ) {
                                                                $lastPassedIndex = $currentIndex;
                                                            }
                                                        }
                                                    @endphp

                                                    @foreach ($stages as $index => $stage)
                                                        @php
                                                            $selection = $applicant->selections
                                                                ->where('stage', $stage)
                                                                ->first();
                                                            $isEnabled =
                                                                $index == 0 ||
                                                                ($index > 0 && $lastPassedIndex >= $index - 1);
                                                        @endphp

                                                        <div
                                                            class="d-flex align-items-start p-3 bg-white border rounded {{ !$isEnabled ? 'opacity-50' : '' }}">
                                                            <div class="rounded-circle 
                                                                @if ($selection && $selection->status == 'accepted') bg-success 
                                                                @elseif($selection && $selection->status == 'rejected') bg-danger
                                                                @elseif($selection && $selection->status == 'in_review') bg-primary
                                                                @else bg-warning @endif 
                                                                bg-opacity-25 d-flex align-items-center justify-content-center me-3"
                                                                style="width: 32px; height: 32px; min-width: 32px;">
                                                                <small class="fw-medium">{{ $index + 1 }}</small>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-3">
                                                                    <h6 class="fw-medium mb-0">
                                                                        {{ ucfirst(str_replace('_', ' ', $stage)) }}</h6>
                                                                    @if ($selection)
                                                                        <span
                                                                            class="badge 
                                                                            @if ($selection->status == 'accepted') bg-success
                                                                            @elseif($selection->status == 'rejected') bg-danger
                                                                            @elseif($selection->status == 'in_review') bg-primary
                                                                            @else bg-warning @endif">
                                                                            {{ ucfirst(str_replace('_', ' ', $selection->status)) }}
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                @if ($isEnabled)
                                                                    @if ($stage == 'portfolio')
                                                                        <div class="mt-2">
                                                                            @if ($selection && $selection->attachment)
                                                                                <div class="d-flex gap-2 mb-3">
                                                                                    <a href="{{ $selection->attachment }}"
                                                                                        target="_blank" type="button">
                                                                                        <i class="fas fa-eye me-1"></i>
                                                                                        View Portfolio
                                                                                        {{ $selection->attachment }}
                                                                                    </a>
                                                                                </div>
                                                                            @else
                                                                                <div class="alert alert-warning mb-0">
                                                                                    <i
                                                                                        class="fas fa-exclamation-triangle me-2"></i>
                                                                                    Waiting for portfolio submission
                                                                                </div>
                                                                            @endif

                                                                            @if (!($selection && $selection->status == 'accepted'))
                                                                                <form
                                                                                    action="{{ route('applicants.selections.update', ['applicant' => $applicant->id, 'selection' => $selection ? $selection->id : 0]) }}"
                                                                                    method="POST" class="mt-3">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="stage"
                                                                                        value="{{ $stage }}">
                                                                                    <div class="d-flex gap-2">
                                                                                        <button type="submit"
                                                                                            name="status"
                                                                                            value="accepted"
                                                                                            class="btn btn-sm btn-success"
                                                                                            {{ !($selection && $selection->attachment) ? 'disabled' : '' }}>
                                                                                            <i
                                                                                                class="fas fa-check me-1"></i>
                                                                                            Approve
                                                                                        </button>
                                                                                        <button type="submit"
                                                                                            name="status"
                                                                                            value="rejected"
                                                                                            class="btn btn-sm btn-danger">
                                                                                            <i
                                                                                                class="fas fa-times me-1"></i>
                                                                                            Reject
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    @elseif($stage == 'interview')
                                                                        <div class="mt-2">
                                                                            @if ($selection && $selection->attachment)
                                                                                <div class="alert alert-info mb-3">
                                                                                    <i class="fas fa-video me-2"></i>
                                                                                    Interview link uploaded
                                                                                    <a href="{{ $selection->attachment }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-outline-primary ms-2">
                                                                                        <i
                                                                                            class="fas fa-external-link-alt me-1"></i>
                                                                                        Join Interview
                                                                                    </a>
                                                                                </div>
                                                                            @else
                                                                                <form
                                                                                    action="{{ route('applicants.upload-interview-details') }}"
                                                                                    method="POST" class="mb-3">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="applicant_id"
                                                                                        value="{{ $applicant->id }}">
                                                                                    <div class="mb-2">
                                                                                        <label
                                                                                            class="form-label small">Interview
                                                                                            URL (Zoom/Meet)</label>
                                                                                        <input type="url"
                                                                                            name="interview_url"
                                                                                            class="form-control form-control-sm"
                                                                                            required>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        class="btn btn-sm btn-primary">
                                                                                        <i class="fas fa-upload me-1"></i>
                                                                                        Upload Link
                                                                                    </button>
                                                                                </form>
                                                                            @endif

                                                                            @if (!($selection && $selection->status == 'accepted'))
                                                                                <form
                                                                                    action="{{ route('applicants.selections.update', ['applicant' => $applicant->id, 'selection' => $selection ? $selection->id : 0]) }}"
                                                                                    method="POST" class="mt-2">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <input type="hidden" name="stage"
                                                                                        value="{{ $stage }}">
                                                                                    <div class="d-flex gap-2">
                                                                                        <button type="submit"
                                                                                            name="status"
                                                                                            value="accepted"
                                                                                            class="btn btn-sm btn-success"
                                                                                            {{ !($selection && $selection->attachment) ? 'disabled' : '' }}>
                                                                                            <i
                                                                                                class="fas fa-check me-1"></i>
                                                                                            Approve
                                                                                        </button>
                                                                                        <button type="submit"
                                                                                            name="status"
                                                                                            value="rejected"
                                                                                            class="btn btn-sm btn-danger">
                                                                                            <i
                                                                                                class="fas fa-times me-1"></i>
                                                                                            Reject
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            @endif
                                                                        </div>
                                                                    @elseif($stage == 'medical_checkup')
                                                                        <div class="mt-2">
                                                                            @if ($selection && $selection->attachment)
                                                                                <div class="d-flex gap-2 mb-3">
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-secondary"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#documentModal"
                                                                                        data-document-url="{{ $selection->attachment }}"
                                                                                        data-document-title="Medical Report">
                                                                                        <i class="fas fa-eye me-1"></i>
                                                                                        View Medical Report
                                                                                    </button>
                                                                                </div>
                                                                            @else
                                                                                <div class="alert alert-warning mb-3">
                                                                                    <i
                                                                                        class="fas fa-exclamation-triangle me-2"></i>
                                                                                    Waiting for medical report submission
                                                                                </div>
                                                                            @endif

                                                                            <form
                                                                                action="{{ route('applicants.approve-medical-document') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="selection_id"
                                                                                    value="{{ $selection->id }}">   
                                                                                <div class="d-flex gap-2">
                                                                                    <button type="submit" name="status"
                                                                                        value="accepted"
                                                                                        class="btn btn-sm btn-success"
                                                                                        {{ !($selection && $selection->attachment) ? 'disabled' : '' }}>
                                                                                        <i class="fas fa-check me-1"></i>
                                                                                        Approve Medical
                                                                                    </button>
                                                                                    <button type="submit" name="status"
                                                                                        value="rejected"
                                                                                        class="btn btn-sm btn-danger">
                                                                                        <i class="fas fa-times me-1"></i>
                                                                                        Reject Medical
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    @else
                                                                        <form
                                                                            action="{{ route('applicants.selections.update', ['applicant' => $applicant->id, 'selection' => $selection ? $selection->id : 0]) }}"
                                                                            method="POST" class="mt-2">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="stage"
                                                                                value="{{ $stage }}">
                                                                            <div class="d-flex gap-2">
                                                                                <select name="status"
                                                                                    class="form-select form-select-sm"
                                                                                    required>
                                                                                    <option value="">Select Status
                                                                                    </option>
                                                                                    <option value="pending"
                                                                                        {{ $selection && $selection->status == 'pending' ? 'selected' : '' }}>
                                                                                        Pending</option>
                                                                                    <option value="in_review"
                                                                                        {{ $selection && $selection->status == 'in_review' ? 'selected' : '' }}>
                                                                                        In Review</option>
                                                                                    <option value="accepted"
                                                                                        {{ $selection && $selection->status == 'accepted' ? 'selected' : '' }}>
                                                                                        Accepted</option>
                                                                                    <option value="rejected"
                                                                                        {{ $selection && $selection->status == 'rejected' ? 'selected' : '' }}>
                                                                                        Rejected</option>
                                                                                </select>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary btn-sm">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    @endif
                                                                @endif

                                                                @if ($selection)
                                                                    <small class="text-muted d-block mt-2">
                                                                        Last updated:
                                                                        {{ $selection->created_at->format('F d, Y') }}
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    @if (!$applicant->selections->count())
                                                        <div class="text-center py-4">
                                                            <i class="fas fa-clipboard-list display-4 text-muted mb-3"></i>
                                                            <h6 class="fw-medium">No Selection Process</h6>
                                                            <p class="small text-muted">This applicant hasn't entered the
                                                                selection process yet.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-5 text-center">
                                    <div class="text-muted">
                                        <i class="fas fa-users display-4 mb-3 text-muted"></i>
                                        <p class="h5 fw-medium">No applicants found</p>
                                        <p class="small">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($applicants->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $applicants->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <!-- Document Modal -->
    <div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe style="width: 100%; height: 75vh;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
