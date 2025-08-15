@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Total Users Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 212, 1, 0.1); color: #ffd401">
                        <i class="fas fa-users fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted small mb-1">Total Users <i class="fas fa-info-circle text-muted" title="Total registered users"></i></h6>
                        <h3 class="fw-bold mb-0">156</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Jobs Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 212, 1, 0.1); color: #ffd401">
                        <i class="fas fa-briefcase fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted small mb-1">Active Jobs <i class="fas fa-info-circle text-muted" title="Currently active job listings"></i></h6>
                        <h3 class="fw-bold mb-0">42</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 212, 1, 0.1); color: #ffd401">
                        <i class="fas fa-file-alt fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted small mb-1">Applications <i class="fas fa-info-circle text-muted" title="Total job applications"></i></h6>
                        <h3 class="fw-bold mb-0">284</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 212, 1, 0.1); color: #ffd401">
                        <i class="fas fa-building fs-4"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted small mb-1">Companies <i class="fas fa-info-circle text-muted" title="Registered companies"></i></h6>
                        <h3 class="fw-bold mb-0">25</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mt-4">
    <!-- Applications Chart -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-4">
                    Applications Trend <i class="fas fa-chart-line text-muted ms-2"></i>
                </h5>
                <canvas id="applicationsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Job Categories Chart -->
    <div class="col-12 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark mb-4">
                    Job Categories Distribution <i class="fas fa-chart-pie text-muted ms-2"></i>
                </h5>
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="mt-5">
    <h5 class="fw-bold text-dark mb-4">
        Recent Activity <i class="fas fa-history text-muted ms-2"></i>
    </h5>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: rgba(255, 212, 1, 0.1)">
                    <tr>
                        <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">
                            User <i class="fas fa-user text-muted ms-1"></i>
                        </th>
                        <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">
                            Action <i class="fas fa-tasks text-muted ms-1"></i>
                        </th>
                        <th class="px-4 py-3 text-start small fw-medium text-muted text-uppercase">
                            Date <i class="fas fa-calendar text-muted ms-1"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-3">John Doe</td>
                        <td class="px-4 py-3">Applied for Software Engineer position</td>
                        <td class="px-4 py-3">2024-03-15</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Jane Smith</td>
                        <td class="px-4 py-3">Updated company profile</td>
                        <td class="px-4 py-3">2024-03-14</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">Mike Johnson</td>
                        <td class="px-4 py-3">Posted new job listing</td>
                        <td class="px-4 py-3">2024-03-13</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Applications Trend Chart
    const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(applicationsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Applications',
                data: [45, 59, 80, 81, 56, 55],
                borderColor: '#ffd401',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Job Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Technology', 'Marketing', 'Sales', 'Design', 'Other'],
            datasets: [{
                data: [30, 20, 25, 15, 10],
                backgroundColor: [
                    '#ffd401',
                    '#ffdc33',
                    '#ffe466',
                    '#ffec99',
                    '#fff4cc'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endpush

@endsection
