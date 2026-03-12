<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'approver_id', 'approval_level', 'status', 'notes'
    ];

    protected $table = 'approval_history';
    
    protected $guarded = []; // Allow mass assignment for static create

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}