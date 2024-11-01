<?php 
namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class InstructorController extends Controller
{
    public function register(Request $request)
    {
        dd('Register method hit!');

       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:instructors',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $instructor = Instructor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate JWT
        $token = $this->generateToken($instructor);

        return response()->json(['token' => $token], 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:instructors',
            'password' => 'required|string|min:8',
        ]);

        $instructor = Instructor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json($instructor, 201);
    }

    private function generateToken($instructor)
    {
        $payload = [
            'sub' => $instructor->id,
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token valid for 1 hour
        ];

        // Include the algorithm as the third argument
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function login(Request $request)
    {
       
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('instructor')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $instructor = Auth::guard('instructor')->user();
        $token = $this->generateToken($instructor);

        return response()->json(['token' => $token], 200);
    }
}
