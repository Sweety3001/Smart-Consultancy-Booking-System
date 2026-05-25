<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\AvailabilitySlot;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    /**
     * Create a new booking with concurrency protection.
     *
     * @param array $data
     * @param int $customerId
     * @return \App\Models\Booking
     * @throws Exception
     */
    public function createBooking(array $data, int $customerId)
    {
        return DB::transaction(function () use ($data, $customerId) {
            // Lock the availability slot for update to prevent race conditions
            $slot = AvailabilitySlot::where('consultant_id', $data['consultant_id'])
                ->where('available_date', $data['booking_date'])
                ->where('start_time', $data['booking_time'])
                ->lockForUpdate()
                ->first();

            // Check if slot exists and is not already booked
            if (!$slot) {
                throw new Exception("Invalid time slot selected.");
            }

            if ($slot->is_booked) {
                throw new Exception("This slot is not available. Please select another slot.");
            }

            $service = Service::findOrFail($data['service_id']);

            // Create the booking
            $booking = Booking::create([
                'customer_id' => $customerId,
                'consultant_id' => $data['consultant_id'],
                'service_id' => $data['service_id'],
                'booking_date' => $data['booking_date'],
                'booking_time' => $data['booking_time'],
                'status' => 'pending',
                'payment_status' => 'pending',
                'total_amount' => $service->price,
                'notes' => $data['notes'] ?? null,
            ]);

            // Mark slot as booked
            $slot->update(['is_booked' => true]);

            return $booking;
        });
    }
}
