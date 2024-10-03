<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Vehicle;
use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PackagingTransaction;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\Auth;

class PackagingTransactionController extends Controller
{
     //packagingin
     public function index_packaging_in()
     {
         $transactions = PackagingTransaction::where('type', 'In')
         ->orderBy('date', 'desc')
         ->orderBy('created_at', 'desc')
         ->paginate(25);
         $user = Auth::user();
         return view('packagings.transactions.index-in', compact('transactions', 'user'));
     }
 
 
     public function report_packaging_in(Request $request)
     {
         $packagings = Packaging::all();
         $user = Auth::user();
 
         $query = PackagingTransaction::query();        
 
         if ($request->filled('packaging_id')) {
             $query->where('packaging_id', $request->input('packaging_id'));
         }
 
         if ($request->filled('from_date')) {
             $query->where('date', '>=', $request->input('from_date'));
         }
 
         if ($request->filled('to_date')) {
             $query->where('date', '<=', $request->input('to_date'));
         }
 
         // Filter by packaging category
     if ($request->filled('category')) {
         $category = $request->input('category');
         $query->join('packagings', 'packaging_transactions.packaging_id', '=', 'packagings.id')
             ->where('packagings.category', $category);
     }
 
         $transactions = $query->where('type', 'In')
             ->where('is_reversed', false)
             ->orderBy('packaging_transactions.date', 'desc')
             ->orderBy('packaging_transactions.created_at', 'desc')
             ->paginate(50);
 
         return view('packagings.transactions.report-in', compact('transactions', 'user', 'packagings'));
     }
 
