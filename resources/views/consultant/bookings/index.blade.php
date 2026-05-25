@extends('layouts.consultant')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Bookings</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>#{{ $booking->id }}</td>
                        <td>
                            <strong>{{ collect($booking->customer)->get('name') ?? 'N/A' }}</strong>
                            <div class="small text-muted">{{ collect($booking->customer)->get('email') ?? '' }}</div>
                        </td>
                        <td>{{ $booking->service->service_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}<br><small class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</small></td>
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
                        <td>
                            @if($booking->status == 'pending' || $booking->status == 'confirmed')
                                <form action="{{ route('consultant.bookings.status', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as Completed">✓</button>
                                </form>
                                <form action="{{ route('consultant.bookings.status', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject this booking?');">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject / Cancel">✕</button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-light" disabled>Locked</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
