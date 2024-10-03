<?php

namespace App\Http\Controllers;

use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChemicalController extends Controller
{
    //
    public function index()
    {
        $seed_chemicals = Chemical::where('category', 'Seed Treatment')->get();
        $farm_chemicals = Chemical::where('category', 'Farm')->get();
        //dd($chemicals);
        $user = Auth::user();
        return view('chemicals.index', compact('seed_chemicals', 'farm_chemicals', 'user'));
    }

    //create form
    public function create()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('chemicals.create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([            
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255',
            'category' => 'required|max:255', 
            'purpose' => 'required|max:255',
            'unit_of_measure' => 'required|max:255', 
            'quantity_per_pack' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
                    
        ]);

        // Create a new chemical
        $chemical = new Chemical();
        $chemical->fill($validatedData);
        $chemical->save();
        return redirect()->route('chemicals.index')->with('success', 'Chemical created successfully.');
    }


    public function edit(Chemical $chemical)
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('chemicals.edit', compact('user', 'chemical'));
    }

    public function update(Request $request, Chemical $chemical)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255',
            'category' => 'required|max:255', 
            'purpose' => 'required|max:255',
            'unit_of_measure' => 'required|max:255', 
            'quantity_per_pack' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
        ]);

        // Update the chemical with the validated data
        $chemical->update($validatedData);

        return redirect()->route('chemicals.index')->with('success', 'chemical Updated successfully.');
        }
}
