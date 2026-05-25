@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    body {
        background: #f4f7f6;
        font-family: 'Inter', sans-serif;
    }
    
    /* Override app layout py-4 to center vertically */
    main.py-4 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        min-height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
    }

    .login-container {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        width: 100%;
        max-width: 1000px;
        display: flex;
        flex-wrap: wrap;
        animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .login-image {
        flex: 1.2;
        min-width: 350px;
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        color: white;
        overflow: hidden;
    }

    .login-image::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 10%, transparent 10%), radial-gradient(circle, rgba(255,255,255,0.08) 10%, transparent 10%);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
        animation: moveBg 30s linear infinite;
        opacity: 0.6;
    }

    .login-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(79, 70, 229, 0.5), transparent);
        z-index: 1;
    }

    @keyframes moveBg {
        0% { transform: translate(0, 0); }
        100% { transform: translate(60px, 60px); }
    }

    .login-image-content {
        position: relative;
        z-index: 2;
        text-align: left;
    }

    .login-image-content h2 {
        font-weight: 800;
        font-size: 3rem;
        line-height: 1.2;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .login-image-content p {
        font-size: 1.15rem;
        opacity: 0.9;
        line-height: 1.7;
        font-weight: 300;
    }

    .login-form-wrapper {
        flex: 1;
        min-width: 350px;
        padding: 4rem 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    .login-form-wrapper h3 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
        letter-spacing: -0.5px;
    }

    .login-form-wrapper p.subtitle {
        color: #6B7280;
        margin-bottom: 2.5rem;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        border: 1px solid #D1D5DB;
        background: #F9FAFB;
        transition: all 0.3s ease;
        box-shadow: none;
        font-size: 1rem;
        color: #111827;
    }

    .form-control::placeholder {
        color: #9CA3AF;
    }

    .form-control:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        outline: none;
    }

    .btn-login {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 600;
        color: white;
        width: 100%;
        font-size: 1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.2);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(124, 58, 237, 0.3);
        color: white;
    }

    .btn-login:active {
        transform: translateY(1px);
        box-shadow: 0 5px 10px rgba(124, 58, 237, 0.2);
    }

    .form-check-input {
        width: 1.1em;
        height: 1.1em;
        margin-top: 0.15em;
        border: 2px solid #D1D5DB;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        border-color: #4F46E5;
    }

    .form-check-label {
        cursor: pointer;
        padding-left: 0.5rem;
    }

    .forgot-password {
        color: #4F46E5;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: #4338CA;
        text-decoration: underline;
    }
    
    .register-link {
        color: #4F46E5;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .register-link:hover {
        color: #4338CA;
        text-decoration: underline;
    }

    @media (max-width: 850px) {
        .login-image {
            display: none;
        }
        .login-form-wrapper {
            padding: 3rem 2rem;
        }
        .login-card {
            max-width: 500px;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-image">
            <div class="login-image-content">
                <h2>Welcome<br>Back</h2>
                <p>Sign in to access your customized dashboard, manage your appointments, and explore new possibilities.</p>
            </div>
        </div>
        <div class="login-form-wrapper">
            <h3>Login</h3>
            <p class="subtitle">Please enter your credentials to proceed.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">

                    @error('email')
                        <span class="invalid-feedback mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">

                    @error('password')
                        <span class="invalid-feedback mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="form-check d-flex align-items-center mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" style="font-size: 0.875rem;" for="remember">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-login mb-4">
                    {{ __('Sign In') }}
                </button>
                
                @if (Route::has('register'))
                    <p class="text-center text-muted mb-0" style="font-size: 0.875rem;">
                        Don't have an account? <a href="{{ route('register') }}" class="register-link">Create one</a>
                    </p>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
