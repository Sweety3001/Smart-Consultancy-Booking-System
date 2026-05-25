@extends('layouts.consultant')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Profile</h2>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('consultant.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row mb-4 text-center">
                <div class="col-12">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover; border: 3px solid #38b2ac;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-inline-flex justify-content-center align-items-center mb-3 fw-bold" style="width: 120px; height: 120px; font-size: 3rem;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <label class="btn btn-sm btn-outline-primary rounded-pill">
                            Change Image <input type="file" name="profile_image" class="d-none" accept="image/*">
                        </label>
                    </div>
                    @error('profile_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <h5 class="fw-bold border-bottom pb-2 mb-3">Basic Information</h5>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address <span class="text-muted small">(Cannot be changed)</span></label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>
            </div>

            <h5 class="fw-bold border-bottom pb-2 mb-3 mt-4">Consultant Details</h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $consultant->specialization) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Experience (Years)</label>
                    <input type="number" name="experience" class="form-control" value="{{ old('experience', $consultant->experience) }}" required min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Base Consultation Fee ($/hr)</label>
                    <input type="number" name="consultation_fee" step="0.01" class="form-control" value="{{ old('consultation_fee', $consultant->consultation_fee) }}" required min="0">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Biography</label>
                <textarea name="bio" rows="4" class="form-control">{{ old('bio', $consultant->bio) }}</textarea>
            </div>

            <div class="mb-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="availability_status" name="availability_status" value="1" {{ $consultant->availability_status ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="availability_status">Accepting New Bookings</label>
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-5">Save Profile</button>
        </form>
    </div>
</div>
@endsection
