<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesInitiate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('class');
            $table->integer('experience')->default(0);
            $table->string('multi_class')->nullable();
            $table->integer('multi_experience')->nullable();
            $table->string('prestige_class')->nullable();
            $table->integer('prestige_experience')->nullable();
            $table->string('race');
            $table->string('alignment')->default("True Neutral");
            $table->string('size')->default("Medium");
            $table->string('gender');
            $table->integer('speed')->default(30);
            $table->timestamps();
        });

        Schema::create('campaign_characters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('character_id')->nullable()->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->boolean('owner')->default(0);
            $table->timestamps();
        });

        Schema::create('abilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('character_abilities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('ability_id')->unsigned();
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->integer('score')->default(10);
            $table->integer('temp_score')->default(0);
            $table->timestamps();
        });

        Schema::create('saving_throws', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ability_id')->unsigned();
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('character_saving_throws', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('character_ability_id')->unsigned();
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
            $table->string('name');
            $table->integer('base_score')->default(0);
            $table->integer('magic_score')->default(0);
            $table->integer('misc_score')->default(0);
            $table->integer('temp_score')->default(0);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ability_id')->unsigned();
            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->string('name');
            $table->boolean('untrained_skill')->default(false);
            $table->timestamps();
        });

        Schema::create('character_skills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('character_ability_id')->unsigned();
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
            $table->string('name');
            $table->integer('rank_score')->default(0);
            $table->integer('misc_score')->default(0);
            $table->integer('order')->default(1);
            $table->boolean('class_skill')->default(false);
            $table->boolean('untrained_skill')->default(false);
            $table->timestamps();
        });

        Schema::create('armor_classes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('character_ability_id')->unsigned();
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
            $table->integer('armor_bonus')->default(0);
            $table->integer('size_bonus')->default(0);
            $table->integer('natural_bonus')->default(0);
            $table->integer('misc_bonus')->default(0);
            $table->timestamps();
        });

        Schema::create('base_attacks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->integer('base_bonus')->default(0);
            $table->integer('second_bonus')->nullable();
            $table->integer('third_bonus')->nullable();
            $table->integer('fourth_bonus')->nullable();
            $table->timestamps();
        });

        Schema::create('grapples', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('character_ability_id')->unsigned();
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
            $table->integer('size_bonus')->default(0);
            $table->integer('misc_bonus')->default(0);
            $table->timestamps();
        });

        Schema::create('health_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->integer('total_hp')->default(0);
            $table->integer('damage')->default(0);
            $table->integer('non_lethal')->default(0);
            $table->integer('temp_hp')->default(0);
            $table->timestamps();
        });

        Schema::create('initiatives', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->bigInteger('character_ability_id')->unsigned();
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
            $table->integer('misc_bonus')->default(0);
            $table->timestamps();
        });

        Schema::create('note_sections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->string('name')->default('Section Name');
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('note_sections_id')->unsigned();
            $table->foreign('note_sections_id')->references('id')->on('note_sections')->onDelete('cascade');
            $table->string('name')->default('Note Name');
            $table->mediumText('summary');
            $table->integer('order')->default(1);
            $table->timestamps();
        });

        Schema::create('spells', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('area');
            $table->string('casting_time');
            $table->string('components');
            $table->string('duration');
            $table->integer('level');
            $table->string('range');
            $table->string('saving_throw');
            $table->string('spell_resistance');
            $table->mediumText('summary');
            $table->string('target');
            $table->timestamps();
        });

        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->string('name')->default("Dagger");
            $table->integer('attack_bonus')->default(0);
            $table->string('damage')->default("1D4");
            $table->string('critical')->default("19-20/x2");
            $table->integer('range')->default(10);
            $table->string('type')->default("Piercing/Slashing");
            $table->integer('ammo')->default(0);
            $table->boolean('equipped')->default(0);
            $table->integer('order')->default(1);
            $table->mediumText('notes');
            $table->timestamps();
        });

        Schema::create('armors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('character_id')->unsigned();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->string('name')->default("Hide Armor");
            $table->integer('ac_bonus')->default(3);
            $table->integer('check_penalty')->default(-3);
            $table->string('type')->default("Medium");
            $table->integer('max_dex')->default(4);
            $table->string('spell_failure')->default("20%");
            $table->integer('speed')->default(20);
            $table->integer('weight')->default(25);
            $table->boolean('equipped')->default(0);
            $table->integer('order')->default(1);
            $table->mediumText('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('campaigns');

        Schema::dropIfExists('characters');

        Schema::dropIfExists('campaign_characters');

        Schema::dropIfExists('abilities');

        Schema::dropIfExists('character_abilities');

        Schema::dropIfExists('saving_throws');

        Schema::dropIfExists('character_saving_throws');

        Schema::dropIfExists('skills');

        Schema::dropIfExists('character_skills');

        Schema::dropIfExists('armor_classes');

        Schema::dropIfExists('base_attacks');

        Schema::dropIfExists('grapples');

        Schema::dropIfExists('health_points');

        Schema::dropIfExists('initiatives');

        Schema::dropIfExists('note_sections');

        Schema::dropIfExists('notes');

        Schema::dropIfExists('spells');

        Schema::dropIfExists('weapons');

        Schema::dropIfExists('armors');

        Schema::enableForeignKeyConstraints();
    }
}
