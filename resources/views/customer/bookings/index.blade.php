@extends('layouts.customer')

@section('content')
<div class="bookings-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        .bookings-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2.5rem 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
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

        /* Card and Table Styling */
        .bookings-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8f9fa;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid #edf2f7;
        }

        .table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #4a5568;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover td {
            background: rgba(52, 152, 219, 0.02);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge-custom {
            padding: 0.5rem 0.85rem;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
        }

        .badge-success-custom {
            background: rgba(46, 204, 113, 0.1);
            color: #27ae60;
            border: 1px solid rgba(46, 204, 113, 0.2);
        }

        .badge-primary-custom {
            background: rgba(52, 152, 219, 0.1);
            color: #2980b9;
            border: 1px solid rgba(52, 152, 219, 0.2);
        }

        .badge-warning-custom {
            background: rgba(241, 196, 15, 0.1);
            color: #d35400;
            border: 1px solid rgba(241, 196, 15, 0.2);
        }

        .badge-danger-custom {
            background: rgba(231, 76, 60, 0.1);
            color: #c0392b;
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        /* Buttons */
        .btn-pay {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }

        .btn-cancel {
            background: transparent;
            color: #e74c3c;
            border: 1px solid #e74c3c;
            padding: 7px 18px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
        }

        .empty-state {
            padding: 5rem 2rem;
            text-align: center;
        }
        
        .empty-icon {
            font-size: 4.5rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
        <div class="mb-3 mb-md-0">
            <h2 class="page-title display-6 mb-1">My Bookings</h2>
            <p class="text-secondary mb-0 fs-6">Manage your upcoming appointments and consultation history.</p>
        </div>
        <div>
            <a href="{{ route('customer.consultants') }}" class="btn btn-pay px-4 py-2" style="font-size: 1rem;">
                <i class="bi bi-plus-lg me-1"></i> New Booking
            </a>
        </div>
    </div>

    <div class="bookings-card">
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th width="8%">ID</th>
                        <th width="25%">Consultant</th>
                        <th width="20%">Service</th>
                        <th width="18%">Date & Time</th>
                        <th width="12%">Payment</th>
                        <th width="12%">Status</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 bg-light text-primary d-flex justify-content-center align-items-center fw-bold rounded-circle border shadow-sm" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                    {{ substr(collect($booking->consultant->user)->get('name', 'N'), 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ collect($booking->consultant->user)->get('name') ?? 'N/A' }}</h6>
                                    <small class="text-muted"><i class="bi bi-person-badge text-primary me-1"></i>{{ $booking->consultant->specialization ?? 'Consultant' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $booking->service->service_name }}</div>
                        </td>
                        <td>
                            <div class="fw-medium text-dark mb-1">
                                <i class="bi bi-calendar3 text-primary me-1"></i> {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                            </div>
                            <small class="text-muted fw-medium">
                                <i class="bi bi-clock text-primary me-1"></i> {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                            </small>
                        </td>
                        <td>
                            @if($booking->payment_status == 'paid')
                                <span class="badge-custom badge-success-custom"><i class="bi bi-check-circle me-1"></i> Paid</span>
                            @else
                                <a href="{{ route('customer.payments.checkout', $booking->id) }}" class="btn btn-pay">Pay Now</a>
                            @endif
                        </td>
                        <td>
                            @if($booking->status == 'completed')
                                <span class="badge-custom badge-primary-custom"><i class="bi bi-star me-1"></i> Completed</span>
                            @elseif($booking->status == 'confirmed')
                                <span class="badge-custom badge-success-custom"><i class="bi bi-check-circle me-1"></i> Confirmed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="badge-custom badge-danger-custom"><i class="bi bi-x-circle me-1"></i> Cancelled</span>
                            @else
                                <span class="badge-custom badge-warning-custom"><i class="bi bi-clock-history me-1"></i> Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-cancel" title="Cancel Booking">
                                        Cancel
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small px-2 text-center d-block">--</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="bi bi-calendar-x empty-icon"></i>
                            <h4 class="fw-bold text-dark mt-3">No bookings found</h4>
                            <p class="text-muted mb-4 fs-5">You haven't scheduled any consultations yet.</p>
                            <a href="{{ route('customer.consultants') }}" class="btn btn-pay px-4 py-2" style="font-size: 1rem;">Browse Consultants</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
