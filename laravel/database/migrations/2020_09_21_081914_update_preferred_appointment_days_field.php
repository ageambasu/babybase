<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreferredAppointmentDaysField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->text('preferred_appointment_days')->change();
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
            $table->string('preferred_appointment_days')->change();
        });
    }
}
