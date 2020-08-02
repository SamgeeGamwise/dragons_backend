<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\CharacterAbility;

class ArmorClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $character_ability_id = CharacterAbility::select('id')->where('ability_id', '=', 2)->first();

        DB::table('armor_classes')->insert([[
            'character_id' => 1,
            'character_ability_id' => $character_ability_id['id'],
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
