<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Region;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('region')->get();
        $regions = Region::all();
        
        return view('vehicles.index', compact('vehicles', 'regions'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('vehicles.create', compact('regions'));
    }

    public function edit(Vehicle $vehicle)
    {
        $regions = Region::all();
        return view('vehicles.edit', compact('vehicle', 'regions'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'license_plate' => 'required|unique:vehicles,license_plate,' . $vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'type' => 'required|in:passenger,cargo',
            'ownership' => 'required|in:company,rental',
            'status' => 'required|in:available,in_use,maintenance',
            'fuel_consumption' => 'required|numeric|min:1|max:50',
            'region_id' => 'nullable|exists:regions,id',
            'rental_company' => 'nullable|string|max:100',
            'rental_expiry' => 'nullable|date',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|unique:vehicles',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'type' => 'required|in:passenger,cargo',
            'ownership' => 'required|in:company,rental',
            'status' => 'required|in:available,in_use,maintenance',
            'fuel_consumption' => 'required|numeric|min:1|max:50',
            'region_id' => 'nullable|exists:regions,id',
            'rental_company' => 'nullable|string|max:100',
            'rental_expiry' => 'nullable|date',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added successfully!');
    }
}


