@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Overview</h2>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Users</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\User::where('role', 'customer')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Consultants</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Consultant::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Bookings</h6>
                <h2 class="mb-0 fw-bold">{{ \App\Models\Booking::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-dark-50">Total Revenue</h6>
                <h2 class="mb-0 fw-bold">₹{{ number_format(\App\Models\Payment::where('status', 'successful')->sum('amount'), 2) }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Recent Bookings</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Consultant</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentBookings = \App\Models\Booking::with('customer', 'consultant.user')->latest()->take(5)->get();
                            @endphp
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>{{ $booking->customer->name ?? 'N/A' }}</td>
                                <td>{{ $booking->consultant->user->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</td>
                                <td>
                                    @if($booking->status == 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>₹{{ $booking->total_amount }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">No recent bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
