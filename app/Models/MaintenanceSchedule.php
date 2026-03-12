<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id', 'scheduled_date', 'maintenance_type', 'notes', 'status', 'created_by'
    ];

    protected $casts = [
        'scheduled_date' => 'date'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}