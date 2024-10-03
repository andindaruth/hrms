<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentAction;
use App\Models\EquipmentReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EquipmentActionController extends Controller
{

    //add quantity action 
    // Show the add quantity form
    public function showAddForm($id)
    {
        $equipment = Equipment::findOrFail($id);
        $user = Auth::user();
        $operators = People::where('role', 'Operator')->get();

        return view('equipment.actions.add', compact('equipment', 'user', 'operators'));
    }

    // Handle the addition of quantity
    public function addQuantity(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'person_id' => 'required|exists:people,id',
            'remarks' => 'nullable|max:255',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $action = new EquipmentAction();
            $action->fill($validatedData);
            $action->save();
            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock += $request->quantity;
            $equipment->save();
            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions')->with('success', 'Action Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }


    //Actions Performed add qty
    public function actions_performed()
    {
        $user = Auth::user();
        $actions = EquipmentAction::where('type', 'add')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('equipment.actions.actions_performed', compact('actions', 'user'));
    }

    //reverse add qty
    public function reverse_add(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the action to reverse
            $action = EquipmentAction::findOrFail($request->action_id);

            // Ensure the action is not already reversed
            if ($action->is_reversed) {
                return back()->with('error', 'action is already reversed.');
            }

            // Check if there is enough lub in store
            $equipment = Equipment::find($request->equipment_id);
            if ($equipment->quantity_in_stock < $action->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient equipment in the workshop to cover this action!.');
            }

            // Create a new reverse action
            $reverseAction = new EquipmentAction();
            $reverseAction->fill([
                'type' => $action->type,
                'date' => $action->date,
                'equipment_id' => $action->equipment_id,
                'quantity' => $action->quantity,
                'remarks' => $action->remarks,
                'user_id' => $action->user_id,
                'person_id' => $action->person_id,
                'reverses' => $action->id,
                'is_reversed' => true,
            ]);
            // dd($reverseAction);
            $reverseAction->save();

            // Reverse the action and mark it as reversed
            $action->reversed_by = $reverseAction->id;
            $action->is_reversed = true;
            $action->reversal_reason = $request->reversal_reason;
            $action->save();


            $equipment = equipment::find($action->equipment_id);
            $equipment->quantity_in_stock -= $action->quantity;
            $equipment->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions.actions_performed')->with('success', 'Action Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the Action. Please try again.');
        }
    }

    //general in report
    public function report_in(Request $request)
    {
        $user = Auth::user();
        $equipments = Equipment::all();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        // Filter by category1,2,3
        if ($request->filled('category1') && $request->filled('category2') && $request->filled('category3')) {
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category2', $category2)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category1') && $request->filled('category2')) {
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category2', $category2);
        } elseif ($request->filled('category1') && $request->filled('category3')) {
            $category1 = $request->input('category1');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category2') && $request->filled('category3')) {
            $category2 = $request->input('category2');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category2', $category2)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category1')) {
            $category1 = $request->input('category1');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1);
        } elseif ($request->filled('category2')) {
            $category2 = $request->input('category2');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category2', $category2);
        } elseif ($request->filled('category3')) {
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category3', $category3);
        } else {
            //skip
        }
        $actions = $query->where('type', 'add')
            ->where('is_reversed', false)
            ->orderBy('equipment_actions.date', 'desc')
            ->orderBy('equipment_actions.created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.report_in', compact('equipments', 'user', 'actions'));
    }

    // Method to show the dispose form
    public function showDisposeForm($id)
    {
        $equipment = Equipment::findOrFail($id);
        $user = Auth::user();
        return view('equipment.actions.dispose', compact('equipment', 'user'));
    }

    // Method to handle the disposal logic
    public function disposeEquipment(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'remarks' => 'nullable|max:255',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if there is enough equipment in store
            $equipment = Equipment::find($request->equipment_id);
            if ($equipment->quantity_in_stock < $request->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient equipment in the workshop to cover this action!.');
            }
            // Create a new transaction
            $action = new EquipmentAction();
            $action->fill($validatedData);
            $action->save();
            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock -= $request->quantity;
            $equipment->save();
            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions')->with('success', 'Equipment disposed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }

    //Actions Performed dispose
    public function actions_performed_dispose()
    {
        $user = Auth::user();
        $actions = EquipmentAction::where('type', 'dispose')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('equipment.actions.actions_performed_dispose', compact('actions', 'user'));
    }

    //reverse dispose
    public function reverse_dispose(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the action to reverse
            $action = EquipmentAction::findOrFail($request->action_id);

            // Ensure the action is not already reversed
            if ($action->is_reversed) {
                return back()->with('error', 'action is already reversed.');
            }

            // Check if there is enough equipment in store
            $equipment = Equipment::find($request->equipment_id);

            // Create a new reverse action
            $reverseAction = new EquipmentAction();
            $reverseAction->fill([
                'type' => $action->type,
                'date' => $action->date,
                'equipment_id' => $action->equipment_id,
                'quantity' => $action->quantity,
                'remarks' => $action->remarks,
                'user_id' => $action->user_id,
                'reverses' => $action->id,
                'is_reversed' => true,
            ]);
            // dd($reverseAction);
            $reverseAction->save();

            // Reverse the action and mark it as reversed
            $action->reversed_by = $reverseAction->id;
            $action->is_reversed = true;
            $action->reversal_reason = $request->reversal_reason;
            $action->save();


            $equipment = equipment::find($action->equipment_id);
            $equipment->quantity_in_stock += $action->quantity;
            $equipment->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions.actions_performed_dispose')->with('success', 'Action Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the Action. Please try again.');
        }
    }

    //general in report
    public function disposed(Request $request)
    {
        $user = Auth::user();
        $equipments = Equipment::all();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->where('type', 'dispose')
            ->where('is_reversed', false)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.disposed', compact('equipments', 'user', 'actions'));
    }

    //Give out form
    public function give($id)
    {
        $user = Auth::user();
        $equipment = Equipment::findOrFail($id);
        $operators = People::where('role', 'Operator')->get();
        return view('equipment.actions.give', compact('equipment', 'user', 'operators'));
    }

    // Handle the give out
    public function give_out(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'person_id' => 'required|exists:people,id',
            'remarks' => 'required|max:255',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $action = EquipmentAction::create([
                'type' => $request->type,
                'date' => $request->date,
                'quantity' => $request->quantity,
                'user_id' => $request->user_id,
                'equipment_id' => $request->equipment_id,
                'person_id' => $request->person_id,
                'remarks' => $request->remarks,
                'quantity_r' => 0,
                'quantity_p' => $request->quantity,
                'status' => 'out',
            ]);

            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock -= $request->quantity;
            $equipment->save();
            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions')->with('success', 'Equipment given out successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }

    //Actions Performed give
    public function actions_performed_give()
    {
        $user = Auth::user();
        $actions = EquipmentAction::where('type', 'give')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('equipment.actions.actions_performed_give', compact('actions', 'user'));
    }

    //reverse give
    public function reverse_give(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the action to reverse
            $action = EquipmentAction::findOrFail($request->action_id);

            // Ensure the action is not already reversed
            if ($action->is_reversed) {
                return back()->with('error', 'action is already reversed.');
            }

            // Check if there is enough equipment in store
            $equipment = Equipment::find($request->equipment_id);

            // Create a new reverse action
            $reverseAction = new EquipmentAction();
            $reverseAction->fill([
                'type' => $action->type,
                'date' => $action->date,
                'equipment_id' => $action->equipment_id,
                'quantity' => $action->quantity,
                'quantity_r' => $action->quantity_r,
                'quantity_p' => $action->quantity_p,
                'status' => $action->status,
                'remarks' => $action->remarks,
                'user_id' => $action->user_id,
                'person_id' => $action->person_id,
                'reverses' => $action->id,
                'is_reversed' => true,
            ]);
            // dd($reverseAction);
            $reverseAction->save();

            // Reverse the action and mark it as reversed
            $action->reversed_by = $reverseAction->id;
            $action->is_reversed = true;
            $action->reversal_reason = $request->reversal_reason;
            $action->save();


            $equipment = equipment::find($action->equipment_id);
            $equipment->quantity_in_stock += $action->quantity;
            $equipment->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions.actions_performed_give')->with('success', 'Action Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the Action. Please try again.');
        }
    }

    //general Out report
    public function report_out(Request $request)
    {
        $user = Auth::user();
        $equipments = Equipment::all();
        $operators = People::where('role', 'Operator')->get();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }
        if ($request->filled('person_id')) {
            $query->where('person_id', $request->input('person_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        // Filter by category1,2,3
        if ($request->filled('category1') && $request->filled('category2') && $request->filled('category3')) {
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category2', $category2)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category1') && $request->filled('category2')) {
            $category1 = $request->input('category1');
            $category2 = $request->input('category2');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category2', $category2);
        } elseif ($request->filled('category1') && $request->filled('category3')) {
            $category1 = $request->input('category1');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category2') && $request->filled('category3')) {
            $category2 = $request->input('category2');
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category2', $category2)
                ->where('equipment.category3', $category3);
        } elseif ($request->filled('category1')) {
            $category1 = $request->input('category1');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category1', $category1);
        } elseif ($request->filled('category2')) {
            $category2 = $request->input('category2');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category2', $category2);
        } elseif ($request->filled('category3')) {
            $category3 = $request->input('category3');
            $query->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
                ->where('equipment.category3', $category3);
        } else {
            //skip
        }

        $actions = $query->where('type', 'give')
            ->where('is_reversed', false)
            ->orderBy('equipment_actions.date', 'desc')
            ->orderBy('equipment_actions.created_at', 'desc')
            ->paginate(50);


        return view('equipment.actions.report_out', compact('equipments', 'user', 'actions', 'operators'));
    }


    //taken_non_returnable
    public function taken_non_returnable(Request $request)
    {

        $user = Auth::user();
        $equipments = Equipment::where('category3', 'non_returnable')->get();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->where('type', 'give')
            ->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
            ->where('equipment.category3', 'non_returnable')
            ->where('is_reversed', false)
            ->orderBy('equipment_actions.date', 'desc')
            ->orderBy('equipment_actions.created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.taken_non_returnable', compact('equipments', 'user', 'actions'));
    }

    //Recommend for repair
    public function recommend_for_repair($id)
    {
        $user = Auth::user();
        $equipment = Equipment::findOrFail($id);
        return view('equipment.actions.recommend_for_repair', compact('equipment', 'user'));
    }

    // Handle the recommendation
    public function recommend_store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'equipment_id' => 'required|exists:equipment,id',
            'remarks' => 'required|max:255',
            'status' => 'required|max:255',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if there is enough equipment in store
            $equipment = Equipment::find($request->equipment_id);
            if ($equipment->quantity_in_stock < $request->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient equipment in the workshop to cover this action!.');
            }
            // Create a new transaction
            $action = new EquipmentAction();
            $action->fill($validatedData);
            $action->save();
            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock -= $request->quantity;
            $equipment->save();
            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions')->with('success', 'Recommendation made successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }

    //Actions Performed recommend
    public function actions_performed_recommend()
    {
        $user = Auth::user();
        $actions = EquipmentAction::where('type', 'recommend')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('equipment.actions.actions_performed_recommend', compact('actions', 'user'));
    }

    //reverse recommend
    public function reverse_recommend(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the action to reverse
            $action = EquipmentAction::findOrFail($request->action_id);

            // Ensure the action is not already reversed
            if ($action->is_reversed) {
                return back()->with('error', 'action is already reversed.');
            }

            // Check if there is enough lub in store
            $equipment = Equipment::find($request->equipment_id);

            // Create a new reverse action
            $reverseAction = new EquipmentAction();
            $reverseAction->fill([
                'type' => $action->type,
                'date' => $action->date,
                'equipment_id' => $action->equipment_id,
                'quantity' => $action->quantity,
                'remarks' => $action->remarks,
                'status' => $action->status,
                'user_id' => $action->user_id,
                'reverses' => $action->id,
                'is_reversed' => true,
            ]);
            // dd($reverseAction);
            $reverseAction->save();

            // Reverse the action and mark it as reversed
            $action->reversed_by = $reverseAction->id;
            $action->is_reversed = true;
            $action->reversal_reason = $request->reversal_reason;
            $action->save();


            $equipment = equipment::find($action->equipment_id);
            $equipment->quantity_in_stock += $action->quantity;
            $equipment->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('equipment.actions.actions_performed_recommend')->with('success', 'Action Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the Action. Please try again.');
        }
    }

    //pending repair
    public function pending_repair(Request $request)
    {

        $user = Auth::user();
        $equipments = Equipment::all();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->where('type', 'recommend')
            ->where('status', 'pending_repair')
            ->where('is_reversed', false)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.pending_repair', compact('equipments', 'user', 'actions'));
    }

    //Repair form
    public function repair($id)
    {
        $user = Auth::user();
        $action = EquipmentAction::findOrFail($id);
        $operators = People::where('role', 'Operator')->get();
        return view('equipment.actions.repair', compact('action', 'user', 'operators'));
    }

    // store repair
    public function store_repair(Request $request, EquipmentAction $action)
    {
        // Validate the input data
        $request->validate([
            'quantity' => 'required|numeric|min:' . $action->quantity,
        ]);
        // dd($request);
        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $equipmentReturn = EquipmentReturn::create([
                'action_id' => $request->action_id,
                'person_id' => $request->person_id,
                'quantity_r' => $request->quantity_r,
                'date_r' => $request->date_r,
                'comment' => $request->comment,
            ]);
            //   dd($equipmentReturn);

            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock += $request->quantity_r;
            $equipment->save();

            $action = EquipmentAction::findOrFail($request->action_id);
            $action->status = 'repaired';
            $action->save();
            // dd($action);
            // Commit the database transaction
            DB::commit();
            return redirect()->route('equipment.actions.pending_repair')->with('success', 'Equipment Marked as repaired successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }

    //repaired
    public function repaired(Request $request)
    {
        $user = Auth::user();
        $equipments = Equipment::all();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->where('type', 'recommend')
            ->where('is_reversed', false)
            ->where('status', 'repaired')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.repaired', compact('equipments', 'user', 'actions'));
    }

    //pending return
    public function pending_return(Request $request)
    {

        $user = Auth::user();
        $equipments = Equipment::where('category3', 'returnable')->get();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->select('equipment_actions.*', 'equipment_actions.id as action_id')
            ->join('equipment', 'equipment_actions.equipment_id', '=', 'equipment.id')
            ->where('type', 'give')
            ->where('equipment.category3', 'returnable')
            ->where('is_reversed', false)
            ->whereNot('status', 'returned')
            ->orderBy('equipment_actions.date', 'desc')
            ->orderBy('equipment_actions.created_at', 'desc')
            ->paginate(50);


        return view('equipment.actions.pending_return', compact('equipments', 'user', 'actions'));
    }


    //Return
    public function return($id)
    {

        $user = Auth::user();
        $action = EquipmentAction::findOrFail($id);
        // dd($action);
        $operators = People::where('role', 'Operator')->get();
        return view('equipment.actions.return', compact('action', 'user', 'operators'));
    }

    // store return
    public function store_return(Request $request, EquipmentAction $action)
    {
        // Validate the input data
        $request->validate([
            'quantity' => 'required|numeric|min:' . $action->quantity_p,
        ]);
        // dd($request);
        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $equipmentReturn = EquipmentReturn::create([
                'action_id' => $request->action_id,
                'person_id' => $request->person_id,
                'quantity_r' => $request->quantity_r,
                'date_r' => $request->date_r,
                // 'comment' => $request->comment,
            ]);
            //   dd($equipmentReturn);

            $equipment = Equipment::findOrFail($request->equipment_id);
            $equipment->quantity_in_stock += $request->quantity_r;
            $equipment->save();


            $action = EquipmentAction::findOrFail($request->action_id);
            $action->quantity_p -= $request->quantity_r;
            $action->quantity_r += $request->quantity_r;
            if ($action->quantity_p == 0) {
                $action->status = 'returned';
            } else {
                $action->status = 'partially_returned';
            }
            $action->save();
            // dd($action);
            // Commit the database transaction
            DB::commit();
            return redirect()->route('equipment.actions.pending_return')->with('success', 'Equipment returned successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the action. Please try again.');
        }
    }


    //returned
    public function returned(Request $request)
    {
        $user = Auth::user();
        $equipments = Equipment::all();
        $query = EquipmentAction::query();

        if ($request->filled('equipment_id')) {
            $query->where('equipment_id', $request->input('equipment_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $actions = $query->where('type', 'give')
            ->where('is_reversed', false)
            ->whereNot('status', 'out')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('equipment.actions.returned', compact('equipments', 'user', 'actions'));
    }
}
