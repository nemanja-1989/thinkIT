<?php

namespace App\Repositories\User;

use App\Contracts\User\UserInterface;
use App\Helpers\RoleConstants;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Notifications\CreateUserNotification;
use App\Notifications\UpdateUserNotification;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface {

    public function paginate() {

        return User::paginate(12);
    }

    public function show(User $user) {

        return $user->load(['author']);
    }

    public function store(UserRegisterRequest $request) {
        //register user
        $user = User::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        //assign role and permissions
        $this->assignRoleAndPermissions($user);
        //notify user for new account
        $user->notify(new CreateUserNotification($user, auth()->user(), $request->get('password')));
        return $user;
    }

    public function update(UserUpdateRequest $request, User $user) {
        $user->fill([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        $user->update();
        //assign role and permissions
        $this->assignRoleAndPermissions($user);
        //notify user per account update
        $user->notify(new UpdateUserNotification($user, auth()->user(), $request->get('password')));
    }

    public function destroy(User $user) {
        $user->delete();
    }

    private function assignRoleAndPermissions($user) {
        if((int)\request()->get('role_type') === (int)RoleConstants::REGISTER_LIBRARIAN['status']) {
            //assign role to Librarian
            $librarianRoleExists = Role::where('name', RoleConstants::LIBRARIAN['name'])->exists();
            if($librarianRoleExists) {
                $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
                $user->syncRoles([$librarianRole]);
            }
        }

        if((int)\request()->get('role_type') === (int)RoleConstants::REGISTER_READER['status']) {
            //assign role to Reader
            $readerRoleExists = Role::where('name', RoleConstants::READER['name'])->exists();
            if($readerRoleExists) {
                $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
                $user->syncRoles([$readerRole]);
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
