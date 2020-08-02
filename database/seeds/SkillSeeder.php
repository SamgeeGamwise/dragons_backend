<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([[
            'name' => 'Appraise',
            'ability_id' => '4',
            'untrained_skill' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Balance',
            'ability_id' => '2',
            'untrained_skill' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Bluff',
            'ability_id' => '6',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Climb',
            'ability_id' => '1',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Concentrate',
            'ability_id' => '3',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Craft',
            'ability_id' => '4',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Decipher Script',
            'ability_id' => '4',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Diplomacy',
            'ability_id' => '6',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Disable Device',
            'ability_id' => '4',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Disguise',
            'ability_id' => '6',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Escape Artist',
            'ability_id' => '2',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Forgery',
            'ability_id' => '4',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Gather Information',
            'ability_id' => '6',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Handle Animal',
            'ability_id' => '6',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Heal',
            'ability_id' => '5',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Hide',
            'ability_id' => '2',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Intimidate',
            'ability_id' => '6',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Jump',
            'ability_id' => '1',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Knowledge',
            'ability_id' => '4',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Listen',
            'ability_id' => '5',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Move Silently',
            'ability_id' => '2',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Open Lock',
            'ability_id' => '2',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Perform',
            'ability_id' => '6',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Profession',
            'ability_id' => '5',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Ride',
            'ability_id' => '2',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Search',
            'ability_id' => '4',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Sense Motive',
            'ability_id' => '5',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Sleight Of Hand',
            'ability_id' => '2',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Spellcraft',
            'ability_id' => '4',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ], [
            'name' => 'Spot',
            'ability_id' => '5',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Survival',
            'ability_id' => '5',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Swim',
            'ability_id' => '1',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Tumble',
            'ability_id' => '2',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Use Magic Device',
            'ability_id' => '6',
            'untrained_skill' => false,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'name' => 'Use Rope',
            'ability_id' => '2',
            'untrained_skill' => true,

            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
