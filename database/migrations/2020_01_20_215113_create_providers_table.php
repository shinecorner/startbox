<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('suffix_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('creator_id')->references('id')->on('users');
        });

        Schema::create('facility_provider', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('provider_id');
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('facility_id')->references('id')->on('facilities');

            $table->unique(['facility_id', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_provider');
        Schema::dropIfExists('providers');
    }
}
