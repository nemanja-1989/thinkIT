<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request) {

        try{
                $userExists = User::where('email', $request->get('email'))->exists();
                if($userExists) {
                    return response()->json(['success' => false, 'message' => 'Account with this ' . $request->get('email') . ' address already exists!']);
                }
                    //register owner
                    $user = User::create([
                        'name' => $request->get('name'),
                        'surname' => $request->get('surname'),
                        'email' => $request->get('email'),
                        'password' => bcrypt($request->get('password')),
                    ]);

                    if($request->get('role_type') === RoleConstants::REGISTER_LIBRARIAN['status']) {
                        //assign role to Librarian
                        $librarianRoleExists = Role::where('name', RoleConstants::LIBRARIAN['name'])->exists();
                        if($librarianRoleExists) {
                            $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
                            $user->assignRole($librarianRole);
                        }
                        //assign predefined permissions to Librarian role
                        $permissionsExists = \Illuminate\Support\Facades\DB::table('permissions')->exists();
                        if($permissionsExists) {
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
                    }

                    if($request->get('role_type') === RoleConstants::REGISTER_READER['status']) {
                        //assign role to Reader
                        $readerRoleExists = Role::where('name', RoleConstants::READER['name'])->exists();
                        if($readerRoleExists) {
                            $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
                            $user->assignRole($readerRole);
                        }
                        //assign predefined permissions to Reader role
                        $permissionsExists = \Illuminate\Support\Facades\DB::table('permissions')->exists();
                        if($permissionsExists) {
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
}
