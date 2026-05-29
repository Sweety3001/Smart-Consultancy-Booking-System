@extends('layouts.customer')

@section('content')
<div class="booking-create-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        .booking-create-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Card Styling */
        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }
        
        .booking-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #3498db, #8e44ad);
        }

        /* Consultant Header */
        .consultant-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(255,255,255,0.8);
        }

        .consultant-avatar {
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            object-fit: cover;
        }

        /* Form Inputs */
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        .custom-input, .custom-select {
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            padding: 0.85rem 1.2rem;
            border-radius: 12px;
            color: #2d3748;
            transition: all 0.3s ease;
            font-size: 1rem;
            width: 100%;
        }

        .custom-input:focus, .custom-select:focus {
            border-color: rgba(52, 152, 219, 0.5);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234a5568' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.2rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
        }

        textarea.custom-input {
            min-height: 120px;
            resize: vertical;
        }

        /* Submit Button */
        .btn-proceed {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 16px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            width: 100%;
        }

        .btn-proceed:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.4);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }
    </style>

    <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto">
            <div class="card booking-card">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="consultant-header d-flex flex-column flex-sm-row align-items-sm-center">
                        <div class="mb-3 mb-sm-0 me-sm-4 text-center text-sm-start">
                            @if($consultant->user->profile_image)
                                <img src="{{ asset('storage/'.$consultant->user->profile_image) }}" class="rounded-circle consultant-avatar" width="85" height="85">
                            @else
                                <div class="rounded-circle bg-white d-flex justify-content-center align-items-center text-primary fw-bold consultant-avatar mx-auto mx-sm-0" style="width: 85px; height: 85px; font-size: 2rem;">
                                    {{ substr($consultant->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-center text-sm-start">
                            <h3 class="fw-bold mb-1 text-dark">Book Appointment</h3>
                            <p class="text-muted mb-2 fs-6">with <span class="fw-bold text-primary">{{ $consultant->user->name }}</span></p>
                            <span class="badge bg-white text-primary border px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-briefcase me-1"></i>{{ $consultant->specialization }}</span>
                        </div>
                    </div>

                    <form action="{{ route('customer.bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="consultant_id" value="{{ $consultant->id }}">
                        
                        <div class="mb-4 pb-2">
                            <label class="form-label"><i class="bi bi-box-seam me-2 text-primary"></i>Select Service</label>
                            <select name="service_id" class="custom-select @error('service_id') is-invalid @enderror" required>
                                <option value="">-- Choose a service --</option>
                                @foreach($consultant->services as $service)
                                    <option value="{{ $service->id }}">{{ $service->service_name }} (₹{{ number_format($service->price, 2) }} - {{ $service->duration }} mins)</option>
                                @endforeach
                            </select>
                            @error('service_id') <div class="text-danger small mt-2 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-4 mb-4 pb-2">
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-calendar3 me-2 text-primary"></i>Select Date</label>
                                <input type="date" name="booking_date" class="custom-input @error('booking_date') is-invalid @enderror" required min="{{ date('Y-m-d') }}">
                                @error('booking_date') <div class="text-danger small mt-2 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="bi bi-clock me-2 text-primary"></i>Select Time Slot</label>
                                <select name="booking_time" class="custom-select @error('booking_time') is-invalid @enderror" required>
                                    <option value="">-- Choose time slot --</option>
                                    <!-- Basic implementation, ideally filtered by selected date via AJAX -->
                                    @foreach($consultant->availabilitySlots->where('is_booked', false) as $slot)
                                        <option value="{{ $slot->start_time }}">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }} ({{ \Carbon\Carbon::parse($slot->available_date)->format('M d') }})</option>
                                    @endforeach
                                </select>
                                @error('booking_time') <div class="text-danger small mt-2 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label"><i class="bi bi-card-text me-2 text-primary"></i>Additional Notes (Optional)</label>
                            <textarea name="notes" class="custom-input" placeholder="Any specific requirements, questions or context for the consultant?"></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn-proceed">
                                Proceed to Payment <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
