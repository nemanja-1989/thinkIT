<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table("roles")->truncate();

        Role::create([
            'name' => 'librarian',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'reader',
            'guard_name' => 'web'
        ]);
    }
}
