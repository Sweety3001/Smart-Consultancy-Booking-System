@extends('layouts.customer')

@section('content')
<div class="checkout-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        
        .checkout-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-top: 1rem;
            padding-bottom: 4rem;
        }

        /* Card Styling */
        .checkout-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border-radius: 28px;
            overflow: hidden;
            position: relative;
        }
        
        .checkout-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #3498db, #8e44ad);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .checkout-title {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 2.2rem;
        }

        /* Booking Details Section */
        .details-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.8);
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.01);
            margin-bottom: 2rem;
        }

        .details-heading {
            font-weight: 700;
            color: #1e293b;
            border-bottom: 2px dashed #cbd5e1;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            align-items: flex-start;
        }

        .detail-label {
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .detail-value {
            color: #0f172a;
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        .total-box {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #e2e8f0;
        }

        .total-label {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e293b;
        }

        .total-amount {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Razorpay Button Overrides */
        .razorpay-payment-button {
            background: linear-gradient(135deg, #3498db, #2980b9) !important;
            color: white !important;
            border: none !important;
            padding: 16px 30px !important;
            border-radius: 50px !important;
            font-size: 1.15rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3) !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .razorpay-payment-button:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.4) !important;
            background: linear-gradient(135deg, #2980b9, #2471a3) !important;
        }
        
        .payment-secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            font-weight: 500;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <div class="card checkout-card p-4 p-md-5">
                
                <div class="checkout-header">
                    <div class="mb-3">
                        <div class="d-inline-flex justify-content-center align-items-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 70px; height: 70px;">
                            <i class="bi bi-credit-card fs-1"></i>
                        </div>
                    </div>
                    <h3 class="checkout-title">Complete Payment</h3>
                    <p class="text-secondary mt-2 mb-0">You're just one step away from confirming your session.</p>
                </div>
                
                <div class="details-box">
                    <h5 class="details-heading">
                        <i class="bi bi-receipt text-primary me-2"></i>Booking Details
                    </h5>
                    
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-person me-2 text-primary"></i>Consultant</span>
                        <span class="detail-value">{{ $booking->consultant->user->name }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-briefcase me-2 text-primary"></i>Service</span>
                        <span class="detail-value">{{ $booking->service->service_name }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-calendar-event me-2 text-primary"></i>Date & Time</span>
                        <span class="detail-value text-end">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}<br>
                            <span class="text-muted small">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                        </span>
                    </div>
                    
                    <div class="total-box">
                        <span class="total-label">Total Amount</span>
                        <span class="total-amount">₹{{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <form action="{{ route('customer.payments.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env('RAZORPAY_KEY') }}"
                                data-amount="{{ $razorpayOrder['amount'] }}"
                                data-currency="INR"
                                data-order_id="{{ $razorpayOrder['id'] }}"
                                data-buttontext="Pay Now Securely"
                                data-name="ConsultBook"
                                data-description="Payment for Consultant Session"
                                data-prefill.name="{{ Auth::user()->name }}"
                                data-prefill.email="{{ Auth::user()->email }}"
                                data-theme.color="#3498db">
                        </script>
                    </form>
                    
                    <div class="payment-secure-badge">
                        <i class="bi bi-shield-lock-fill me-2 text-success"></i> Payments are 100% secure and encrypted
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
