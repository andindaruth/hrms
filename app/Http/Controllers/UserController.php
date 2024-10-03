<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user()
    {
        $users = User::all();
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.users.index', compact('users', 'user'));
    }

    public function createUser()
    {
        $user = Auth::user();
        if($user->role == 'Store Keeper'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.users.create', compact('user'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    
    public function editUser(User $nowuser)
    {
        $user = Auth::user();
        if($user->role != 'Admin'){
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this resource!.');
        }
        return view('admin.users.edit', compact('nowuser', 'user'));
    }

    public function updateUser(Request $request, User $nowuser)
    {   
        //dd($request);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|string|confirmed|min:8',
            'role' => 'required|string',
        ]);

        $nowuser->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->has('password') ? Hash::make($request->input('password')) : $nowuser->password,
            'role' => $request->input('role'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
