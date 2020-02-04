<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('default_provider_id')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('dod_identifier')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('sex');
            $table->date('dob');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('default_provider_id')->references('id')->on('providers');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        Schema::create('patient_facility', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('facility_id');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->unique(['patient_id', 'facility_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_facility');
        Schema::dropIfExists('patients');
    }
}
