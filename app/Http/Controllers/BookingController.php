<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create($consultant_id)
    {
        $consultant = \App\Models\Consultant::with('user', 'services', 'availabilitySlots')->findOrFail($consultant_id);
        return view('customer.bookings.create', compact('consultant'));
    }

    public function store(Request $request, \App\Services\BookingService $bookingService)
    {
        $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

        try {
            $booking = $bookingService->createBooking($request->all(), auth()->id());
            return redirect()->route('customer.payments.checkout', $booking->id);
        } catch (\Exception $e) {
            return back()->withErrors(['booking_time' => $e->getMessage()])->withInput();
        }
    }

    public function customerIndex()
    {
        $bookings = \App\Models\Booking::with('consultant.user', 'service')->where('customer_id', auth()->id())->latest()->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    public function consultantIndex()
    {
        $consultant = auth()->user()->consultant;
        if(!$consultant) return abort(404);
        $bookings = \App\Models\Booking::with('customer', 'service')->where('consultant_id', $consultant->id)->latest()->get();
        return view('consultant.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:confirmed,cancelled,completed']);
        
        $booking = \App\Models\Booking::where('consultant_id', auth()->user()->consultant->id)->findOrFail($id);
        $booking->update(['status' => $request->status]);

        // If cancelled by consultant, free up the slot
        if ($request->status === 'cancelled') {
            \App\Models\AvailabilitySlot::where('consultant_id', $booking->consultant_id)
                ->where('available_date', $booking->booking_date)
                ->where('start_time', $booking->booking_time)
                ->update(['is_booked' => false]);
        }

        return back()->with('success', 'Booking status updated.');
    }

    public function cancel($id)
    {
        $booking = \App\Models\Booking::where('customer_id', auth()->id())->findOrFail($id);
        
        if ($booking->status === 'completed') {
            return back()->with('error', 'Cannot cancel a completed booking.');
        }

        $booking->update(['status' => 'cancelled']);

        \App\Models\AvailabilitySlot::where('consultant_id', $booking->consultant_id)
            ->where('available_date', $booking->booking_date)
            ->where('start_time', $booking->booking_time)
            ->update(['is_booked' => false]);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
