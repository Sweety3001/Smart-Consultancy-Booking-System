@extends('layouts.consultant')

@section('content')
<div class="dashboard-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        
        .dashboard-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-bottom: 2rem;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2.5rem 2.5rem;
            border-radius: 20px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0;
            font-size: 2.2rem;
        }

        .btn-new-service {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-new-service:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.4);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 24px;
            border: none;
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px rgba(0,0,0,0.1);
        }

        .stat-card-body {
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .stat-bg-icon {
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 7rem;
            opacity: 0.15;
            z-index: 1;
            transform: rotate(-15deg);
        }

        .stat-title {
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }

        .stat-value {
            font-weight: 800;
            font-size: 3rem;
            margin-bottom: 0;
            line-height: 1;
        }

        /* Gradients for cards */
        .bg-gradient-info { background: linear-gradient(135deg, #00c6ff, #0072ff); }
        .bg-gradient-success { background: linear-gradient(135deg, #11998e, #38ef7d); }
        .bg-gradient-primary { background: linear-gradient(135deg, #8e2de2, #4a00e0); }

        /* Schedule Card */
        .schedule-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
            margin-top: 1.5rem;
        }

        .schedule-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem 2rem;
        }

        .schedule-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .schedule-body {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-schedule-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h2 class="page-title">My Dashboard</h2>
            <p class="text-secondary mt-1 mb-0 fs-6">Overview of your bookings and performance.</p>
        </div>
        <a href="{{ route('consultant.services.create') }}" class="btn-new-service">
            <i class="bi bi-plus-lg me-2"></i> New Service
        </a>
    </div>

    <div class="row g-4">
        <!-- Upcoming Bookings -->
        <div class="col-md-4">
            <div class="card stat-card bg-gradient-info text-white">
                <div class="stat-card-body">
                    <h6 class="stat-title text-uppercase">Upcoming Bookings</h6>
                    <h2 class="stat-value">8</h2>
                    <i class="bi bi-calendar-event stat-bg-icon"></i>
                </div>
            </div>
        </div>

        <!-- Total Earnings -->
        <div class="col-md-4">
            <div class="card stat-card bg-gradient-success text-white">
                <div class="stat-card-body">
                    <h6 class="stat-title text-uppercase">Total Earnings</h6>
                    <h2 class="stat-value">₹3,250</h2>
                    <i class="bi bi-wallet2 stat-bg-icon"></i>
                </div>
            </div>
        </div>

        <!-- Active Services -->
        <div class="col-md-4">
            <div class="card stat-card bg-gradient-primary text-white">
                <div class="stat-card-body">
                    <h6 class="stat-title text-uppercase">Active Services</h6>
                    <h2 class="stat-value">4</h2>
                    <i class="bi bi-briefcase stat-bg-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card schedule-card">
                <div class="schedule-header">
                    <h5 class="schedule-title"><i class="bi bi-clock-history me-2 text-primary"></i>Today's Schedule</h5>
                </div>
                <div class="card-body schedule-body">
                    <i class="bi bi-calendar2-x empty-schedule-icon"></i>
                    <h4 class="fw-bold text-dark mt-2">No appointments today</h4>
                    <p class="text-muted mb-0 fs-5">Enjoy your free time or manage your services.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
