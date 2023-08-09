<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'new_name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($request->input('user_id'));
        $user->name = $request->input('new_name');
        $user->save();

        return response()->json(['message' => 'Name updated successfully']);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'new_email' => 'required|email|unique:users,email,',
        ]);

        $user = User::findOrFail($request->input('user_id'));
        $user->email = $request->input('email');
        $user->save();

        return response()->json(['message' => 'Email updated successfully']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->input('user_id'));

        if (Hash::check($request->input('current_password'), $user->password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return response()->json(['message' => 'Password updated successfully']);
        } else {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }
    }
}
