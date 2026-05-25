@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Consultants</h2>
    <a href="{{ route('admin.consultants.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Add Consultant
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Consultant Info</th>
                        <th>Specialization</th>
                        <th>Fee</th>
                        <th>Availability</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultants as $consultant)
                    <tr>
                        <td>{{ $consultant->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($consultant->user->profile_image)
                                    <img src="{{ asset('storage/'.$consultant->user->profile_image) }}" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center me-2" style="width: 40px; height: 40px;">
                                        {{ substr($consultant->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $consultant->user->name }}</strong>
                                    <div class="small text-muted">{{ $consultant->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $consultant->specialization }}<br><small>{{ $consultant->experience }} yrs exp</small></td>
                        <td>₹{{ $consultant->consultation_fee }}</td>
                        <td>
                            @if($consultant->availability_status)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-secondary">Busy</span>
                            @endif
                        </td>
                        <td>
                            @if($consultant->user->is_blocked)
                                <span class="badge bg-danger">Blocked</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.users.block', $consultant->user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $consultant->user->is_blocked ? 'btn-success' : 'btn-danger' }}">
                                    {{ $consultant->user->is_blocked ? 'Unblock' : 'Block' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.consultants.destroy', $consultant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to completely remove this consultant and ALL of their data (services, bookings, slots)? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Remove Consultant">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No consultants found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4 d-flex justify-content-end">
    {{ $consultants->links() }}
</div>
@endsection
