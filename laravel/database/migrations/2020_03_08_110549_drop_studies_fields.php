<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropStudiesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn('study_type');
            $table->dropColumn('study_name');
            $table->dropColumn('study_age_range');
            $table->dropColumn('prevous_studies_completed');
            $table->dropColumn('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->string('study_type')->nullable();
            $table->string('study_name')->nullable();
            $table->integer('study_age_range')->nullable();
            $table->text('prevous_studies_completed')->nullable();
            $table->text('notes')->nullable();
        });
    }
}
