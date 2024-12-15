<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permissions')->insert([[
            'name' => 'update_post',
        ],[
            'name' => 'delete_post',
        ],[
            'name' => 'create_user',
        ],[
            'name' => 'view_user',
        ],
        [
            'name' => 'update_user',
        ],
        [
            'name' => 'delete_user',
        ],[
            'name' => 'create_brand',
        ],
        [
            'name' => 'update_brand',
        ],
        [
            'name' => 'delete_brand',
        ],
        [
            'name' => 'create_product',
        ],
        [
            'name' => 'update_product',
        ],
        [
            'name' => 'delete_product',
        ]]);
    }
}
