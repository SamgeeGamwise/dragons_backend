<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpellSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('spells')->insert([[
            'id' => 1,
            'name' => 'Heroes’ Feast',
            'school_of_magic' => 'Conjuration',
            'area' => '',
            'casting_time' => '10 minutes',
            'components' => 'V,S,DF',
            'duration' => '1 hour plus 12 hours; see summary',
            'effect' => 'Feast for one creature/level',
            'range' => 'Close (25 ft. + 5 ft./2 levels)',
            'saving_throw' => 'None',
            'spell_resistance' => 'No',
            'summary' => 'You bring forth a great feast, including a magnificent table, chairs, service, and food and drink. The feast takes 1 hour to consume, and the beneficial effects do not set in until this hour is over. Every creature partaking of the feast is cured of all diseases, sickness, and nausea; becomes immune to poison for 12 hours; and gains 1d8 temporary hit points +1 point per two caster levels (maximum +10) after imbibing the nectar-like beverage that is part of the feast. The ambrosial food that is consumed grants each creature that partakes a +1 morale bonus on attack rolls and Will saves and immunity to fear effects for 12 hours. If the feast is interrupted for any reason, the spell is ruined and all effects of the spell are negated.',
            'target' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);

        DB::table('spell_levels')->insert([
            [
                'spells_id' => 1,
                'level' => 6,
                'class' => 'Bard',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'spells_id' => 1,
                'level' => 6,
                'class' => 'Cleric',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
