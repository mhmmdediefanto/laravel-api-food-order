<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class  AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Email Atau Password Salah'], 401);
            }
            $user->tokens()->delete();

            $user->makeHidden(['created_at', 'updated_at', 'email_verified_at']);

            return response()->json([
                'token' => $user->createToken($request->email)->plainTextToken,
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], status: 500);
        }
    }

    public function me()
    {
        $user = Auth::user();
        unset($user->created_at);
        unset($user->updated_at);
        unset($user->email_verified_at);
        return response()->json([
            'data' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // dd($user);
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['error' => 'Not authenticated'], 401);
    }
}
