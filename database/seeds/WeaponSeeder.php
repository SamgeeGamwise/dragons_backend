<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weapons')->insert([[
            'character_id' => 1,
            'name' => 'Dagger',
            'attack_bonus' => '8',
            'damage' => 'D4',
            'critical' => '19-20/X2',
            'range' => '10',
            'type' => 'Slashing / Piercing',
            'notes' => 'Regular Dagger',
            'ammo' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
