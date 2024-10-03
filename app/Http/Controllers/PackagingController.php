<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackagingController extends Controller
{
    //
    public function index()
    {
        $packagings = Packaging::all();
        //dd($packagings);
        $user = Auth::user();
        return view('packagings.index', compact('packagings', 'user'));
    }

    //create form
    public function create()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('packagings.create', compact('user'));
    }

    public function store(Request $request)
    {
        //dd($request);
        // Validate the input data
        $validatedData = $request->validate([            
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255',
            'category' => 'required|max:255', 
            'purpose' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
                    
        ]);

        // Create a new packaging
        $packaging = new Packaging();
        // dd($packaging);
        $packaging->fill($validatedData);
       
        $packaging->save();
        return redirect()->route('packagings.index')->with('success', 'Packaging created successfully.');
    }


    public function edit(Packaging $packaging)
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('packagings.edit', compact('user', 'packaging'));
    }

    public function update(Request $request, Packaging $packaging)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|max:255', 
            'code' => 'nullable|max:255',
            'category' => 'required|max:255', 
            'purpose' => 'required|max:255',
            'rate' => 'required|max:255', 
            'unit_price' => 'required|numeric|min:0',
        ]);

        // Update the packaging with the validated data
        $packaging->update($validatedData);

        return redirect()->route('packagings.index')->with('success', 'packaging Updated successfully.');
        }
}
