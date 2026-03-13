@extends('layouts.app')

@section('title', 'Vehicle Bookings')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="mb-0">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    Pemesanan Kendaraan
                </h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Pemesanan Baru
                </a>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vehicle</th>
                            <th>Requester</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->start_date->format('d/M/Y') }} - {{ $booking->end_date->format('d/M/Y') }}</td>
{{ $booking->vehicle?->license_plate ?? 'N/A' }}
                            <td>{{ $booking->requester->full_name }}</td>
                            <td>{{ $booking->driver->full_name ?? 'TBD' }}</td>
                            <td>
                                <span class="badge badge-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
                                No bookings yet. Create your first booking!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
