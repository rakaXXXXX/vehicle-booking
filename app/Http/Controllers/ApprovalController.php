<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ApprovalHistory;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $pendingBookings = Booking::with(['requester', 'driver', 'vehicle'])
            ->whereIn('status', ['pending', 'approved_level_1'])
            ->latest()
            ->get();
            
        $pendingCount = $pendingBookings->count();
        
        return view('approvals.index', compact('pendingBookings', 'pendingCount'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $user = auth()->user();
        
        if (!$booking->canBeApprovedBy($user)) {
            return back()->with('error', 'Unauthorized to approve this booking.');
        }
        
        $booking->approve($user, $request->notes);
        
        return back()->with('success', 'Booking approved successfully!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $user = auth()->user();
        
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);
        
        $booking->reject($user, $request->rejection_reason);
        
        return back()->with('success', 'Booking rejected.');
    }
}
