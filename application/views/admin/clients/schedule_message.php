<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<style>
/* File Input CSS */



.form-group input[type=file] {
	opacity: 0;
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 100;
}
.fileinput .thumbnail {
	display: inline-block;
	margin-bottom: 10px;
	overflow: hidden;
	text-align: center;
	vertical-align: middle;
	max-width: 250px;
	box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}
.thumbnail {
	border: 0 none;
	border-radius: 4px;
	padding: 0;
}
.fileinput-exists .fileinput-new, .fileinput-new .fileinput-exists {
	display: none;
}
.fileinput {
	display: inline-block;
	margin-bottom: 9px;
}
.fileinput .thumbnail>img {
	max-height: 100%;
}
.btn:not(:disabled):not(.disabled) {
	cursor: pointer;
}
.fileinput .btn {
	vertical-align: middle;
}
.btn.btn-round, .navbar .navbar-nav>li>a.btn.btn-round {
	border-radius: 30px;
}
.btn.btn-danger, .navbar .navbar-nav>li>a.btn.btn-danger {
	box-shadow: 0 2px 2px 0 rgba(244, 67, 54, 0.14), 0 3px 1px -2px rgba(244, 67, 54, 0.2), 0 1px 5px 0 rgba(244, 67, 54, 0.12);
}
.btn, .btn.btn-default, .navbar .navbar-nav>li>a.btn, .navbar .navbar-nav>li>a.btn.btn-default {
	box-shadow: 0 2px 2px 0 rgba(153, 153, 153, 0.14), 0 3px 1px -2px rgba(153, 153, 153, 0.2), 0 1px 5px 0 rgba(153, 153, 153, 0.12);
}
.btn-file, .btn-danger, .navbar .navbar-nav>li>a.btn {
	border: none;
	border-radius: 3px;
	position: relative;
	padding: 12px 30px;
	margin: 10px 1px;
	font-size: 12px;
	font-weight: 400;
	text-transform: uppercase;
	letter-spacing: 0;
	will-change: box-shadow, transform;
	transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.highcharts-figure, .highcharts-data-table table {
/* min-width: 360px; 
      max-width: 800px;
      margin: 1em auto;*/
}
.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
	padding: 1em 0;
	font-size: 1.2em;
	color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
	padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
	padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
	background: #f8f8f8;
}
.highcharts-data-table tr:hover {
	background: #f1f7ff;
}
</style>
<style>
@import 'https://code.highcharts.com/css/highcharts.css';
.highcharts-pie-series .highcharts-point {
	stroke: #EDE;
	stroke-width: 2px;
}
.highcharts-pie-series .highcharts-data-label-connector {
	stroke: silver;
	stroke-dasharray: 2, 2;
	stroke-width: 2px;
}
.highcharts-figure, .highcharts-data-table table {
/*  min-width: 320px; 
      max-width: 600px;
      margin: 1em auto;*/
}
.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
	padding: 1em 0;
	font-size: 1.2em;
	color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
	padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
	padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
	background: #f8f8f8;
}
.highcharts-data-table tr:hover {
	background: #f1f7ff;
}
</style>
<style>
.highcharts-credits {
	display: none!important;
}
.hr_style {
	margin-top: 10px;
	border: 0.5px solid;
	color: #03a9f4;
}
.select2{
	width:100%!important;
}
label.error, .custom_error{
 color:red;
}
.schedule_msg_container{
	display:none;
}
.fileinput .thumbnail {
    
    max-width: 175px!important;
    
}
</style>

