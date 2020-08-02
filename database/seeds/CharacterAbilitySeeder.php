<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ability;

class CharacterAbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = Ability::select('id')->get();

        $abilities_insert = [];

        foreach ($abilities as $ability) {
            array_push($abilities_insert, [
                'character_id' => 1,
                'ability_id' => $ability['id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        DB::table('character_abilities')->insert($abilities_insert);
    }
}
