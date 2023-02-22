<?php

namespace App\Repositories\User;

use App\Classes\User\UserPermission;
use App\Classes\User\UserRoles;
use App\Contracts\User\UserInterface;
use App\Helpers\RoleConstants;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Notifications\CreateUserNotification;
use App\Notifications\UpdateUserNotification;

class UserRepository implements UserInterface {

    public function paginate() {

        return User::paginate(12);
    }

    public function show(User $user) {

        return $user->load(['author']);
    }

    public function store(UserRegisterRequest $request) {
        $user = User::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        match((int)\request()->get('role_type')) {
            (int)RoleConstants::REGISTER_LIBRARIAN['status'] => UserRoles::assignRolesLibrarianUpdate($user),
            (int)RoleConstants::REGISTER_READER['status'] => UserRoles::assignRolesReaderUpdate($user),
        };
        UserPermission::assignPermissionsPerUpdate($user);
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
        match((int)\request()->get('role_type')) {
            (int)RoleConstants::REGISTER_LIBRARIAN['status'] => UserRoles::assignRolesLibrarianUpdate($user),
            (int)RoleConstants::REGISTER_READER['status'] => UserRoles::assignRolesReaderUpdate($user),
        };
        UserPermission::assignPermissionsPerUpdate($user);
        $user->notify(new UpdateUserNotification($user, auth()->user(), $request->get('password')));
    }

    public function destroy(User $user) {
        $user->delete();
    }
}
