@extends('layouts.app')

@section('content')
<div class="row justify-content-center min-vh-100 align-items-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 text-primary font-weight-bold">Welcome Back</h3>
                <p class="text-center mb-4 text-muted">Please login to continue</p>

                <!-- Success Message -->
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted">Email Address</label>
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-muted">Password</label>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="remember_me" class="form-check-label">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-indigo-600">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling for Login Form */
    .card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .card-body {
        padding: 2rem;
    }

    h3 {
        font-size: 1.75rem;
        color: #1c3d58;
    }

    .text-primary {
        color: #1D4ED8 !important; /* Custom Primary Color */
    }

    .text-muted {
        color: #6B7280 !important;
    }

    .btn-primary {
        background-color: #1D4ED8;
        border-color: #1D4ED8;
        padding: 12px 20px;
        font-size: 1.2rem;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #2563EB;
        transform: translateY(-2px);
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        box-shadow: none;
        font-size: 1rem;
        padding: 12px 16px;
    }

    .form-control:focus {
        border-color: #1D4ED8;
        box-shadow: 0 0 0 0.25rem rgba(29, 78, 216, 0.25);
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #dc3545;
    }

    .form-check-label {
        font-size: 0.875rem;
        color: #6B7280;
    }

    .form-check-input {
        margin-top: 0.25rem;
        margin-right: 0.5rem;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
@endsection
