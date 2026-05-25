<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Consultant</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { height: 100vh; background-color: #1a202c; color: #fff; padding-top: 20px; position: fixed; width: 250px; overflow-y: auto;}
        .sidebar a { color: #a0aec0; text-decoration: none; padding: 12px 20px; display: block; transition: 0.3s; font-weight: 500;}
        .sidebar a:hover, .sidebar a.active { background-color: #2d3748; color: #fff; border-left: 3px solid #38b2ac; }
        .main-wrapper { margin-left: 250px; min-height: 100vh; }
        .content { padding: 30px; }
        .navbar { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.04); }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); border-radius: 0.5rem; transition: transform 0.2s;}
        .card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mb-4 text-white fw-bold">Consultant Panel</h4>
        <a href="{{ route('consultant.dashboard') }}" class="{{ request()->routeIs('consultant.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('consultant.services.index') }}" class="{{ request()->routeIs('consultant.services.*') ? 'active' : '' }}">Services</a>
        <a href="{{ route('consultant.availability.index') }}" class="{{ request()->routeIs('consultant.availability.*') ? 'active' : '' }}">Availability</a>
        <a href="{{ route('consultant.bookings.index') }}" class="{{ request()->routeIs('consultant.bookings.*') ? 'active' : '' }}">Bookings</a>
        <a href="{{ route('consultant.earnings') }}" class="{{ request()->routeIs('consultant.earnings') ? 'active' : '' }}">Earnings</a>
        <a href="{{ route('consultant.profile') }}" class="{{ request()->routeIs('consultant.profile') ? 'active' : '' }}">Profile</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mt-5 text-danger">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
    <div class="main-wrapper">
        <nav class="navbar navbar-expand-lg px-4 py-3">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h5 fw-bold">Welcome, {{ Auth::user()->name }}</span>
            </div>
        </nav>
        <div class="content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</body>
</html>
