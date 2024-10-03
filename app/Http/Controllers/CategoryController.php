<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = VehicleCategory::all();
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard.fuel')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.categories.index', compact('categories', 'user'));
    }

    //create branch form
    public function create()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard.fuel')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.categories.create', compact('user'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([            
            'name' => 'required|max:255',            
        ]);

        // Create a new category
        $category = new VehicleCategory();
        $category->fill($validatedData);
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Vehicle Category created successfully.');
    }


    public function edit(VehicleCategory $category)
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('admin.categories.edit', compact('user', 'category'));
    }

    public function update(Request $request, VehicleCategory $category)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        // Update the category with the validated data
        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Vehicle Category Updated successfully.');
        }
}
