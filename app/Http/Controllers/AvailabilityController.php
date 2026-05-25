<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $consultant = auth()->user()->consultant;
        if(!$consultant) return redirect()->route('consultant.dashboard')->with('error', 'Profile not found.');

        $slots = \App\Models\AvailabilitySlot::where('consultant_id', $consultant->id)
            ->where('available_date', '>=', now()->toDateString())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        return view('consultant.availability.index', compact('slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'available_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $consultant = auth()->user()->consultant;

        \App\Models\AvailabilitySlot::create([
            'consultant_id' => $consultant->id,
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Availability slot added.');
    }

    public function destroy($id)
    {
        $slot = \App\Models\AvailabilitySlot::where('consultant_id', auth()->user()->consultant->id)->findOrFail($id);
        if ($slot->is_booked) {
            return redirect()->back()->with('error', 'Cannot delete a booked slot.');
        }
        $slot->delete();

        return redirect()->back()->with('success', 'Slot deleted.');
    }}
