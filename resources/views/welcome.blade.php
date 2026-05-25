<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ConsultBook') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --dark-bg: #0f172a;
            --dark-card: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            overflow-x: hidden;
            position: relative;
        }

        /* Abstract glowing background shapes */
        .bg-shape {
            position: absolute;
            filter: blur(100px);
            z-index: -1;
            border-radius: 50%;
            animation: float 20s infinite ease-in-out alternate;
        }
        .shape-1 {
            width: 500px;
            height: 500px;
            background: rgba(99, 102, 241, 0.15);
            top: -100px;
            left: -100px;
        }
        .shape-2 {
            width: 400px;
            height: 400px;
            background: rgba(139, 92, 246, 0.15);
            bottom: -50px;
            right: -50px;
            animation-delay: -10s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(20deg); }
        }

        /* Glassmorphism Navbar */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.6) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Nav Links */
        .nav-link {
            color: var(--text-main) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: var(--primary) !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Buttons */
        .btn-glow {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(99, 102, 241, 0.5);
            color: white;
        }
        .btn-outline-glow {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 0.65rem 1.8rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-outline-glow:hover {
            border-color: white;
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
        }
        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-title span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            font-weight: 300;
            max-width: 600px;
        }

        /* Features Section */
        .features-section {
            padding: 6rem 0;
            position: relative;
        }
        .feature-card {
            background: var(--dark-card);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .feature-card:hover::before {
            opacity: 1;
        }
        .feature-icon {
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }
        .feature-title {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        .feature-text {
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 2rem 0;
            text-align: center;
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-title { font-size: 3rem; }
            .hero-section { text-align: center; padding-top: 120px; }
            .hero-subtitle { margin: 0 auto 2rem auto; }
            .hero-content { display: flex; flex-direction: column; align-items: center; }
            .navbar-collapse {
                background: rgba(15, 23, 42, 0.95);
                padding: 1rem;
                border-radius: 10px;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-glass">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-layers-fill me-2" style="color: var(--primary);"></i>ConsultBook
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="btn-glow ms-lg-3 text-decoration-none d-inline-block mt-3 mt-lg-0">Go to Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn-outline-glow ms-lg-3 text-decoration-none d-inline-block mt-3 mt-lg-0">Sign up</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content mb-5 mb-lg-0">
                    <h1 class="hero-title">
                        Unlock Your Potential with <span>Expert Advice</span>
                    </h1>
                    <p class="hero-subtitle">
                        Connect with top-tier consultants instantly. Schedule sessions, manage your bookings, and elevate your business strategies through personalized guidance.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        @auth
                            <a href="{{ route('home') }}" class="btn-glow text-decoration-none">Explore Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-glow text-decoration-none">Get Started Free</a>
                            <a href="{{ route('login') }}" class="btn-outline-glow text-decoration-none">Log in</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <!-- A stylized CSS representation of a dashboard/booking -->
                    <div class="position-relative" style="perspective: 1000px;">
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 2rem; transform: rotateY(-15deg) rotateX(5deg); box-shadow: -20px 20px 40px rgba(0,0,0,0.5); backdrop-filter: blur(10px);">
                            <div class="d-flex align-items-center mb-4">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
                                    CB
                                </div>
                                <div class="ms-3">
                                    <div style="width: 120px; height: 12px; background: rgba(255,255,255,0.1); border-radius: 6px; margin-bottom: 8px;"></div>
                                    <div style="width: 80px; height: 8px; background: rgba(255,255,255,0.05); border-radius: 4px;"></div>
                                </div>
                            </div>
                            
                            <div style="background: rgba(0,0,0,0.2); border-radius: 10px; padding: 1.5rem; margin-bottom: 1rem;">
                                <div class="d-flex justify-content-between mb-3">
                                    <div style="width: 100px; height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;"></div>
                                    <div style="width: 50px; height: 10px; background: var(--primary); border-radius: 5px;"></div>
                                </div>
                                <div style="width: 100%; height: 60px; background: rgba(255,255,255,0.03); border-radius: 8px;"></div>
                            </div>

                            <div style="background: rgba(0,0,0,0.2); border-radius: 10px; padding: 1.5rem;">
                                <div class="d-flex gap-2">
                                    <div style="flex: 1; height: 40px; background: var(--secondary); border-radius: 8px; opacity: 0.8;"></div>
                                    <div style="flex: 1; height: 40px; background: rgba(255,255,255,0.05); border-radius: 8px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="font-size: 2.5rem;">Why Choose ConsultBook?</h2>
                <p class="text-muted" style="font-size: 1.1rem;">A seamless experience designed for both clients and professionals.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3 class="feature-title">Effortless Scheduling</h3>
                        <p class="feature-text">View real-time availability and book sessions instantly. Say goodbye to back-and-forth emails and timezone confusion.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3 class="feature-title">Secure Payments</h3>
                        <p class="feature-text">Integrated with industry-leading payment gateways for quick, safe, and reliable transactions for every booking.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="feature-title">Powerful Analytics</h3>
                        <p class="feature-text">Consultants get access to comprehensive dashboards to track earnings, upcoming appointments, and client engagement.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="mb-3 mb-md-0">
                    <span class="fw-bold text-white"><i class="bi bi-layers-fill me-2" style="color: var(--primary);"></i>ConsultBook</span> &copy; {{ date('Y') }}. All rights reserved.
                </div>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted text-decoration-none" style="transition:color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">Privacy Policy</a>
                    <a href="#" class="text-muted text-decoration-none" style="transition:color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">Terms of Service</a>
                    <a href="#" class="text-muted text-decoration-none" style="transition:color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='var(--text-muted)'">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
