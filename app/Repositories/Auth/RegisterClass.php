<?php

namespace App\Repositories\Auth;

use App\Classes\User\UserPermission;
use App\Classes\User\UserRoles;
use App\Helpers\RoleConstants;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RegisterClass {

    /**
     * @param RegisterRequest $request
     *
     * @return [type]
     */
    public function registerUser(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $this->checkRoleRequest($user);
        return $user;
    }

    private function checkRoleRequest($user) {
        switch((int)\request()->get('role_type')) {
            case (int)RoleConstants::REGISTER_LIBRARIAN['status']:
                UserRoles::assignRolesLibrarianRegistration($user);
                UserPermission::assignPermissionsLibrarianRegistration($user);
                break;
            case (int)RoleConstants::REGISTER_READER['status']:
                UserRoles::assignRolesReaderRegistration($user);
                UserPermission::assignPermissionsReaderRegistration($user);
                break;
        }
    }
}
