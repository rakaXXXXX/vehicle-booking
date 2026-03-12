<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number', 'vehicle_id', 'driver_id', 'approver_level_1_id',
        'approver_level_2_id', 'requester_id', 'purpose', 'start_date',
        'end_date', 'start_odometer', 'end_odometer', 'fuel_used',
        'status', 'rejection_reason'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            $booking->booking_number = 'BKG-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approver_level_1_id');
    }

    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approver_level_2_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function approvalHistory()
    {
        return $this->hasMany(ApprovalHistory::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function canBeApprovedBy($user)
    {
        if ($this->status === 'pending' && $user->id === $this->approver_level_1_id) {
            return true;
        }
        
        if ($this->status === 'approved_level_1' && $user->id === $this->approver_level_2_id) {
            return true;
        }
        
        return false;
    }

    public function approve($user, $notes = null)
    {
        if ($user->id === $this->approver_level_1_id && $this->status === 'pending') {
            $this->status = 'approved_level_1';
            $this->save();
            
            ApprovalHistory::create([
                'booking_id' => $this->id,
                'approver_id' => $user->id,
                'approval_level' => 1,
                'status' => 'approved',
                'notes' => $notes
            ]);
            
            return true;
        }
        
        if ($user->id === $this->approver_level_2_id && $this->status === 'approved_level_1') {
            $this->status = 'approved';
            $this->save();
            
            ApprovalHistory::create([
                'booking_id' => $this->id,
                'approver_id' => $user->id,
                'approval_level' => 2,
                'status' => 'approved',
                'notes' => $notes
            ]);
            
            // Update vehicle status
            $this->vehicle->status = 'in_use';
            $this->vehicle->save();
            
            return true;
        }
        
        return false;
    }

    public function reject($user, $reason)
    {
        $level = $user->id === $this->approver_level_1_id ? 1 : 2;
        
        $this->status = 'rejected';
        $this->rejection_reason = $reason;
        $this->save();
        
        ApprovalHistory::create([
            'booking_id' => $this->id,
            'approver_id' => $user->id,
            'approval_level' => $level,
            'status' => 'rejected',
            'notes' => $reason
        ]);
        
        return true;
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'approved_level_1']);
    }

    public function scopeForApprover($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('approver_level_1_id', $userId)
              ->where('status', 'pending')
              ->orWhere('approver_level_2_id', $userId)
              ->where('status', 'approved_level_1');
        });
    }
}