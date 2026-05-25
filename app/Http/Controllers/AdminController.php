<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = \App\Models\User::where('role', 'customer')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function consultants()
    {
        $consultants = \App\Models\Consultant::with('user')->paginate(15);
        return view('admin.consultants', compact('consultants'));
    }

    public function bookings()
    {
        $bookings = \App\Models\Booking::with('customer', 'consultant.user', 'service')->latest()->paginate(15);
        return view('admin.bookings', compact('bookings'));
    }

    public function payments()
    {
        $payments = \App\Models\Payment::with('booking.customer')->latest()->paginate(15);
        return view('admin.payments', compact('payments'));
    }

    public function blockUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot block an admin account.');
        }
        
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        
        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User successfully {$status}.");
    }

    public function createConsultant()
    {
        return view('admin.consultants.create');
    }

    public function storeConsultant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'consultant',
        ]);

        \App\Models\Consultant::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'availability_status' => true,
        ]);

        return redirect()->route('admin.consultants')->with('success', 'Consultant created successfully.');
    }

    public function destroyConsultant($id)
    {
        $consultant = \App\Models\Consultant::findOrFail($id);
        $user = $consultant->user;
        
        // This will cascade delete the consultant, services, slots, bookings, and payments
        $user->delete();

        return back()->with('success', 'Consultant and all associated data have been permanently removed.');
    }
}
