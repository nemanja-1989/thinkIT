<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(LoginRequest $request) {
        $request->authenticate();
        $token = Auth::user()->createToken(env('API_TOKEN'))->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User has been successfully logged in.',
            'token_type' => 'Bearer', 'token' => $token,
            'user' => Auth::user()->load(['roles', 'permissions'])], 200);
    }

    public function logout(LogoutRequest $request) {
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json(['success' => true, 'message' => 'User has been successfully logged out.']);
        }catch(\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()]);
        }
    }
}
