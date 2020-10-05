<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_characters', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->onDelete('cascade');
        });

        Schema::table('character_skills', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities')->onDelete('cascade');
        });

        Schema::table('character_saving_throws', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities')->onDelete('cascade');
        });

        Schema::table('armor_classes', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities')->onDelete('cascade');
        });

        Schema::table('grapples', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities')->onDelete('cascade');
        });

        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities')->onDelete('cascade');
        });

        Schema::table('character_abilities', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');
        });

        Schema::table('saving_throws', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('recipient_user_id')->unsigned();
            $table->foreign('recipient_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('firebase_key');
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
        Schema::table('campaign_characters', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
            $table->foreign('campaign_id')
                ->references('id')->on('campaigns');
        });

        Schema::table('character_skills', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign(['character_ability_id'])->references('id')->on('character_abilities');
        });

        Schema::table('character_saving_throws', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
        });

        Schema::table('armor_classes', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
        });

        Schema::table('grapples', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
        });

        Schema::table('initiatives', function (Blueprint $table) {
            $table->dropForeign(['character_ability_id']);
            $table->foreign('character_ability_id')->references('id')->on('character_abilities');
        });

        Schema::table('character_abilities', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities');
        });

        Schema::table('saving_throws', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign(['ability_id']);
            $table->foreign('ability_id')->references('id')->on('abilities');
        });

        Schema::dropIfExists('chats');
    }
}
