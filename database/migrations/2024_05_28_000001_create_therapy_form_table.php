<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapyFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapy_form', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->date('dob')->nullable();
            $table->string('age', 255)->nullable();
            $table->string('ok_to_number', 255)->nullable();
            $table->string('ok_to_email', 255)->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('country', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zip_code', 255)->nullable();
            $table->string('employer', 255)->nullable();
            $table->string('school', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('relationship_status', 255)->nullable();
            $table->string('sexual_orientation', 255)->nullable();
            $table->string('pronouns', 255)->nullable();
            $table->string('name_of_significant', 255)->nullable();
            $table->string('age_of_significant', 255)->nullable();
            $table->string('occupation_of_significant', 255)->nullable();
            $table->string('year_married_of_significant', 255)->nullable();
            $table->string('previous_marriages', 255)->nullable();
            $table->string('year_previous_marriages', 255)->nullable();
            $table->string('divorce_previous_marriages', 255)->nullable();
            $table->string('reason_previous_marriages', 255)->nullable();
            $table->string('household_gender', 255)->nullable();
            $table->string('household_age', 255)->nullable();
            $table->string('household_relation', 255)->nullable();
            $table->string('abusive_relationship', 255)->nullable();
            $table->text('abusive_relationship_apply')->nullable();
            $table->text('abusive_relationship_occur')->nullable();
            $table->text('abusive_relationship_others')->nullable();
            $table->string('past_relationships_abusive', 255)->nullable();
            $table->text('past_relationships_abusive_describe')->nullable();
            $table->text('sexually_violated_assaulted')->nullable();
            $table->text('sexually_violated_assaulted_year')->nullable();
            $table->text('sexually_violated_assaulted_by_whom')->nullable();
            $table->text('sexually_violated_assaulted_relationship')->nullable();
            $table->text('sexually_assaulted_raped')->nullable();
            $table->text('sexually_assaulted_raped_when')->nullable();
            $table->text('sexually_assaulted_raped_whom')->nullable();
            $table->text('sexually_assaulted_raped_relation')->nullable();
            $table->text('receiving_therapy_any_one')->nullable();
            $table->text('counseling_services')->nullable();
            $table->text('counseling_services_when')->nullable();
            $table->text('counseling_services_whom')->nullable();
            $table->text('counseling_services_what')->nullable();
            $table->text('current_medical')->nullable();
            $table->text('mental_health_diagnoses')->nullable();
            $table->text('what_treatments')->nullable();
            $table->text('hospitalized_child_birth')->nullable();
            $table->text('hospitalized_child_birth_reason')->nullable();
            $table->text('hospitalized_mental_health')->nullable();
            $table->text('alcohol_usaged')->nullable();
            $table->text('alcohol_usaged_type')->nullable();
            $table->text('alcohol_usaged_frequency')->nullable();
            $table->text('family_alcohol_usaged')->nullable();
            $table->text('family_alcohol_usaged_relationship')->nullable();
            $table->text('family_alcohol_usaged_describe')->nullable();
            $table->text('prescription_medications')->nullable();
            $table->text('prescription_medications_name')->nullable();
            $table->text('prescription_medications_dosage')->nullable();
            $table->text('prescription_medications_doctor')->nullable();
            $table->text('head_injury')->nullable();
            $table->text('consciousness_hallucinations')->nullable();
            $table->text('symptom_name')->nullable();
            $table->text('symptom_contact')->nullable();
            $table->text('symptom_address')->nullable();
            $table->text('symptom_email')->nullable();
            $table->text('symptom_problems')->nullable();
            $table->text('symptom_noticeable')->nullable();
            $table->text('symptom_negative')->nullable();
            $table->text('primary_goal_one')->nullable();
            $table->text('primary_goal_two')->nullable();
            $table->text('primary_goal_three')->nullable();
            $table->longText('photos')->nullable();
            $table->string('appoinment_date', 255)->nullable();
            $table->string('appoinment_time', 255)->nullable();
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
        Schema::dropIfExists('therapy_form');
    }
}
