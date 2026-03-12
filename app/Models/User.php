<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'full_name', 'nip',
        'position', 'region_id', 'role', 'is_active'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function bookingsAsDriver()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }

    public function bookingsAsRequester()
    {
        return $this->hasMany(Booking::class, 'requester_id');
    }

    public function approvals()
    {
        return $this->hasMany(ApprovalHistory::class, 'approver_id');
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isApprover()
    {
        return in_array($this->role, ['approver_level_1', 'approver_level_2']);
    }
}