@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Payments</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Txn ID</th>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->razorpay_payment_id ?? 'N/A' }}</td>
                        <td>#{{ $payment->booking_id }}</td>
                        <td>{{ $payment->booking->customer->name ?? 'N/A' }}</td>
                        <td><strong class="text-primary">₹{{ $payment->amount }}</strong></td>
                        <td><span class="badge bg-dark">{{ ucfirst($payment->payment_method) }}</span></td>
                        <td>
                            @if($payment->status == 'successful')
                                <span class="badge bg-success">Successful</span>
                            @elseif($payment->status == 'failed')
                                <span class="badge bg-danger">Failed</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-end">
    {{ $payments->links() }}
</div>
@endsection
