<x-mail::message>
# Your Booking is Confirmed!

Hi {{ $booking->customer->name }},

Your booking with **{{ $booking->consultant->user->name }}** for the service **{{ $booking->service->service_name }}** has been successfully confirmed.

**Date:** {{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}  
**Time:** {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}

<x-mail::button :url="route('customer.bookings.index')">
View Booking Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
