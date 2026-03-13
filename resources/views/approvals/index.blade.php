@extends('layouts.app')

@section('title', 'Booking Approvals')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-check-circle text-success me-2"></i>
                Pending Approvals
            </h1>
            <small class="text-muted">Review and approve vehicle bookings</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bookings Requiring Approval</h5>
                <span class="badge bg-warning">{{ $pendingCount ?? 0 }} pending</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Requester</th>
                                <th>Driver</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingBookings as $booking)
                            <tr>
                                <td>
                                    <strong>{{ $booking->start_date->format('d M Y') }}</strong>
                                    <br><small>{{ $booking->end_date->format('d M Y') }}</small>
                                </td>
{{ $booking->vehicle?->license_plate ?? 'N/A' }}
                                <td>{{ $booking->requester->full_name }}</td>
                                <td>{{ $booking->driver->full_name ?? 'Not assigned' }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($booking->purpose ?? 'N/A', 50) }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form method="POST" action="{{ route('approvals.approve', $booking) }}" style="display:inline;" onsubmit="return confirm('Approve this booking?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('approvals.reject', $booking) }}" style="display:inline;" onsubmit="return confirm('Reject this booking?')">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" value="Rejected by approver">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-clipboard-check fa-4x text-muted mb-4 d-block"></i>
                                    <h5 class="text-muted">No pending approvals</h5>
                                    <p class="text-muted">All bookings approved or no new requests.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
