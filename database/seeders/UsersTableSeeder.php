<?php

namespace Database\Seeders;

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
        $librarian->createToken(env('API_TOKEN'))->plainTextToken;
        $librarian->assignRole($librarianRole);

        $reader = User::create([
            'name' => 'Reader',
            'surname' => 'Reader Reader',
            'email' => 'reader@thinkit.com',
            'password' => bcrypt('@123qwer')
        ]);
        $reader->createToken(env('API_TOKEN'))->plainTextToken;
        $reader->assignRole($readerRole);
    }
}
