<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BabiesRemoveColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn(['appointment_date', 'appointment_time', 'appointment_number',
                                'appointment_status' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->integer('age_at_appointment')->nullable();
        $table->date('appointment_date')->nullable();
        $table->time('appointment_time')->nullable();
        $table->integer('appointment_number')->nullable();
        $table->string('appointment_status')->nullable();
    }
}
