<?php

namespace App\Http\Controllers;

use App\Models\Fertiliser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FertiliserController extends Controller
{
    public function index()
    {
       
        $fertilisers = Fertiliser::all(); 
        //dd($fertilisers);
        $user = Auth::user();
        return view('fertilisers.index', compact('fertilisers', 'user'));
    }

    //create form
    public function create()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('fertilisers.create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validate the input data from
        $validatedData = $request->validate([            
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255', 
            'quantity_per_pack' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
                    
        ]);

        // Create a new Fertiliser
        $fertiliser = new Fertiliser();
        $fertiliser->fill($validatedData);
        $fertiliser->save();
        return redirect()->route('fertilisers.index')->with('success', 'Fertiliser created successfully.');
    }


    public function edit(Fertiliser $fertiliser)
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('fertilisers.edit', compact('user', 'fertiliser'));
    }

    public function update(Request $request, Fertiliser $fertiliser)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255', 
            'quantity_per_pack' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
        ]);

        // Update the fertiliser with the validated data
        $fertiliser->update($validatedData);

        return redirect()->route('fertilisers.index')->with('success', 'fertiliser Updated successfully.');
        }
}
