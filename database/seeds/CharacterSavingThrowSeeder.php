<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SavingThrow;
use App\CharacterAbility;

class CharacterSavingThrowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saving_throws = SavingThrow::select('id', 'name', 'ability_id')->get();

        $saving_throws_insert = [];

        foreach ($saving_throws as $saving_throw) {
            $character_ability_id = CharacterAbility::select('id')->where('ability_id', '=', $saving_throw['ability_id'])->first();

            array_push($saving_throws_insert, [
                'character_id' => 1,
                'name' => $saving_throw['name'],
                'character_ability_id' => $character_ability_id['id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        DB::table('character_saving_throws')->insert($saving_throws_insert);
    }
}
