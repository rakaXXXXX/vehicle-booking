@extends('layouts.app')

@section('title', 'Booking Detail - ' . $booking->booking_number)

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-receipt text-primary me-2"></i>
                Booking #{{ $booking->booking_number }}
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status:</label>
                        <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal:</label>
                        <div>
                            <strong>{{ $booking->start_date->format('d M Y H:i') }}</strong> 
                            s/d 
                            <strong>{{ $booking->end_date->format('d M Y H:i') }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Kendaraan:</label>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-{{ $booking->vehicle->type == 'passenger' ? 'car' : 'truck' }} fa-2x text-primary"></i>
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h5 class="mb-1">{{ $booking->vehicle->license_plate }}</h5>
                                <p class="mb-1">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
                                <small class="text-muted">
                                    Region: {{ $booking->vehicle->region->name ?? 'N/A' }} | 
                                    Fuel: {{ $booking->vehicle->fuel_consumption }} km/l
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pemohon:</label>
                        <p>{{ $booking->requester->full_name }} ({{ $booking->requester->role }})</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Driver:</label>
                        <p>{{ $booking->driver->full_name ?? 'Belum ditentukan' }} </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Approver L1:</label>
                        <p>{{ $booking->approverLevel1->full_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Approver L2:</label>
                        <p>{{ $booking->approverLevel2->full_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Tujuan:</label>
                        <p class="text-muted">{{ $booking->purpose }}</p>
                    </div>
                    @if($booking->rejection_reason)
                    <div class="col-12">
                        <label class="form-label fw-bold text-danger">Alasan Penolakan:</label>
                        <p class="text-danger bg-light p-3 rounded">{{ $booking->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Approval History</h6>
            </div>
            <div class="card-body">
<p class="text-muted text-center py-3">Approval history will appear here after actions</p>
            </div>
        </div>
    </div>
</div>
@endsection

