<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'id' => 1,
            'first_name' => 'Samuel',
            'last_name' => 'Krohn',
            'email' => 'sk.n8594@yahoo.com',
            'password' => '$2y$12$6UgEuoYa7VOyxqUEQrKd1e3gb68CHzHgWeQydXIAvv95ZtZDf33C.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
