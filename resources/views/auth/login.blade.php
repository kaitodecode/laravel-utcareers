<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ffd401;
        }
        .bg-primary-custom { background-color: var(--primary-color) !important; }
        .text-primary-custom { color: var(--primary-color) !important; }
        .border-primary-custom { border-color: var(--primary-color) !important; }
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 212, 1, 0.25);
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: #000;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #e6bf00;
            transform: translateY(-2px);
        }
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center p-3">
        <div class="login-card p-4 p-sm-5" style="width: 100%; max-width: 450px;">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center gap-3 mb-4">
                    <div class="bg-primary-custom p-3 rounded">
                        <i class="fas fa-briefcase text-dark fs-4"></i>
                    </div>
                    <div class="text-start">
                        <h1 class="h4 mb-0">UT Careers</h1>
                        <p class="small text-muted mb-0">Career Management</p>
                    </div>
                </div>
                <h2 class="h3 mb-2">Welcome Back!</h2>
                <p class="text-muted">Please sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-4">
                    <label for="login" class="form-label">Email or Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input id="login" type="text" name="login" value="{{ old('login') }}" 
                            class="form-control border-start-0 ps-0" placeholder="Enter email or phone number" required autocomplete="username" autofocus>
                    </div>
                    @error('login')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input id="password" type="password" name="password" 
                            class="form-control border-start-0 ps-0" required autocomplete="current-password">
                    </div>
                    @error('password')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" 
                            class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary-custom">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
{{-- 
                <p class="text-center mb-0">
                    <span class="text-muted">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary-custom ms-1">Sign up</a>
                </p> --}}
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