<div id="wrapper">
<div class="content">
<div class="row">
<div class="col-md-12">
<div class="panel_s">
<div class="panel-body">
  <div class="clearfix"></div>
  <div class="row mbot15">
    <div class="col-md-12">
      <h3 class="padding-5 p_style" style="color: #03a9f4;">
      Schedule a Message
      </h4>
    </div>
    <hr class="hr_style" />
    <!--<div class="row mbot15">
        <div class="col-md-12">
          <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
            <div class="top_stats_wrapper hrm-minheight85"> <a class="text-default mbot15">
              <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Piad Amount </p>
              <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo number_format((float)$sumTotalAmount, 2, '.', '').' R'; ?></span> </a>
              <div class="clearfix"></div>
              <div class="progress no-margin progress-bar-mini">
                <div class="progress-bar progress-bar-default no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
              </div>
            </div>
          </div>
          <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
            <div class="top_stats_wrapper hrm-minheight85"> <a class="text-success mbot15">
              <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Complete Payout </p>
              <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo number_format((float)$sumTotalAmount, 2, '.', '').' R'; ?></span> </a>
              <div class="clearfix"></div>
              <div class="progress no-margin progress-bar-mini">
                <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
              </div>
            </div>
          </div>
          <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
            <div class="top_stats_wrapper hrm-minheight85"> <a class="text-danger mbot15">
              <p class="text-uppercase mtop5 hrm-minheight35"> <i class="hidden-sm glyphicon glyphicon-edit"></i> Need to Pay </p>
              <span class="pull-right bold no-mtop hrm-fontsize24"> <?php echo 0; ?> R </span> </a>
              <div class="clearfix"></div>
              <div class="progress no-margin progress-bar-mini">
                <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
              </div>
            </div>
          </div>
          <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
            <div class="top_stats_wrapper hrm-minheight85"> <a class="text-warning mbot15">
              <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Payment </p>
              <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo 0 ?> R</span> </a>
              <div class="clearfix"></div>
              <div class="progress no-margin progress-bar-mini">
                <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h3 class="padding-5 p_style"> Message </h3>
      </div>--> 
    <!--<hr class="hr_style" />-->
    <form id="scheduleMessageForm" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12 col-xs-12" style="">
          <div class="row">
            <div class=" col-md-12 col-xs-12">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
                <div class="panel-body">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab_staff_profile"> 
                      <!--<div class="checkbox checkbox-primary">
								<input type="checkbox" value="1" name="two_factor_auth_enabled" id="two_factor_auth_enabled">
								<label for="two_factor_auth_enabled"><i class="fa fa-question-circle" data-toggle="tooltip" data-title="Two factor authentication is provided by email, before enable two factor authentication make sure that your SMTP settings are properly configured and the system is able to send an email. Unique authentication key will be sent to email upon login."></i> Enable Two Factor Authentication</label>
							  </div>--> 
                      <!--<div class="is-not-staff">
								<div class="checkbox checkbox-primary">
								  <input type="checkbox" value="1" name="is_not_staff" id="is_not_staff">
								  <label for="is_not_staff">Not Staff Member</label>
								</div>
								<hr>
							  </div>-->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="schedule_msg_container"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <label for="message_type">
                          <h4>Message Type <small class="req text-danger"> * </small></h4>
                          </label>
                          <div class="radio radio-primary">
                            <input type="radio" id="message_type2" name="message_type" value="2" checked="checked">
                            <label for="message_type2">Push Notification</label>
                          </div>
                          <div class="radio radio-primary">
                            <input type="radio" id="message_type1" name="message_type" value="1" >
                            <label for="message_type1">SMS</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="notification_type_options">
                            <label for="notification_type">
                            <h4>Send Notification VIA <small class="req text-danger"> * </small></h4>
                            </label>
                            <div class="radio radio-primary">
                              <input type="radio" id="notification_type2" name="notification_type" value="2" checked="checked">
                              <label for="notification_type2">FireBase Notification</label>
                            </div>
                            <div class="radio radio-primary">
                              <input type="radio" id="notification_type1" name="notification_type" value="1" >
                              <label for="notification_type1">WonderPush Notification</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="notification_type_options">
                            <label for="departments">
                            <h4>User Type<small class="req text-danger"> * </small></h4>
                            </label>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="radio radio-primary">
                                  <input type="radio" id="dep_1" name="user_type" value="eater" checked="checked">
                                  <label for="dep_1">Eater</label>
                                </div>
                                <div class="radio radio-primary">
                                  <input type="radio" id="dep_1" name="user_type" value="driver">
                                  <label for="dep_1">Driver</label>
                                </div>
                              </div>
                              <div class="col-md-6=9">
                                <div class="radio radio-primary">
                                  <input type="radio" id="dep_1" name="user_type" value="resturant">
                                  <label for="dep_1">Restaurant</label>
                                </div>
                                <div class="radio radio-primary">
                                  <input type="radio" id="dep_1" name="user_type" value="all">
                                  <label for="dep_1"> Eater & Driver & Restaurant</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="hr_style" />
                      <div class="row">
                        <div class="col-md-2">
                          <label for="departments">
                          <h4>To <small class="req text-danger">* </small></h4>
                          </label>
                          <div class="radio radio-primary">
                            <input type="radio"  name="user" value="all" checked="checked">
                            <label for="dep_1">All</label>
                          </div>
                          <div class="radio radio-primary">
                            <input type="radio"  name="user" value="specific">
                            <label for="dep_1">Specific Users</label>
                          </div>
                          <div class="radio radio-primary">
                            <input type="radio"  name="user" value="city" >
                            <label for="dep_1">Specific City</label>
                          </div>
                          <div class="radio radio-primary">
                            <input type="radio"  name="user" value="insight" >
                            <label for="dep_1">Customer Insight</label>
                          </div>
                        </div>
                        <div class="select_clients" style="display:none;">
                          <div class="col-md-10" >
                            <div class="clearfix form-group"></div>
                            <label for="password" class="control-label">
                            <h4> User <small class="req text-danger">* </small></h4>
                            </label>
                            <select class="js-example-data-ajax form-control select_filters " multiple data-live-search="true" name="clients_select[]" id="clients_select" required="true">
                              <?php if(count($restaurants)>0){
									foreach($restaurants as $val){?>
                              <option value="<?php echo $val['device_id'];?>"><?php echo ucfirst($val['firstname']).' - '.$val['phonenumber'];?></option>
                              <?php } } ?>
                            </select>
                            <br />
                          </div>
                        </div>
                        <div class="select_city" style="display:none;">
                          <div class="col-md-10" >
                            <div class="clearfix form-group"></div>
                            <label for="city" class="control-label">
                            <h4> City <small class="req text-danger">* </small></h4>
                            </label>
                            <select class="js-example-data-ajax form-control select_filters" multiple data-live-search="true" name="city_select[]"  id="city_select" required="true">
                              <?php if(count($cities)>0){
									foreach($cities as $val){?>
                              <option value="<?php echo $val['city'];?>"><?php echo $val['city'];?></option>
                              <?php } } ?>
                            </select>
                            <br />
                          </div>
                        </div>
                        <div class="select_insight" style="display:none;">
                          <div class="col-md-4" >
                            <div class="clearfix form-group"></div>
                            <label for="city" class="control-label">
                            <h4> Customer Insight <small class="req text-danger">* </small></h4>
                            </label>
                            <select class="js-example-data-ajax form-control select_filters"  name="insight_select"  id="insight_select" required="true">
                              <option value="first_time_order">First Time Ordering</option>
                              <option value="never_purchase">Never Purchased</option>
                              <option value="new_signup">New Signup </option>
                            </select>
                            <br />
                          </div>
                          <div class="col-md-3" >
                            <div class="form-group" >
                              <div class="clearfix form-group"></div>
                              <label for="city" class="control-label">
                              <h4> From Date <small class="req text-danger">* </small></h4>
                              </label>
                              <div class="input-group date input-group-date">
                                <input type="text" id="fromdate" name="fromdate"  class="form-control fromdate" value="" autocomplete="off" aria-invalid="false"  required="true">
                                <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i> </div>
                              </div>
                              <?php //echo form_error('date', '<div class="custom_error">', '</div>'); ?> </div>
                          </div>
                          <div class="col-md-3" >
                            <div class="form-group" >
                              <div class="clearfix form-group"></div>
                              <label for="city" class="control-label">
                              <h4> To Date <small class="req text-danger">* </small></h4>
                              </label>
                              <div class="input-group date input-group-date">
                                <input type="text" id="todate" name="todate" class="form-control todate" value="" autocomplete="off" aria-invalid="false"  required="true">
                                <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i> </div>
                              </div>
                              <?php //echo form_error('date', '<div class="custom_error">', '</div>'); ?> </div>
                          </div>
                        </div>
                      </div>
                      <hr class="hr_style" />
                      <label for="departments">
                      <h4>Schedule Date And Time <small class="req text-danger">* </small></h4>
                      </label>
                      <div class="">
                        <div class="form-group row " id="break_date-item">
                          <div class="col-md-3">
                            <div class="form-group" app-field-wrapper="break_date[0]">
                              <label for="break_date[0]" class="control-label">Day off</label>
                              <div class="input-group date input-group-date">
                                <input type="text" id="date" name="date" required="true" class="form-control scheduleDatepicker" value="" autocomplete="off" aria-invalid="false">
                                <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i> </div>
                              </div>
                              <?php echo form_error('date', '<div class="custom_error">', '</div>'); ?> </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="timekeeping[0]">Hours</label>
                              <div class="dropdown bootstrap-select bs3">
                                <select name="hours" id="hours" required="true" class="selectpicker" data-live-search="true" data-none-selected-text="Non selected" data-hide-disabled="true" tabindex="-98">
                                  <option value="1">1:00</option>
                                  <option value="2">2:00</option>
                                  <option value="3">3:00</option>
                                  <option value="4">4:00</option>
                                  <option value="5">5:00</option>
                                  <option value="6">6:00</option>
                                  <option value="7">7:00</option>
                                  <option value="8">8:00</option>
                                  <option value="9">9:00</option>
                                  <option value="10">10:00</option>
                                  <option value="11">11:00</option>
                                  <option value="12">12:00</option>
                                  <option value="13">13:00</option>
                                  <option value="14">14:00</option>
                                  <option value="15">15:00</option>
                                  <option value="16">16:00</option>
                                  <option value="17">17:00</option>
                                  <option value="18">18:00</option>
                                  <option value="19">19:00</option>
                                  <option value="20">20:00</option>
                                  <option value="21">21:00</option>
                                  <option value="22">22:00</option>
                                  <option value="23">23:00</option>
                                  <option value="00">00:00</option>
                                  <option value="no"></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-1"></div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="timekeeping[0]">Minutes</label>
                              <div class="dropdown bootstrap-select bs3">
                                <select name="minutes" id="minutes" required="true" data-live-search="true" class="selectpicker"  data-none-selected-text="Non selected" data-hide-disabled="true" tabindex="-98">
                                  <option value="1">1:00</option>
                                  <option value="2">2:00</option>
                                  <option value="3">3:00</option>
                                  <option value="4">4:00</option>
                                  <option value="5">5:00</option>
                                  <option value="6">6:00</option>
                                  <option value="7">7:00</option>
                                  <option value="8">8:00</option>
                                  <option value="9">9:00</option>
                                  <option value="10">10:00</option>
                                  <option value="11">11:00</option>
                                  <option value="12">12:00</option>
                                  <option value="13">13:00</option>
                                  <option value="14">14:00</option>
                                  <option value="15">15:00</option>
                                  <option value="16">16:00</option>
                                  <option value="17">17:00</option>
                                  <option value="18">18:00</option>
                                  <option value="19">19:00</option>
                                  <option value="20">20:00</option>
                                  <option value="21">21:00</option>
                                  <option value="22">22:00</option>
                                  <option value="23">23:00</option>
                                  <option value="24">24:00</option>
                                  <option value="25">25:00</option>
                                  <option value="26">26:00</option>
                                  <option value="27">27:00</option>
                                  <option value="28">28:00</option>
                                  <option value="29">29:00</option>
                                  <option value="30">30:00</option>
                                  <option value="31">31:00</option>
                                  <option value="32">32:00</option>
                                  <option value="33">33:00</option>
                                  <option value="34">34:00</option>
                                  <option value="35">35:00</option>
                                  <option value="36">36:00</option>
                                  <option value="37">37:00</option>
                                  <option value="38">38:00</option>
                                  <option value="39">39:00</option>
                                  <option value="40">40:00</option>
                                  <option value="41">41:00</option>
                                  <option value="42">42:00</option>
                                  <option value="43">43:00</option>
                                  <option value="44">44:00</option>
                                  <option value="45">45:00</option>
                                  <option value="46">46:00</option>
                                  <option value="47">47:00</option>
                                  <option value="48">48:00</option>
                                  <option value="49">49:00</option>
                                  <option value="50">50:00</option>
                                  <option value="51">51:00</option>
                                  <option value="52">52:00</option>
                                  <option value="53">53:00</option>
                                  <option value="54">54:00</option>
                                  <option value="55">55:00</option>
                                  <option value="56">56:00</option>
                                  <option value="57">57:00</option>
                                  <option value="58">58:00</option>
                                  <option value="59">59:00</option>
                                  <option value="00">00:00</option>
                                  <option value="no"></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-1"></div>
                          <div class="col-md-3">
                            <canvas id="canvas" width="150" height="150"style="    margin-top: -60px;"></canvas>
                          </div>
                        </div>
                        <hr class="hr_style" />
                        <div class="row">
                          <div class="col-md-9">
                            <div class="form-group" app-field-wrapper="email_signature">
                              <label for="email_signature" class="control-label">
                              <h4>Title <small class="req text-danger"> * </small></h4>
                              </label>
                              <input class="form-control" type="text" id="title" name="title" value="" required="true">
                              <?php echo form_error('title', '<div class="custom_error">', '</div>'); ?> </div>
                            <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="If empty default message template will be used"></i>
                            <div class="form-group" app-field-wrapper="email_signature">
                              <label for="email_signature" class="control-label">
                              <h4>Message <small class="req text-danger"> * </small></h4>
                              </label>
                              <input   maxlength="3" size="3"  value="400" id="counter"  data-entities-encode="true" rows="6">
                              <textarea onkeyup="textCounter(this,'counter',400);" id="message" name="message" class="form-control" rows="6" required="true"></textarea>
                              <?php echo form_error('message', '<div class="custom_error">', '</div>'); ?> </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group label-floating">
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail img-circle"> <img src="<?php echo base_url();?>assets/images/placeholder.jpg" alt="..."> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                <div> <span class="btn btn-success btn-file"> <span class="fileinput-new">Add Attachment</span> <span class="fileinput-exists">Change</span>
                                  <input type="file" name="attachment" id="attachment" accept ="image/*"/>
                                  </span> <br />
                                  <a href="#pablo" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a> </div>
                                <div class="attachment-error"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr class="hr_style" />
                        <div class="col-md-6">
                          <div class="text-left btn-toolbar-container-out pull-left">
                            <button type="button" class="btn btn-info  submit">Schedule Message</button>
                          </div>
                        </div>
                        <br>
                      </div>
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
</div>
<?php init_tail(); ?>
<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/additional-methods.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jasny-bootstrap.min.js"></script> 
<script>

