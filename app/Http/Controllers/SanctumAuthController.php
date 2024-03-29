<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SanctumAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware($this->authMiddleware, ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'between:4,255'],
            'password' => ['required', 'between:4,255'],
            'device_name' => ['required', 'between:4,255'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return [
            'token' => $user->createToken($validated['device_name'])->plainTextToken
        ];
    }

    public function user(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function tokens(Request $request)
    {
        return $request->user()->tokens;
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}
