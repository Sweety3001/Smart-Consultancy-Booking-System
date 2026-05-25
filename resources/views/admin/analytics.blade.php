@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Analytics Dashboard</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Users</h6>
                <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Consultants</h6>
                <h2 class="mb-0 fw-bold">{{ $totalConsultants }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-white-50">Total Bookings</h6>
                <h2 class="mb-0 fw-bold">{{ $totalBookings }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body">
                <h6 class="card-title text-uppercase text-dark-50">Total Revenue</h6>
                <h2 class="mb-0 fw-bold">₹{{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Revenue Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Top Spenders</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentSpendings as $spending)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                {{ substr($spending->customer->name, 0, 1) }}
                            </div>
                            <span>{{ $spending->customer->name }}</span>
                        </div>
                        <span class="badge bg-success rounded-pill">₹{{ number_format($spending->total_spent, 2) }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center py-4">No data available</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueData);
    
    const labels = revenueData.map(data => data.date);
    const data = revenueData.map(data => data.total);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue (₹)',
                data: data,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
