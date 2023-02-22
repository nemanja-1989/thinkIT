<?php

namespace App\Classes\User;

use App\Helpers\PermissionConstants;
use App\Models\User;

class UserPermission {

    public static function assignPermissionsPerUpdate(User $user) {
         //assign permissions on update Librarian user
         $permissionsExists = \Illuminate\Support\Facades\DB::table('permissions')->exists();
         if($permissionsExists) {
             $readerPermissions = \Illuminate\Support\Facades\DB::table('permissions')
                 ->whereIn('name', \request()->get('permissions'))
                 ->pluck('name')
                 ->toArray();
             $user->syncPermissions([$readerPermissions]);
         }
    }

    public static function assignPermissionsLibrarianRegistration(User $user) {
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

    public static function assignPermissionsReaderRegistration(User $user) {
        //assign predefined permissions to Reader role
        $readerPermissions = \Illuminate\Support\Facades\DB::table('permissions')
            ->whereIn('name', [
                PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name']
            ])
            ->pluck('name')
            ->toArray();
        $user->givePermissionTo($readerPermissions);
    }
}
