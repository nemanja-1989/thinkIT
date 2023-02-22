<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Auth\RegisterClass;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, RegisterClass $registerClass) {
        try{
            $user = $registerClass->registerUser($request);
            $token = $user->createToken(env('API_TOKEN'))->plainTextToken;
            return response()->json([
                'success' => true,
                'token_type' => 'Bearer',
                'token' => $token,
                'message' => 'User has been successfully register',
                'user' => $user->load(['roles', 'permissions'])
            ], 201);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
