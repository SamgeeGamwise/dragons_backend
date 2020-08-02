<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('characters')->insert([[
            'id' => 1,
            'user_id' => 1,
            'name' => 'Xoelos',
            'class' => 'Druid',
            'race' => 'Halfling',
            'alignment' => 'True Neutral',
            'size' => 'Small',
            'gender' => 'Male',
            'experience' => 0,
            'speed' => 20,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ],]);
    }
}
