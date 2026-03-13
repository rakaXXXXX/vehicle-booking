<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('status', 'available')->count(),
            'in_use_vehicles' => Vehicle::where('status', 'in_use')->count(),
            'maintenance_vehicles' => Vehicle::where('status', 'maintenance')->count(),
            'pending_bookings' => Booking::whereIn('status', ['pending', 'approved_level_1'])->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'completed_today' => Booking::whereDate('end_date', today())
                                        ->where('status', 'completed')
                                        ->count(),
        ];

        // Grafik pemakaian per bulan
       $usageChart = Booking::select(
        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->whereYear('created_at', date('Y'))
    ->groupByRaw('EXTRACT(MONTH FROM created_at)')
    ->orderBy('month')
    ->get();
        // Jika tidak ada data, buat data dummy
        if ($usageChart->isEmpty()) {
            $usageChart = collect([
                (object)['month' => 1, 'total' => 0],
                (object)['month' => 2, 'total' => 0],
                (object)['month' => 3, 'total' => 0],
                (object)['month' => 4, 'total' => 0],
                (object)['month' => 5, 'total' => 0],
                (object)['month' => 6, 'total' => 0],
                (object)['month' => 7, 'total' => 0],
                (object)['month' => 8, 'total' => 0],
                (object)['month' => 9, 'total' => 0],
                (object)['month' => 10, 'total' => 0],
                (object)['month' => 11, 'total' => 0],
                (object)['month' => 12, 'total' => 0],
            ]);
        }

        // Kendaraan paling sering dipakai
        $topVehicles = Vehicle::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        // Booking terbaru
        $recentBookings = Booking::with(['vehicle', 'driver', 'requester'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Status kendaraan untuk chart
        $vehicleStatus = [
            'available' => Vehicle::where('status', 'available')->count(),
            'in_use' => Vehicle::where('status', 'in_use')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
        ];

        ApplicationLog::create([
            'user_id' => auth()->id(),
            'action' => 'VIEW_DASHBOARD',
            'description' => 'User melihat dashboard',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        return view('dashboard.index', compact(
            'stats', 'usageChart', 'topVehicles', 
            'recentBookings', 'vehicleStatus'
        ));
    }
}