<?php

namespace App\Helpers;

class PermissionConstants {

    //ALL PERMISSIONS
    const AUTHOR_PRIVILEGES = [
        'name' => 'author',
        'nick_name' => 'author privileges'
    ];

    const USER_PRIVILEGES = [
        'name' => 'user',
        'nick_name' => 'user_privileges'
    ];

    const BOOK_PRIVILEGES_VIEW_ONLY = [
        'name' => 'book_view_only',
        'nick_name' => 'book privileges view'
    ];

    const BOOK_PRIVILEGES_CREATE = [
        'name' => 'book_create',
        'nick_name' => 'book privileges create'
    ];

    const BOOK_PRIVILEGES_EDIT = [
        'name' => 'book_edit',
        'nick_name' => 'book privileges edit'
    ];

    const BOOK_PRIVILEGES_DELETE = [
        'name' => 'book_delete',
        'nick_name' => 'book privileges delete'
    ];

}
