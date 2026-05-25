@extends('layouts.consultant')

@section('content')
<div class="services-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        
        .services-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-bottom: 2rem;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2rem 2.5rem;
            border-radius: 20px;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0;
            font-size: 2rem;
        }

        .btn-new-service {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-new-service:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.4);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }

        /* Card and Table Styling */
        .services-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid #edf2f7;
            border-top: none;
        }

        .table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            transition: all 0.2s ease;
        }

        .table tbody tr:hover td {
            background: rgba(52, 152, 219, 0.02);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges & Text Styling */
        .service-name {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.05rem;
            margin-bottom: 0.2rem;
        }
        
        .service-desc {
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .duration-badge {
            background: rgba(52, 152, 219, 0.1);
            color: #2980b9;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .price-text {
            font-weight: 700;
            color: #27ae60;
            font-size: 1.05rem;
        }

        /* Action Buttons */
        .btn-action-edit {
            background: transparent;
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.5);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-action-edit:hover {
            background: rgba(52, 152, 219, 0.1);
            color: #2980b9;
            border-color: #3498db;
        }

        .btn-action-delete {
            background: transparent;
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.5);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-action-delete:hover {
            background: rgba(231, 76, 60, 0.1);
            color: #c0392b;
            border-color: #e74c3c;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .empty-icon {
            font-size: 3.5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }
        }
    </style>

    <div class="page-header">
        <div>
            <h2 class="page-title">My Services</h2>
            <p class="text-secondary mt-1 mb-0 fs-6">Manage the consultation services you offer.</p>
        </div>
        <a href="{{ route('consultant.services.create') }}" class="btn-new-service">
            <i class="bi bi-plus-lg me-2"></i> New Service
        </a>
    </div>

    <div class="services-card">
        <div class="table-responsive">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th width="45%">Service Details</th>
                        <th width="15%">Duration</th>
                        <th width="15%">Price (₹)</th>
                        <th width="25%" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>
                            <div class="service-name">{{ $service->service_name }}</div>
                            <div class="service-desc">{{ Str::limit($service->description, 60) }}</div>
                        </td>
                        <td>
                            <span class="duration-badge">
                                <i class="bi bi-clock me-1"></i> {{ $service->duration }} mins
                            </span>
                        </td>
                        <td>
                            <span class="price-text">₹{{ number_format($service->price, 2) }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('consultant.services.edit', $service->id) }}" class="btn-action-edit me-2">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>
                            <form action="{{ route('consultant.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <i class="bi bi-briefcase empty-icon"></i>
                            <h4 class="fw-bold text-dark mt-2">No services active</h4>
                            <p class="text-muted mb-4">You haven't created any services yet.</p>
                            <a href="{{ route('consultant.services.create') }}" class="btn-new-service">
                                <i class="bi bi-plus-lg me-2"></i> Create Your First Service
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
