<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (Hash::check($request->password, $user->password)) {
            return $this->ResponseJson([
                'token' => $user->createToken('authToken')->plainTextToken,
                'user' => $user,
            ]);
        }
        return $this->ErrorResponseJson('Incorrect email or password');
    }


    public function me(): JsonResponse
    {
        $user = auth('sanctum')->user();

        return $this->ResponseJson($user);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ResponseJson('User successfully logged out');
    }
}
