<?php

namespace Database\Seeders;

use App\Helpers\PermissionConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table("permissions")->truncate();

        $permissions = [
            //author permissions
            [
                'name' => PermissionConstants::AUTHOR_PRIVILEGES['name'],
                'nick_name' => PermissionConstants::AUTHOR_PRIVILEGES['nick_name'],
                'guard_name' => 'web'
            ],
            //users permissions
            [
                'name' => PermissionConstants::USER_PRIVILEGES['name'],
                'nick_name' => PermissionConstants::USER_PRIVILEGES['nick_name'],
                'guard_name' => 'web'
            ],
              //books permissions
            [
                'name' => PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name'],
                'nick_name' => PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['nick_name'],
                'guard_name' => 'web'
            ],
            [
                'name' => PermissionConstants::BOOK_PRIVILEGES_CREATE['name'],
                'nick_name' => PermissionConstants::BOOK_PRIVILEGES_CREATE['nick_name'],
                'guard_name' => 'web'
            ],
            [
                'name' => PermissionConstants::BOOK_PRIVILEGES_EDIT['name'],
                'nick_name' => PermissionConstants::BOOK_PRIVILEGES_EDIT['nick_name'],
                'guard_name' => 'web'
            ],
            [
                'name' => PermissionConstants::BOOK_PRIVILEGES_DELETE['name'],
                'nick_name' => PermissionConstants::BOOK_PRIVILEGES_DELETE['nick_name'],
                'guard_name' => 'web'
            ],
        ];

        foreach($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'nick_name' => isset($permission['nick_name']) ? $permission['nick_name'] : null,
                'guard_name' => $permission['guard_name']
            ]);
        }
    }
}

