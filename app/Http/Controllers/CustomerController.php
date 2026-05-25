<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $upcomingBookings = \App\Models\Booking::with('consultant.user', 'service')
            ->where('customer_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        $totalSpent = \App\Models\Booking::where('customer_id', auth()->id())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('customer.dashboard', compact('upcomingBookings', 'totalSpent'));
    }

    public function consultants(Request $request)
    {
        $query = \App\Models\Consultant::with('user')->where('availability_status', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('specialization', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $consultants = $query->paginate(10)->appends($request->all());
        
        return view('customer.consultants', compact('consultants'));
    }
}
