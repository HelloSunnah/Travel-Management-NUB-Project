@extends('layouts.app')

@section('content')
<div class="row justify-content-center min-vh-100 align-items-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 text-success font-weight-bold">Create Your Account</h3>
                <p class="text-center mb-4 text-muted">Please fill in the details below to register</p>

                <!-- Success Message -->
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted">Full Name</label>
                        <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your full name" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted">Email Address</label>
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-muted">Password</label>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-muted">Confirm Password</label>
                        <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-6">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-indigo-600">
                            Already have an account? Log in
                        </a>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling for Registration Form */
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

    .text-success {
        color: #10B981 !important; /* Custom Success Color */
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

    .text-sm {
        font-size: 0.875rem;
    }

    .d-flex {
        display: flex;
    }

    .d-grid {
        display: grid;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

@endsection
