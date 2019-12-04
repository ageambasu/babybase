<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('babies', function (Blueprint $table) {
            //Personal information
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('application_date')->nullable();
            $table->integer('age_today')->nullable();
            $table->date('dob')->nullable();
            $table->string('sex')->nullable();
            $table->string('monolingual')->nullable();
            $table->text('other_languages')->nullable();
            $table->string('parent_firstname')->nullable();
            $table->string('parent_lastname')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->integer('house_number')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('recruitment_source')->nullable();
            
            //Appointment information
            $table->string('preferred_appointment_days')->nullable();
            $table->integer('age_at_appointment')->nullable();
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->integer('appointment_number')->nullable();
            $table->string('appointment_status')->nullable();

            //Study information
            $table->string('study_type')->nullable();
            $table->string('study_name')->nullable();
            $table->integer('study_age_range')->nullable();
            $table->text('prevous_studies_completed')->nullable();

            $table->text('notes')->nullable();
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
        Schema::dropIfExists('babies');
    }
}
