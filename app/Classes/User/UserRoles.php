<?php

namespace App\Classes\User;

use App\Helpers\RoleConstants;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoles {

    public static function assignRolesLibrarianUpdate(User $user) {
        $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
        $user->syncRoles([$librarianRole]);
    }

    public static function assignRolesReaderUpdate(User $user) {
        $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
        $user->syncRoles([$readerRole]);
    }

    public static function assignRolesLibrarianRegistration(User $user) {
        $librarianRole = Role::where('name', RoleConstants::LIBRARIAN['name'])->first();
        $user->assignRole($librarianRole);
    }

    public static function assignRolesReaderRegistration(User $user) {
        $readerRole = Role::where('name', RoleConstants::READER['name'])->first();
        $user->assignRole($readerRole);
    }
}
