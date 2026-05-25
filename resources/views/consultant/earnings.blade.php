@extends('layouts.consultant')

@section('content')
<div class="earnings-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        
        .earnings-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-bottom: 2rem;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2.5rem;
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

        .total-earnings-badge {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(46, 204, 113, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .total-earnings-label {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
            font-weight: 600;
            margin: 0;
        }

        .total-earnings-amount {
            font-size: 1.6rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        /* Card and Table Styling */
        .earnings-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
        }

        .card-header-custom {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.5rem 2rem;
        }

        .card-title-custom {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid #edf2f7;
            border-top: none;
        }

        .table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .table tbody tr:hover td {
            background: rgba(46, 204, 113, 0.02);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Value Styling */
        .date-text {
            color: #64748b;
            font-size: 0.9rem;
        }

        .tx-id {
            font-family: monospace;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 6px;
            color: #475569;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .amount-text {
            font-weight: 700;
            color: #27ae60;
            font-size: 1.1rem;
        }
        
        .customer-name {
            font-weight: 600;
            color: #1e293b;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .empty-icon {
            font-size: 3.5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
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
            <h2 class="page-title">Earnings & Payments</h2>
            <p class="text-secondary mt-1 mb-0 fs-6">Track your consultation revenue and transaction history.</p>
        </div>
        <div class="total-earnings-badge">
            <i class="bi bi-wallet2 fs-2 opacity-75"></i>
            <div>
                <p class="total-earnings-label">Total Earnings</p>
                <p class="total-earnings-amount">₹{{ number_format($totalEarnings, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="earnings-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom"><i class="bi bi-receipt me-2 text-primary"></i> Payment History</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th class="text-end pe-4">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>
                                <span class="date-text">{{ $payment->created_at->format('M d, Y') }}</span><br>
                                <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                            </td>
                            <td><span class="tx-id">{{ $payment->razorpay_payment_id ?? 'N/A' }}</span></td>
                            <td><span class="customer-name">{{ $payment->booking->customer->name ?? 'N/A' }}</span></td>
                            <td>{{ $payment->booking->service->service_name ?? 'N/A' }}</td>
                            <td class="text-end pe-4"><span class="amount-text">₹{{ number_format($payment->amount, 2) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="bi bi-cash-stack empty-icon"></i>
                                <h4 class="fw-bold text-dark mt-2">No earnings recorded yet</h4>
                                <p class="text-muted mb-0">Payments will appear here once customers book your services.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @if($payments->hasPages())
    <div class="mt-4 d-flex justify-content-end">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
