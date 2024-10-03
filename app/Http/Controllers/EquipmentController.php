<?php

namespace App\Http\Controllers;
use DB;
use App\Models\People;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentAction;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{   
    public function index()
    {      
        //dd($equipment);
        $equipment = Equipment::orderBy('id', 'asc')->get();
        $user = Auth::user();
        return view('equipment.actions', compact('equipment', 'user'));
    }

    //create form
    public function create()
    {
        $user = Auth::user();
        return view('equipment.create', compact('user'));
    }

    // Store a new equipment in the database
    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([ 
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'category1' => 'required|string',
            'category2' => 'required|string',
            'category3' => 'required|string',
            'quantity_in_stock' => 'required|numeric|min:0',
            're_order_value' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Create a new Equipment
        $equipment = new Equipment();
        $equipment->fill($validatedData);
        $equipment->save();
        return redirect()->route('equipment.actions')->with('success', 'Equipment created successfully.');
    }

    //Edit an Equipment
    public function edit(Equipment $equipment)
    {
        $user = Auth::user();
        return view('equipment.edit', compact('user', 'equipment'));
    }
//update the equipment
public function update(Request $request, Equipment $equipment)
{
   
    // Validate the input data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'category1' => 'required|string',
        'category2' => 'required|string',
        'category3' => 'required|string',
        'quantity_in_stock' => 'required|numeric|min:0',
        're_order_value' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable allows the form to work even if no new image is uploaded
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('equipment_images', 'public');
        $validatedData['image'] = $imagePath;
    } else {
        unset($validatedData['image']); // If no new image is uploaded, don't override the existing one
    }

    
   $equipment->update($validatedData);
 
    return redirect()->route('equipment.actions')->with('success', 'Equipment updated successfully.');
}

    // Display all equipment
    public function item()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.item', compact('equipment', 'user'));
    }

    public function tool()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.tool', compact('equipment', 'user'));
    }

    public function spare_part()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.spare_part', compact('equipment', 'user'));
    }

    public function material()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.material', compact('equipment', 'user'));
    }

    public function farm()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.farm', compact('equipment', 'user'));
    }
    
    public function workshop()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('name', 'asc')->get();
        return view('equipment.workshop', compact('equipment', 'user'));
    }

    public function all()
    {
        $user = Auth::user();
        $equipment = Equipment::orderBy('id', 'asc')->get();
        return view('equipment.all', compact('equipment', 'user'));
    }

}
