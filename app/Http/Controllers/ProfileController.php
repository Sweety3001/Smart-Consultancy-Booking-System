<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function consultantProfile()
    {
        $user = auth()->user();
        $consultant = $user->consultant;
        return view('consultant.profile', compact('user', 'consultant'));
    }

    public function updateConsultantProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'availability_status' => 'boolean'
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $imagePath;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        if ($user->consultant) {
            $user->consultant->update([
                'specialization' => $request->specialization,
                'experience' => $request->experience,
                'consultation_fee' => $request->consultation_fee,
                'bio' => $request->bio,
                'availability_status' => $request->has('availability_status')
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function customerProfile()
    {
        $user = auth()->user();
        return view('customer.profile', compact('user'));
    }

    public function updateCustomerProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $imagePath;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
