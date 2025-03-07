<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'count' => $users->count(),
            'data' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required',
            'role_id' => 'required|' . Rule::in([1, 2, 3, 4]),
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user
        ]);
    }
}
