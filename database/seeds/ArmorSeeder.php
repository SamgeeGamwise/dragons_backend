<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArmorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('armors')->insert([[
            'character_id' => 1,
            'name' => 'Hide',
            'ac_bonus' => 3,
            'check_penalty' => -3,
            'type' => 'Light',
            'max_dex' => 5,
            'spell_failure' => 0,
            'speed' => '30',
            'weight' => 25,
            'notes' => 'Plain armor made of animal hide',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
