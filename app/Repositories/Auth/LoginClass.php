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
        $request->authenticate();
        return Auth::user();
    }
}
