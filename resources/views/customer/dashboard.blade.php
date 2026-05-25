@extends('layouts.customer')

@section('content')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        padding: 4rem 2rem;
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.15);
        animation: fadeDown 0.8s ease-out;
    }
    
    .dashboard-header::before {
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
        opacity: 0.5;
    }

    @keyframes moveBg {
        0% { transform: translate(0, 0); }
        100% { transform: translate(60px, 60px); }
    }
    
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-header-content {
        position: relative;
        z-index: 2;
    }

    .btn-browse {
        background: white;
        color: #4F46E5;
        font-weight: 700;
        border-radius: 50px;
        padding: 12px 35px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: all 0.3s;
        border: none;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        color: #7C3AED;
    }

    .premium-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
    }

    .card-header-custom {
        background: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.5rem;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: #F3F4F6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        color: #9CA3AF;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: rgba(79, 70, 229, 0.1);
        color: #4F46E5;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem auto;
    }
</style>

<div class="row g-4 mb-5">
    <div class="col-md-12">
        <div class="dashboard-header text-center text-white">
            <div class="dashboard-header-content">
                <h1 class="display-4 fw-bolder mb-3" style="letter-spacing: -1px;">Find the Perfect Consultant</h1>
                <p class="lead mb-4 fw-light" style="opacity: 0.9;">Book 1-on-1 sessions with top experts across various domains to accelerate your growth.</p>
                <div>
                    <a href="{{ route('customer.consultants') }}" class="btn btn-browse text-decoration-none">Browse Experts</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="premium-card h-100">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Upcoming Appointments</h5>
                <a href="{{ route('customer.bookings.index') }}" class="btn btn-sm" style="background: rgba(79, 70, 229, 0.1); color: #4F46E5; border-radius: 50px; padding: 5px 15px; font-weight: 600; text-decoration: none;">View All</a>
            </div>
            <div class="card-body p-0">
                @if($upcomingBookings->count() > 0)
                    <div class="list-group list-group-flush border-0">
                        @foreach($upcomingBookings as $booking)
                            <div class="list-group-item p-4 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if($booking->consultant->user->profile_image)
                                            <img src="{{ asset('storage/'.$booking->consultant->user->profile_image) }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold; background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                                                {{ substr($booking->consultant->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $booking->service->service_name }}</h6>
                                            <p class="mb-0 text-muted small">with {{ $booking->consultant->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="badge bg-light text-dark border mb-1 px-3 py-2 rounded-pill">
                                            <i class="bi bi-calendar3 me-1 text-primary" style="color: #4F46E5 !important;"></i> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                        </div>
                                        <div class="small fw-bold" style="color: #4F46E5;">
                                            <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar2-x" viewBox="0 0 16 16">
                                <path d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                            </svg>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">No upcoming appointments</h5>
                        <p class="text-muted mb-4">You don't have any sessions scheduled right now. Ready to learn something new?</p>
                        <a href="{{ route('customer.consultants') }}" class="btn btn-primary" style="background: #4F46E5; border: none; border-radius: 50px; padding: 10px 25px; font-weight: 500;">Book a Session</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="premium-card stats-card h-100 d-flex align-items-center justify-content-center p-4">
            <div class="text-center w-100">
                <div class="stats-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                    </svg>
                </div>
                <h5 class="fw-bold text-muted mb-2" style="font-size: 1.1rem;">Total Spent</h5>
                <h2 class="fw-bolder mb-0" style="color: #4F46E5; font-size: 2.5rem; letter-spacing: -1px;">₹{{ number_format($totalSpent, 2) }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
