<?php

namespace App\Http\Controllers;

use App\Models\Lub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LubController extends Controller
{
    //
     public function index()
     {
         $lubs = Lub::all();
         //dd($lubs);
         $user = Auth::user();
        //  if($user->role == 'Store Keeper'){
        //      return redirect()->route('dashboard.fuel')->with('error', 'You do not have permission to access this resource!.');
        //  }
         return view('lubricants.index', compact('lubs', 'user'));
     }
 
     //create form
     public function create()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
        //  if($user->role == 'Store Keeper'){
        //      return redirect()->route('dashboard.fuel')->with('error', 'You do not have permission to access this resource!.');
        //  }
         return view('lubricants.create', compact('user'));
     }
 
     public function store(Request $request)
     {
         // Validate the input data
         $validatedData = $request->validate([            
             'type' => 'required|max:255',            
         ]);
 
         // Create a new lub
         $lub = new Lub();
         $lub->fill($validatedData);
         $lub->save();
         return redirect()->route('lubs.index')->with('success', 'Lubricant created successfully.');
     }
 
 
     public function edit(Lub $lub)
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         return view('lubricants.edit', compact('user', 'lub'));
     }
 
     public function update(Request $request, Lub $lub)
     {
         // Validate the input data
         $validatedData = $request->validate([
             'type' => 'required|max:255',
         ]);
 
         // Update the lub with the validated data
         $lub->update($validatedData);
 
         return redirect()->route('lubs.index')->with('success', 'Vehicle lub Updated successfully.');
         }
 }
