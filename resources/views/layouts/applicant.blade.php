<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ffd401;
        }
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        .text-primary-custom { color: var(--primary-color) !important; }
        .border-primary-custom { border-color: var(--primary-color) !important; }
        .sidebar-gradient {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            width: 280px;
            position: fixed;
            height: 100vh;
            z-index: 1040;
        }
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            transform: translateX(4px);
        }
        .main-content {
            margin-left: 280px;
        }
        .top-nav {
            left: 280px;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9) !important;
        }
        .nav-link {
            color: #adb5bd;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
        }
        .nav-link:hover {
            background-color: var(--primary-color);
            color: #000;
        }
        .profile-card {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        .top-nav-btn {
            padding: 0.5rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }
        .top-nav-btn:hover {
            background-color: var(--primary-color);
            color: #000;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 0.75rem;
            padding: 1rem;
        }
        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }
        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: #000;
        }
        .search-box {
            width: 300px;
            transition: all 0.3s ease;
        }
        .search-box:focus {
            width: 350px;
            box-shadow: 0 0 0 0.25rem rgba(255, 212, 1, 0.25);
        }
    </style>
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex">
        <!-- Sidebar -->
        <aside class="sidebar-gradient text-white overflow-auto">
            <!-- Logo Section -->
            <div class="p-4 border-bottom border-secondary">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary-custom p-2 rounded">
                        <i class="fas fa-briefcase text-dark fs-5"></i>
                    </div>
                    <div>
                        <h1 class="h5 mb-0 text-white">UT Careers</h1>
                        <p class="small text-muted mb-0">Applicant Portal</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-3">
                <div class="mb-4">
                    <p class="text-uppercase small fw-bold text-muted mb-3">Main Menu</p>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a href="{{ route('pelamar.dashboard') }}" class="nav-link d-flex align-items-center">
                                <i class="fas fa-home me-3"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pelamar.applications') }}" class="nav-link d-flex align-items-center">
                                <i class="fas fa-file-alt me-3"></i>
                                <span>My Applications</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pelamar.selection-process') }}" class="nav-link d-flex align-items-center">
                                <i class="fas fa-tasks me-3"></i>
                                <span>Selection Process</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <p class="text-uppercase small fw-bold text-muted mb-3">Job Opportunities</p>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a href="#" class="nav-link d-flex align-items-center">
                                <i class="fas fa-search me-3"></i>
                                <span>Job Opportunities</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-4">
                    <p class="text-uppercase small fw-bold text-muted mb-3">Account</p>
                    <ul class="nav flex-column gap-2">
                        <li class="nav-item">
                            <a href="#" class="nav-link d-flex align-items-center">
                                <i class="fas fa-user me-3"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link d-flex align-items-center">
                                <i class="fas fa-cog me-3"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>

            <!-- User Profile Card -->
            <div class="position-absolute bottom-0 start-0 end-0 p-3">
                <div class="profile-card rounded p-3">
                    <div class="d-flex align-items-center gap-3">
                        <img class="rounded-circle border border-2 border-primary-custom" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=ffd401&color=000" alt="User" width="40" height="40">
                        <div class="flex-grow-1">
                            <p class="small fw-medium text-white mb-0">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="small text-muted mb-0">Applicant</p>
                        </div>
                        <button class="btn btn-link text-muted p-0">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm position-sticky top-0 top-nav z-3">
                <div class="d-flex justify-content-between align-items-center px-4 py-3">
                    <div>
                        <h2 class="h4 mb-0 d-flex align-items-center gap-2">
                            @yield('title', '<i class="fas fa-hand-wave text-primary-custom"></i> Welcome back, ' . (auth()->user()->name ?? 'User') . '!')
                        </h2>
                    </div>
                    <div class="d-flex align-items-center gap-4">
                        <!-- Notifications -->
                        <button class="btn top-nav-btn position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <button class="btn d-flex align-items-center gap-3 top-nav-btn" data-bs-toggle="dropdown">
                                <img class="rounded-circle border border-2 border-primary-custom" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=ffd401&color=000" alt="User" width="32" height="32">
                                <div class="text-start d-none d-sm-block">
                                    <p class="small fw-medium mb-0">{{ auth()->user()->name ?? 'User' }}</p>
                                    <p class="small text-muted mb-0">Applicant</p>
                                </div>
                                <i class="fas fa-chevron-down text-muted small"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>