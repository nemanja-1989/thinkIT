<?php

namespace App\Repositories\Auth;

use App\Classes\User\UserPermission;
use App\Classes\User\UserRoles;
use App\Helpers\RoleConstants;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterClass {

    public function registerUser(RegisterRequest $request) {
        try{
                //register user
                $user = User::create([
                    'name' => $request->get('name'),
                    'surname' => $request->get('surname'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                ]);
                if((int)$request->get('role_type') === (int)RoleConstants::REGISTER_LIBRARIAN['status']) {
                    UserRoles::assignRolesLibrarianRegistration($user);
                    UserPermission::assignPermissionsLibrarianRegistration($user);
                }
                if((int)$request->get('role_type') === (int)RoleConstants::REGISTER_READER['status']) {
                    UserRoles::assignRolesReaderRegistration($user);
                    UserPermission::assignPermissionsReaderRegistration($user);
                }
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
