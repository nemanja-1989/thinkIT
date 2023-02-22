<?php

namespace App\Repositories\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginClass {

    /**
     * @param LoginRequest $request
     *
     * @return [type]
     */
    public function loginUser(LoginRequest $request) {
        try{
            $request->authenticate();
            $token = Auth::user()->createToken(env('API_TOKEN'))->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'User has been successfully logged in.',
                'token_type' => 'Bearer', 'token' => $token,
                'user' => Auth::user()->load(['roles', 'permissions'])
            ], 200);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
