@extends('layouts.app')

@section('title', 'Vehicle Booking Reports')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-chart-bar text-primary me-2"></i>
                Booking Reports
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('reports.index') }}" id="reportForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Region</label>
                            <select name="region_id" class="form-select">
                                <option value="">All Regions</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('reports.export', request()->all()) }}" class="btn btn-success">
                            <i class="fas fa-file-excel me-1"></i>Export Excel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                <h5>Excel Export</h5>
                <p class="text-muted">Download filtered bookings as Excel file with all details.</p>
                <div class="mt-3">
                    <span class="badge bg-info fs-6">{{ $bookings->count() }} bookings</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h6 class="mb-0">Bookings Report {{ request('date_from') || request('date_to') ? '(Filtered)' : '' }}</h6>
                <small class="text-muted">{{ $bookings->count() }} records</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Vehicle</th>
                                <th>Requester</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->start_date->format('d M Y') }}</td>
{{ $booking->vehicle?->license_plate ?? 'N/A' }}
                                <td>{{ $booking->requester->full_name }}</td>
                                <td><span class="badge bg-{{ $booking->status == 'approved' ? 'success' : 'warning' }}">{{ ucfirst($booking->status) }}</span></td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
