<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Skill;
use App\CharacterAbility;

class CharacterSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = Skill::select('id', 'ability_id', 'name', 'untrained_skill')->get();
        $skills_insert = [];

        foreach ($skills as $skill) {
            $character_ability_id = CharacterAbility::select('id')->where('ability_id', '=', $skill['ability_id'])->first();

            array_push($skills_insert, [
                'character_id' => 1,
                'character_ability_id' => $character_ability_id['id'],
                'name' => $skill['name'],
                'untrained_skill' => $skill['untrained_skill'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        DB::table('character_skills')->insert($skills_insert);
    }
}
