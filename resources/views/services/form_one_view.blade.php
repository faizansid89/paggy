@extends('layouts.dashboard')

@section('content')

    <div class="page-wrapper cardhead">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">{{ $section->heading }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ $section->heading }}</a></li>
                            <li class="breadcrumb-item active">{{ $section->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
<style>
    label.form-label {
    font-size: 18px;
    font-weight: 500;
    padding-right: 20px;
}
.threegoals .input-group {
    display: flex;
    align-items: center;
    gap: 20px;
}
.dflex {
    display: flex;
    flex-direction: column;
}
</style>

            <div class="row">
                <div class="col-md-12">

                    <!-- main alert @s -->
                    @include('partials.alerts')
                    <!-- main alert @e -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $section->title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-row row">
                               <div class="col-md-4 mb-3">
                                  <label class="form-label" for="validationCustom01">First name:</label>
                                  <p class="form">{{ $formData->first_name }}</p>
                               </div>
                               <div class="col-md-4 mb-3">
                                  <label class="form-label" for="validationCustom02">Last name:</label>
                                  <p class="form">{{ $formData->last_name }}</p>
                               </div>
                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Email:</label>
                                  <p class="form">{{ $formData->email }}</p>
                               </div>
                               
                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Contact Number:</label>
                                  <p class="form">{{ $formData->phone }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label class="form-label">DOB:</label>
                                  <p class="form">{{ $formData->dob }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Age:</label>
                                  <p class="form">{{ $formData->age }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                   <div class="form-group">
                                       <label>Is it OK to leave a message at this number?</label>
                                       {{ $formData->ok_to_number }}
                                   </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                   <div class="form-group">
                                       <label>Is it OK to send you an email?</label>
                                       {{ $formData->ok_to_email }}
                                   </div>
                               </div>
                           </div>
                           <div class="form-row row">

                               <div class="col-md-4 mb-3">
                                  <label for="inputAddress" class="form-label">Address:</label>
                                  <p class="form">{{ $formData->address1 }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="inputAddress2" class="form-label">Address 2:</label>
                                  <p class="form">{{ $formData->address2 }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="inputCountry" class="form-label">Country:</label>
                                  <p class="form">{{ $formData->country }}</p>
                               </div>


                               <div class="col-md-2 mb-3">
                                  <label for="inputCity" class="form-label">City:</label>
                                  <p class="form">{{ $formData->city }}</p>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="inputZip" class="form-label">Zip:</label>
                                  <p class="form">{{ $formData->zip_code }}</p>
                               </div>

                                <div class="col-md-4 mb-3">
                                  <label for="inputEmployer" class="form-label">Employer:</label>
                                  <p class="form">{{ $formData->employer }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="inputSchool" class="form-label">School:</label>
                                  <p class="form">{{ $formData->school }}</p>
                               </div>


                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label>Sex/Gender:</label>
                                     {{ $formData->gender }}
                                  </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label class="form-label">Current relationship status (please “X” one)</label>
                                     {{ $formData->relationship_status }}
                                  </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label class="form-label">Sexual Orientation:</label>
                                     {{ $formData->sexual_orientation }}
                                  </div>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <div class="form-group">
                                     <label class="form-label">Pronouns:</label>
                                     {{ $formData->pronouns }}
                                  </div>
                               </div>

                               <div class="col-md-3 mb-3">
                                  <label for="NameofSignificant" class="form-label">Name of Significant other:</label>
                                   <p class="form">{{ $formData->name_of_significant }}</p>
                                  
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="SignificantAge" class="form-label">Age:</label>
                                   <p class="form">{{ $formData->age_of_significant }}</p>
                               </div>

                               <div class="col-md-3 mb-3">
                                  <label for="SignificantOccupation" class="form-label">Occupation:</label>
                                   <p class="form">{{ $formData->occupation_of_significant }}</p>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="SignificantYearsMarried" class="form-label">Years Married:</label>
                                   <p class="form">{{ $formData->year_married_of_significant }}</p>
                               </div>

                               <div class="col-md-3 mb-3">
                                   <div class="form-group">
                                       <label class="form-label">Previous marriages:</label>
                                       {{ $formData->previous_marriages }}
                                   </div>
                               </div>
                                <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="yearsmarried" class="form-label"># of years married:</label>
                                  <p class="form">{{ $formData->year_previous_marriages }}</p>
                               </div>
                               <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="yearsdivorce" class="form-label">years of divorce:</label>
                                  <p class="form">{{ $formData->divorce_previous_marriages }}</p>
                               </div>
                               <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="reasonfordivorce" class="form-label">reason for divorce:</label>
                                  <p class="form">{{ $formData->reason_previous_marriages }}</p>
                               </div>

                            </div>


                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Who currently lives in your household?</h3>
                                    <h5 class="mb-3">ease list age and gender of your children</h5>
                                </div>
                            </div>

                            <!-- HouseHoldFields Start -->
                            <div class="form-row row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Sex/Gender:</label>
                                        {{ $formData->household_gender }}
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                  <label for="HouseHoldAge" class="form-label">Age:</label>
                                  <p class="form">{{ $formData->household_age }}</p>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="HouseHoldRelationship" class="form-label">Relationship:</label>
                                  <p class="form">{{ $formData->household_relation }}</p>
                               </div>
                            </div>
                            <!-- HouseHoldFields END -->

                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Are there any relationships that you are concerned about?</h3>
                                    <h5 class="mb-3">Abuse History</h5>
                                </div>
                            </div>

                            <div class="form-row row">
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>Are you currently in an abusive relationship?</label>
                                        {{ $formData->abusive_relationship }}
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3 relationshipAbuseFeilds">
                                    <div class="form-group">
                                        <label>If “Yes”, check the types of abuse that apply to this relationship</label>
                                        <div class="form-check"> 
                                            <input class="form-check-input" value="Emotional" type="radio" name="abusive_relationship_apply" id="abusiveRelationshipEmotional" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipEmotional">{{ $formData->abusive_relationship_apply }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3 relationshipAbuseFeilds">
                                    <div class="form-group">
                                        <label>How often does this occur?</label>
                                        {{ $formData->abusive_relationship_occur }}
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3 OccurOthersFields relationshipAbuseNoFeilds">
                                  <label for="OccurOthers" class="form-label">Other:</label>
                                  <p class="form">{{ $formData->abusive_relationship_others }}</p>
                               </div>

                            </div>

                            <!-- relationshipAbusiveCustom start -->
                            <div class="form-row row relationshipAbusiveCustom">
                                <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Have you had past relationships that were abusive?</label>
                                         {{ $formData->past_relationships_abusive }}
                                     </div>
                                 </div>
                                 <div class="col-md-8 mb-3 relationshipsAbusiveFields hidden">
                                  <label for="Abusivedescribe" class="form-label">If “Yes”, please describe</label>
                                  <p class="form">{{ $formData->past_relationships_abusive_describe }}</p>
                               </div>
                            </div>
                            <!-- relationshipAbusiveCustom end -->

                            <!-- sexually/violated/assaulted Start -->
                                <div class="form-row row CustomSexuallyViolatedAssaulted">
                                    <div class="col-md-4 mb-3">
                                         <div class="form-group">
                                             <label>Were you ever sexually violated/assaulted as a child (0-18 years)?</label>
                                             {{ $formData->sexually_violated_assaulted }}
                                         </div>
                                     </div>
                                     <div class="col-md-4 mb-3 SexuallyViolatedAssaultedFields">
                                        <label for="SexuallyOldWere" class="form-label">If “Yes”, how old were you?</label>
                                        <p class="form">{{ $formData->sexually_violated_assaulted_year }}</p>
                                     </div>
                                </div>
                            <!-- sexually/violated/assaulted End -->

                            <!-- CustomAdultRaped Start -->
                                <div class="form-row row">
                                    <div class="col-md-4 mb-3">
                                         <div class="form-group">
                                             <label>Have you ever been sexually assaulted or raped as an adult?</label>
                                             {{ $formData->sexually_assaulted_raped }}
                                         </div>
                                     </div>
                                     <div class="col-md-4 mb-3 CustomAdultRapedFields">
                                        <label for="RapeYesWhen" class="form-label">“Yes”, when?</label>
                                        <p class="form">{{ $formData->sexually_assaulted_raped_when }}</p>
                                     </div>
                                     <div class="col-md-4 mb-3 CustomAdultRapedFields">
                                        <label for="RapeRelationship" class="form-label">Relationship</label>
                                        <p class="form">{{ $formData->sexually_assaulted_raped_relation }}</p>
                                     </div>
                                </div>
                            <!-- CustomAdultRaped End -->


                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Therapy History:</h3>
                                </div>
                            </div>

                            <div class="form-row row">
                                <div class="col-md-3 mb-3">
                                     <div class="form-group">
                                         <label>Are you currently receiving therapy with anyone?</label>
                                         {{ $formData->receiving_therapy_any_one }}
                                     </div>
                                 </div>
                                 <div class="col-md-3 mb-3 ReceivingTherapyFields">
                                    <label for="ReceivingTherapyFromWhen" class="form-label">Form whom?</label>
                                    <p class="form">{{ $formData->receiving_therapy_from_when }}</p>
                                 </div>
                                 <div class="col-md-3 mb-3 ReceivingTherapyFields">
                                    <label for="ReceivingTherapyPhone" class="form-label">Phone</label>
                                    <p class="form">{{ $formData->receiving_therapy_phone }}</p>
                                 </div>
                                 <div class="col-md-3 mb-3 ReceivingTherapyFields">
                                    <label for="ReceivingTherapyEmail" class="form-label">Email</label>
                                    <p class="form">{{ $formData->receiving_therapy_email }}</p>
                                 </div>
                            </div>

                            <!-- CustomCounselingServices Start -->
                            <div class="form-row row">
                                <div class="col-md-3 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever received any type of counseling services before today?</label>
                                         {{ $formData->counseling_services }}
                                     </div>
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields dflex">
                                    <label for="CounselingServicesWhen" class="form-label">When?</label>
                                    <p class="form">{{ $formData->counseling_services_when }}</p>
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields dflex">
                                    <label for="CounselingServicesFromwhom" class="form-label">Form whom?</label>
                                    <p class="form">{{ $formData->counseling_services_whom }}</p>
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields dflex">
                                    <label for="CounselingServicesForWhat" class="form-label">For what?</label>
                                    <p class="form">{{ $formData->counseling_services_what }}</p>

                                 </div>
                            </div>
                            <!-- CustomCounselingServices END -->


                            <!-- MedicalHistory Start -->
                            <div class="form-row row">
                                 <div class="col-md-12 mb-3 dflex">
                                   <label for="inputCurrentMedical" class="form-label">Do you have any current medical conditions?</label>
                                   <p class="form">{{ $formData->current_medical }}</p>
                                </div>
                                <div class="col-md-12 mb-3 dflex">
                                   <label for="inputMentalHealthDiagnoses" class="form-label">Please list any mental health diagnoses received from a mental health or medical professional</label>
                                   <p class="form">{{ $formData->mental_health_diagnoses }}</p>
                                </div>
                                <div class="col-md-12 mb-3 dflex">
                                   <label for="inputWhatTreatments" class="form-label">What treatments have you tried for these medical and mental health diagnoses?</label>
                                   <p class="form">{{ $formData->what_treatments }}</p>
                                </div>

                                <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever been hospitalized for medical reasons other than childbirth?</label>
                                         {{ $formData->hospitalized_child_birth }}
                                     </div>
                                 </div>
                                 <div class="col-md-8 mb-3 radioChildBirthFields">
                                     <label for="inputWhatReasons" class="form-label">for what reasons?</label>
                                     <p class="form">{{ $formData->hospitalized_child_birth_reason }}</p>
                                 </div>

                                 <div class="col-md-12 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever been hospitalized for mental health reasons?</label>
                                         {{ $formData->hospitalized_mental_health }}
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Is there a history of drug or alcohol usage?</label>
                                         {{ $formData->alcohol_usaged }}
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3 radioAlcoholUsagedFields">
                                     <label for="inputDrugAlcoholType" class="form-label">Drug/Alcohol Type</label>
                                     <p class="form">{{ $formData->alcohol_usaged_type }}</p>
                                 </div>

                                 <div class="col-md-4 mb-3 radioAlcoholUsagedFields">
                                     <label for="inputDrugFrequency" class="form-label">Drug/Alcohol Frequency</label>
                                     <p class="form">{{ $formData->alcohol_usaged_frequency }}</p>
                                 </div>

                             </div>

                             <div class="form-row row">
                                 <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Is there a family history of drug or alcohol usage?</label>
                                         {{ $formData->family_alcohol_usaged }}
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3 radioFamilyAlcoholUsagedFields">
                                     <label for="inputRelationshipAlcoholType" class="form-label">Relationship</label>
                                     <p class="form">{{ $formData->family_alcohol_usaged_relationship }}</p>
                                 </div>

                                 <div class="col-md-4 mb-3 radioFamilyAlcoholUsagedFields">
                                     <label for="inputDescribeAlcoholType" class="form-label">Describe</label>
                                     <p class="form">{{ $formData->family_alcohol_usaged_describe }}</p>
                                 </div>
                             </div>

                                 
                                <div class="form-row row">
                                 <div class="col-md-3 mb-3">
                                     <div class="form-group">
                                         <label>Are you currently taking any prescription medications? Over the counter medications?</label>
                                         {{ $formData->prescription_medications }}
                                     </div>
                                 </div>

                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields">
                                    <label for="inputMedication" class="form-label">Medication:</label>
                                    <p class="form">{{ $formData->prescription_medications_name }}</p>
                                </div>
                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields">
                                    <label for="inputDosage" class="form-label">Dosage:</label>
                                    <p class="form">{{ $formData->prescription_medications_dosage }}</p>
                                </div>
                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields">
                                    <label for="inputPrescribingDoctor" class="form-label">Prescribing Doctor:</label>
                                    <p class="form">{{ $formData->prescription_medications_doctor }}</p>
                                </div>

                                <div class="col-md-12 mb-3 dflex">
                                   <label for="inputHeadInjury" class="form-label">Have you ever suffered a head injury? (Car accidents, sports, violence, etc.)</label>
                                   <p class="form">{{ $formData->head_injury }}</p>
                                </div>

                                <div class="col-md-12 mb-3 dflex">
                                   <label for="inputConsciousnessHallucinations" class="form-label">Have you ever experienced any unusual states of consciousness like hallucinations, loss of time, long periods of confusion, out of body, etc.?</label>
                                   <p class="form">{{ $formData->consciousness_hallucinations }}</p>
                                </div>

                            </div>
                            <!-- MedicalHistory END -->

                            <!-- Symptom History Started -->
                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Symptom History:</h3>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-12 mb-3 dflex">
                                   <label for="textareaSymptomProblems" class="form-label">What symptoms/problems are you hoping to improve?</label>
                                   <p class="form">{{ $formData->symptom_problems }}</p>
                                </div>
                                <div class="col-md-12 mb-3 dflex">
                                   <label for="textareaSymptomProblems" class="form-label">When did these symptoms/problems first become noticeable?</label>
                                   <p class="form">{{ $formData->symptom_noticeable }}</p>
                                </div>
                                <div class="col-md-12 mb-3 dflex">
                                   <label for="textareaSymptomProblems" class="form-label">What have been the major negative consequences of these symptoms/problems?</label>
                                   <p class="form">{{ $formData->symptom_negative }}</p>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Please list your three primary goals for therapy:</h3>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-12 mb-3">
                                    <ol style="list-style: auto; margin-left: 15px;">
                                        <li>{{ $formData->primary_goal_one }}</li>
                                        <li>{{ $formData->primary_goal_two }}</li>
                                        <li>{{ $formData->primary_goal_three }}</li>
                                    </ol>
                                </div>
                                

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                       <label class="form-label">Select a Service:</label>
                                       <label class="form">{{ $formData->appoinment_type }}</label>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                       <label>Appoinment Date:</label>
                                      <label class="form">{{ $formData->appoinment_date }}</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group col-md-6">
                                      <label for="time">Appoinment Time:</label>
                                      <label class="form">{{ $formData->appoinment_time }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
    
    $(document).ready(function() {
        // previous marriage section;
        $('input[name="previous_marriages"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.PreviousMarriageFields').removeClass('hidden');
            } else {
                $('.PreviousMarriageFields').addClass('hidden');
            }
        });

        // abusive relationship section;
        $('input[name="abusive_relationship"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.relationshipAbuseFeilds').removeClass('hidden').alert("abusive_relationship");
            } else {
                $('.relationshipAbuseFeilds').addClass('hidden');
            }
        });

        $('input[name="abusive_relationship"]').on('change', function() {
            if ($(this).val() === 'no') {
                $('.relationshipAbuseNoFeilds').addClass('hidden hide');
            } else {
                $('.relationshipAbuseNoFeilds').removeClass('hidden hide');
            }
        });

        // occur Offer section;
        $('input[name="abusive_relationship_occur"]').on('change', function() {
            if ($(this).val() === 'Other') {
                $('.OccurOthersFields').removeClass('hidden hide');
            } else {
                $('.OccurOthersFields').addClass('hidden hide');
            }
        });
        
         // relationshipsAbusive section;
        $('input[name="past_relationships_abusive"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.relationshipsAbusiveFields').removeClass('hidden');
            } else {
                $('.relationshipsAbusiveFields').addClass('hidden');
            }
        });

        // SexuallyViolatedAssaulted section;
        $('input[name="sexually_violated_assaulted"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.SexuallyViolatedAssaultedFields').removeClass('hidden');
            } else {
                $('.SexuallyViolatedAssaultedFields').addClass('hidden');
            }
        });

        // CustomAdultRaped section;
        $('input[name="sexually_assaulted_raped"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.CustomAdultRapedFields').removeClass('hidden');
            } else {
                $('.CustomAdultRapedFields').addClass('hidden');
            }
        });

        // ReceivingTherapyFields section;
        $('input[name="receiving_therapy_any_one"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.ReceivingTherapyFields').removeClass('hidden');
            } else {
                $('.ReceivingTherapyFields').addClass('hidden');
            }
        });
        
        // CounselingServices section;
        $('input[name="counseling_services"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.CounselingServicesFields').removeClass('hidden');
            } else {
                $('.CounselingServicesFields').addClass('hidden');
            }
        });

        // radioChildBirth section;
        $('input[name="hospitalized_child_birth"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioChildBirthFields').removeClass('hidden');
            } else {
                $('.radioChildBirthFields').addClass('hidden');
            }
        });
        
        // radioAlcoholUsaged section;
        $('input[name="alcohol_usaged"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioAlcoholUsagedFields').removeClass('hidden');
            } else {
                $('.radioAlcoholUsagedFields').addClass('hidden');
            }
        });
        
        // radioFamilyAlcoholUsaged section;
        $('input[name="family_alcohol_usaged"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioFamilyAlcoholUsagedFields').removeClass('hidden');
            } else {
                $('.radioFamilyAlcoholUsagedFields').addClass('hidden');
            }
        });
        
        // radioPrescriptionMedications section;
        $('input[name="prescription_medications"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioPrescriptionMedicationsFields').removeClass('hidden');
            } else {
                $('.radioPrescriptionMedicationsFields').addClass('hidden');
            }
        });

        $(document).on('change', '.hasDatepicker', function() {
            var dateString = $('#datepicker').val();
            console.log(dateString);
            var date = new Date(dateString);
            var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var day = daysOfWeek[date.getDay()];
            console.log(day);
            // Get CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var selectedValue = $('#theropyServices').val();
            // console.log('Selected value:', selectedValue);

            $.ajax({
                url: '{{ route('services.getServiceDayTimings') }}', // Laravel route
                type: 'POST',
                data: {
                    _token: csrfToken, // CSRF token for Laravel
                    service_day : day,
                    service_type : selectedValue,
                    service_id : 1
                },
                success: function(response) {
                    // console.log("Response from server:", response);
                    $('#serviceTimingFetch').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });

        $('#theropyServices').change(function() {
            var selectedValue = $(this).val();
            $('#selectDate').html('<input type="text" id="datepicker" name="appoinment_date">');
            $('#serviceTimingFetch').html('');
            // Get CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ route('services.getServiceDays') }}', // Laravel route
                type: 'POST',
                data: {
                    _token: csrfToken, // CSRF token for Laravel
                    service_type: selectedValue,
                    service_id : 1
                },
                success: function(response) {
                    console.log("Response from server:", response);
                    var daysString = '';
                    daysString = JSON.stringify(response);
                    var today = new Date();
                    var threeMonthsLater = new Date();
                    threeMonthsLater.setMonth(today.getMonth() + 3);

                    var disabledDays = null;
                    var disabledDays = JSON.parse(daysString); //['tuesday', 'monday']; // Your dynamic days array
                    
                    var dayMap = {
                        'sunday': 0,
                        'monday': 1,
                        'tuesday': 2,
                        'wednesday': 3,
                        'thursday': 4,
                        'friday': 5,
                        'saturday': 6
                    };
                    // Convert the day names to numerical values
                    var disabledDaysNumbers = disabledDays.map(day => dayMap[day.toLowerCase()]);
                    $("#datepicker").datepicker({
                        dateFormat: 'yy-mm-dd',
                        minDate: today,
                        maxDate: threeMonthsLater,
                        beforeShowDay: function(date) {
                            var day = date.getDay();
                            return [disabledDaysNumbers.includes(day), ''];
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });

    });

       // Below code sets format to the 
       // datetimepicker having id as 
       // datetime
       $('#datetime').datetimepicker({
           format: 'hh:mm:ss a'
       });
   </script>
    <!-- Include Bootstrap DateTimePicker CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/richtext.min.css') }}">
    <script src="{{ asset('assets/js/jquery.richtext.js') }}"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    
    <script>
        $(document).ready(function() {
            $('.contentArea').richText({
                // text formatting
                bold: true,
                italic: true,
                underline: true,

                // text alignment
                leftAlign: true,
                centerAlign: true,
                rightAlign: true,
                justify: true,

                // lists
                ol: true,
                ul: true,

                // title
                heading: true,

                // link
                urls: true,

                // tables
                table: true,

                // code
                removeStyles: true,
                code: true,

                // colors
                colors: [],

                // dropdowns
                fileHTML: '',
                imageHTML: '',

                // privacy
                youtubeCookies: false,

                // preview
                preview: false,

                // placeholder
                placeholder: '',

                // dev settings
                useSingleQuotes: false,
                height: 0,
                heightPercentage: 0,
                id: "",
                class: "",
                useParagraph: false,
                maxlength: 0,
                useTabForNext: false,

                // callback function after init
                callback: undefined,
            });

        });


        var imageUploadClass;

        $('.dropzone').on('click',function(e) {
            console.log('On Click - '+$(this).data('test'));
            imageUploadClass = $(this).data('test');
        });

        Dropzone.options.dropzone =
        {
            url: '{{url('dashboard/image/upload/store')}}',
            maxFilesize: 25,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + '_' + file.name;
            },
            acceptedFiles: "image/*",
            addRemoveLinks: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            timeout: 50000,
            removedfile: function (file) {
                console.log(file._removeLink.className);
                console.log($(this).data('test'));
                var imageUploadClass = $(this).closest('#dropzone').data('test');

                console.log(imageUploadClass);
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '{{ url("dashboard/image/delete") }}',
                    data: {filename: name},
                    success: function (data) {
                        console.log(imageUploadClass);
                        var newArr = [];
                        if ($('#'+imageUploadClass).val().length != 0){
                            newArr = $('#'+imageUploadClass).val().split(',');
                            console.log('Remove Item');
                            console.log(newArr);
                        }
                        console.log("File has been successfully removed!!");
                        var removeItem = data;
                        newArr = jQuery.grep(newArr, function (va) {
                            return va != removeItem;
                        });
                        $('#'+imageUploadClass).val(newArr);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, response) {
                console.log(imageUploadClass);
                var newArr = [];
                if ($('#'+imageUploadClass).val().length != 0){
                    newArr = $('#'+imageUploadClass).val().split(',');
                    console.log(newArr);
                }
                console.log(newArr);
                $.each(response, function (key, value) {
                    console.log(value);
                    newArr.push(value);
                });
                console.log(newArr);
                $('#'+imageUploadClass).val(newArr);
            },
            error: function (file, response) {
                return false;
            }
        };
    </script>
@endsection