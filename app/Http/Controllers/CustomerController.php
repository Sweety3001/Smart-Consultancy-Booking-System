<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard');
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