var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var radius = canvas.height / 2;
ctx.translate(radius, radius);
radius = radius * 0.90
setInterval(drawClock, 1000);

function drawClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  var grad;
  ctx.beginPath();
  ctx.arc(0, 0, radius, 0, 2*Math.PI);
  ctx.fillStyle = 'white';
  ctx.fill();
  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
  grad.addColorStop(0, '#333');
  grad.addColorStop(0.5, 'white');
  grad.addColorStop(1, '#333');
  ctx.strokeStyle = grad;
  ctx.lineWidth = radius*0.1;
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
  ctx.fillStyle = '#333';
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  var ang;
  var num;
  ctx.font = radius*0.15 + "px arial";
  ctx.textBaseline="middle";
  ctx.textAlign="center";
  for(num = 1; num < 13; num++){
    ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius*0.85);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius*0.85);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    //hour
    hour=hour%12;
    hour=(hour*Math.PI/6)+
    (minute*Math.PI/(6*60))+
    (second*Math.PI/(360*60));
    drawHand(ctx, hour, radius*0.5, radius*0.07);
    //minute
    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
    drawHand(ctx, minute, radius*0.8, radius*0.07);
    // second
    second=(second*Math.PI/30);
    drawHand(ctx, second, radius*0.9, radius*0.02);
}

