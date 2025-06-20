<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register API
    public function register(Request $request){
        $data = $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed",
            "telephone" => "required|string",
            "address" => "required|string",
        ]);

        // password_confirmation

        User::create($data);

        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }

    // Login API
    public function login(Request $request){
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if(!Auth::attempt($request->only("email", "password"))){
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken("myToken")->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "User Login Successfully",
            "token" => $token,
            "role" => $user->role,
            "user" => $user,
        ]);
    }

    // Profile API
    public function profile(){
        $user = Auth::user();

        return response()->json([
            "status" => true,
            "message" => "User profile data",
            "user" => $user,
        ]);
    }

    //Logout API
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "status" => true,
            "message" => "user logout successfully",
        ]);
    }
}
