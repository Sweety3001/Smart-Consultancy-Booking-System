@extends('layouts.consultant')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Create New Service</h2>
    <a href="{{ route('consultant.services.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Back</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('consultant.services.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Service Name</label>
                <input type="text" name="service_name" class="form-control @error('service_name') is-invalid @enderror" value="{{ old('service_name') }}" required>
                @error('service_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Duration (Minutes)</label>
                    <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration') }}" required>
                    @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary rounded-pill px-4">Save Service</button>
        </form>
    </div>
</div>
@endsection
