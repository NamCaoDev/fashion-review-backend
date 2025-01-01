<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            ["id" =>Str::uuid() ,"name" => "Admin", "username" => "admin1", "email" => "admin@gmail.com", "password" => Hash::make('123456'), "role" => "admin", "is_super_admin" => 1]
        ]);
    }
}
