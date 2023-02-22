<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\LoginClass;
use App\Repositories\Auth\LogoutClass;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function login(LoginRequest $request, LoginClass $loginClass) {
        try{
            $user = $loginClass->loginUser($request);
            return response()->json([
                'success' => true,
                'message' => 'User has been successfully logged in.',
                'token_type' => 'Bearer', 'token' => $user->createToken(env('API_TOKEN'))->plainTextToken,
                'user' => $user->load(['roles', 'permissions'])
            ], 200);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function logout(LogoutRequest $request, LogoutClass $logoutClass) {
        try{
            $logoutClass->logoutUser($request);
            return response()->json(['success' => true, 'message' => 'User has been successfully logged out.']);
        }catch(\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()]);
        }
    }
}
