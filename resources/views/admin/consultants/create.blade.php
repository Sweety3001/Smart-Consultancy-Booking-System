@extends('layouts.admin')

@section('content')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .premium-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
        padding: 2.5rem;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
    }
    .form-control, .form-select {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .input-group-text {
        border-radius: 10px 0 0 10px;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-right: none;
        color: #64748b;
    }
    .input-group .form-control {
        border-radius: 0 10px 10px 0;
    }
    .btn-submit {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        transition: all 0.2s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    }
</style>

<div class="form-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Consultant</h2>
        <a href="{{ route('admin.consultants') }}" class="btn btn-light rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="premium-card">
        <form action="{{ route('admin.consultants.store') }}" method="POST">
            @csrf
            
            <div class="form-section-title">
                <i class="bi bi-person-badge text-primary fs-5"></i> Account Information
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Jane Doe" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="jane@example.com" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Temporary Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Min 8 characters" required>
                    </div>
                    <small class="text-muted mt-1 d-block">Consultant can change this later.</small>
                </div>
            </div>

            <div class="form-section-title mt-2">
                <i class="bi bi-briefcase text-success fs-5"></i> Professional Details
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="e.g. Business Strategy" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="experience" class="form-label">Years of Experience</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="experience" name="experience" value="{{ old('experience') }}" min="0" required>
                        <span class="input-group-text" style="border-radius: 0 10px 10px 0; border-left: none; border-right: 1px solid #cbd5e1;">Years</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="consultation_fee" class="form-label">Base Consultation Fee</label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" step="0.01" class="form-control" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" min="0" placeholder="0.00" required>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary btn-submit text-white px-5">
                    Create Consultant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