     public function create_packaging_in()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         $vehicles = Vehicle::all();
         $packagings = Packaging::all();
         return view('packagings.transactions.create-in', compact('user', 'vehicles', 'packagings'));
     }
 
     public function store_packaging_in(Request $request)
     {
        //dd($request); 
        // Validate the input data
         $validatedData = $request->validate([
             'type' => 'required|max:255',
             'date' => 'required|date',
             'no_of_packs' => 'required|numeric|min:0',
             'total_quantity' => 'required|numeric|min:0',
             'delivery_note_no' => 'required|max:255',
             'internal_delivery_no' => 'required|max:255',
             'user_id' => 'required|exists:users,id',
             'vehicle_id' => 'required|exists:vehicles,id',
             'packaging_id' => 'required|exists:packagings,id',
         ]);
 
         try {
             // Start a database transaction
             DB::beginTransaction();
             // Create a new transaction
             $transaction = new PackagingTransaction();
             $transaction->fill($validatedData);
            // dd($transaction);
             $transaction->save();
 
             $packaging = Packaging::find($request->packaging_id);
             $packaging->balance += $request->total_quantity;
             $packaging->save();
 
             // Commit the database transaction
             DB::commit();
             return redirect()->route('packaging-in.index')->with('success', 'Transaction Added successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }
 
     //reverse packagingin
     public function reverse_packaging_in(Request $request)
     {
 
         try {
             // Start a database transaction
             DB::beginTransaction();
 
             // Find the transaction to reverse
             $transaction = PackagingTransaction::findOrFail($request->transaction_id);
 
             // Ensure the transaction is not already reversed
             if ($transaction->is_reversed) {
                 return back()->with('error', 'Transaction is already reversed.');
             }
 
             // Check if there is enough packaging in store
             $packaging = Packaging::find($request->packaging_id);
             if ($packaging->balance < $transaction->no_of_packs) {
                 DB::rollback();
                 return back()->withInput()->with('error', 'Insufficient packaging in the store to cover this transaction!.');
             }
 
             // Create a new reverse transaction
             $reverseTransaction = new PackagingTransaction();
             $reverseTransaction->fill([
                 'type' => $transaction->type,
                 'date' => $transaction->date,
                 'delivery_note_no' => $transaction->delivery_note_no,
                 'internal_delivery_no' => $transaction->internal_delivery_no,
                 'packaging_id' => $transaction->packaging_id,
                 'no_of_packs' => $transaction->no_of_packs,
                 'total_quantity' => $transaction->total_quantity,
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
 
 
             $packaging = Packaging::find($transaction->packaging_id);
             $packaging->balance -= $transaction->total_quantity;
             $packaging->save();
 
             // Commit the database transaction
             DB::commit();
 
             return redirect()->route('packaging-in.index')->with('success', 'Transaction Reversed successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }
 
 
     //packagingOUT
     public function index_packaging_out()
     {
         $transactions = PackagingTransaction::where('type', 'Out')
         ->orderBy('date', 'desc')
         ->orderBy('created_at', 'desc')
         ->paginate(25);
         $user = Auth::user();
         return view('packagings.transactions.index-out', compact('transactions', 'user'));
     }
 
 
     public function report_packaging_out(Request $request)
     {
         $packagings = Packaging::all();
         $user = Auth::user();
 
         $query = PackagingTransaction::query();        
 
         if ($request->filled('packaging_id')) {
             $query->where('packaging_id', $request->input('packaging_id'));
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
 
         // Filter by packaging category
     if ($request->filled('category')) {
         $category = $request->input('category');
         $query->join('packagings', 'packaging_transactions.packaging_id', '=', 'packagings.id')
             ->where('packagings.category', $category);
     }
     
         $transactions = $query->where('type', 'Out')
             ->where('is_reversed', false)
             ->orderBy('packaging_transactions.date', 'desc')
             ->orderBy('packaging_transactions.created_at', 'desc')
             ->paginate(50);
 
         return view('packagings.transactions.report-out', compact('transactions', 'user', 'packagings'));
     }
 
 
     public function create_packaging_out()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
         $operators = People::where('role', 'Operator')->get();
         $packagings = Packaging::all();
         return view('packagings.transactions.create-out', compact('user', 'packagings', 'operators'));
     }
 
     public function store_packaging_out(Request $request)
     {
         // Validate the input data
         $validatedData = $request->validate([
 
             'type' => 'required|max:255',
             'date' => 'required|date',
             'no_of_packs' => 'required|numeric|min:0',
             'total_quantity' =>  'required|numeric|min:0',
             'receipt_no' => 'required|max:255',
             'destination' => 'required|max:255',
             'user_id' => 'required|exists:users,id',
             'person_id' => 'required|exists:people,id',
             'packaging_id' => 'required|exists:packagings,id',
         ]);
 
 
         try {
             // Start a database transaction
             DB::beginTransaction();
 
              // Check if there is enough packaging in store
              $packaging = Packaging::find($request->packaging_id);
              if ($packaging->balance < $request->total_quantity) {
                  DB::rollback();
                  return back()->withInput()->with('error', 'Insufficient packaging in the store to cover this transaction!.');
              }
 
             // Create a new transaction
             $transaction = new PackagingTransaction();
             $transaction->fill($validatedData);
             $transaction->save();
 
             $packaging = Packaging::find($request->packaging_id);
             $packaging->balance -= $request->total_quantity;
             $packaging->save();
 
             // Commit the database transaction
             DB::commit();
 
             return redirect()->route('packaging-out.index')->with('success', 'Transaction Added successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }
 
     //reverse packagingout
     public function reverse_packaging_out(Request $request)
     {
 
         try {
             // Start a database transaction
             DB::beginTransaction();
 
             // Find the transaction to reverse
             $transaction = PackagingTransaction::findOrFail($request->transaction_id);
 
             // Ensure the transaction is not already reversed
             if ($transaction->is_reversed) {
                 return back()->with('error', 'Transaction is already reversed.');
             }
 
             // Create a new reverse transaction
             $reverseTransaction = new PackagingTransaction();
             $reverseTransaction->fill([
                 'type' => $transaction->type,
                 'date' => $transaction->date,
                 'receipt_no' => $transaction->receipt_no,
                 'destination' => $transaction->destination,
                 'packaging_id' => $transaction->packaging_id,
                 'no_of_packs' => $transaction->no_of_packs,
                 'total_quantity' => $transaction->total_quantity,
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
 
 
             $packaging = Packaging::find($transaction->packaging_id);
             $packaging->balance += $transaction->total_quantity;
             $packaging->save();
 
             // Commit the database transaction
             DB::commit();
 
             return redirect()->route('packaging-out.index')->with('success', 'Transaction Reversed successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }
}