function drawHand(ctx, pos, length, width) {
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = "round";
    ctx.moveTo(0,0);
    ctx.rotate(pos);
    ctx.lineTo(0, -length);
    ctx.stroke();
    ctx.rotate(-pos);
}



<!--END -->

$("#scheduleMessageForm").validate({
        messages: {
			title: {
    		  required: "The Title is required",
    		},
			/*city_select: {
    		  required: "The City is required",
    		},*/
    		date: {
    		  required: "The Date is required",
    		},
    		message: {
    		  required: "The Message is required",
    		},
			hours: {
    		  required: "The Hours are required",
    		},
			minutes: {
    		  required: "The Minutes is required",
    		},
			attachment: {
				accept: "Only PNG|JPG|JPEG files are allowed",
			}
          },
		errorPlacement: function(error, element) {
			if ( element.attr("name")=="date"){
               error.insertAfter(".input-group-date");
			}
			else if ( element.attr("name")=="attachment"){
               $(".attachment-error").html(error);
			}
			else{
				error.insertAfter(element);
			}
        }
});
	
$(document).ready(function(e) {

        $("input[type='radio']").click(function(){
            var radioValue = $("input[name='user']:checked").val();
            if(radioValue=='specific'){
                $(".select_clients").show();
				$(".select_city").hide();
				$(".select_insight").hide();
            }
			else if(radioValue=='city'){
                $(".select_clients").hide();
				$(".select_city").show();
				$(".select_insight").hide();
            }
			else if(radioValue=='insight'){
                $(".select_clients").hide();
				$(".select_city").hide();
				$(".select_insight").show();
            }
			else{
				$(".select_clients").hide();
				$(".select_city").hide();
				$(".select_insight").hide();
			}
        });

});
</script> 
<script>
function textCounter(field,field2,maxlimit)
{
 var countfield = document.getElementById(field2);
 if ( field.value.length > maxlimit ) {
  field.value = field.value.substring( 0, maxlimit );
  return false;
 } else {
  countfield.value = maxlimit - field.value.length;
 }
}
</script> 
<script>
$(document).ready(function(e) {

  var segments = window.location.href.split( '/' );
  if(segments.length > 5){
    var filter_type = segments[6];
  }else{
    var filter_type = '';
  }
 
  var post_client = '';
  var post_contact = '';
  var post_driver = '';
  if( filter_type == 'client'){ post_client = segments[7];}
  if( filter_type == 'contact'){ post_contact = segments[7];}
  if( filter_type == 'driver'){ post_driver = segments[7];}

  $('#clients_select').select2({
    placeholder: "Select Client",
    /*ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/clients_ajax_select/"+post_client,
      dataType: 'json',
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }*/

  });
  
  $('#city_select').select2({
    placeholder: "Select City",
    /*ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/clients_ajax_select/"+post_client,
      dataType: 'json',
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }*/

  });
  });

