<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BabyMonolingualDutchBoolean extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babies', function(Blueprint $table) {
            $table->dropColumn('monolingual_dutch');
        });
        Schema::table('babies', function(Blueprint $table) {
            $table->boolean('monolingual_dutch')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babies', function(Blueprint $table) {
            $table->dropColumn('monolingual_dutch');
        });
        Schema::table('babies', function(Blueprint $table) {
            $table->string('monolingual_dutch')->nullable();
        });
    }
}
