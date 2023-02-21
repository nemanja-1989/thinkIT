<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\LoginClass;
use App\Repositories\Auth\LogoutClass;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(LoginRequest $request, LoginClass $loginClass) {
        return $loginClass->loginUser($request);
    }

    public function logout(LogoutRequest $request, LogoutClass $logoutClass) {
        return $logoutClass->logoutUser($request);
    }
}
