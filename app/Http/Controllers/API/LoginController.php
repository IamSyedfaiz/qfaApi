<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                ],
            ]);
        } else {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 401,
                    'message' => 'The provided credentials are incorrect.',
                    'data' => null,
                ],
                401,
            );
        }
    }
}
