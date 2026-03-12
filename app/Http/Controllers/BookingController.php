<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $bookings = Booking::with(['requester', 'vehicle', 'driver', 'approverLevel1', 'approverLevel2'])
            ->when($user->role === 'employee' || $user->role === 'driver', function ($query) use ($user) {
                $query->where('requester_id', $user->id)
                      ->orWhere('driver_id', $user->id);
            })
            ->latest()
            ->get();
            
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::with('region')->get();
        $drivers = User::where('role', 'driver')->get();
        $supervisors = User::whereIn('role', ['supervisor', 'approver_level_1', 'admin'])->get();
        $managers = User::whereIn('role', ['manager', 'approver_level_2', 'admin'])->get();
        
        return view('bookings.create', compact('vehicles', 'drivers', 'supervisors', 'managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'driver_id' => 'nullable|exists:users,id',
            'approver_level_1_id' => 'required|exists:users,id',
            'approver_level_2_id' => 'required|exists:users,id',
            'purpose' => 'required|string|max:1000',
        ]);

        $booking = Booking::create([
            'vehicle_id' => $validated['vehicle_id'],
            'driver_id' => $validated['driver_id'],
            'approver_level_1_id' => $validated['approver_level_1_id'],
            'approver_level_2_id' => $validated['approver_level_2_id'],
            'requester_id' => auth()->id(),
            'purpose' => $validated['purpose'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        $booking->vehicle->update(['status' => 'in_use']);

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibuat dan menunggu persetujuan!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['vehicle.region', 'requester', 'driver', 'approverLevel1', 'approverLevel2']);
        
        return view('bookings.show', compact('booking'));
    }
}

