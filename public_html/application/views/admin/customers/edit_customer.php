<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper" class="customer_profile" style="min-height: 1314.4px;">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> </div>
      
        <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
        </div>
      
      <div class="testing col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div>
              <div class="tab-content">
                <h4 class="customer-profile-group-heading">Edit Customer</h4>
                <div class="row">
                  <form action="https://crm.dryvarfoods.com/admin/general_customers/edit_customers" class="client-form" autocomplete="off" method="post" accept-charset="utf-8" novalidate="novalidate">
                    
                    <div class="col-md-12">
                      
                      <div class="tab-content mtop15">
                      
                       <?php
                    if ($this->session->flashdata('err_message')) {
                    ?>
                      <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                    } //end if($this->session->flashdata('err_message'))

                    if ($this->session->flashdata('ok_message')) {
                    ?>
                      <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php
                    } //if($this->session->flashdata('ok_message'))
                    ?>
                        
                        <div role="tabpanel" class="tab-pane active" id="contact_info">
                          <div class="row">
                            <div class="col-md-12 mtop15  hide" id="client-show-primary-contact-wrapper">
                              <div class="checkbox checkbox-info mbot20 no-mtop">
                                <input type="checkbox" name="show_primary_contact" value="1" id="show_primary_contact">
                                <label for="show_primary_contact">Show primary contact full name on Invoices, Estimates, Payments, Credit Notes</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group" app-field-wrapper="company">
                                <label for="first_name" class="control-label"> <small class="req text-danger">* </small>First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" autofocus="1" value="<?php echo $arr_general_customers['firstname']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="dryvarfoods_id">
                                <label for="last_name" class="control-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" autofocus="1" value="<?php echo $arr_general_customers['lastname']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="commission">
                                <label for="email" class="control-label">Email Address </label>
                                <input type="text" id="email" name="email" class="form-control" autofocus="1" value="<?php echo $arr_general_customers['email']?>">
                              </div>
                              <div id="company_exists_info" class="hide"></div>
                              
                              <div class="form-group" app-field-wrapper="phonenumber">
                                <label for="phonenumber" class="control-label">Phone</label>
                                <input type="text" id="phonenumber" name="phonenumber" class="form-control" value="<?php echo $arr_general_customers['phonenumber']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="website">
                                <label for="website" class="control-label">Company</label>
                                <input type="text" id="company" name="company" class="form-control" value="<?php echo $arr_general_customers['company']?>">
                              </div>
                              
                              <input type="hidden" name="custoemr_id" id="custoemr_id" value="<?php echo $arr_general_customers['id']?>" />
                              
                              <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="If the customer use other currency then the base currency make sure you select the appropriate currency for this customer. Changing the currency is not possible after transactions are recorded."></i>
                              <div class="form-group" app-field-wrapper="default_currency">
                                <label for="default_currency" class="control-label">Currency</label>
                                <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                  <select id="default_currency" name="default_currency" class="selectpicker" data-none-selected-text="System Default" data-width="100%" data-live-search="true" tabindex="-98">
                                    <option value=""></option>
                                    <option value="1" data-subtext="R">ZAR</option>
                                  </select>
                                  <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" data-id="default_currency" title="System Default">
                                  <div class="filter-option">
                                    <div class="filter-option-inner">
                                      <div class="filter-option-inner-inner">System Default</div>
                                    </div>
                                  </div>
                                  <span class="bs-caret"><span class="caret"></span></span></button>
                                  <div class="dropdown-menu open">
                                    <div class="bs-searchbox">
                                      <input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-3" aria-autocomplete="list">
                                    </div>
                                    <div class="inner open" role="listbox" id="bs-select-3" tabindex="-1">
                                      <ul class="dropdown-menu inner " role="presentation">
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!--<div class="form-group">
                                <label for="default_language" class="control-label">Default Language </label>
                                <div class="dropdown bootstrap-select form-control bs3">
                                  <select name="default_language" id="default_language" class="form-control selectpicker" data-none-selected-text="Non selected" tabindex="-98">
                                    <option value="">System Default</option>
                                    <option value="ukrainian">Ukrainian</option>
                                    <option value="russian">Russian</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="romanian">Romanian</option>
                                    <option value="turkish">Turkish</option>
                                    <option value="bulgarian">Bulgarian</option>
                                    <option value="greek">Greek</option>
                                    <option value="vietnamese">Vietnamese</option>
                                    <option value="indonesia">Indonesia</option>
                                    <option value="italian">Italian</option>
                                    <option value="english">English</option>
                                    <option value="czech">Czech</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="polish">Polish</option>
                                    <option value="dutch">Dutch</option>
                                    <option value="catalan">Catalan</option>
                                    <option value="slovak">Slovak</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="portuguese">Portuguese</option>
                                    <option value="persian">Persian</option>
                                    <option value="swedish">Swedish</option>
                                    <option value="portuguese_br">Portuguese_br</option>
                                    <option value="german">German</option>
                                    <option value="french">French</option>
                                  </select>
                                  <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="combobox" aria-owns="bs-select-4" aria-haspopup="listbox" aria-expanded="false" data-id="default_language" title="System Default">
                                  <div class="filter-option">
                                    <div class="filter-option-inner">
                                      <div class="filter-option-inner-inner">System Default</div>
                                    </div>
                                  </div>
                                  <span class="bs-caret"><span class="caret"></span></span></button>
                                  <div class="dropdown-menu open">
                                    <div class="inner open" role="listbox" id="bs-select-4" tabindex="-1">
                                      <ul class="dropdown-menu inner " role="presentation">
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>-->
                            </div>
                            <div class="col-md-6">
                              <div class="form-group" app-field-wrapper="address">
                                <label for="address" class="control-label">Address</label>
                                <textarea id="address" name="address" class="form-control" rows="4"><?php echo $arr_general_customers['address']?></textarea>
                              </div>
                              <div class="form-group" app-field-wrapper="city">
                                <label for="city" class="control-label">City</label>
                                <input type="text" id="city" name="city" class="form-control" value="<?php echo $arr_general_customers['city']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="state">
                                <label for="state" class="control-label">State</label>
                                <input type="text" id="state" name="state" class="form-control" value="<?php echo $arr_general_customers['state']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="zip">
                                <label for="zip" class="control-label">Zip Code</label>
                                <input type="text" id="zip" name="zip" class="form-control" value="<?php echo $arr_general_customers['zip']?>">
                              </div>
                              <div class="form-group" app-field-wrapper="country">
                                <label for="country" class="control-label">Country</label>
                                <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                  <select id="country" name="country" class="form-control"  data-width="100%" tabindex="-98">
                                    <option value=""></option>
                                    <option value="1">Afghanistan</option>
                                    <option value="2">Aland Islands</option>
                                    <option value="3">Albania</option>
                                    <option value="4">Algeria</option>
                                    <option value="5">American Samoa</option>
                                    <option value="6">Andorra</option>
                                    <option value="7">Angola</option>
                                    <option value="8">Anguilla</option>
                                    <option value="9">Antarctica</option>
                                    <option value="10">Antigua and Barbuda</option>
                                    <option value="11">Argentina</option>
                                    <option value="12">Armenia</option>
                                    <option value="13">Aruba</option>
                                    <option value="14">Australia</option>
                                    <option value="15">Austria</option>
                                    <option value="16">Azerbaijan</option>
                                    <option value="17">Bahamas</option>
                                    <option value="18">Bahrain</option>
                                    <option value="19">Bangladesh</option>
                                    <option value="20">Barbados</option>
                                    <option value="21">Belarus</option>
                                    <option value="22">Belgium</option>
                                    <option value="23">Belize</option>
                                    <option value="24">Benin</option>
                                    <option value="25">Bermuda</option>
                                    <option value="26">Bhutan</option>
                                    <option value="27">Bolivia</option>
                                    <option value="28">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="29">Bosnia and Herzegovina</option>
                                    <option value="30">Botswana</option>
                                    <option value="31">Bouvet Island</option>
                                    <option value="32">Brazil</option>
                                    <option value="33">British Indian Ocean Territory</option>
                                    <option value="34">Brunei</option>
                                    <option value="35">Bulgaria</option>
                                    <option value="36">Burkina Faso</option>
                                    <option value="37">Burundi</option>
                                    <option value="38">Cambodia</option>
                                    <option value="39">Cameroon</option>
                                    <option value="40">Canada</option>
                                    <option value="41">Cape Verde</option>
                                    <option value="42">Cayman Islands</option>
                                    <option value="43">Central African Republic</option>
                                    <option value="44">Chad</option>
                                    <option value="45">Chile</option>
                                    <option value="46">China</option>
                                    <option value="47">Christmas Island</option>
                                    <option value="48">Cocos (Keeling) Islands</option>
                                    <option value="49">Colombia</option>
                                    <option value="50">Comoros</option>
                                    <option value="51">Congo</option>
                                    <option value="52">Cook Islands</option>
                                    <option value="53">Costa Rica</option>
                                    <option value="54">Cote d'ivoire (Ivory Coast)</option>
                                    <option value="55">Croatia</option>
                                    <option value="56">Cuba</option>
                                    <option value="57">Curacao</option>
                                    <option value="58">Cyprus</option>
                                    <option value="59">Czech Republic</option>
                                    <option value="60">Democratic Republic of the Congo</option>
                                    <option value="61">Denmark</option>
                                    <option value="62">Djibouti</option>
                                    <option value="63">Dominica</option>
                                    <option value="64">Dominican Republic</option>
                                    <option value="65">Ecuador</option>
                                    <option value="66">Egypt</option>
                                    <option value="67">El Salvador</option>
                                    <option value="68">Equatorial Guinea</option>
                                    <option value="69">Eritrea</option>
                                    <option value="70">Estonia</option>
                                    <option value="71">Ethiopia</option>
                                    <option value="72">Falkland Islands (Malvinas)</option>
                                    <option value="73">Faroe Islands</option>
                                    <option value="74">Fiji</option>
                                    <option value="75">Finland</option>
                                    <option value="76">France</option>
                                    <option value="77">French Guiana</option>
                                    <option value="78">French Polynesia</option>
                                    <option value="79">French Southern Territories</option>
                                    <option value="80">Gabon</option>
                                    <option value="81">Gambia</option>
                                    <option value="82">Georgia</option>
                                    <option value="83">Germany</option>
                                    <option value="84">Ghana</option>
                                    <option value="85">Gibraltar</option>
                                    <option value="86">Greece</option>
                                    <option value="87">Greenland</option>
                                    <option value="88">Grenada</option>
                                    <option value="89">Guadaloupe</option>
                                    <option value="90">Guam</option>
                                    <option value="91">Guatemala</option>
                                    <option value="92">Guernsey</option>
                                    <option value="93">Guinea</option>
                                    <option value="94">Guinea-Bissau</option>
                                    <option value="95">Guyana</option>
                                    <option value="96">Haiti</option>
                                    <option value="97">Heard Island and McDonald Islands</option>
                                    <option value="98">Honduras</option>
                                    <option value="99">Hong Kong</option>
                                    <option value="100">Hungary</option>
                                    <option value="101">Iceland</option>
                                    <option value="102">India</option>
                                    <option value="103">Indonesia</option>
                                    <option value="104">Iran</option>
                                    <option value="105">Iraq</option>
                                    <option value="106">Ireland</option>
                                    <option value="107">Isle of Man</option>
                                    <option value="108">Israel</option>
                                    <option value="109">Italy</option>
                                    <option value="110">Jamaica</option>
                                    <option value="111">Japan</option>
                                    <option value="112">Jersey</option>
                                    <option value="113">Jordan</option>
                                    <option value="114">Kazakhstan</option>
                                    <option value="115">Kenya</option>
                                    <option value="116">Kiribati</option>
                                    <option value="117">Kosovo</option>
                                    <option value="118">Kuwait</option>
                                    <option value="119">Kyrgyzstan</option>
                                    <option value="120">Laos</option>
                                    <option value="121">Latvia</option>
                                    <option value="122">Lebanon</option>
                                    <option value="123">Lesotho</option>
                                    <option value="124">Liberia</option>
                                    <option value="125">Libya</option>
                                    <option value="126">Liechtenstein</option>
                                    <option value="127">Lithuania</option>
                                    <option value="128">Luxembourg</option>
                                    <option value="129">Macao</option>
                                    <option value="131">Madagascar</option>
                                    <option value="132">Malawi</option>
                                    <option value="133">Malaysia</option>
                                    <option value="134">Maldives</option>
                                    <option value="135">Mali</option>
                                    <option value="136">Malta</option>
                                    <option value="137">Marshall Islands</option>
                                    <option value="138">Martinique</option>
                                    <option value="139">Mauritania</option>
                                    <option value="140">Mauritius</option>
                                    <option value="141">Mayotte</option>
                                    <option value="142">Mexico</option>
                                    <option value="143">Micronesia</option>
                                    <option value="144">Moldava</option>
                                    <option value="145">Monaco</option>
                                    <option value="146">Mongolia</option>
                                    <option value="147">Montenegro</option>
                                    <option value="148">Montserrat</option>
                                    <option value="149">Morocco</option>
                                    <option value="150">Mozambique</option>
                                    <option value="151">Myanmar (Burma)</option>
                                    <option value="152">Namibia</option>
                                    <option value="153">Nauru</option>
                                    <option value="154">Nepal</option>
                                    <option value="155">Netherlands</option>
                                    <option value="156">New Caledonia</option>
                                    <option value="157">New Zealand</option>
                                    <option value="158">Nicaragua</option>
                                    <option value="159">Niger</option>
                                    <option value="160">Nigeria</option>
                                    <option value="161">Niue</option>
                                    <option value="162">Norfolk Island</option>
                                    <option value="163">North Korea</option>
                                    <option value="130">North Macedonia</option>
                                    <option value="164">Northern Mariana Islands</option>
                                    <option value="165">Norway</option>
                                    <option value="166">Oman</option>
                                    <option value="167">Pakistan</option>
                                    <option value="168">Palau</option>
                                    <option value="169">Palestine</option>
                                    <option value="170">Panama</option>
                                    <option value="171">Papua New Guinea</option>
                                    <option value="172">Paraguay</option>
                                    <option value="173">Peru</option>
                                    <option value="174">Phillipines</option>
                                    <option value="175">Pitcairn</option>
                                    <option value="176">Poland</option>
                                    <option value="177">Portugal</option>
                                    <option value="178">Puerto Rico</option>
                                    <option value="179">Qatar</option>
                                    <option value="180">Reunion</option>
                                    <option value="181">Romania</option>
                                    <option value="182">Russia</option>
                                    <option value="183">Rwanda</option>
                                    <option value="184">Saint Barthelemy</option>
                                    <option value="185">Saint Helena</option>
                                    <option value="186">Saint Kitts and Nevis</option>
                                    <option value="187">Saint Lucia</option>
                                    <option value="188">Saint Martin</option>
                                    <option value="189">Saint Pierre and Miquelon</option>
                                    <option value="190">Saint Vincent and the Grenadines</option>
                                    <option value="191">Samoa</option>
                                    <option value="192">San Marino</option>
                                    <option value="193">Sao Tome and Principe</option>
                                    <option value="194">Saudi Arabia</option>
                                    <option value="195">Senegal</option>
                                    <option value="196">Serbia</option>
                                    <option value="197">Seychelles</option>
                                    <option value="198">Sierra Leone</option>
                                    <option value="199">Singapore</option>
                                    <option value="200">Sint Maarten</option>
                                    <option value="201">Slovakia</option>
                                    <option value="202">Slovenia</option>
                                    <option value="203">Solomon Islands</option>
                                    <option value="204">Somalia</option>
                                    <option value="205" selected="">South Africa</option>
                                    <option value="206">South Georgia and the South Sandwich Islands</option>
                                    <option value="207">South Korea</option>
                                    <option value="208">South Sudan</option>
                                    <option value="209">Spain</option>
                                    <option value="210">Sri Lanka</option>
                                    <option value="211">Sudan</option>
                                    <option value="212">Suriname</option>
                                    <option value="213">Svalbard and Jan Mayen</option>
                                    <option value="214">Swaziland</option>
                                    <option value="215">Sweden</option>
                                    <option value="216">Switzerland</option>
                                    <option value="217">Syria</option>
                                    <option value="218">Taiwan</option>
                                    <option value="219">Tajikistan</option>
                                    <option value="220">Tanzania</option>
                                    <option value="221">Thailand</option>
                                    <option value="222">Timor-Leste (East Timor)</option>
                                    <option value="223">Togo</option>
                                    <option value="224">Tokelau</option>
                                    <option value="225">Tonga</option>
                                    <option value="226">Trinidad and Tobago</option>
                                    <option value="227">Tunisia</option>
                                    <option value="228">Turkey</option>
                                    <option value="229">Turkmenistan</option>
                                    <option value="230">Turks and Caicos Islands</option>
                                    <option value="231">Tuvalu</option>
                                    <option value="232">Uganda</option>
                                    <option value="233">Ukraine</option>
                                    <option value="234">United Arab Emirates</option>
                                    <option value="235">United Kingdom</option>
                                    <option value="236">United States</option>
                                    <option value="237">United States Minor Outlying Islands</option>
                                    <option value="238">Uruguay</option>
                                    <option value="239">Uzbekistan</option>
                                    <option value="240">Vanuatu</option>
                                    <option value="241">Vatican City</option>
                                    <option value="242">Venezuela</option>
                                    <option value="243">Vietnam</option>
                                    <option value="244">Virgin Islands, British</option>
                                    <option value="245">Virgin Islands, US</option>
                                    <option value="246">Wallis and Futuna</option>
                                    <option value="247">Western Sahara</option>
                                    <option value="248">Yemen</option>
                                    <option value="249">Zambia</option>
                                    <option value="250">Zimbabwe</option>
                                  </select>
                                  <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="combobox" aria-owns="bs-select-5" aria-haspopup="listbox" aria-expanded="false" data-id="country" title="South Africa">
                                  <div class="filter-option">
                                    <div class="filter-option-inner">
                                      <div class="filter-option-inner-inner">South Africa</div>
                                    </div>
                                  </div>
                                  <span class="bs-caret"><span class="caret"></span></span></button>
                                  <div class="dropdown-menu open">
                                    <div class="bs-searchbox">
                                      <input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-5" aria-autocomplete="list">
                                    </div>
                                    <div class="inner open" role="listbox" id="bs-select-5" tabindex="-1">
                                      <ul class="dropdown-menu inner " role="presentation">
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              
                           
                             
                             <div class="form-group" app-field-wrapper="country">

        <button class="btn btn-info save-and-add-contact customer-form-submiter"> Save and create contact </button>
      </div>
                            </div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="billing_and_shipping">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6">
                                  <h4 class="no-mtop">Billing Address <a href="#" class="pull-right billing-same-as-customer"><small class="font-medium-xs">Same as Customer Info</small></a></h4>
                                  <hr>
                                  <div class="form-group" app-field-wrapper="billing_street">
                                    <label for="billing_street" class="control-label">Street</label>
                                    <textarea id="billing_street" name="billing_street" class="form-control" rows="4"><?php echo $arr_general_customers['first_name']?></textarea>
                                  </div>
                                  <div class="form-group" app-field-wrapper="billing_city">
                                    <label for="billing_city" class="control-label">City</label>
                                    <input type="text" id="billing_city" name="billing_city" class="form-control" value="<?php echo $arr_general_customers['first_name']?>">
                                  </div>
                                  <div class="form-group" app-field-wrapper="billing_state">
                                    <label for="billing_state" class="control-label">State</label>
                                    <input type="text" id="billing_state" name="billing_state" class="form-control" value="<?php echo $arr_general_customers['first_name']?>">
                                  </div>
                                  <div class="form-group" app-field-wrapper="billing_zip">
                                    <label for="billing_zip" class="control-label">Zip Code</label>
                                    <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="<?php echo $arr_general_customers['first_name']?>">
                                  </div>
                                  <div class="form-group" app-field-wrapper="billing_country">
                                    <label for="billing_country" class="control-label">Country</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                      <select id="billing_country" name="billing_country" class="selectpicker" data-none-selected-text="Non selected" data-width="100%" data-live-search="true" tabindex="-98">
                                        <option value=""></option>
                                        <option value="1">Afghanistan</option>
                                        <option value="2">Aland Islands</option>
                                        <option value="3">Albania</option>
                                        <option value="4">Algeria</option>
                                        <option value="5">American Samoa</option>
                                        <option value="6">Andorra</option>
                                        <option value="7">Angola</option>
                                        <option value="8">Anguilla</option>
                                        <option value="9">Antarctica</option>
                                        <option value="10">Antigua and Barbuda</option>
                                        <option value="11">Argentina</option>
                                        <option value="12">Armenia</option>
                                        <option value="13">Aruba</option>
                                        <option value="14">Australia</option>
                                        <option value="15">Austria</option>
                                        <option value="16">Azerbaijan</option>
                                        <option value="17">Bahamas</option>
                                        <option value="18">Bahrain</option>
                                        <option value="19">Bangladesh</option>
                                        <option value="20">Barbados</option>
                                        <option value="21">Belarus</option>
                                        <option value="22">Belgium</option>
                                        <option value="23">Belize</option>
                                        <option value="24">Benin</option>
                                        <option value="25">Bermuda</option>
                                        <option value="26">Bhutan</option>
                                        <option value="27">Bolivia</option>
                                        <option value="28">Bonaire, Sint Eustatius and Saba</option>
                                        <option value="29">Bosnia and Herzegovina</option>
                                        <option value="30">Botswana</option>
                                        <option value="31">Bouvet Island</option>
                                        <option value="32">Brazil</option>
                                        <option value="33">British Indian Ocean Territory</option>
                                        <option value="34">Brunei</option>
                                        <option value="35">Bulgaria</option>
                                        <option value="36">Burkina Faso</option>
                                        <option value="37">Burundi</option>
                                        <option value="38">Cambodia</option>
                                        <option value="39">Cameroon</option>
                                        <option value="40">Canada</option>
                                        <option value="41">Cape Verde</option>
                                        <option value="42">Cayman Islands</option>
                                        <option value="43">Central African Republic</option>
                                        <option value="44">Chad</option>
                                        <option value="45">Chile</option>
                                        <option value="46">China</option>
                                        <option value="47">Christmas Island</option>
                                        <option value="48">Cocos (Keeling) Islands</option>
                                        <option value="49">Colombia</option>
                                        <option value="50">Comoros</option>
                                        <option value="51">Congo</option>
                                        <option value="52">Cook Islands</option>
                                        <option value="53">Costa Rica</option>
                                        <option value="54">Cote d'ivoire (Ivory Coast)</option>
                                        <option value="55">Croatia</option>
                                        <option value="56">Cuba</option>
                                        <option value="57">Curacao</option>
                                        <option value="58">Cyprus</option>
                                        <option value="59">Czech Republic</option>
                                        <option value="60">Democratic Republic of the Congo</option>
                                        <option value="61">Denmark</option>
                                        <option value="62">Djibouti</option>
                                        <option value="63">Dominica</option>
                                        <option value="64">Dominican Republic</option>
                                        <option value="65">Ecuador</option>
                                        <option value="66">Egypt</option>
                                        <option value="67">El Salvador</option>
                                        <option value="68">Equatorial Guinea</option>
                                        <option value="69">Eritrea</option>
                                        <option value="70">Estonia</option>
                                        <option value="71">Ethiopia</option>
                                        <option value="72">Falkland Islands (Malvinas)</option>
                                        <option value="73">Faroe Islands</option>
                                        <option value="74">Fiji</option>
                                        <option value="75">Finland</option>
                                        <option value="76">France</option>
                                        <option value="77">French Guiana</option>
                                        <option value="78">French Polynesia</option>
                                        <option value="79">French Southern Territories</option>
                                        <option value="80">Gabon</option>
                                        <option value="81">Gambia</option>
                                        <option value="82">Georgia</option>
                                        <option value="83">Germany</option>
                                        <option value="84">Ghana</option>
                                        <option value="85">Gibraltar</option>
                                        <option value="86">Greece</option>
                                        <option value="87">Greenland</option>
                                        <option value="88">Grenada</option>
                                        <option value="89">Guadaloupe</option>
                                        <option value="90">Guam</option>
                                        <option value="91">Guatemala</option>
                                        <option value="92">Guernsey</option>
                                        <option value="93">Guinea</option>
                                        <option value="94">Guinea-Bissau</option>
                                        <option value="95">Guyana</option>
                                        <option value="96">Haiti</option>
                                        <option value="97">Heard Island and McDonald Islands</option>
                                        <option value="98">Honduras</option>
                                        <option value="99">Hong Kong</option>
                                        <option value="100">Hungary</option>
                                        <option value="101">Iceland</option>
                                        <option value="102">India</option>
                                        <option value="103">Indonesia</option>
                                        <option value="104">Iran</option>
                                        <option value="105">Iraq</option>
                                        <option value="106">Ireland</option>
                                        <option value="107">Isle of Man</option>
                                        <option value="108">Israel</option>
                                        <option value="109">Italy</option>
                                        <option value="110">Jamaica</option>
                                        <option value="111">Japan</option>
                                        <option value="112">Jersey</option>
                                        <option value="113">Jordan</option>
                                        <option value="114">Kazakhstan</option>
                                        <option value="115">Kenya</option>
                                        <option value="116">Kiribati</option>
                                        <option value="117">Kosovo</option>
                                        <option value="118">Kuwait</option>
                                        <option value="119">Kyrgyzstan</option>
                                        <option value="120">Laos</option>
                                        <option value="121">Latvia</option>
                                        <option value="122">Lebanon</option>
                                        <option value="123">Lesotho</option>
                                        <option value="124">Liberia</option>
                                        <option value="125">Libya</option>
                                        <option value="126">Liechtenstein</option>
                                        <option value="127">Lithuania</option>
                                        <option value="128">Luxembourg</option>
                                        <option value="129">Macao</option>
                                        <option value="131">Madagascar</option>
                                        <option value="132">Malawi</option>
                                        <option value="133">Malaysia</option>
                                        <option value="134">Maldives</option>
                                        <option value="135">Mali</option>
                                        <option value="136">Malta</option>
                                        <option value="137">Marshall Islands</option>
                                        <option value="138">Martinique</option>
                                        <option value="139">Mauritania</option>
                                        <option value="140">Mauritius</option>
                                        <option value="141">Mayotte</option>
                                        <option value="142">Mexico</option>
                                        <option value="143">Micronesia</option>
                                        <option value="144">Moldava</option>
                                        <option value="145">Monaco</option>
                                        <option value="146">Mongolia</option>
                                        <option value="147">Montenegro</option>
                                        <option value="148">Montserrat</option>
                                        <option value="149">Morocco</option>
                                        <option value="150">Mozambique</option>
                                        <option value="151">Myanmar (Burma)</option>
                                        <option value="152">Namibia</option>
                                        <option value="153">Nauru</option>
                                        <option value="154">Nepal</option>
                                        <option value="155">Netherlands</option>
                                        <option value="156">New Caledonia</option>
                                        <option value="157">New Zealand</option>
                                        <option value="158">Nicaragua</option>
                                        <option value="159">Niger</option>
                                        <option value="160">Nigeria</option>
                                        <option value="161">Niue</option>
                                        <option value="162">Norfolk Island</option>
                                        <option value="163">North Korea</option>
                                        <option value="130">North Macedonia</option>
                                        <option value="164">Northern Mariana Islands</option>
                                        <option value="165">Norway</option>
                                        <option value="166">Oman</option>
                                        <option value="167">Pakistan</option>
                                        <option value="168">Palau</option>
                                        <option value="169">Palestine</option>
                                        <option value="170">Panama</option>
                                        <option value="171">Papua New Guinea</option>
                                        <option value="172">Paraguay</option>
                                        <option value="173">Peru</option>
                                        <option value="174">Phillipines</option>
                                        <option value="175">Pitcairn</option>
                                        <option value="176">Poland</option>
                                        <option value="177">Portugal</option>
                                        <option value="178">Puerto Rico</option>
                                        <option value="179">Qatar</option>
                                        <option value="180">Reunion</option>
                                        <option value="181">Romania</option>
                                        <option value="182">Russia</option>
                                        <option value="183">Rwanda</option>
                                        <option value="184">Saint Barthelemy</option>
                                        <option value="185">Saint Helena</option>
                                        <option value="186">Saint Kitts and Nevis</option>
                                        <option value="187">Saint Lucia</option>
                                        <option value="188">Saint Martin</option>
                                        <option value="189">Saint Pierre and Miquelon</option>
                                        <option value="190">Saint Vincent and the Grenadines</option>
                                        <option value="191">Samoa</option>
                                        <option value="192">San Marino</option>
                                        <option value="193">Sao Tome and Principe</option>
                                        <option value="194">Saudi Arabia</option>
                                        <option value="195">Senegal</option>
                                        <option value="196">Serbia</option>
                                        <option value="197">Seychelles</option>
                                        <option value="198">Sierra Leone</option>
                                        <option value="199">Singapore</option>
                                        <option value="200">Sint Maarten</option>
                                        <option value="201">Slovakia</option>
                                        <option value="202">Slovenia</option>
                                        <option value="203">Solomon Islands</option>
                                        <option value="204">Somalia</option>
                                        <option value="205">South Africa</option>
                                        <option value="206">South Georgia and the South Sandwich Islands</option>
                                        <option value="207">South Korea</option>
                                        <option value="208">South Sudan</option>
                                        <option value="209">Spain</option>
                                        <option value="210">Sri Lanka</option>
                                        <option value="211">Sudan</option>
                                        <option value="212">Suriname</option>
                                        <option value="213">Svalbard and Jan Mayen</option>
                                        <option value="214">Swaziland</option>
                                        <option value="215">Sweden</option>
                                        <option value="216">Switzerland</option>
                                        <option value="217">Syria</option>
                                        <option value="218">Taiwan</option>
                                        <option value="219">Tajikistan</option>
                                        <option value="220">Tanzania</option>
                                        <option value="221">Thailand</option>
                                        <option value="222">Timor-Leste (East Timor)</option>
                                        <option value="223">Togo</option>
                                        <option value="224">Tokelau</option>
                                        <option value="225">Tonga</option>
                                        <option value="226">Trinidad and Tobago</option>
                                        <option value="227">Tunisia</option>
                                        <option value="228">Turkey</option>
                                        <option value="229">Turkmenistan</option>
                                        <option value="230">Turks and Caicos Islands</option>
                                        <option value="231">Tuvalu</option>
                                        <option value="232">Uganda</option>
                                        <option value="233">Ukraine</option>
                                        <option value="234">United Arab Emirates</option>
                                        <option value="235">United Kingdom</option>
                                        <option value="236">United States</option>
                                        <option value="237">United States Minor Outlying Islands</option>
                                        <option value="238">Uruguay</option>
                                        <option value="239">Uzbekistan</option>
                                        <option value="240">Vanuatu</option>
                                        <option value="241">Vatican City</option>
                                        <option value="242">Venezuela</option>
                                        <option value="243">Vietnam</option>
                                        <option value="244">Virgin Islands, British</option>
                                        <option value="245">Virgin Islands, US</option>
                                        <option value="246">Wallis and Futuna</option>
                                        <option value="247">Western Sahara</option>
                                        <option value="248">Yemen</option>
                                        <option value="249">Zambia</option>
                                        <option value="250">Zimbabwe</option>
                                      </select>
                                      <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="combobox" aria-owns="bs-select-6" aria-haspopup="listbox" aria-expanded="false" data-id="billing_country" title="Non selected">
                                      <div class="filter-option">
                                        <div class="filter-option-inner">
                                          <div class="filter-option-inner-inner">Non selected</div>
                                        </div>
                                      </div>
                                      <span class="bs-caret"><span class="caret"></span></span></button>
                                      <div class="dropdown-menu open">
                                        <div class="bs-searchbox">
                                          <input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-6" aria-autocomplete="list">
                                        </div>
                                        <div class="inner open" role="listbox" id="bs-select-6" tabindex="-1">
                                          <ul class="dropdown-menu inner " role="presentation">
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <h4 class="no-mtop"> <i class="fa fa-question-circle" data-toggle="tooltip" data-title="Do not fill shipping address information if you won't use shipping address on customer invoices"></i> Shipping Address <a href="#" class="pull-right customer-copy-billing-address"><small class="font-medium-xs">Copy Billing Address</small></a> </h4>
                                  <hr>
                                  <div class="form-group" app-field-wrapper="shipping_street">
                                    <label for="shipping_street" class="control-label">Street</label>
                                    <textarea id="shipping_street" name="shipping_street" class="form-control" rows="4"></textarea>
                                  </div>
                                  <div class="form-group" app-field-wrapper="shipping_city">
                                    <label for="shipping_city" class="control-label">City</label>
                                    <input type="text" id="shipping_city" name="shipping_city" class="form-control" value="">
                                  </div>
                                  <div class="form-group" app-field-wrapper="shipping_state">
                                    <label for="shipping_state" class="control-label">State</label>
                                    <input type="text" id="shipping_state" name="shipping_state" class="form-control" value="">
                                  </div>
                                  <div class="form-group" app-field-wrapper="shipping_zip">
                                    <label for="shipping_zip" class="control-label">Zip Code</label>
                                    <input type="text" id="shipping_zip" name="shipping_zip" class="form-control" value="">
                                  </div>
                                  <div class="form-group" app-field-wrapper="shipping_country">
                                    <label for="shipping_country" class="control-label">Country</label>
                                    <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                      <select id="shipping_country" name="shipping_country" class="selectpicker" data-none-selected-text="Non selected" data-width="100%" data-live-search="true" tabindex="-98">
                                        <option value=""></option>
                                        <option value="1">Afghanistan</option>
                                        <option value="2">Aland Islands</option>
                                        <option value="3">Albania</option>
                                        <option value="4">Algeria</option>
                                        <option value="5">American Samoa</option>
                                        <option value="6">Andorra</option>
                                        <option value="7">Angola</option>
                                        <option value="8">Anguilla</option>
                                        <option value="9">Antarctica</option>
                                        <option value="10">Antigua and Barbuda</option>
                                        <option value="11">Argentina</option>
                                        <option value="12">Armenia</option>
                                        <option value="13">Aruba</option>
                                        <option value="14">Australia</option>
                                        <option value="15">Austria</option>
                                        <option value="16">Azerbaijan</option>
                                        <option value="17">Bahamas</option>
                                        <option value="18">Bahrain</option>
                                        <option value="19">Bangladesh</option>
                                        <option value="20">Barbados</option>
                                        <option value="21">Belarus</option>
                                        <option value="22">Belgium</option>
                                        <option value="23">Belize</option>
                                        <option value="24">Benin</option>
                                        <option value="25">Bermuda</option>
                                        <option value="26">Bhutan</option>
                                        <option value="27">Bolivia</option>
                                        <option value="28">Bonaire, Sint Eustatius and Saba</option>
                                        <option value="29">Bosnia and Herzegovina</option>
                                        <option value="30">Botswana</option>
                                        <option value="31">Bouvet Island</option>
                                        <option value="32">Brazil</option>
                                        <option value="33">British Indian Ocean Territory</option>
                                        <option value="34">Brunei</option>
                                        <option value="35">Bulgaria</option>
                                        <option value="36">Burkina Faso</option>
                                        <option value="37">Burundi</option>
                                        <option value="38">Cambodia</option>
                                        <option value="39">Cameroon</option>
                                        <option value="40">Canada</option>
                                        <option value="41">Cape Verde</option>
                                        <option value="42">Cayman Islands</option>
                                        <option value="43">Central African Republic</option>
                                        <option value="44">Chad</option>
                                        <option value="45">Chile</option>
                                        <option value="46">China</option>
                                        <option value="47">Christmas Island</option>
                                        <option value="48">Cocos (Keeling) Islands</option>
                                        <option value="49">Colombia</option>
                                        <option value="50">Comoros</option>
                                        <option value="51">Congo</option>
                                        <option value="52">Cook Islands</option>
                                        <option value="53">Costa Rica</option>
                                        <option value="54">Cote d'ivoire (Ivory Coast)</option>
                                        <option value="55">Croatia</option>
                                        <option value="56">Cuba</option>
                                        <option value="57">Curacao</option>
                                        <option value="58">Cyprus</option>
                                        <option value="59">Czech Republic</option>
                                        <option value="60">Democratic Republic of the Congo</option>
                                        <option value="61">Denmark</option>
                                        <option value="62">Djibouti</option>
                                        <option value="63">Dominica</option>
                                        <option value="64">Dominican Republic</option>
                                        <option value="65">Ecuador</option>
                                        <option value="66">Egypt</option>
                                        <option value="67">El Salvador</option>
                                        <option value="68">Equatorial Guinea</option>
                                        <option value="69">Eritrea</option>
                                        <option value="70">Estonia</option>
                                        <option value="71">Ethiopia</option>
                                        <option value="72">Falkland Islands (Malvinas)</option>
                                        <option value="73">Faroe Islands</option>
                                        <option value="74">Fiji</option>
                                        <option value="75">Finland</option>
                                        <option value="76">France</option>
                                        <option value="77">French Guiana</option>
                                        <option value="78">French Polynesia</option>
                                        <option value="79">French Southern Territories</option>
                                        <option value="80">Gabon</option>
                                        <option value="81">Gambia</option>
                                        <option value="82">Georgia</option>
                                        <option value="83">Germany</option>
                                        <option value="84">Ghana</option>
                                        <option value="85">Gibraltar</option>
                                        <option value="86">Greece</option>
                                        <option value="87">Greenland</option>
                                        <option value="88">Grenada</option>
                                        <option value="89">Guadaloupe</option>
                                        <option value="90">Guam</option>
                                        <option value="91">Guatemala</option>
                                        <option value="92">Guernsey</option>
                                        <option value="93">Guinea</option>
                                        <option value="94">Guinea-Bissau</option>
                                        <option value="95">Guyana</option>
                                        <option value="96">Haiti</option>
                                        <option value="97">Heard Island and McDonald Islands</option>
                                        <option value="98">Honduras</option>
                                        <option value="99">Hong Kong</option>
                                        <option value="100">Hungary</option>
                                        <option value="101">Iceland</option>
                                        <option value="102">India</option>
                                        <option value="103">Indonesia</option>
                                        <option value="104">Iran</option>
                                        <option value="105">Iraq</option>
                                        <option value="106">Ireland</option>
                                        <option value="107">Isle of Man</option>
                                        <option value="108">Israel</option>
                                        <option value="109">Italy</option>
                                        <option value="110">Jamaica</option>
                                        <option value="111">Japan</option>
                                        <option value="112">Jersey</option>
                                        <option value="113">Jordan</option>
                                        <option value="114">Kazakhstan</option>
                                        <option value="115">Kenya</option>
                                        <option value="116">Kiribati</option>
                                        <option value="117">Kosovo</option>
                                        <option value="118">Kuwait</option>
                                        <option value="119">Kyrgyzstan</option>
                                        <option value="120">Laos</option>
                                        <option value="121">Latvia</option>
                                        <option value="122">Lebanon</option>
                                        <option value="123">Lesotho</option>
                                        <option value="124">Liberia</option>
                                        <option value="125">Libya</option>
                                        <option value="126">Liechtenstein</option>
                                        <option value="127">Lithuania</option>
                                        <option value="128">Luxembourg</option>
                                        <option value="129">Macao</option>
                                        <option value="131">Madagascar</option>
                                        <option value="132">Malawi</option>
                                        <option value="133">Malaysia</option>
                                        <option value="134">Maldives</option>
                                        <option value="135">Mali</option>
                                        <option value="136">Malta</option>
                                        <option value="137">Marshall Islands</option>
                                        <option value="138">Martinique</option>
                                        <option value="139">Mauritania</option>
                                        <option value="140">Mauritius</option>
                                        <option value="141">Mayotte</option>
                                        <option value="142">Mexico</option>
                                        <option value="143">Micronesia</option>
                                        <option value="144">Moldava</option>
                                        <option value="145">Monaco</option>
                                        <option value="146">Mongolia</option>
                                        <option value="147">Montenegro</option>
                                        <option value="148">Montserrat</option>
                                        <option value="149">Morocco</option>
                                        <option value="150">Mozambique</option>
                                        <option value="151">Myanmar (Burma)</option>
                                        <option value="152">Namibia</option>
                                        <option value="153">Nauru</option>
                                        <option value="154">Nepal</option>
                                        <option value="155">Netherlands</option>
                                        <option value="156">New Caledonia</option>
                                        <option value="157">New Zealand</option>
                                        <option value="158">Nicaragua</option>
                                        <option value="159">Niger</option>
                                        <option value="160">Nigeria</option>
                                        <option value="161">Niue</option>
                                        <option value="162">Norfolk Island</option>
                                        <option value="163">North Korea</option>
                                        <option value="130">North Macedonia</option>
                                        <option value="164">Northern Mariana Islands</option>
                                        <option value="165">Norway</option>
                                        <option value="166">Oman</option>
                                        <option value="167">Pakistan</option>
                                        <option value="168">Palau</option>
                                        <option value="169">Palestine</option>
                                        <option value="170">Panama</option>
                                        <option value="171">Papua New Guinea</option>
                                        <option value="172">Paraguay</option>
                                        <option value="173">Peru</option>
                                        <option value="174">Phillipines</option>
                                        <option value="175">Pitcairn</option>
                                        <option value="176">Poland</option>
                                        <option value="177">Portugal</option>
                                        <option value="178">Puerto Rico</option>
                                        <option value="179">Qatar</option>
                                        <option value="180">Reunion</option>
                                        <option value="181">Romania</option>
                                        <option value="182">Russia</option>
                                        <option value="183">Rwanda</option>
                                        <option value="184">Saint Barthelemy</option>
                                        <option value="185">Saint Helena</option>
                                        <option value="186">Saint Kitts and Nevis</option>
                                        <option value="187">Saint Lucia</option>
                                        <option value="188">Saint Martin</option>
                                        <option value="189">Saint Pierre and Miquelon</option>
                                        <option value="190">Saint Vincent and the Grenadines</option>
                                        <option value="191">Samoa</option>
                                        <option value="192">San Marino</option>
                                        <option value="193">Sao Tome and Principe</option>
                                        <option value="194">Saudi Arabia</option>
                                        <option value="195">Senegal</option>
                                        <option value="196">Serbia</option>
                                        <option value="197">Seychelles</option>
                                        <option value="198">Sierra Leone</option>
                                        <option value="199">Singapore</option>
                                        <option value="200">Sint Maarten</option>
                                        <option value="201">Slovakia</option>
                                        <option value="202">Slovenia</option>
                                        <option value="203">Solomon Islands</option>
                                        <option value="204">Somalia</option>
                                        <option value="205">South Africa</option>
                                        <option value="206">South Georgia and the South Sandwich Islands</option>
                                        <option value="207">South Korea</option>
                                        <option value="208">South Sudan</option>
                                        <option value="209">Spain</option>
                                        <option value="210">Sri Lanka</option>
                                        <option value="211">Sudan</option>
                                        <option value="212">Suriname</option>
                                        <option value="213">Svalbard and Jan Mayen</option>
                                        <option value="214">Swaziland</option>
                                        <option value="215">Sweden</option>
                                        <option value="216">Switzerland</option>
                                        <option value="217">Syria</option>
                                        <option value="218">Taiwan</option>
                                        <option value="219">Tajikistan</option>
                                        <option value="220">Tanzania</option>
                                        <option value="221">Thailand</option>
                                        <option value="222">Timor-Leste (East Timor)</option>
                                        <option value="223">Togo</option>
                                        <option value="224">Tokelau</option>
                                        <option value="225">Tonga</option>
                                        <option value="226">Trinidad and Tobago</option>
                                        <option value="227">Tunisia</option>
                                        <option value="228">Turkey</option>
                                        <option value="229">Turkmenistan</option>
                                        <option value="230">Turks and Caicos Islands</option>
                                        <option value="231">Tuvalu</option>
                                        <option value="232">Uganda</option>
                                        <option value="233">Ukraine</option>
                                        <option value="234">United Arab Emirates</option>
                                        <option value="235">United Kingdom</option>
                                        <option value="236">United States</option>
                                        <option value="237">United States Minor Outlying Islands</option>
                                        <option value="238">Uruguay</option>
                                        <option value="239">Uzbekistan</option>
                                        <option value="240">Vanuatu</option>
                                        <option value="241">Vatican City</option>
                                        <option value="242">Venezuela</option>
                                        <option value="243">Vietnam</option>
                                        <option value="244">Virgin Islands, British</option>
                                        <option value="245">Virgin Islands, US</option>
                                        <option value="246">Wallis and Futuna</option>
                                        <option value="247">Western Sahara</option>
                                        <option value="248">Yemen</option>
                                        <option value="249">Zambia</option>
                                        <option value="250">Zimbabwe</option>
                                      </select>
                                      <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="combobox" aria-owns="bs-select-7" aria-haspopup="listbox" aria-expanded="false" data-id="shipping_country" title="Non selected">
                                      <div class="filter-option">
                                        <div class="filter-option-inner">
                                          <div class="filter-option-inner-inner">Non selected</div>
                                        </div>
                                      </div>
                                      <span class="bs-caret"><span class="caret"></span></span></button>
                                      <div class="dropdown-menu open">
                                        <div class="bs-searchbox">
                                          <input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-7" aria-autocomplete="list">
                                        </div>
                                        <div class="inner open" role="listbox" id="bs-select-7" tabindex="-1">
                                          <ul class="dropdown-menu inner " role="presentation">
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="banking_details">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group" app-field-wrapper="account_title">
                                    <label for="account_title" class="control-label">Account Title</label>
                                    <input type="text" id="account_title" name="account_title" class="form-control" value="">
                                  </div>
                                  <div class="form-group" app-field-wrapper="account_no">
                                    <label for="account_no" class="control-label">Account No</label>
                                    <input type="text" id="account_no" name="account_no" class="form-control" value="">
                                  </div>
                                  <div class="form-group" app-field-wrapper="account_description">
                                    <label for="account_description" class="control-label">Account Description</label>
                                    <textarea id="account_description" name="account_description" class="form-control" rows="4"></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal fade" id="customer_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"> <span class="edit-title">Edit Customer Group</span> <span class="add-title">Add New Customer Group</span> </h4>
                      </div>
                      <form action="https://crm.dryvarfoods.com/admin/clients/group" id="customer-group-modal" method="post" accept-charset="utf-8" novalidate="novalidate">
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group" app-field-wrapper="name">
                                <label for="name" class="control-label"> <small class="req text-danger">* </small>Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="">
                              </div>
                              <input type="hidden" name="id" value="">
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button group="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button group="submit" class="btn btn-info">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <script>
  /*  window.addEventListener('load',function(){
       appValidateForm($('#customer-group-modal'), {
        name: 'required'
    }, manage_customer_groups);*/

       $('#customer_group_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
        $('#customer_group_modal .add-title').removeClass('hide');
        $('#customer_group_modal .edit-title').addClass('hide');
        $('#customer_group_modal input[name="id"]').val('');
        $('#customer_group_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(group_id) !== 'undefined') {
            $('#customer_group_modal input[name="id"]').val(group_id);
            $('#customer_group_modal .add-title').addClass('hide');
            $('#customer_group_modal .edit-title').removeClass('hide');
            $('#customer_group_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   /*});*/
    function manage_customer_groups(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-customer-groups')){
                    $('.table-customer-groups').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#customer_group_modal').modal('hide');
        });
        return false;
    }

</script> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-bottom-pusher"></div>
  </div>
</div>
