<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('baby_id')->unsigned();
            $table->foreign('baby_id')
                  ->references('id')->on('babies')->onDelete('cascade');
            $table->biginteger('study_id')->unsigned();
            $table->foreign('study_id')
                  ->references('id')->on('studies')->onDelete('cascade');
            $table->timestamps();
            $table->date('date');
            $table->time('time');
            $table->integer('number');
            $table->string('status');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
