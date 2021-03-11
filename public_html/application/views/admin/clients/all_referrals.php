<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  .p_style{
  color: #03a9f4;
  }
  a.text-default{
	  color:#004b6d!important;
  }
  .filter_price .ui-widget.ui-widget-content {
	border: 0;
	border-radius: 0;
	background-color: #ddd;
	height: 4px;
	margin-bottom: 20px;
}
.ui-slider-horizontal .ui-slider-range {
	top: 0;
	height: 100%;
}
.filter_price .ui-slider .ui-slider-range {
	background-color: #FF324D;
	border-radius: 0;
}
.filter_price .ui-slider .ui-slider-handle {
	cursor: pointer;
	background-color: #fff;
	border-radius: 100%;
	border: 0;
	height: 18px;
	top: -8px;
	width: 18px;
	margin: 0;
	box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
.price_range {
	color: #292b2c;
}
#flt_price {
	margin-left: 5px;
	font-weight: 600;
}
.loading-image {
  position: absolute;
  top: 50%;
  left: 35%;
  z-index: 10;
  width:200px;
}
.loader
{
    display: none;
    position:absolute;
    width:100%;
    height:100%;
    left:0;
    top:0;
    text-align: center;
    margin-top: -100px;
    z-index: 2;
}
</style>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body" >
          
             <div class="clearfix"></div>
             
             <div class="row">
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Royalty & Rewards</h3>
              </div>
              </div>
              <hr class="hr_style" />
             <!-- <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Drivers</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_drivers_count"><?php echo ($drivers_count); ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-success mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Active Drivers            </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24 total_active_drivers_count"><?php echo ($drivers_count_active); ?></span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-danger mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Inactive Drivers
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_inactive_drivers_count">
                          <?php echo ($drivers_count_inactive); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
              </div>-->

              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Referrals & Commissions    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			      <form id="clientsFilter" method="post" action="<?php echo base_url();?>admin/clients/export_referrals">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
        				  <div class="col-md-12 col-xs-12">
          				  <?php
          					if ($this->session->flashdata('err_message')) { ?>
          					   <div class="alert alert-danger">
          					     <?php echo $this->session->flashdata('err_message'); ?>
          					   </div>
          				  <?php } ?>
        				  </div>
                  <div class=" col-md-4 col-xs-6">
                    <label><strong>Select Month </strong></label>
                    <select name="month" id="month" class="js-example-data-ajax form-control select_filters">
                      <option value="">Select Month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select> 
                  </div>
                  <div class='col-sm-4'>
                    <label><strong>Date From</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class='col-sm-4'>
                    <label><strong>Date To</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" id="date_too" placeholder="To Date" name="date_too" class="form-control datepicker select_filters" value="" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
                  
                  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Sort By </strong></label>
                    <select class="js-example-data-ajax form-control orderby select_filters" id="orderby" name="orderby">
                      <option value="ASC" >Asc Customers</option>
                      <option value="DESC" selected="selected">Desc Customers</option>
                    </select>
                  </div>   
              
                  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Name </strong></label>
                    <input class="form-control select_filters" type="text" name="firstname" id="firstname" value="" placeholder="Search By Name">
                  </div>
				  <div class=" col-md-4 col-xs-6">
            <label class="mtop15"><strong>Email </strong></label>
					  <input class="form-control select_filters" type="text" name="email" id="email" value="" placeholder="Search By Email">          
          </div>
				  <div class=" col-md-4 col-xs-6">
                  
            <label class="mtop15"><strong>Phone Number </strong></label>
					  <input class="form-control select_filters" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Search By Phone Number">          
          </div>
          <div class=" col-md-4 col-xs-6">
                    <label class="mtop15"><strong>City </strong></label>
					<input class="form-control select_filters" type="text" name="city" id="city" value="" placeholder="Search By City">
                    
                  </div>
                </div>
              </div>
			  <br/>
			  <br/>
			  <div class="row">
			  <div class="col-md-12 col-xs-12">
			    <div class="col-md-12 col-xs-12">
			    <div class="pull-left">
					  <input class="btn btn-default export_report_btn" type="submit" name="export_csv_btn" id="export_csv_btn" value="Export As CSV">
				</div>
			    <div class="pull-right">
			      <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
			    </div>
				</div>
			  </div>
			  </div>
               </form>
              <hr />

          <div class="row">

          <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
      			<div class="loader">
      			   <center>
      				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
      			   </center>
      			</div>
            <table class="table table-hover  no-footer dtr-inline collapsed" >
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="font-weight: bold; max-width: 150px;">S.NO</th>
                  <th style="font-weight: bold; max-width: 150px;">C.ID</th>
                  <th style="font-weight: bold; max-width: 150px;">Name</th>
                  <th style="font-weight: bold; max-width: 150px;">Email</th>
                  <th style="font-weight: bold; max-width: 150px;">Phone Number</th>
				          <th style="font-weight: bold; max-width: 80px;">City</th>
                  <th style="font-weight: bold; max-width: 150px;">Royalty</th>
                  <th style="font-weight: bold; max-width: 150px;">Rewards</th>
                  <th style="font-weight: bold; max-width: 150px;">Last Order</th>
                  <th style="font-weight: bold; max-width: 150px;">Orders Last 30 Days</th>
                  <th style="font-weight: bold; max-width: 150px;">Total Orders</th>
                  <th style="font-weight: bold; max-width: 150px;">Verified Email At</th>
                </tr>
              </thead>
              <tbody id="clients_list">
                <?php foreach ($clients as $key => $value) {  ?>
                <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <td><a href="<?php echo AURL;?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id']; ?>"> <?php echo $value['dryvarfoods_id']; ?></a></td>
					         <td><?php echo $value["firstname"];?></td>
					         <td><?php echo $value["email"];?></td>
					         <td><i class="fa fa-phone" style="font-size:20px; color:#148254; ">&nbsp; </i> <?php echo $value["phonenumber"];?></td>
                    <td><?php echo ($value['city']==" " || $value['city']=="") ? "<span >N/A</span>" : substr($value['city'], 0, 15) ;  ?></td>
                    <td><?php echo "<span class='label label-success'>".'0'."</span>";?></td>
                    <td><?php echo "<span class='label label-success'>".'0'."</span>";?></td>
                    <td><?php if($value["last_order"]!=""){ ?> <a href="<?php echo AURL;?>orders/orders_detail/<?php echo $value["last_order"];?>" target="_Blank">#<?php echo $value["last_order"];?></a><?php } else{ ?><span class="label label-danger">N/P</span> <?php } ?></td>
                    <td><?php echo ($value["orders_last_30_days"]==0)?"<span class='label label-primary'>N/O</span>":"<span class='label label-success'>".$value["orders_last_30_days"]."</span>";?></td>
                    <td><?php echo ($value["total_orders"]=="")?"<span class='label label-danger'>N/P</span>":"<span class='label label-success'>".$value["total_orders"]."</span>";?></td>
                    <td><?php echo  date("F j, Y", strtotime($value['email_verified_at'])); ?></td>
				        </tr>
                <?php } ?>
              </tbody>
            </table>
            <span id="response_pagination">
              <?php
              if($page_links !=""){ ?>
                
                  <div class="row_iner">
                      <div id="pagigi">
                          <div id="page_links123"><?php echo $page_links;?></div>
                      </div>
                  </div>
                  <?php
              }
              ?>
            </span>
          </div>
        </div>     
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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
    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/clients_ajax_select/"+post_client,
      dataType: 'json',

      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

  $('#contact_select').select2({

    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/contacts_ajax_select"+post_contact,
      dataType: 'json',
      data: function (params) {
        var query = {
          term: params.term,
          type: '0'
        }
        return query;
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

  $('#driver_select').select2({

    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/contacts_ajax_select"+post_driver,
      dataType: 'json',
      data: function (params) {
        var query = {
          term: params.term,
          type: '2'
        }
        return query;
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

});

  

  $("body").on("click", ".client_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var data = $("#clientsFilter").serialize();
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/referrals_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){
              var res_arr = response.split('***||***');
              $('#clients_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
		      $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("click", "#search_btn", function(){

    var page = 0;
	  var data = $("#clientsFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/referrals_ajax/"+page,
        type: "POST",
        data: data,
		    beforeSend: function(){
			   $('#page_links123').html("");
			   $('#clients_list').html("");
               $('#record_count').html(0);
                     $('.loader').show();
                },
        success: function(response){
          $('.loader').hide();
          var res_arr = response.split('***||***');
		  
		    if(res_arr=='norclients'){
			    $('#page_links123').html('<div class="alert alert-danger" role="alert"> No referrals found !</div>');
			    $('#clients_list').html("");
          $('#record_count').html(0);
			 
		    }else{
        
          $('#clients_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		      $('#page_links123').html(res_arr[2]);
		    }
          
        }
    });   
  });
  
</script>
</body>
</html>
