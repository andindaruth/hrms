<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    //
    public function index()
    {
        $vehicles = Vehicle::all();
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.vehicles.index', compact('vehicles', 'user'));
    }

    //create branch form
    public function create()
    {
        $categories = VehicleCategory::all();
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.vehicles.create', compact('user', 'categories'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([            
            'number_plate' => 'required|max:255',
            'model' => 'required|max:255',    
            'category_id' => 'required|exists:vehicle_categories,id',        
        ]);

        // Create a new vehicle
        $vehicle = new Vehicle();
        $vehicle->fill($validatedData);
        $vehicle->save();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }


    public function edit(Vehicle $vehicle)
    {
        $categories = VehicleCategory::all();
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.vehicles.edit', compact('user', 'vehicle', 'categories'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'number_plate' => 'required|max:255',
            'model' => 'required|max:255',    
            'category_id' => 'required|exists:vehicle_categories,id', 
        ]);

        // Update the category with the validated data
        $vehicle->update($validatedData);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle Updated successfully.');
        }
}
