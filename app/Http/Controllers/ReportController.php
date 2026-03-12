<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::with(['requester', 'vehicle'])->get();
        $regions = \App\Models\Region::all();
        
        return view('reports.index', compact('bookings', 'regions'));
    }

    public function export(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        $regionId = $request->region_id;
        
        return Excel::download(new BookingsExport($dateFrom, $dateTo), 'vehicle-bookings-' . date('Y-m-d') . '.xlsx');
    }
}

