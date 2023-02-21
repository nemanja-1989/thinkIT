<?php

namespace App\Repositories;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Notifications\CreateUserNotification;
use App\Notifications\UpdateUserNotification;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserRepository {

    public function all() {

        try{
            return response()->json([
                'success' => true,
                'users' => User::paginate(12)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function show(User $user) {

        try{
            return response()->json([
                'success' => true,
                'author' => $user->load(['author'])
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }

    }

    public function store(UserRegisterRequest $request) {
        try {
            //register user
            $user = User::create([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
            //assign role and permissions
            $this->assignRoleAndPermissions($user);

            $token = $user->createToken(env('API_TOKEN'))->plainTextToken;
            $user->notify(new CreateUserNotification($user, auth()->user(), $request->get('password')));
            return response()->json([
                'success' => true,
                'token_type' => 'Bearer',
                'token' => $token,
                'message' => 'User has been successfully created',
                'user' => $user->load(['roles', 'permissions'])
            ], 201);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
        }
    }

    public function update(UserUpdateRequest $request, User $user) {
        try {
            $user->fill([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password'))
            ]);
            $user->update();
            $user->roles()->delete();
            $user->permissions()->delete();
            //assign role and permissions
            $this->assignRoleAndPermissions($user);
            $user->notify(new UpdateUserNotification($user, auth()->user(), $request->get('password')));
            return response()->json([
                'success' => true,
                'message' => 'User has been successfully updated.',
                'user' => $user->load(['roles', 'permissions'])
            ], 204);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
    }

    public function destroy(User $user) {
        try{
            $user->delete();
            return response()->json([
                'success' => true,
                'message' =>
                'User has been successfully deleted.'
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    private function assignRoleAndPermissions($user) {
        if(\request()->get('role_type') === RoleConstants::REGISTER_LIBRARIAN['status']) {
            //assign role to Librarian
            $librarianRoleExists = Role::where('name', RoleConstants::LIBRARIAN['name'])->exists();
            if($librarianRoleExists) {
                $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
                $user->syncRoles([$librarianRole]);
            }
        }

        if(\request()->get('role_type') === RoleConstants::REGISTER_READER['status']) {
            //assign role to Reader
            $readerRoleExists = Role::where('name', RoleConstants::READER['name'])->exists();
            if($readerRoleExists) {
                $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
                $user->syncRoles([$librarianRole]);
            }
        }

        //assign permissions
        $permissionsExists = \Illuminate\Support\Facades\DB::table('permissions')->exists();
        if($permissionsExists) {
            $readerPermissions = \Illuminate\Support\Facades\DB::table('permissions')
                ->whereIn('name', \request()->get('permissions'))
                ->pluck('name')
                ->toArray();
            $user->syncPermissions([$readerPermissions]);
        }
    }
}
