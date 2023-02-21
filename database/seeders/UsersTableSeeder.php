<?php

namespace Database\Seeders;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table("users")->truncate();

        $librarianRole = Role::where("name", RoleConstants::LIBRARIAN['name'])->first();
        $readerRole = Role::where("name", RoleConstants::READER['name'])->first();

        $librarian = User::create([
            'name' => 'Librarian',
            'surname' => 'Librarian Librarian',
            'email' => 'librarian@thinkit.com',
            'password' => bcrypt('@123qwer')
        ]);
        //assign role
        $librarian->createToken(env('API_TOKEN'))->plainTextToken;
        $librarian->assignRole($librarianRole);
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
            $librarian->givePermissionTo($librarianPermissions);
        }

        $reader = User::create([
            'name' => 'Reader',
            'surname' => 'Reader Reader',
            'email' => 'reader@thinkit.com',
            'password' => bcrypt('@123qwer')
        ]);
        //assign role to reader
        $reader->createToken(env('API_TOKEN'))->plainTextToken;
        $reader->assignRole($readerRole);
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
            $reader->givePermissionTo($readerPermissions);
        }
    }
}
