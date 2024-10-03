<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Vehicle;
use App\Models\Fertiliser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FertiliserTransaction;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Auth;

class FertiliserTransactionController extends Controller
{
    //fertiliserin
    public function index_fertiliser_in()
    {
        $transactions = FertiliserTransaction::where('type', 'In')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $user = Auth::user();
        return view('fertilisers.transactions.index-in', compact('transactions', 'user'));
    }


    public function report_fertiliser_in(Request $request)
    {
        $fertilisers = Fertiliser::all();
        $user = Auth::user();

        $query = FertiliserTransaction::query();        

        if ($request->filled('fertiliser_id')) {
            $query->where('fertiliser_id', $request->input('fertiliser_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        // Filter by fertiliser category
    if ($request->filled('category')) {
        $category = $request->input('category');
        $query->join('fertilisers', 'fertiliser_transactions.fertiliser_id', '=', 'fertilisers.id')
            ->where('fertilisers.category', $category);
    }

        $transactions = $query->where('type', 'In')
            ->where('is_reversed', false)
            ->orderBy('fertiliser_transactions.date', 'desc')
            ->orderBy('fertiliser_transactions.created_at', 'desc')
            ->paginate(50);

        return view('fertilisers.transactions.report-in', compact('transactions', 'user', 'fertilisers'));
    }

    public function create_fertiliser_in()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $fertilisers = Fertiliser::all();
        return view('fertilisers.transactions.create-in', compact('user', 'vehicles', 'fertilisers'));
    }

    public function store_fertiliser_in(Request $request)
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
            'fertiliser_id' => 'required|exists:fertilisers,id',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();
            // Create a new transaction
            $transaction = new FertiliserTransaction();
            $transaction->fill($validatedData);
          // dd($transaction);
            $transaction->save();

            $fertiliser = Fertiliser::find($request->fertiliser_id);
            $fertiliser->balance += $request->no_of_packs;
            $fertiliser->save();

            // Commit the database transaction
            DB::commit();
            return redirect()->route('fertiliser-in.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse fertiliserin
    public function reverse_fertiliser_in(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = FertiliserTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Check if there is enough fertiliser in store
            $fertiliser = Fertiliser::find($request->fertiliser_id);
            if ($fertiliser->balance < $transaction->no_of_packs) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient fertiliser in the store to cover this transaction!.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new FertiliserTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'delivery_note_no' => $transaction->delivery_note_no,
                'internal_delivery_no' => $transaction->internal_delivery_no,
                'fertiliser_id' => $transaction->fertiliser_id,
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


            $fertiliser = Fertiliser::find($transaction->fertiliser_id);
            $fertiliser->balance -= $transaction->no_of_packs;
            $fertiliser->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('fertiliser-in.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }


    //fertiliserOUT
    public function index_fertiliser_out()
    {
        $transactions = FertiliserTransaction::where('type', 'Out')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $user = Auth::user();
        return view('fertilisers.transactions.index-out', compact('transactions', 'user'));
    }


    public function report_fertiliser_out(Request $request)
    {
        $fertilisers = Fertiliser::all();
        $user = Auth::user();

        $query = fertiliserTransaction::query();        

        if ($request->filled('fertiliser_id')) {
            $query->where('fertiliser_id', $request->input('fertiliser_id'));
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

        // Filter by fertiliser category
    if ($request->filled('category')) {
        $category = $request->input('category');
        $query->join('fertilisers', 'fertiliser_transactions.fertiliser_id', '=', 'fertilisers.id')
            ->where('fertilisers.category', $category);
    }
    
        $transactions = $query->where('type', 'Out')
            ->where('is_reversed', false)
            ->orderBy('fertiliser_transactions.date', 'desc')
            ->orderBy('fertiliser_transactions.created_at', 'desc')
            ->paginate(50);

        return view('fertilisers.transactions.report-out', compact('transactions', 'user', 'fertilisers'));
    }


    public function create_fertiliser_out()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $operators = People::where('role', 'Operator')->get();
        $fertilisers = Fertiliser::all();
        return view('fertilisers.transactions.create-out', compact('user', 'fertilisers', 'operators'));
    }

    public function store_fertiliser_out(Request $request)
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
            'fertiliser_id' => 'required|exists:fertilisers,id',
        ]);


        try {
            // Start a database transaction
            DB::beginTransaction();

             // Check if there is enough fertiliser in store
             $fertiliser = Fertiliser::find($request->fertiliser_id);
             if ($fertiliser->balance < $request->no_of_packs) {
                 DB::rollback();
                 return back()->withInput()->with('error', 'Insufficient fertiliser in the store to cover this transaction!.');
             }

            // Create a new transaction
            $transaction = new FertiliserTransaction();
            $transaction->fill($validatedData);
            $transaction->save();

            $fertiliser = Fertiliser::find($request->fertiliser_id);
            $fertiliser->balance -= $request->no_of_packs;
            $fertiliser->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('fertiliser-out.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse fertiliserout
    public function reverse_fertiliser_out(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = FertiliserTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new FertiliserTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'receipt_no' => $transaction->receipt_no,
                'destination' => $transaction->destination,
                'fertiliser_id' => $transaction->fertiliser_id,
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


            $fertiliser = Fertiliser::find($transaction->fertiliser_id);
            $fertiliser->balance += $transaction->no_of_packs;
            $fertiliser->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('fertiliser-out.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }
    
}
