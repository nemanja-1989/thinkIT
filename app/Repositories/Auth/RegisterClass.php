<?php

namespace App\Repositories\Auth;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

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
                    $this->assignRoleAndPermissionsToLibrarian($user);
                }
                if((int)$request->get('role_type') === (int)RoleConstants::REGISTER_READER['status']) {
                    $this->assignRoleAndPermissionsToReader($user);
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
            return response()->json([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    private function assignRoleAndPermissionsToLibrarian($user) {
        //assign role to Librarian
        $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
        $user->assignRole($librarianRole);
        //assign predefined permissions to Librarian role
        $librarianPermissions = \Illuminate\Support\Facades\DB::table('permissions')
            ->whereIn('name', [
                PermissionConstants::USER_PRIVILEGES['name'],
                PermissionConstants::AUTHOR_PRIVILEGES['name'],
                PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name'],
                PermissionConstants::BOOK_PRIVILEGES_CREATE['name'],
                PermissionConstants::BOOK_PRIVILEGES_EDIT['name'],
                PermissionConstants::BOOK_PRIVILEGES_DELETE['name']
            ])
            ->pluck('name')
            ->toArray();
        $user->givePermissionTo($librarianPermissions);
    }

    private function assignRoleAndPermissionsToReader($user) {
        //assign role to Reader
        $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
        $user->assignRole($readerRole);
        //assign predefined permissions to Reader role
        $readerPermissions = \Illuminate\Support\Facades\DB::table('permissions')
            ->whereIn('name', [
                PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name'],
                PermissionConstants::BOOK_PRIVILEGES_CREATE['name'],
                PermissionConstants::BOOK_PRIVILEGES_EDIT['name'],
                PermissionConstants::BOOK_PRIVILEGES_DELETE['name']
            ])
            ->pluck('name')
            ->toArray();
        $user->givePermissionTo($readerPermissions);
    }
}
