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
                            {!! Form::model($service, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)

                            <div class="form-row row">
                               <div class="col-md-4 mb-3">
                                  <label class="form-label" for="validationCustom01">First name</label>
                                  <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="" required="">
                                  <div class="valid-feedback">
                                     Looks good!
                                  </div>
                               </div>
                               <div class="col-md-4 mb-3">
                                  <label class="form-label" for="validationCustom02">Last name</label>
                                  <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" required="">
                                  <div class="valid-feedback">
                                     Looks good!
                                  </div>
                               </div>
                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Email</label>
                                  <input type="email" class="form-control" placeholder="Email">
                               </div>
                               
                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Contact Number</label>
                                  <input type="text" class="form-control" placeholder="Phone Number" onkeypress="return isNumber(event)">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label class="form-label">DOB</label>
                                  <input type="date" class="form-control">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label class="form-label">Age</label>
                                  <input type="text" class="form-control" placeholder="Age" onkeypress="return isNumber(event)">
                               </div>

                               <div class="col-md-4 mb-3">
                                   <div class="form-group">
                                       <label>Is it OK to leave a message at this number?</label>
                                       <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                           <label class="form-check-label" for="flexRadioDefault1"> Yes </label>
                                       </div>
                                       <div class="form-check form-check-inline">
                                           <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="">
                                           <label class="form-check-label" for="flexRadioDefault2"> No </label>
                                       </div>
                                   </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                   <div class="form-group">
                                       <label>Is it OK to send you an email?</label>
                                       <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="emailSend" id="emailSendYes">
                                           <label class="form-check-label" for="emailSendYes"> Yes </label>
                                       </div>
                                       <div class="form-check form-check-inline">
                                           <input class="form-check-input" type="radio" name="emailSend" id="emailSendNo" checked="">
                                           <label class="form-check-label" for="emailSendNo"> No </label>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="form-row row">

                               <div class="col-md-4 mb-3">
                                  <label for="inputAddress" class="form-label">Address</label>
                                  <input type="text" class="form-control" id="inputAddress">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="inputAddress2" class="form-label">Address 2</label>
                                  <input type="text" class="form-control" id="inputAddress2">
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="inputCountry" class="form-label">Country</label>
                                  <select id="inputCountry" class="form-select">
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cabo Verde">Cabo Verde</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos Islands">Cocos Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curaçao">Curaçao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czechia">Czechia</option>
                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Eswatini">Eswatini</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands">Falkland Islands</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                    <option value="Holy See">Holy See</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="North Macedonia">North Macedonia</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestine, State of">Palestine, State of</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Réunion">Réunion</option>
                                    <option value="Saint Barthélemy">Saint Barthélemy</option>
                                    <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Martin">Saint Martin</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Sint Maarten">Sint Maarten</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria Arab Republic">Syria Arab Republic</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania, the United Republic of">Tanzania, the United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Türkiye">Türkiye</option>
                                    <option value="US Minor Outlying Islands">US Minor Outlying Islands</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States" selected="selected">United States</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                    <option value="Åland Islands">Åland Islands</option>
                                  </select>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="inputState" class="form-label">State</label>
                                  <select id="inputState" class="form-select">
                                     <option selected="">Choose...</option>
                                     <option>...</option>
                                  </select>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="inputCity" class="form-label">City</label>
                                  <input type="text" class="form-control" id="inputCity">
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="inputZip" class="form-label">Zip</label>
                                  <input type="text" class="form-control" id="inputZip" onkeypress="return isNumber(event)">
                               </div>

                                <div class="col-md-4 mb-3">
                                  <label for="inputEmployer" class="form-label">Employer</label>
                                  <input type="text" class="form-control" id="inputEmployer">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="inputSchool" class="form-label">School</label>
                                  <input type="text" class="form-control" id="inputSchool">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label>Sex/Gender</label>
                                     <div class="form-check"> <input class="form-check-input" type="radio" name="radioSex/Gender" id="Male">
                                        <label class="form-check-label" for="Male">Male</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioSex/Gender" id="Female" checked="">
                                        <label class="form-check-label" for="Female">Female</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioSex/Gender" id="TransgenderMale" checked="">
                                        <label class="form-check-label" for="TransgenderMale">Transgender Male</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioSex/Gender" id="TransgenderFemale" checked="">
                                        <label class="form-check-label" for="TransgenderFemale">Transgender Female</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioSex/Gender" id="Genderqueer" checked="">
                                        <label class="form-check-label" for="Genderqueer">Genderqueer</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioSex/Gender" id="Choosenottodisclose" checked="">
                                        <label class="form-check-label" for="Choosenottodisclose">Choose not to disclose</label>
                                     </div>
                                  </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label>Current relationship status (please “X” one)</label>
                                     <div class="form-check"> <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Single">
                                        <label class="form-check-label" for="Single">Single</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Married" checked="">
                                        <label class="form-check-label" for="Married">Married</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Partnered/CommittedRelationship" checked="">
                                        <label class="form-check-label" for="Partnered/CommittedRelationship">Partnered/Committed Relationship</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Separated" checked="">
                                        <label class="form-check-label" for="Separated">Separated</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Divorced" checked="">
                                        <label class="form-check-label" for="Divorced">Divorced</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Remarried" checked="">
                                        <label class="form-check-label" for="Remarried">Remarried</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioRelationshipStatus" id="Widowed" checked="">
                                        <label class="form-check-label" for="Widowed">Widowed</label>
                                     </div>
                                  </div>
                               </div>

                               <div class="col-md-4 mb-3">
                                  <div class="form-group">
                                     <label>Sexual Orientation</label>
                                     <div class="form-check "> <input class="form-check-input" type="radio" name="SexualOrientation" id="Straight/heterosexual">
                                        <label class="form-check-label" for="Straight/heterosexual">Straight/heterosexual</label>
                                     </div>
                                     <div class="form-check ">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Lesbian/homosexual" checked="">
                                        <label class="form-check-label" for="Lesbian/homosexual">Lesbian/homosexual</label>
                                     </div>
                                     <div class="form-check ">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Gay/Homosexual" checked="">
                                        <label class="form-check-label" for="Gay/Homosexual">Gay/Homosexual</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Bisexual" checked="">
                                        <label class="form-check-label" for="Bisexual">Bisexual</label>
                                     </div>
                                     <div class="form-check ">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Somethingelse" checked="">
                                        <label class="form-check-label" for="Somethingelse">Something else</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Don’tknow" checked="">
                                        <label class="form-check-label" for="Don’tknow">Don’t know</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="SexualOrientation" id="Choosenottodisclose" checked="">
                                        <label class="form-check-label" for="Choosenottodisclose">Choose not to disclose</label>
                                     </div>
                                  </div>
                               </div>

                               <div class="col-md-2 mb-3">
                                  <div class="form-group">
                                     <label>Pronouns</label>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Pronouns" id="PronounsHe/him" checked="">
                                        <label class="form-check-label" for="PronounsHe/him">He/him</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Pronouns" id="PronounsShe/her" checked="">
                                        <label class="form-check-label" for="PronounsShe/her">She/her</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Pronouns" id="PronounsThey/them" checked="">
                                        <label class="form-check-label" for="PronounsThey/them">They/them</label>
                                     </div>
                                     <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Pronouns" id="PronounsOther" checked="">
                                        <label class="form-check-label" for="PronounsOther">Other</label>
                                     </div>
                                  </div>
                               </div>

                               <div class="col-md-3 mb-3">
                                  <label for="NameofSignificant" class="form-label">Name of Significant other</label>
                                  <input type="text" class="form-control" id="NameofSignificant">
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="SignificantAge" class="form-label">Age</label>
                                  <input type="text" class="form-control" id="SignificantAge"  onkeypress="return isNumber(event)">
                               </div>

                               <div class="col-md-3 mb-3">
                                  <label for="SignificantOccupation" class="form-label">Occupation</label>
                                  <input type="text" class="form-control" id="SignificantOccupation">
                               </div>

                               <div class="col-md-2 mb-3">
                                  <label for="SignificantYearsMarried" class="form-label">Years Married</label>
                                  <input type="text" class="form-control" id="SignificantYearsMarried"  onkeypress="return isNumber(event)">
                               </div>

                               <div class="col-md-3 mb-3">
                                   <div class="form-group">
                                       <label>Previous marriages</label>
                                       <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="radioPreviousmarriages" value="yes" id="PreviousmarriagesYes">
                                           <label class="form-check-label" for="PreviousmarriagesYes"> Yes </label>
                                       </div>
                                       <div class="form-check form-check-inline">
                                           <input class="form-check-input" type="radio" name="radioPreviousmarriages" value="no" id="PreviousmarriagesNo" checked="">
                                           <label class="form-check-label" for="PreviousmarriagesNo"> No </label>
                                       </div>
                                   </div>
                               </div>
                                <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="yearsmarried" class="form-label"># of years married</label>
                                  <input type="text" class="form-control" id="yearsmarried"  onkeypress="return isNumber(event)">
                               </div>
                               <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="yearsdivorce" class="form-label">years of divorce</label>
                                  <input type="text" class="form-control" id="yearsdivorce"  onkeypress="return isNumber(event)">
                               </div>
                               <div class="col-md-3 mb-3 PreviousMarriageFields hidden">
                                  <label for="reasonfordivorce" class="form-label">reason for divorce</label>
                                  <input type="text" class="form-control" id="reasonfordivorce">
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
                                        <label>Sex/Gender</label>
                                        <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="radioHouseHoldGender" id="HouseHoldMale">
                                            <label class="form-check-label" for="HouseHoldMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioHouseHoldGender" id="HouseHoldFemale" checked="">
                                            <label class="form-check-label" for="HouseHoldFemale">Female</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                  <label for="HouseHoldAge" class="form-label">Age</label>
                                  <input type="text" class="form-control" id="HouseHoldAge"  onkeypress="return isNumber(event)">
                               </div>

                               <div class="col-md-4 mb-3">
                                  <label for="HouseHoldRelationship" class="form-label">Relationship</label>
                                  <input type="text" class="form-control" id="HouseHoldRelationship">
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
                                        <div class="form-check form-check-inline"> 
                                            <input class="form-check-input" type="radio" name="radioabusiveRelationship" id="abusiveRelationshipYes" value="yes">
                                            <label class="form-check-label" for="abusiveRelationshipYes"> Yes </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioabusiveRelationship" id="abusiveRelationshipNo" checked="" value="no">
                                            <label class="form-check-label" for="abusiveRelationshipNo"> No </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3 relationshipAbuseFeilds hidden">
                                    <div class="form-group">
                                        <label>If “Yes”, check the types of abuse that apply to this relationship</label>
                                        <div class="form-check"> 
                                            <input class="form-check-input" value="Emotional" type="radio" name="radioRelationshipApply" id="abusiveRelationshipEmotional">
                                            <label class="form-check-label" for="abusiveRelationshipEmotional">Emotional</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Sexual" type="radio" name="radioRelationshipApply" id="abusiveRelationshipSexual" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipSexual">Sexual</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Financial" type="radio" name="radioRelationshipApply" id="abusiveRelationshipFinancial" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipFinancial">Financial</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Spiritual" type="radio" name="radioRelationshipApply" id="abusiveRelationshipSpiritual" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipSpiritual">Spiritual</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Verbal" type="radio" name="radioRelationshipApply" id="abusiveRelationshipVerbal" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipVerbal">Verbal</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Physical" type="radio" name="radioRelationshipApply" id="abusiveRelationshipPhysical" checked="">
                                            <label class="form-check-label" for="abusiveRelationshipPhysical">Physical</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>How often does this occur?</label>
                                        <div class="form-check"> 
                                            <input class="form-check-input" value="Daily" type="radio" name="radioOccur" id="OccurDaily" checked="">
                                            <label class="form-check-label" for="OccurDaily">Daily</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Weekly" type="radio" name="radioOccur" id="OccurWeekly">
                                            <label class="form-check-label" for="OccurWeekly">Weekly</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="Other" type="radio" name="radioOccur" id="OccurOther" >
                                            <label class="form-check-label" for="OccurOther">Other</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3 OccurOthersFields hidden">
                                  <label for="OccurOthers" class="form-label">Others</label>
                                  <input type="text" name="OccurOthers" class="form-control" id="OccurOthers">
                               </div>
                            </div>

                            <!-- relationshipAbusiveCustom start -->
                            <div class="form-row row relationshipAbusiveCustom">
                                <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Have you had past relationships that were abusive?</label>
                                         <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="relationshipsAbusive" value="yes" id="relationshipsAbusiveYes">
                                             <label class="form-check-label" for="relationshipsAbusiveYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" value="no" type="radio" name="relationshipsAbusive" id="relationshipsAbusiveNo" checked="">
                                             <label class="form-check-label" for="relationshipsAbusiveNo">No</label>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-8 mb-3 relationshipsAbusiveFields hidden">
                                  <label for="Abusivedescribe" class="form-label">If “Yes”, please describe</label>
                                  <input type="text" class="form-control" id="Abusivedescribe">
                               </div>
                            </div>
                            <!-- relationshipAbusiveCustom end -->

                            <!-- sexually/violated/assaulted Start -->
                                <div class="form-row row CustomSexuallyViolatedAssaulted">
                                    <div class="col-md-3 mb-3">
                                         <div class="form-group">
                                             <label>Were you ever sexually violated/assaulted as a child (0-18 years)?</label>
                                             <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="SexuallyViolatedAssaulted" value="yes" id="SexuallyViolatedAssaultedYes">
                                                 <label class="form-check-label" for="SexuallyViolatedAssaultedYes">Yes</label>
                                             </div>
                                             <div class="form-check form-check-inline">
                                                 <input class="form-check-input" value="no" type="radio" name="SexuallyViolatedAssaulted" id="SexuallyViolatedAssaultedNo" checked="">
                                                 <label class="form-check-label" for="SexuallyViolatedAssaultedNo">No</label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 mb-3 SexuallyViolatedAssaultedFields hidden">
                                        <label for="SexuallyOldWere" class="form-label">If “Yes”, how old were you?</label>
                                        <input type="number" class="form-control" id="SexuallyOldWere">
                                     </div>
                                     <div class="col-md-3 mb-3 SexuallyViolatedAssaultedFields hidden">
                                        <label for="SexuallyBywhom" class="form-label">by whom?</label>
                                        <input type="text" class="form-control" id="SexuallyBywhom">
                                     </div>
                                     <div class="col-md-3 mb-3 SexuallyViolatedAssaultedFields hidden">
                                        <label for="SexuallyRelationship" class="form-label">Relationship</label>
                                        <input type="text" class="form-control" id="SexuallyRelationship">
                                     </div>
                                </div>
                            <!-- sexually/violated/assaulted End -->

                            <!-- CustomAdultRaped Start -->
                                <div class="form-row row">
                                    <div class="col-md-3 mb-3">
                                         <div class="form-group">
                                             <label>Have you ever been sexually assaulted or raped as an adult?</label>
                                             <div class="form-check form-check-inline"> 
                                                <input class="form-check-input" value="yes" type="radio" name="CustomAdultRaped" id="CustomAdultRapedYes">
                                                 <label class="form-check-label" for="CustomAdultRapedYes">Yes</label>
                                             </div>
                                             <div class="form-check form-check-inline">
                                                 <input class="form-check-input" value="no" type="radio" name="CustomAdultRaped" id="CustomAdultRapedNo" checked="">
                                                 <label class="form-check-label" for="CustomAdultRapedNo">No</label>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 mb-3 CustomAdultRapedFields hidden">
                                        <label for="RapeYesWhen" class="form-label">“Yes”, when?</label>
                                        <input type="number" class="form-control" id="RapeYesWhen">
                                     </div>
                                     <div class="col-md-3 mb-3 CustomAdultRapedFields hidden">
                                        <label for="RapeBywhom" class="form-label">by whom?</label>
                                        <input type="text" class="form-control" id="RapeBywhom">
                                     </div>
                                     <div class="col-md-3 mb-3 CustomAdultRapedFields hidden">
                                        <label for="RapeRelationship" class="form-label">Relationship</label>
                                        <input type="text" class="form-control" id="RapeRelationship">
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
                                         <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="CustomReceivingTherapy" id="CustomReceivingTherapyYes">
                                             <label class="form-check-label" for="CustomReceivingTherapyYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" type="radio" name="CustomReceivingTherapy" id="CustomReceivingTherapyNo" checked="">
                                             <label class="form-check-label" for="CustomReceivingTherapyNo">No</label>
                                         </div>
                                     </div>
                                 </div>
                            </div>

                            <!-- CustomCounselingServices Start -->
                            <div class="form-row row">
                                <div class="col-md-3 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever received any type of counseling services before today?</label>
                                         <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="CounselingServices" value="yes" id="CounselingServicesYes">
                                             <label class="form-check-label" for="CounselingServicesYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" value="no" type="radio" name="CounselingServices" id="CounselingServicesNo" checked="">
                                             <label class="form-check-label" for="CounselingServicesNo">No</label>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields hidden">
                                    <label for="CounselingServicesWhen" class="form-label">When?</label>
                                    <input type="text" class="form-control" id="CounselingServicesWhen">
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields hidden">
                                    <label for="CounselingServicesFromwhom" class="form-label">Form whom?</label>
                                    <input type="text" class="form-control" id="CounselingServicesFromwhom">
                                 </div>
                                 <div class="col-md-3 mb-3 CounselingServicesFields hidden">
                                    <label for="CounselingServicesForWhat" class="form-label">For what?</label>
                                    <input type="text" class="form-control" id="CounselingServicesForWhat">
                                 </div>
                            </div>
                            <!-- CustomCounselingServices END -->


                            <!-- MedicalHistory Start -->
                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Therapy History:</h3>
                                </div>
                                 <div class="col-md-12 mb-3">
                                   <label for="inputCurrentMedical" class="form-label">Do you have any current medical conditions (particularly seizures, diabetes, and sickle cell)?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="inputCurrentMedical" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                   <label for="inputMentalHealthDiagnoses" class="form-label">Please list any mental health diagnoses received from a mental health or medical professional</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="inputMentalHealthDiagnoses" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                   <label for="inputWhatTreatments" class="form-label">What treatments have you tried for these medical and mental health diagnoses?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="inputWhatTreatments" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>

                                <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever been hospitalized for medical reasons other than childbirth?</label>
                                         <div class="form-check form-check-inline"> 
                                            <input class="form-check-input" type="radio" value="yes" name="radioChildBirth" id="ChildBirthYes">
                                             <label class="form-check-label" for="ChildBirthYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" type="radio" value="no" name="radioChildBirth" id="ChildBirthNo" checked="">
                                             <label class="form-check-label" for="ChildBirthNo">No</label>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-8 mb-3 radioChildBirthFields hidden">
                                     <label for="inputWhatReasons" class="form-label">for what reasons?</label>
                                     <input type="text" class="form-control" name="inputWhatReasons" id="inputWhatReasons">
                                 </div>

                                 <div class="col-md-12 mb-3">
                                     <div class="form-group">
                                         <label>Have you ever been hospitalized for mental health reasons?</label>
                                         <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="radioHospitalized" id="HospitalizedYes">
                                             <label class="form-check-label" for="HospitalizedYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" type="radio" name="radioHospitalized" id="HospitalizedNo" checked="">
                                             <label class="form-check-label" for="HospitalizedNo">No</label>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Is there a history of drug or alcohol usage?</label>
                                         <div class="form-check form-check-inline"> 
                                            <input class="form-check-input" value="yes" type="radio" name="radioAlcoholUsaged" id="radioAlcoholUsagedYes">
                                             <label class="form-check-label" for="radioAlcoholUsagedYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" value="no" type="radio" name="radioAlcoholUsaged" id="radioAlcoholUsagedNo" checked="">
                                             <label class="form-check-label" for="radioAlcoholUsagedNo">No</label>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3 radioAlcoholUsagedFields hidden">
                                     <label for="inputDrugAlcoholType" class="form-label">Drug/Alcohol Type</label>
                                     <input type="text" class="form-control" name="inputDrugAlcoholType" id="inputDrugAlcoholType">
                                 </div>

                                 <div class="col-md-4 mb-3 radioAlcoholUsagedFields hidden">
                                     <label for="inputDrugFrequency" class="form-label">Drug/Alcohol Type</label>
                                     <input type="text" class="form-control" name="inputDrugFrequency" id="inputDrugFrequency">
                                 </div>

                             </div>

                             <div class="form-row row">
                                 <div class="col-md-4 mb-3">
                                     <div class="form-group">
                                         <label>Is there a family history of drug or alcohol usage?</label>
                                         <div class="form-check form-check-inline"> 
                                            <input class="form-check-input" value="yes" type="radio" name="radioFamilyAlcoholUsaged" id="radioFamilyAlcoholUsagedYes">
                                             <label class="form-check-label" for="radioFamilyAlcoholUsagedYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" value="no" type="radio" name="radioFamilyAlcoholUsaged" id="radioFamilyAlcoholUsagedNo" checked="">
                                             <label class="form-check-label" for="radioFamilyAlcoholUsagedNo">No</label>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-4 mb-3 radioFamilyAlcoholUsagedFields hidden">
                                     <label for="inputRelationshipAlcoholType" class="form-label">Relationship</label>
                                     <input type="text" class="form-control" name="inputRelationshipAlcoholType" id="inputRelationshipAlcoholType">
                                 </div>

                                 <div class="col-md-4 mb-3 radioFamilyAlcoholUsagedFields hidden">
                                     <label for="inputDescribeAlcoholType" class="form-label">Describe</label>
                                     <input type="text" class="form-control" name="inputDescribeAlcoholType" id="inputDescribeAlcoholType">
                                 </div>
                             </div>

                                 
                                <div class="form-row row">
                                 <div class="col-md-3 mb-3">
                                     <div class="form-group">
                                         <label>Are you currently taking any prescription medications? Over the counter medications?</label>
                                         <div class="form-check form-check-inline"> 
                                            <input class="form-check-input" value="yes" type="radio" name="radioPrescriptionMedications" id="radioPrescriptionMedicationsYes">
                                             <label class="form-check-label" for="radioPrescriptionMedicationsYes">Yes</label>
                                         </div>
                                         <div class="form-check form-check-inline">
                                             <input class="form-check-input" value="no" type="radio" name="radioPrescriptionMedications" id="radioPrescriptionMedicationsNo" checked="">
                                             <label class="form-check-label" for="radioPrescriptionMedicationsNo">No</label>
                                         </div>
                                     </div>
                                 </div>

                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields hidden">
                                    <label for="inputMedication" class="form-label">Medication</label>
                                    <input type="text" class="form-control" id="inputMedication">
                                </div>
                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields hidden">
                                    <label for="inputDosage" class="form-label">Dosage</label>
                                    <input type="text" class="form-control" id="inputDosage">
                                </div>
                                <div class="col-md-3 mb-3 radioPrescriptionMedicationsFields hidden">
                                    <label for="inputPrescribingDoctor" class="form-label">Prescribing Doctor</label>
                                    <input type="text" class="form-control" id="inputPrescribingDoctor">
                                </div>

                                <div class="col-md-12 mb-3">
                                   <label for="inputHeadInjury" class="form-label">Have you ever suffered a head injury? (Car accidents, sports, violence, etc.)</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="inputHeadInjury" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                   <label for="inputConsciousnessHallucinations" class="form-label">Have you ever experienced any unusual states of consciousness like hallucinations, loss of time, long periods of confusion, out of body, etc.?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="inputConsciousnessHallucinations" cols="50" rows="5" spellcheck="false"></textarea>
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
                                <div class="col-md-3 mb-3">
                                   <label class="form-label" for="inputSymptomName">Name</label>
                                   <input type="text" class="form-control" name="inputSymptomName" id="inputSymptomName" placeholder="Name" value="" required="">
                                </div>
                                <div class="col-md-3 mb-3">
                                   <label for="inputSymptomContact" class="form-label">Phone Number</label>
                                   <input type="text" name="inputSymptomContact" id="inputSymptomContact" class="form-control" placeholder="Phone Number"  onkeypress="return isNumber(event)">
                                </div>
                                <div class="col-md-3 mb-3">
                                   <label for="inputSymptomAddress" class="form-label">Physical Address</label>
                                   <input type="text" name="inputSymptomAddress" id="inputSymptomAddress" class="form-control" placeholder="Physical Address">
                                </div>
                                <div class="col-md-3 mb-3">
                                   <label for="inputSymptomEmail" class="form-label">Email</label>
                                   <input type="email" name="inputSymptomEmail" id="inputSymptomEmail" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-md-12 mb-3">
                                   <label for="textareaSymptomProblems" class="form-label">What symptoms/problems are you hoping to improve?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="textareaSymptomProblems" id="textareaSymptomProblems" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                   <label for="textareaSymptomProblems" class="form-label">When did these symptoms/problems first become noticeable?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="textareaSymptomNoticeable" id="textareaSymptomNoticeable" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                   <label for="textareaSymptomProblems" class="form-label">What have been the major negative consequences of these symptoms/problems?</label>
                                   <textarea class="form-control" placeholder="Please Describe" required="required" name="textareaSymptomNegative" id="textareaSymptomNegative" cols="50" rows="5" spellcheck="false"></textarea>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-12">
                                    <h3 class="mb-3">Please list your three primary goals for therapy.</h3>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">1</span>
                                        <input type="text" class="form-control" name="inputThreePrimaryGoals1" id="inputThreePrimaryGoals1" placeholder="" value="" required="">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">2</span>
                                        <input type="text" class="form-control" name="inputThreePrimaryGoals2" id="inputThreePrimaryGoals2" placeholder="" value="" required="">
                                    </div>                                   
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">3</span>
                                        <input type="text" class="form-control" name="inputThreePrimaryGoals3" id="inputThreePrimaryGoals3" placeholder="" value="" required="">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 mb-3">
                                    <div class="custom-file-container" data-upload-id="mySecondImage">
                                       <label>Upload (Allow Multiple) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                       <label class="custom-file-container__custom-file">
                                       <input type="file" class="custom-file-container__custom-file__custom-file-input" multiple="">
                                       <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                       <span class="custom-file-container__custom-file__custom-file-control">Choose file...<span class="custom-file-container__custom-file__custom-file-control__button"> Browse </span></span>
                                       </label>
                                    </div>
                                </div> --}}
                                <div class="col-md-12 mb-3">
                                    <div class="form-control-wrap">
                                        <label for="dropzone" class="form-label">Upload Files</label>
                                        <div class="custom-file">
                                            <div class="dropzone" data-test="start_job_upload_photos" id="dropzone"></div>
                                            <div class="form-note">Max. file size: 15 GB, Max. files: 5.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                       <label>Select Date</label>
                                       <input class="form-control" placeholder="Enter Title" required="required" name="title" type="date">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group col-md-6">
                                      <label for="time">Time</label>
                                      <input class="form-control" type="text" id="datetime">
                                    </div>
                                </div>
                                


                            </div>
                            <!-- Symptom History Started -->




                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Date</label>
                                            {!! Form::date('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Input</label>
                                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rich Tech Editor</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control contentArea', 'placeholder' => 'Enter Description', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Text Area</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thumbnail</label>
                                            {!! Form::file('thumbnail_file', null, ['class' => 'form-control', 'required' => 'required', 'multiple']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($section->method == 'PUT')
                                            <img src="{{ $service->thumbnail }}" alt="" class="avatar avatar-xl rounded"  />
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select DropDown</label>
                                            {!! Form::select('status', array(1 => 'Active', 0 => 'Block'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Radio Button</label>
                                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1"> Default radio </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="">
                                                <label class="form-check-label" for="flexRadioDefault2"> Default checked radio </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Checkbox</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
                                                <label class="form-check-label" for="flexCheckChecked"> Checked checkbox </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            {!! Form::close() !!}
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
        $('input[name="radioPreviousmarriages"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.PreviousMarriageFields').removeClass('hidden');
            } else {
                $('.PreviousMarriageFields').addClass('hidden');
            }
        });

        // abusive relationship section;
        $('input[name="radioabusiveRelationship"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.relationshipAbuseFeilds').removeClass('hidden');
            } else {
                $('.relationshipAbuseFeilds').addClass('hidden');
            }
        });

        // occur Offer section;
        $('input[name="radioOccur"]').on('change', function() {
            if ($(this).val() === 'Other') {
                $('.OccurOthersFields').removeClass('hidden');
            } else {
                $('.OccurOthersFields').addClass('hidden');
            }
        });
        
         // relationshipsAbusive section;
        $('input[name="relationshipsAbusive"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.relationshipsAbusiveFields').removeClass('hidden');
            } else {
                $('.relationshipsAbusiveFields').addClass('hidden');
            }
        });

        // SexuallyViolatedAssaulted section;
        $('input[name="SexuallyViolatedAssaulted"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.SexuallyViolatedAssaultedFields').removeClass('hidden');
            } else {
                $('.SexuallyViolatedAssaultedFields').addClass('hidden');
            }
        });

        // CustomAdultRaped section;
        $('input[name="CustomAdultRaped"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.CustomAdultRapedFields').removeClass('hidden');
            } else {
                $('.CustomAdultRapedFields').addClass('hidden');
            }
        });
        
        // CounselingServices section;
        $('input[name="CounselingServices"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.CounselingServicesFields').removeClass('hidden');
            } else {
                $('.CounselingServicesFields').addClass('hidden');
            }
        });

        // radioChildBirth section;
        $('input[name="radioChildBirth"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioChildBirthFields').removeClass('hidden');
            } else {
                $('.radioChildBirthFields').addClass('hidden');
            }
        });
        
        // radioAlcoholUsaged section;
        $('input[name="radioAlcoholUsaged"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioAlcoholUsagedFields').removeClass('hidden');
            } else {
                $('.radioAlcoholUsagedFields').addClass('hidden');
            }
        });
        
        // radioFamilyAlcoholUsaged section;
        $('input[name="radioFamilyAlcoholUsaged"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioFamilyAlcoholUsagedFields').removeClass('hidden');
            } else {
                $('.radioFamilyAlcoholUsagedFields').addClass('hidden');
            }
        });
        
        // radioPrescriptionMedications section;
        $('input[name="radioPrescriptionMedications"]').on('change', function() {
            if ($(this).val() === 'yes') {
                $('.radioPrescriptionMedicationsFields').removeClass('hidden');
            } else {
                $('.radioPrescriptionMedicationsFields').addClass('hidden');
            }
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
    </script>
@endsection