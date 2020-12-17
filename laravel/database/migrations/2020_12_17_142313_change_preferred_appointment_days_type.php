<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePreferredAppointmentDaysType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn('preferred_appointment_days');
        });

        Schema::table('babies', function (Blueprint $table) {
            $table->integer('preferred_appointment_days')->default(0);
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
            $table->text('preferred_appointment_days')->change();
        });
    }
}
