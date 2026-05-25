<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $consultant = auth()->user()->consultant;
        if(!$consultant) return redirect()->route('consultant.dashboard')->with('error', 'Profile not found.');
        
        $services = \App\Models\Service::where('consultant_id', $consultant->id)->get();
        return view('consultant.services.index', compact('services'));
    }

    public function create()
    {
        return view('consultant.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
        ]);

        $consultant = auth()->user()->consultant;
        
        \App\Models\Service::create([
            'consultant_id' => $consultant->id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);

        return redirect()->route('consultant.services.index')->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = \App\Models\Service::where('consultant_id', auth()->user()->consultant->id)->findOrFail($id);
        return view('consultant.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
        ]);

        $service = \App\Models\Service::where('consultant_id', auth()->user()->consultant->id)->findOrFail($id);
        $service->update($request->only('service_name', 'description', 'price', 'duration'));

        return redirect()->route('consultant.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = \App\Models\Service::where('consultant_id', auth()->user()->consultant->id)->findOrFail($id);
        $service->delete();

        return redirect()->route('consultant.services.index')->with('success', 'Service deleted successfully.');
    }}
