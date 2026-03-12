@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-truck text-primary me-2"></i>
                Vehicles
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Vehicle
            </a>
        </div>
    </div>
</div>

<div class="row">
    @foreach($vehicles as $vehicle)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-{{ $vehicle->type == 'passenger' ? 'users' : 'truck' }} fa-3x text-muted mb-3"></i>
                <h5 class="card-title">{{ $vehicle->license_plate }}</h5>
                <p class="card-text">{{ $vehicle->brand }} {{ $vehicle->model }}</p>
                <span class="badge badge-{{ $vehicle->status == 'available' ? 'success' : ($vehicle->status == 'in_use' ? 'warning' : 'danger') }}">
                    {{ ucfirst($vehicle->status) }}
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover datatable">
                    <thead>
                        <tr>
                            <th>License</th>
                            <th>Model</th>
                            <th>Status</th>
                            <th>Fuel</th>
                            <th>Region</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td><strong>{{ $vehicle->license_plate }}</strong></td>
                            <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                            <td>
                                <span class="badge bg-{{ $vehicle->status == 'available' ? 'success' : ($vehicle->status == 'in_use' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </td>
                            <td>{{ $vehicle->fuel_consumption }} km/l</td>
                            <td>{{ $vehicle->region->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" class="d-inline" onsubmit="return confirm('Hapus kendaraan {{ $vehicle->license_plate }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