</script> 
<script>

$("body").on("change", ".select_filters", function(){


    var page = 0;
    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    if( filter_type == 'client'){ var client  = segments[7];}
    else { var client   = $('#clients_select').val(); }

    if( filter_type == 'driver'){ var driver  = segments[7];}
    else { var driver   = $('#driver_select').val(); }

    if( filter_type == 'contact'){ var contact  = segments[7];}
    else { var contact  = $('#contact_select').val(); }

    var orderby = $("#sort").val();
    var date_from = $("#date_from").val();
    var date_too = $("#date_too").val();
    var month = $("#month").val();
    var order_type = $("#order_type").val();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
        type: "POST",
        data: {client:client,driver:driver,contact:contact,orderby:orderby,date_from:date_from,date_too:date_too,month:month,order_type:order_type},
        success: function(response){

          var res_arr = response.split('***||***');
		  
		  if(res_arr=='nororders'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No orders found !</div>');
			   $('#order_list').html(res_arr[0]);
               $('#record_count').html(res_arr[1]);
			
		  }else{
        
          $('#order_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		  
		  }
          

        }
    });   

  });

</script> 
<script>


  /*$("body").on("click", ".submit", function(){
	  
    var user       = $('input[name="user"]:checked').val();
	var user_type  = $('input[name="user_type"]:checked').val();
	
    var orderby    = $("#sort").val();
    var date_from  = $("#start_date").val();
    var date_too   = $("#end_date").val();
    var month      = $("#month").val();
    var order_type = $("#order_type").val();
  
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/submit_message/",
        type: "POST",
        data: {client:client,driver:driver,contact:contact,orderby:orderby,date_from:date_from,date_too:date_too,month:month,order_type:order_type},
        success: function(response){

            var res_arr = response.split('***||***');

            $('#order_list').html(res_arr[0]);
            $('#record_count').html(res_arr[1]);
            $('#page_links').html(res_arr[2]);

        }
    });   

  });*/
  
  $("body").on("click", ".submit", function(){
	  
	  if($("#scheduleMessageForm").valid()){
		var form = $('#scheduleMessageForm')[0];
        var data = new FormData(form);
       $.ajax({
                   type:'POST',
                   url: "<?php echo AURL;?>clients/submit_message",
                   data: data,
                   processData: false,
                   contentType: false,
                   cache: false,
                   beforeSend: function() {
                        $(".submit").text('Please Wait....');
                        $(".submit").attr('disabled',true);
                    },
                   success:function(result){
                       if(result=="sent"){
						   $("#scheduleMessageForm")[0].reset();
						   $("#hours").val('1').selectpicker('refresh');
						   $("#minutes").val('1').selectpicker('refresh');
                           $(".submit").attr('disabled',false);
						   $(".select_clients").hide();
				           $(".select_city").hide();
                           $(".submit").text('Submit');
                           $(".schedule_msg_container").show();
                           $(".schedule_msg_container").html("<p class='text-success'>Message has been scheduled successfully!</p>").delay(3000);
                            $('html, body').animate({
                                scrollTop: $("#scheduleMessageForm").offset().top
                            }, 2000);
                       }
                       else{
                             $(".schedule_msg_container").show();
                            $(".schedule_msg_container").html(result).delay(3000).fadeOut(300);
                       }
                       
                    }
                }); 
   }  
   else{
       $("#scheduleMessageForm").validate();
   }
	  
  });
  
  $("input[name='message_type']"). change(function(){
	  if($(this).val()==1){
		$(".notification_type_options").hide();
	  }
	  else{
		$(".notification_type_options").show();
	  }
  });
  
  var dateToday = new Date();

  
  $(".fromdate").datepicker({})
  $(".todate").datepicker({})
  
  $(".scheduleDatepicker").datepicker({
	 minDate: dateToday, 
        
  });

</script>
</body>
</html>
