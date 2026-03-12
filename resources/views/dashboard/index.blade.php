@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Dashboard</h4>
                <small class="text-muted">Selamat datang, {{ auth()->user()->full_name }}</small>
            </div>
            <div>
                <span class="badge bg-primary">{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-truck"></i>
            </div>
            <h3>{{ $stats['total_vehicles'] ?? 0 }}</h3>
            <p>Total Kendaraan</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle text-success"></i>
            </div>
            <h3>{{ $stats['available_vehicles'] ?? 0 }}</h3>
            <p>Tersedia</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-play-circle text-primary"></i>
            </div>
            <h3>{{ $stats['in_use_vehicles'] ?? 0 }}</h3>
            <p>Digunakan</p>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-wrench text-warning"></i>
            </div>
            <h3>{{ $stats['maintenance_vehicles'] ?? 0 }}</h3>
            <p>Maintenance</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Grafik Pemakaian Kendaraan {{ date('Y') }}</h5>
            </div>
            <div class="card-body">
                @if($usageChart->sum('total') > 0)
                    <canvas id="usageChart" height="300"></canvas>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data pemakaian untuk tahun ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Status Kendaraan</h5>
            </div>
            <div class="card-body">
                @if($vehicleStatus['available'] + $vehicleStatus['in_use'] + $vehicleStatus['maintenance'] > 0)
                    <canvas id="statusChart" height="250"></canvas>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-pie-chart fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data kendaraan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Booking Terbaru</h5>
                <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentBookings as $booking)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $booking->booking_number }}</h6>
                                    <small class="text-muted">
                                        {{ $booking->vehicle->license_plate ?? 'N/A' }} - 
                                        Driver: {{ $booking->driver->full_name ?? 'N/A' }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'approved' ? 'success' : 'secondary') }}">
                                    {{ $booking->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>Tidak ada booking</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Kendaraan Teraktif</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kendaraan</th>
                                <th>Total Pemakaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topVehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->license_plate }} - {{ $vehicle->brand }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $vehicle->bookings_count }} kali</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        <i class="fas fa-truck fa-2x mb-2"></i>
                                        <p>Belum ada data pemakaian</p>
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

@push('scripts')
@if($usageChart->sum('total') > 0)
<script>
    // Usage Chart
    const ctx = document.getElementById('usageChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($usageChart->pluck('month')->map(function($m) {
                return date('F', mktime(0, 0, 0, $m, 1));
            })) !!},
            datasets: [{
                label: 'Jumlah Pemesanan',
                data: {!! json_encode($usageChart->pluck('total')) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endif

@if($vehicleStatus['available'] + $vehicleStatus['in_use'] + $vehicleStatus['maintenance'] > 0)
<script>
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Tersedia', 'Digunakan', 'Maintenance'],
            datasets: [{
                data: [
                    {{ $vehicleStatus['available'] ?? 0 }},
                    {{ $vehicleStatus['in_use'] ?? 0 }},
                    {{ $vehicleStatus['maintenance'] ?? 0 }}
                ],
                backgroundColor: [
                    '#28a745',
                    '#007bff',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endif
@endpush