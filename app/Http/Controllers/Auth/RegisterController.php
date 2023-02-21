<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Auth\RegisterClass;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request, RegisterClass $registerClass) {
        return $registerClass->registerUser($request);
    }
}
