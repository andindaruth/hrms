<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
     //operators
     public function index_operator()
     {
        $operators = People::where('role', 'Operator')->orderBy('created_at', 'desc')->get(); 
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.operators', compact('operators', 'user'));
     }

        
     public function create_operator()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard.')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.create-operator', compact('user'));
     }
 
     public function store_operator(Request $request)
     {
         // Validate the input data
         $validatedData = $request->validate([            
             'name' => 'required|max:255',
             'role' => 'required|max:255',            
         ]);
 
         // Create a new people
         $people = new People();
         $people->fill($validatedData);
         $people->save();
         return redirect()->route('operators.index')->with('success', 'Operator Added successfully.');
     }
 
 
     public function edit_operator(People $operator)
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.edit-operator', compact('user', 'operator'));
     }
 
     public function update_operator(Request $request, People $operator)
     {
         // Validate the input data
         $validatedData = $request->validate([
             'name' => 'required|max:255',
         ]);
 
         // Update the people with the validated data
         $operator->update($validatedData);
 
         return redirect()->route('operators.index')->with('success', 'Operator Updated successfully.');
         }


        //driver
     public function index_driver()
     {
        $drivers = People::where('role', 'Driver')->orderBy('created_at', 'desc')->get(); 
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.drivers', compact('drivers', 'user'));
     }

        
     public function create_driver()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.create-driver', compact('user'));
     }
 
     public function store_driver(Request $request)
     {
         // Validate the input data
         $validatedData = $request->validate([            
             'name' => 'required|max:255',
             'role' => 'required|max:255',            
         ]);
 
         // Create a new people
         $people = new People();
         $people->fill($validatedData);
         $people->save();
         return redirect()->route('drivers.index')->with('success', 'driver Added successfully.');
     }
 
 
     public function edit_driver(People $driver)
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
         return view('admin.people.edit-driver', compact('user', 'driver'));
     }
 
     public function update_driver(Request $request, People $driver)
     {
         // Validate the input data
         $validatedData = $request->validate([
             'name' => 'required|max:255',
         ]);
 
         // Update the people with the validated data
         $driver->update($validatedData);
 
         return redirect()->route('drivers.index')->with('success', 'driver Updated successfully.');
         }

         

}
