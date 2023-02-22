<?php

namespace App\Repositories\Auth;

use App\Http\Requests\LogoutRequest;

class LogoutClass {

    /**
     * @param LogoutRequest $request
     *
     * @return [type]
     */
    public function logoutUser(LogoutRequest $request) {
        $request->user()->currentAccessToken()->delete();
    }
}
