@extends('layouts.customer')

@section('content')
<div class="consultants-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        .consultants-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2.5rem 2rem;
            border-radius: 20px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
        }
        
        .page-title {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Card Styling */
        .consultant-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            position: relative;
        }

        .consultant-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3498db, #8e44ad);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .consultant-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .consultant-card:hover::before {
            opacity: 1;
        }

        .consultant-avatar-wrap {
            position: relative;
            display: inline-block;
            padding: 4px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #8e44ad);
            margin-bottom: 1rem;
        }

        .consultant-avatar {
            border: 3px solid white;
            border-radius: 50%;
            background: white;
            object-fit: cover;
        }

        .specialization-badge {
            background: rgba(52, 152, 219, 0.1);
            color: #2980b9;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        /* Buttons & Forms */
        .btn-premium {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.25);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }

        .search-input {
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            padding: 12px 24px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: rgba(52, 152, 219, 0.5);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            outline: none;
        }
    </style>

    <div class="page-header row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="page-title display-5">Browse Consultants</h2>
            <p class="text-secondary fs-5 mb-0">Discover and book sessions with our top-tier expert consultants.</p>
        </div>
        <div class="col-lg-6">
            <form action="{{ route('customer.consultants') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control rounded-pill search-input me-3" placeholder="Search by name or specialization..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-premium">Search</button>
                @if(request('search'))
                    <a href="{{ route('customer.consultants') }}" class="btn btn-light rounded-pill ms-2 px-4 border" style="padding-top: 12px; padding-bottom: 12px; font-weight: 500;">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($consultants as $consultant)
        <div class="col-md-6 col-lg-4">
            <div class="card consultant-card h-100">
                <div class="card-body text-center p-4">
                    <div class="consultant-avatar-wrap">
                        @if($consultant->user->profile_image)
                            <img src="{{ asset('storage/'.$consultant->user->profile_image) }}" class="consultant-avatar" width="100" height="100">
                        @else
                            <div class="consultant-avatar d-inline-flex justify-content-center align-items-center text-primary fw-bold" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ substr($consultant->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="fw-bold mb-2">{{ $consultant->user->name }}</h4>
                    <div class="specialization-badge">{{ $consultant->specialization }}</div>
                    
                    <div class="d-flex justify-content-center gap-4 mb-4 text-secondary">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-briefcase text-primary fs-5 me-2"></i> 
                            <span class="fw-medium">{{ $consultant->experience }} yrs exp</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cash-coin text-success fs-5 me-2"></i> 
                            <span class="fw-medium">₹{{ number_format($consultant->consultation_fee, 2) }}/hr</span>
                        </div>
                    </div>
                    
                    <p class="text-muted text-truncate mb-4" style="max-height: 48px; font-size: 0.95rem; line-height: 1.5;">{{ $consultant->bio ?? 'No biography provided yet. Ready to assist you with expertise.' }}</p>
                    
                    <a href="{{ route('customer.bookings.create', $consultant->id) }}" class="btn btn-premium w-100">Book Appointment</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm border border-light">
                <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                <h3 class="mt-3 text-dark fw-bold">No consultants found</h3>
                <p class="text-muted fs-5">We couldn't find any consultants matching your criteria.</p>
                @if(request('search'))
                    <a href="{{ route('customer.consultants') }}" class="btn btn-primary mt-3 rounded-pill px-4">View All Consultants</a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $consultants->links() }}
    </div>
</div>
@endsection
