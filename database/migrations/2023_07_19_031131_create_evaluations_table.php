<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('date');
            $table->string('1a_course');
            $table->string('1b_material');
            $table->string('1c_attention');
            $table->string('1d_length');
            $table->string('1e_visual_aspects');
            $table->string('1f_degree');
            $table->string('1g_cost');
            $table->string('course_helpful');
            $table->string('recommend_this');
            $table->text('best_about');
            $table->text('least_about');
            $table->text('suggestions_improve');
            $table->text('suggestions_future');
            $table->string('take_another_course');
            $table->string('webinar_id');
            $table->string('webinar_type');
            $table->string('user_id');

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
        Schema::dropIfExists('evaluations');
    }
}
