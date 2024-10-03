<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Vehicle;
use App\Models\Chemical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ChemicalTransaction;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Auth;

class ChemicalTransactionController extends Controller
{
    //chemicalin
    public function index_chemical_in()
    {
        $transactions = ChemicalTransaction::where('type', 'In')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $user = Auth::user();
        return view('chemicals.transactions.index-in', compact('transactions', 'user'));
    }


    public function report_chemical_in(Request $request)
    {
        $chemicals = Chemical::all();
        $user = Auth::user();

        $query = ChemicalTransaction::query();        

        if ($request->filled('chemical_id')) {
            $query->where('chemical_id', $request->input('chemical_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        // Filter by chemical category
    if ($request->filled('category')) {
        $category = $request->input('category');
        $query->join('chemicals', 'chemical_transactions.chemical_id', '=', 'chemicals.id')
            ->where('chemicals.category', $category);
    }

        $transactions = $query->where('type', 'In')
            ->where('is_reversed', false)
            ->orderBy('chemical_transactions.date', 'desc')
            ->orderBy('chemical_transactions.created_at', 'desc')
            ->paginate(50);

        return view('chemicals.transactions.report-in', compact('transactions', 'user', 'chemicals'));
    }

    public function create_chemical_in()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $chemicals = Chemical::all();
        return view('chemicals.transactions.create-in', compact('user', 'vehicles', 'chemicals'));
    }

    public function store_chemical_in(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'type' => 'required|max:255',
            'date' => 'required|date',
            'no_of_packs' => 'required|numeric|min:0',
            'delivery_note_no' => 'required|max:255',
            'internal_delivery_no' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'chemical_id' => 'required|exists:chemicals,id',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $transaction = new ChemicalTransaction();
            $transaction->fill($validatedData);
           // dd($transaction);
            $transaction->save();

            $chemical = Chemical::find($request->chemical_id);
            $chemical->balance += $request->no_of_packs;
            $chemical->save();

            // Commit the database transaction
            DB::commit();
            return redirect()->route('chemical-in.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse chemicalin
    public function reverse_chemical_in(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = ChemicalTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Check if there is enough chemical in store
            $chemical = Chemical::find($request->chemical_id);
            if ($chemical->balance < $transaction->no_of_packs) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient chemical in the store to cover this transaction!.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new ChemicalTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'delivery_note_no' => $transaction->delivery_note_no,
                'internal_delivery_no' => $transaction->internal_delivery_no,
                'chemical_id' => $transaction->chemical_id,
                'no_of_packs' => $transaction->no_of_packs,
                'user_id' => $transaction->user_id,
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


            $chemical = Chemical::find($transaction->chemical_id);
            $chemical->balance -= $transaction->no_of_packs;
            $chemical->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('chemical-in.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }


    //chemicalOUT
    public function index_chemical_out()
    {
        $transactions = ChemicalTransaction::where('type', 'Out')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $user = Auth::user();
        return view('chemicals.transactions.index-out', compact('transactions', 'user'));
    }


    public function report_chemical_out(Request $request)
    {
        $chemicals = Chemical::all();
        $user = Auth::user();

        $query = ChemicalTransaction::query();        

        if ($request->filled('chemical_id')) {
            $query->where('chemical_id', $request->input('chemical_id'));
        }
        if ($request->filled('destination')) {
            $query->where('destination', $request->input('destination'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        // Filter by chemical category
    if ($request->filled('category')) {
        $category = $request->input('category');
        $query->join('chemicals', 'chemical_transactions.chemical_id', '=', 'chemicals.id')
            ->where('chemicals.category', $category);
    }
    
        $transactions = $query->where('type', 'Out')
            ->where('is_reversed', false)
            ->orderBy('chemical_transactions.date', 'desc')
            ->orderBy('chemical_transactions.created_at', 'desc')
            ->paginate(50);

        return view('chemicals.transactions.report-out', compact('transactions', 'user', 'chemicals'));
    }


    public function create_chemical_out()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $operators = People::where('role', 'Operator')->get();
        $chemicals = Chemical::all();
        return view('chemicals.transactions.create-out', compact('user', 'chemicals', 'operators'));
    }

    public function store_chemical_out(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([

            'type' => 'required|max:255',
            'date' => 'required|date',
            'no_of_packs' => 'required|numeric|min:0',
            'receipt_no' => 'required|max:255',
            'destination' => 'required|max:255',
            'user_id' => 'required|exists:users,id',
            'person_id' => 'required|exists:people,id',
            'chemical_id' => 'required|exists:chemicals,id',
        ]);


        try {
            // Start a database transaction
            DB::beginTransaction();

             // Check if there is enough chemical in store
             $chemical = Chemical::find($request->chemical_id);
             if ($chemical->balance < $request->no_of_packs) {
                 DB::rollback();
                 return back()->withInput()->with('error', 'Insufficient chemical in the store to cover this transaction!.');
             }

            // Create a new transaction
            $transaction = new ChemicalTransaction();
            $transaction->fill($validatedData);
            $transaction->save();

            $chemical = Chemical::find($request->chemical_id);
            $chemical->balance -= $request->no_of_packs;
            $chemical->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('chemical-out.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse chemicalout
    public function reverse_chemical_out(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = ChemicalTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new ChemicalTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'receipt_no' => $transaction->receipt_no,
                'destination' => $transaction->destination,
                'chemical_id' => $transaction->chemical_id,
                'no_of_packs' => $transaction->no_of_packs,
                'user_id' => $transaction->user_id,
                'person_id' => $transaction->person_id,
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


            $chemical = Chemical::find($transaction->chemical_id);
            $chemical->balance += $transaction->no_of_packs;
            $chemical->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('chemical-out.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }
    
}
