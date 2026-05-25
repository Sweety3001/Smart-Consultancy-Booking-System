<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function dashboard()
    {
        return view('consultant.dashboard');
    }

    public function earnings()
    {
        $consultant = auth()->user()->consultant;
        if(!$consultant) return abort(404);

        $bookings = \App\Models\Booking::where('consultant_id', $consultant->id)->pluck('id');
        $payments = \App\Models\Payment::with('booking.customer', 'booking.service')
            ->whereIn('booking_id', $bookings)
            ->where('status', 'successful')
            ->latest()
            ->paginate(15);

        $totalEarnings = \App\Models\Payment::whereIn('booking_id', $bookings)
            ->where('status', 'successful')
            ->sum('amount');

        return view('consultant.earnings', compact('payments', 'totalEarnings'));
    }
}
