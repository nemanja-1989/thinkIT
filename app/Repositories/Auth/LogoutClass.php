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
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json(['success' => true, 'message' => 'User has been successfully logged out.']);
        }catch(\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()]);
        }
    }
}
