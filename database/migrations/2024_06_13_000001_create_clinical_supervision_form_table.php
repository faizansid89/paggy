<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicalSupervisionFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinical_supervision_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('clinical_supervision')->nullable();
            $table->longText('photos')->nullable();
            $table->string('radio_clinicial_schedule', 255)->nullable();
            $table->string('appoinment_date', 255)->nullable();
            $table->string('appoinment_time', 255)->nullable();
            $table->string('appoinment_type', 255)->nullable();
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
        Schema::dropIfExists('clinical_supervision_form');
    }
}
