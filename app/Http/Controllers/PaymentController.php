<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\CustomerSpending;

class PaymentController extends Controller
{
    public function checkout($booking_id)
    {
        $booking = Booking::with('consultant.user', 'service')->findOrFail($booking_id);
        
        if($booking->payment_status === 'paid') {
            return redirect()->route('customer.bookings.index')->with('error', 'Booking is already paid.');
        }

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        $orderData = [
            'receipt'         => 'rcptid_'.$booking->id,
            'amount'          => $booking->total_amount * 100,
            'currency'        => 'INR',
            'payment_capture' => 1
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);
        } catch (\Exception $e) {
            return back()->with('error', 'Razorpay error: ' . $e->getMessage());
        }

        return view('customer.payments.checkout', compact('booking', 'razorpayOrder'));
    }

    public function process(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $attributes = array(
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        );

        try {
            $api->utility->verifyPaymentSignature($attributes);
            
            $booking = Booking::findOrFail($request->booking_id);
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'confirmed'
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'amount' => $booking->total_amount,
                'status' => 'successful',
                'payment_method' => 'razorpay'
            ]);

            $spending = CustomerSpending::firstOrCreate(['customer_id' => $booking->customer_id]);
            $spending->increment('total_spent', $booking->total_amount);

            \Illuminate\Support\Facades\Mail::to($booking->customer->email)->send(new \App\Mail\BookingConfirmed($booking));
            
            return redirect()->route('customer.bookings.index')->with('success', 'Payment successful! Booking confirmed.');

        } catch(\Exception $e) {
            return redirect()->route('customer.bookings.index')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }
}
