<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permissions')->insert([[
            "id" =>Str::uuid(),
            'name' => 'update_post',
        ],[
            "id" =>Str::uuid(),
            'name' => 'delete_post',
        ],[
            "id" =>Str::uuid(),
            'name' => 'create_user',
        ],[
            "id" =>Str::uuid(),
            'name' => 'view_user',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'update_user',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'delete_user',
        ],[
            "id" =>Str::uuid(),
            'name' => 'create_brand',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'update_brand',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'delete_brand',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'create_product',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'update_product',
        ],
        [
            "id" =>Str::uuid(),
            'name' => 'delete_product',
        ]]);
    }
}
