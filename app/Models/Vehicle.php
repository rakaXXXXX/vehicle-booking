<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate', 'brand', 'model', 'type', 'ownership',
        'rental_company', 'rental_expiry', 'region_id',
        'fuel_consumption', 'last_service_date', 'next_service_date', 'status'
    ];

    protected $casts = [
        'rental_expiry' => 'date',
        'last_service_date' => 'date',
        'next_service_date' => 'date'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenanceSchedules()
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function updateStatus()
    {
        if ($this->next_service_date && now() >= $this->next_service_date) {
            $this->status = 'maintenance';
            $this->save();
        }
    }
}