<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class StudyAgeRangeToDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update('update studies set study_age_range_start = study_age_range_start * 30,
                    study_age_range_end = study_age_range_end * 30');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update('update studies set study_age_range_start = study_age_range_start / 30,
                    study_age_range_end = study_age_range_end / 30');
    }
}
