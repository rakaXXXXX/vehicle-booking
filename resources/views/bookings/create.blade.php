@extends('layouts.app')

@section('title', 'New Vehicle Booking')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="mb-0">
                <i class="fas fa-calendar-plus text-primary me-2"></i>
                New Vehicle Booking
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Pemesanan</h5>
            </div>
            <form action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                <option value="">Pilih Kendaraan</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->license_plate }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                                        @if($vehicle->status != 'available')
                                            <span class="badge bg-warning ms-1">{{ $vehicle->status }}</span>
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sopir</label>
                            <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
                                <option value="">Otomatis Assign</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->full_name }} ({{ $driver->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supervisor (Tingkat 1)</label>
                            <select name="approver_level_1_id" class="form-select @error('approver_level_1_id') is-invalid @enderror">
                                <option value="">Pilih Supervisor</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" {{ old('approver_level_1_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->full_name }} ({{ $supervisor->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('approver_level_1_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Manager (Tingkat 2)</label>
                            <select name="approver_level_2_id" class="form-select @error('approver_level_2_id') is-invalid @enderror">
                                <option value="">Pilih Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('approver_level_2_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->full_name }} ({{ $manager->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('approver_level_2_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tujuan Pemesanan <span class="text-danger">*</span></label>
                        <textarea name="purpose" rows="3" class="form-control @error('purpose') is-invalid @enderror" placeholder="Jelaskan tujuan perjalanan..." required>{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Submit Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');
    
    endDate.addEventListener('change', function() {
        if (startDate.value && endDate.value < startDate.value) {
            alert('Tanggal selesai harus setelah tanggal mulai!');
            endDate.value = '';
        }
    });
});
</script>
@endsection
