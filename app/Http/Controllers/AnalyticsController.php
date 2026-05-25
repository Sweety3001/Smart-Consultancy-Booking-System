<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::where('role', 'customer')->count();
        $totalConsultants = \App\Models\Consultant::count();
        $totalRevenue = \App\Models\Payment::where('status', 'successful')->sum('amount');
        $totalBookings = \App\Models\Booking::count();

        $recentSpendings = \App\Models\CustomerSpending::with('customer')->orderByDesc('total_spent')->take(5)->get();

        $revenueData = \App\Models\Payment::selectRaw('date(created_at) as date, sum(amount) as total')
            ->where('status', 'successful')
            ->groupBy('date')
            ->get();

        return view('admin.analytics', compact('totalUsers', 'totalConsultants', 'totalRevenue', 'totalBookings', 'recentSpendings', 'revenueData'));
    }}
