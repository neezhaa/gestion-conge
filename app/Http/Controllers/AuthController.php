<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employe;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employes',
            'password' => 'required',
        ]);

        $employe = Employe::where('email', $request->email)->first();

        if (!$employe || !Hash::check($request->password, $employe->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $employe->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'employe' => $employe,
        ]);
    
        // $user = Auth::user();
        // $token = $user->createToken('auth_token')->plainTextToken;
    
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $employe = $request->user();

        if (!Hash::check($request->current_password, $employe->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
            ], 400);
        }

        $employe->password = Hash::make($request->new_password);
        $employe->save();

        return response()->json([
            'message' => 'Password updated successfully.',
        ]);
    }

}
