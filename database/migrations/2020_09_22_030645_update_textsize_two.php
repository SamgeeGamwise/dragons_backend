<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTextsizeTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->mediumText('summary')->default('Note Summary')->change();
        });

        Schema::table('spells', function (Blueprint $table) {
            $table->mediumText('summary')->change();
        });

        Schema::table('weapons', function (Blueprint $table) {
            $table->mediumText('notes')->default("A short knife with a pointed and edged blade")->change();
        });

        Schema::table('armors', function (Blueprint $table) {
            $table->mediumText('notes')->default("Crude armor consisting of thick furs and pelts")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->string('summary')->change();
        });

        Schema::table('spells', function (Blueprint $table) {
            $table->string('summary')->change();
        });

        Schema::table('weapons', function (Blueprint $table) {
            $table->string('notes')->change();
        });

        Schema::table('armors', function (Blueprint $table) {
            $table->string('notes')->change();
        });
    }
}
