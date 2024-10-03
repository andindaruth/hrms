<?php

namespace App\Http\Controllers;


use App\Models\Fuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the user belongs to the selected organization
            $user = Auth::user();

            // User is authenticated, belongs to the selected organization, and is enabled
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }


    //dashboard
    public function dashboard()
    {
        $user = Auth::user();
       

        return view('dashboards.dashboard', compact('user'));
    }

    //dashboard fuel
    public function dashboard_fuel()
    {
        $user = Auth::user();
        $fuel = Fuel::where('type', 'Diesel')->first();
        $balance = $fuel->balance;
        return view('dashboards.fuel', compact('user', 'balance'));
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Clear the user's session
        $request->session()->invalidate();

        return redirect()->route('login');
    }

    // Display the Edit Profile page
    public function editProfile()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        return view('auth.edit-profile', compact('user'));
    }

    // Update the user's password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Check if the old password is correct
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return redirect()->route('user.edit-profile')->with('error', 'Old password is incorrect.');
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
    }
}
