<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AbilitySeeder::class);
        $this->call(SavingThrowSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CharacterSeeder::class);
        $this->call(CampaignSeeder::class);
        $this->call(CampaignCharacterSeeder::class);
        $this->call(CharacterAbilitySeeder::class);
        $this->call(CharacterSavingThrowSeeder::class);
        $this->call(CharacterSkillSeeder::class);
        $this->call(GrappleSeeder::class);
        $this->call(BaseAttackSeeder::class);
        $this->call(HealthPointSeeder::class);
        $this->call(InitiativeSeeder::class);
        $this->call(NoteSectionSeeder::class);
        $this->call(NoteSeeder::class);
        $this->call(SpellSeeder::class);
        $this->call(ArmorClassSeeder::class);
        $this->call(WeaponSeeder::class);
        $this->call(ArmorSeeder::class);
    }
}
