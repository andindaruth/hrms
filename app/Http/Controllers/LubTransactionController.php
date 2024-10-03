<?php

namespace App\Http\Controllers;


use App\Models\Lub;
use App\Models\People;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\LubTransaction;
// use App\Models\VehicleCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LubTransactionController extends Controller
{
    //

    public function index_lub_in()
    {
        $transactions = LubTransaction::where('type', 'In')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        $user = Auth::user();

        return view('lubricants.transactions.index-in', compact('transactions', 'user'));
    }


    public function report_lub_in(Request $request)
    {
        // $categories = VehicleCategory::all();
        $lubs = Lub::all();
        // dd($lubs);
        $user = Auth::user();

        $query = LubTransaction::query();

        if ($request->filled('lub_id')) {
            $query->where('lub_id', $request->input('lub_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $transactions = $query->where('type', 'In')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('lubricants.transactions.report-in', compact('transactions', 'user', 'lubs'));
    }

    public function create_lub_in()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $drivers = People::where('role', 'Driver')->get();
        $lubs = Lub::all();
        return view('lubricants.transactions.create-in', compact('user', 'vehicles', 'drivers', 'lubs'));
    }


    public function store_lub_in(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([

            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'lub_id' => 'required|exists:lubs,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'person_id' => 'required|exists:people,id',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $transaction = new LubTransaction();
            $transaction->fill($validatedData);
            $transaction->save();
            $lub = Lub::findOrFail($request->lub_id);
            $lub->balance += $request->quantity;
            $lub->save();
            // Commit the database transaction
            DB::commit();

            return redirect()->route('lub-in.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();
            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse lubin
    public function reverse_lub_in(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = LubTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Check if there is enough lub in store
            $lub = Lub::find($request->lub_id);
            if ($lub->balance < $transaction->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient lub in the store to cover this transaction!.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new lubTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'lub_id' => $transaction->lub_id,
                'quantity' => $transaction->quantity,
                'user_id' => $transaction->user_id,
                'person_id' => $transaction->person_id,
                'vehicle_id' => $transaction->vehicle_id,
                'reverses' => $transaction->id,
                'is_reversed' => true,
            ]);
            // dd($reverseTransaction);
            $reverseTransaction->save();

            // Reverse the transaction and mark it as reversed
            $transaction->reversed_by = $reverseTransaction->id;
            $transaction->is_reversed = true;
            $transaction->reversal_reason = $request->reversal_reason;
            $transaction->save();


            $lub = Lub::find($transaction->lub_id);
            $lub->balance -= $transaction->quantity;
            $lub->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('lub-in.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }


    //lubOUT
    public function index_lub_out()
    {
        $transactions = LubTransaction::where('type', 'Out')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        $user = Auth::user();

        return view('lubricants.transactions.index-out', compact('transactions', 'user'));
    }


    public function report_lub_out(Request $request)
    {
        // $categories = VehicleCategory::all();
        $lubs = Lub::all();
        // dd($lubs);
        $user = Auth::user();

        $query = LubTransaction::query();

        if ($request->filled('lub_id')) {
            $query->where('lub_id', $request->input('lub_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $transactions = $query->where('type', 'Out')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('lubricants.transactions.report-out', compact('transactions', 'user', 'lubs'));
    }

    public function create_lub_out()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $operators = People::where('role', 'Operator')->get();
        $lubs = Lub::all();
        return view('lubricants.transactions.create-out', compact('user', 'vehicles', 'operators', 'lubs'));
    }


    public function store_lub_out(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([

            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'lub_id' => 'required|exists:lubs,id',
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'person_id' => 'required|exists:people,id',
        ]);
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if there is enough lub in store
            $lub = Lub::find($request->lub_id);
            if ($lub->balance < $request->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient lubricant in the store to cover this transaction!.');
            }
            // Create a new transaction
            $transaction = new LubTransaction();
            $transaction->fill($validatedData);
            $transaction->save();

            //reduce lub balance
            $lub->balance -= $request->quantity;
            $lub->save();


            // Commit the database transaction
            DB::commit();

            return redirect()->route('lub-out.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

     //reverse Lubout
     public function reverse_lub_out(Request $request)
     {
 
         try {
             // Start a database transaction
             DB::beginTransaction();
 
             // Find the transaction to reverse
             $transaction = lubTransaction::findOrFail($request->transaction_id);
 
             // Ensure the transaction is not already reversed
             if ($transaction->is_reversed) {
                 return back()->with('error', 'Transaction is already reversed.');
             }
 
             // Create a new reverse transaction
             $reverseTransaction = new LubTransaction();
             $reverseTransaction->fill([
                 'type' => $transaction->type,
                 'date' => $transaction->date,                 
                 'lub_id' => $transaction->lub_id,
                 'quantity' => $transaction->quantity,
                 'user_id' => $transaction->user_id,
                 'person_id' => $transaction->person_id,
                 'vehicle_id' => $transaction->vehicle_id,
                 'reverses' => $transaction->id,
                 'is_reversed' => true,
             ]);
             // dd($reverseTransaction);
             $reverseTransaction->save();
 
             // Reverse the transaction and mark it as reversed
             $transaction->reversed_by = $reverseTransaction->id;
             $transaction->is_reversed = true;
             $transaction->reversal_reason = $request->reversal_reason;
             $transaction->save();
 
 
             $lub = Lub::find($transaction->lub_id);
             $lub->balance += $transaction->quantity;
             $lub->save();
 
             // Commit the database transaction
             DB::commit();
 
             return redirect()->route('lub-out.index')->with('success', 'Transaction Reversed successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }
}
