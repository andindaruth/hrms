<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use App\Models\People;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\FuelTransaction;
use App\Models\VehicleCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FuelTransactionController extends Controller
{
    //fuelin
    public function index_fuel_in()
    {
        $transactions = FuelTransaction::where('type', 'In')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $user = Auth::user();
        $fuel = Fuel::where('type', 'Diesel')->first();
        $balance = $fuel->balance;
        return view('fuel.transactions.index-in', compact('transactions', 'user', 'balance'));
    }


    public function report_fuel_in(Request $request)
    {
        $categories = VehicleCategory::all();
        $vehicles = Vehicle::all();
        $user = Auth::user();

        $query = FuelTransaction::query();

        // Apply filters
        if ($request->filled('category_id')) {
            $query->whereHas('vehicle.category', function ($query) use ($request) {
                $query->where('id', $request->input('category_id'));
            });
        }

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $transactions = $query->where('type', 'In')
            ->where('is_reversed', false)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $fuel = Fuel::where('type', 'Diesel')->first();
        $balance = $fuel->balance;
        return view('fuel.transactions.report-in', compact('transactions', 'user', 'balance', 'categories', 'vehicles'));
    }

    public function create_fuel_in()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $drivers = People::where('role', 'Driver')->get();
        return view('fuel.transactions.create-in', compact('user', 'vehicles', 'drivers'));
    }


    public function store_fuel_in(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([

            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'person_id' => 'required|exists:people,id',
        ]);



        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create a new transaction
            $transaction = new FuelTransaction();
            $transaction->fill($validatedData);
            $transaction->save();


            $fuel = Fuel::where('type', 'Diesel')->first();
            $fuel->balance += $request->quantity;
            $fuel->save();



            // Commit the database transaction
            DB::commit();

            return redirect()->route('fuel-in.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

    //reverse fuelin
    public function reverse_fuel_in(Request $request)
    {

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Find the transaction to reverse
            $transaction = FuelTransaction::findOrFail($request->transaction_id);

            // Ensure the transaction is not already reversed
            if ($transaction->is_reversed) {
                return back()->with('error', 'Transaction is already reversed.');
            }

            // Check if there is enough fuel in store
            $fuel = Fuel::where('type', 'Diesel')->first();
            if ($fuel->balance < $transaction->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient fuel in the store to cover this transaction!.');
            }

            // Create a new reverse transaction
            $reverseTransaction = new FuelTransaction();
            $reverseTransaction->fill([
                'type' => $transaction->type,
                'date' => $transaction->date,
                'quantity' => $transaction->quantity,
                'user_id' => $transaction->user_id,
                'vehicle_id' => $transaction->vehicle_id,
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


            $fuel = Fuel::where('type', 'Diesel')->first();
            $fuel->balance -= $transaction->quantity;
            $fuel->save();

            // Commit the database transaction
            DB::commit();

            return redirect()->route('fuel-in.index')->with('success', 'Transaction Reversed successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }


    //fuelOUT
    public function index_fuel_out()
    {
        $transactions = FuelTransaction::where('type', 'Out')
        ->orderBy('date', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(25);
        $user = Auth::user();
        $fuel = Fuel::where('type', 'Diesel')->first();
        $balance = $fuel->balance;
        return view('fuel.transactions.index-out', compact('transactions', 'user', 'balance'));
    }


    public function report_fuel_out(Request $request)
    {
        $categories = VehicleCategory::all();
        $vehicles = Vehicle::all();
        $user = Auth::user();

        $query = FuelTransaction::query();

        // Apply filters
        if ($request->filled('category_id')) {
            $query->whereHas('vehicle.category', function ($query) use ($request) {
                $query->where('id', $request->input('category_id'));
            });
        }

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->input('to_date'));
        }

        $transactions = $query->where('type', 'Out')
            ->where('is_reversed', false)
            ->orderBy('date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $fuel = Fuel::where('type', 'Diesel')->first();
        $balance = $fuel->balance;
        return view('fuel.transactions.report-out', compact('transactions', 'user', 'balance', 'categories', 'vehicles'));
    }

    public function report_fuel_out_sum(Request $request)
    {

        $user = Auth::user();

        if ($request->filled('year')) {
            $year = $request->input('year', date('Y'));
        } else {
            $year = date('Y');
        }

        // Fetch fuel transactions with related vehicle and category
        $fuelTransactions = FuelTransaction::with('vehicle.category')
            ->where('type', 'Out')
            ->where('is_reversed', false)
            ->whereYear('date', $year)
            ->get();

        // Initialize an array to store the summary data
        $summaryData = [];
        //array to store years
        $yearsArray = array();
        // Loop through years from 2020 to 2030 and add them to the array
        for ($y = 2020; $y <= 2030; $y++) {
            $yearsArray[] = $y;
        }

        // Iterate over fuel transactions to calculate totals per category and vehicle
        foreach ($fuelTransactions as $transaction) {
            $categoryName = $transaction->vehicle->category->name;
            $vehicleName = strtoupper(substr($transaction->vehicle->category->name, 0, 1)) . '/' . $transaction->vehicle->model . '/' . $transaction->vehicle->number_plate;
            $month = date('M', strtotime($transaction->date));
            $quantity = $transaction->quantity;

            // Add quantity to the corresponding category subtotal
            $summaryData[$categoryName]['total'] = isset($summaryData[$categoryName]['total']) ? $summaryData[$categoryName]['total'] + $quantity : $quantity;
            // Add quantity to the corresponding vehicle subtotal
            $summaryData[$categoryName]['vehicles'][$vehicleName][$month] = isset($summaryData[$categoryName]['vehicles'][$vehicleName][$month]) ? $summaryData[$categoryName]['vehicles'][$vehicleName][$month] + $quantity : $quantity;
        }



        return view('fuel.transactions.report-out-sum', compact('summaryData', 'user', 'year', 'yearsArray'));
    }



    public function create_fuel_out()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $vehicles = Vehicle::all();
        $operators = People::where('role', 'Operator')->get();
        return view('fuel.transactions.create-out', compact('user', 'vehicles', 'operators'));
    }


    public function store_fuel_out(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([

            'type' => 'required|max:255',
            'date' => 'required|date',
            'quantity' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'person_id' => 'required|exists:people,id',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Check if there is enough fuel in store
            $fuel = Fuel::where('type', 'Diesel')->first();
            if ($fuel->balance < $request->quantity) {
                DB::rollback();
                return back()->withInput()->with('error', 'Insufficient fuel in the store to cover this transaction!.');
            }


            // Create a new transaction
            $transaction = new FuelTransaction();
            $transaction->fill($validatedData);
            $transaction->save();

            //reduce fuel balance
            $fuel->balance -= $request->quantity;
            $fuel->save();


            // Commit the database transaction
            DB::commit();

            return redirect()->route('fuel-out.index')->with('success', 'Transaction Added successfully.');
        } catch (\Exception $e) {
            // If an exception occurs, rollback the database transaction
            DB::rollback();

            return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
        }
    }

     //reverse fuelin
     public function reverse_fuel_out(Request $request)
     {
 
         try {
             // Start a database transaction
             DB::beginTransaction();
 
             // Find the transaction to reverse
             $transaction = FuelTransaction::findOrFail($request->transaction_id);
 
             // Ensure the transaction is not already reversed
             if ($transaction->is_reversed) {
                 return back()->with('error', 'Transaction is already reversed.');
             }
 
             // Create a new reverse transaction
             $reverseTransaction = new FuelTransaction();
             $reverseTransaction->fill([
                 'type' => $transaction->type,
                 'date' => $transaction->date,
                 'quantity' => $transaction->quantity,
                 'user_id' => $transaction->user_id,
                 'vehicle_id' => $transaction->vehicle_id,
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
 
 
             $fuel = Fuel::where('type', 'Diesel')->first();
             $fuel->balance += $transaction->quantity;
             $fuel->save();
 
             // Commit the database transaction
             DB::commit();
 
             return redirect()->route('fuel-out.index')->with('success', 'Transaction Reversed successfully.');
         } catch (\Exception $e) {
             // If an exception occurs, rollback the database transaction
             DB::rollback();
 
             return back()->withInput()->with('error', 'Failed to register the transaction. Please try again.');
         }
     }

}
