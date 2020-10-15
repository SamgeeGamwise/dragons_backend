<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaignCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_characters', function (Blueprint $table) {
            $table->dropForeign(['character_id']);
        });

        Schema::table('campaign_characters', function (Blueprint $table) {
            $table->string('character_id')->nullable()->change();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('code')->unique()->change();
            $table->string('firebase_key')->nullable()->after('code');
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
            $table->bigInteger('character_id')->nullable()->unsigned()->change();
        });

        Schema::table('campaign_characters', function (Blueprint $table) {
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('code')->change();
            $table->dropColumn('firebase_key');
        });
    }
}
