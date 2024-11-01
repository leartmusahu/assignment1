<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed', 
        'role' => 'in:student,instructor,admin',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request-> role ?? 'student',
    ]);

    return response()->json(['user' => $user], 201);
}

    

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);
   
    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();
        
        // Generate the token
        $token = $user->createToken('authToken')->plainTextToken;

        
        $user->api_token = $token; 
        $user->save();

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }
   
    return response()->json(['error' => 'Unauthorized'], 401);
}


}


