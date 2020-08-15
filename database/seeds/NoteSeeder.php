<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notes')->insert([[
            'note_sections_id' => 1,
            'name' => 'Coins',
            'summary' =>
            'CP: 100
SP: 50
GP: 10
PP: 1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'note_sections_id' => 1,
            'name' => 'Gems',
            'summary' => 'Diamond x2',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'note_sections_id' => 2,
            'name' => 'Potions',
            'summary' =>
            'Healing 2d8
Healing 4d8',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ], [
            'note_sections_id' => 2,
            'name' => 'Survival',
            'summary' => 'Blanket
Tent
Matches',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],]);
    }
}
