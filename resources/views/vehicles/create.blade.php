@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-truck-plus text-primary me-2"></i>
                Add New Vehicle
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Vehicles
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Vehicle Information</h5>
            </div>
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">License Plate <span class="text-danger">*</span></label>
                            <input type="text" name="license_plate" class="form-control @error('license_plate') is-invalid @enderror" value="{{ old('license_plate') }}" required>
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="passenger" {{ old('type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                                <option value="cargo" {{ old('type') == 'cargo' ? 'selected' : '' }}>Cargo</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ownership</label>
                            <select name="ownership" class="form-select @error('ownership') is-invalid @enderror">
                                <option value="company" {{ old('ownership') == 'company' ? 'selected' : '' }}>Company Owned</option>
                                <option value="rental" {{ old('ownership') == 'rental' ? 'selected' : '' }}>Rental</option>
                            </select>
                            @error('ownership')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fuel Consumption (km/l)</label>
                            <input type="number" step="0.1" name="fuel_consumption" class="form-control @error('fuel_consumption') is-invalid @enderror" value="{{ old('fuel_consumption') }}">
                            @error('fuel_consumption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Region</label>
                            <select name="region_id" class="form-select @error('region_id') is-invalid @enderror">
                                <option value="">Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if(old('ownership') == 'rental')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rental Company</label>
                            <input type="text" name="rental_company" class="form-control" value="{{ old('rental_company') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rental Expiry</label>
                            <input type="date" name="rental_expiry" class="form-control" value="{{ old('rental_expiry') }}">
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer bg-transparent border-0">
                    <div class="d-grid d-md-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Vehicle
                        </button>
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
