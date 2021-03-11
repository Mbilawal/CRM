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
          <div class="panel-body" style="overflow-x: scroll;">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Drivers  <span class="pull-right"><a href="<?php echo base_url();?>admin/drivers/export_csv" target="_blank" class="btn btn-default buttons-collection btn-default-dt-options" type="button" id="csv_download" ><span>Export As CSV</span></a></h4>
              </div>
              <hr class="hr_style" />
              <div class="row mbot15">
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
              </div>

              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Drivers    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="driversFilter">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
				  <div class="col-md-12 col-xs-12">
				  <?php
					if ($this->session->flashdata('err_message')) {
				     ?>
					 <div class="alert alert-danger">
					  <?php echo $this->session->flashdata('err_message'); ?>
					 </div>
				     <?php
				     }?>
				  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label><strong>Select Status </strong></label>
                    <select class="js-example-data-ajax form-control driver_status select_filters" id="driver_status" name="driver_status">
                       <option value="" selected="selected">Status</option>
                      <option value="1" >Active </option>
                      <option value="0" >Inactive </option>
                    </select>
                  </div>
                  <div class=" col-md-3 col-xs-6">
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
                  <div class='col-sm-3'>
                    <label><strong>Date From</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class='col-sm-3'>
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

                  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Sort By </strong></label>
                    <select class="js-example-data-ajax form-control orderby select_filters" id="orderby" name="orderby">
                      <option value="ASC" >Asc Drivers</option>
                      <option value="DESC" selected="selected">Desc Drivers</option>
                    </select>
                  </div>   
              
                  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Name </strong></label>
                    <input class="form-control select_filters" type="text" name="firstname" id="firstname" value="" placeholder="Search By Name">
                  </div>
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Email </strong></label>
					<input class="form-control select_filters" type="text" name="email" id="email" value="" placeholder="Search By Email">
                    
                  </div>
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Phone Number </strong></label>
					<input class="form-control select_filters" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Search By Phone Number">
                    
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>City </strong></label>
					<input class="form-control select_filters" type="text" name="city" id="city" value="" placeholder="Search By City">
                    
                  </div>
				  <div class="col-md-3 col-xs-6">
				  <label class="mtop15"><strong>Tip </strong></label>
				    <div class="filter_price">
                             <div id="tip_filter" data-min="0" data-max="5000" data-min-value="0" data-max-value="0" data-price-sign="R"></div>
                             <div class="price_range">
                                 <span>Price: <span id="tip_price"></span></span>
                                 <input type="hidden" id="tip_first" name="tip_first" value="0">
                                 <input type="hidden" id="tip_second" name="tip_second" value="0">
                             </div>
                     </div>
				  </div>
				  <div class="col-md-3 col-xs-6">
				  <label class="mtop15"><strong>Delivery Fee </strong></label>
				    <div class="filter_price">
                             <div id="delivery_fee_filter" data-min="0" data-max="5000" data-min-value="0" data-max-value="0" data-price-sign="R"></div>
                             <div class="price_range">
                                 <span>Price: <span id="delivery_fee_price"></span></span>
                                 <input type="hidden" id="delivery_fee_first" name="delivery_fee_first"  value="0">
                                 <input type="hidden" id="delivery_fee_second" name="delivery_fee_second"  value="0">
                             </div>
                     </div>
				  </div>
				  <div class="col-md-3 col-xs-6">
				  <label class="mtop15"><strong>Estimate Distance </strong></label>
				    <div class="filter_price">
                             <div id="estimate_distance_filter" data-min="0" data-max="5000" data-min-value="0" data-max-value="0" data-price-sign="KM"></div>
                             <div class="price_range">
                                 <span>Distance: <span id="estimate_distance"></span></span>
                                 <input type="hidden" id="estimate_distance_first" name="estimate_distance_first" value="0">
                                 <input type="hidden" id="estimate_distance_second" name="estimate_distance_second" value="0">
                             </div>
                     </div>
				  </div>
				  <div class="col-md-3 col-xs-6">
				  <label class="mtop15"><strong>Drop Distance </strong></label>
				    <div class="filter_price">
                             <div id="drop_distance_filter" data-min="0" data-max="5000" data-min-value="0" data-max-value="0" data-price-sign="KM"></div>
                             <div class="price_range">
                                 <span>Distance: <span id="drop_distance"></span></span>
                                 <input type="hidden" id="drop_distance_first" name="drop_distance_first" value="0">
                                 <input type="hidden" id="drop_distance_second" name="drop_distance_second" value="0">
                             </div>
                     </div>
				  </div>
                </div>
              </div>
			  <div class="row">
			  <div class="col-md-12 col-xs-12">
			    <div class="pull-right">
			      <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
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
                  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 50px;font-weight: bold;">Driver ID</th>
                  <th style="min-width: 120px;font-weight: bold;">Name</th>
                  <th style="min-width: 120px;font-weight: bold;">Email</th>
                  <th style="min-width: 80px;font-weight: bold;">Phone Number</th>
				  <th style="min-width: 80px;font-weight: bold;">City</th>
                  <th style="min-width: 120px;font-weight: bold;">Last Order</th>
                  <th style="min-width: 120px;font-weight: bold;">Orders Last 30 Days</th>
                  <th style="min-width: 120px;font-weight: bold;">Total Orders</th>
				  <th style="min-width: 120px;font-weight: bold;">Total Tip</th>
				  <th style="min-width: 120px;font-weight: bold;">Total Delivery Fee</th>
				  <th style="min-width: 120px;font-weight: bold;">Total Estimate Distance</th>
				  <th style="min-width: 120px;font-weight: bold;">Total Drop Distance</th>
                  <th style="min-width: 120px;font-weight: bold;">Status</th>
                  <th style="min-width: 120px;font-weight: bold;">Verified Email At</th>
				  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="drivers_list">

                  <?php foreach ($drivers as $key => $value) { 
           
          
           ?>
                  <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <td><a href="<?php echo AURL;?>drivers/detail/<?php echo $value['id']; ?>"> <?php echo $value['id']; ?></a></td>
					<td><?php echo $value["firstname"];?></td>
					<td><?php echo $value["email"];?></td>
					<td><?php echo $value["phonenumber"];?></td>
                    <td><?php echo ($value['city']==" " || $value['city']=="") ? "<span >N/A</span>" : $value['city'];  ?></td>
                    <td><?php if($value["last_order"]!=""){ ?> <a href="<?php echo AURL;?>orders/orders_detail/<?php echo $value["last_order"];?>" target="_Blank">#<?php echo $value["last_order"];?></a><?php } ?></td>
                    <td><?php echo $value["orders_last_30_days"];?></td>
                    <td><?php echo $value["total_orders"];?></td>
                   <td><?php echo number_format($value['total_tip'], 2, ".", ",");?></td> 
				   <td><?php echo number_format($value['total_delivery_fee'], 2, ".", ",");?></td> 
				   <td><?php echo $value["total_estimate_distance"];?></td>
				   <td><?php echo $value["total_drop_distance"];?></td>
                    <td>
                    <?php if($value['active']==1){ ?>
                    <span class="label label-success">Active</span>
                     <?php }else{ ?>
                      <span class="label label-danger">Inactive</span>
                      <?php }?>
                    </td>
                    <td><?php echo date("d-m-Y  h:i A", strtotime($value['email_verified_at'])); ?></td>
					<td><a href="<?php echo AURL;?>drivers/requests/<?php echo $value["id"];?>"><i class="fa fa-cab"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo AURL;?>drivers/bank_details/<?php echo $value["id"];?>"><i class="fa fa-credit-card"></i></a></td>
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
$('#tip_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#tip_price" ).html( c + ui.values[ 0 ] + " - " + c + ui.values[ 1 ] );
				$( "#tip_first" ).val(ui.values[ 0 ]);
				$( "#tip_second" ).val(ui.values[ 1 ]);
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});
	
$('#delivery_fee_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#delivery_fee_price" ).html( c + ui.values[ 0 ] + " - " + c + ui.values[ 1 ] );
				$( "#delivery_fee_first" ).val(ui.values[ 0 ]);
				$( "#delivery_fee_second" ).val(ui.values[ 1 ]);
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});

$('#estimate_distance_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#estimate_distance" ).html( ui.values[ 0 ] + c + " - " + ui.values[ 1 ] + c );
				$( "#estimate_distance_first" ).val(ui.values[ 0 ]);
				$( "#estimate_distance_second" ).val(ui.values[ 1 ]);
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});

$('#drop_distance_filter').each( function() {
		var $filter_selector = $(this);
		var a = $filter_selector.data("min-value");
		var b = $filter_selector.data("max-value");
		var c = $filter_selector.data("price-sign");
		$filter_selector.slider({
			range: true,
			min: $filter_selector.data("min"),
			max: $filter_selector.data("max"),
			values: [ a, b ],
			slide: function( event, ui ) {
				$( "#drop_distance" ).html( ui.values[ 0 ]+ c + " - " + ui.values[ 1 ] + c );
				$( "#drop_distance_first" ).val(ui.values[ 0 ]);
				$( "#drop_distance_second" ).val(ui.values[ 1 ]);
			}
		});
		$( "#flt_price" ).html( c + $filter_selector.slider( "values", 0 ) + " - " + c + $filter_selector.slider( "values", 1 ) );
	});

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

  

  $("body").on("click", ".driver_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var data = $("#driversFilter").serialize();
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>drivers/drivers_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){

              var res_arr = response.split('***||***');

              $('#drivers_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("click", "#search_btn", function(){


    var page = 0;
  
	var data = $("#driversFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>drivers/drivers_ajax/"+page,
        type: "POST",
        data: data,
		beforeSend: function(){
			   $('#page_links123').html("");
			   $('#drivers_list').html("");
               $('#record_count').html(0);
			   $('.total_drivers_count').html(0);
		       $('.total_active_drivers_count').html(0);
		       $('.total_inactive_drivers_count').html(0);
                     $('.loader').show();
                },
        success: function(response){
          $('.loader').hide();
          var res_arr = response.split('***||***');
		  
		  if(res_arr=='nordrivers'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No drivers found !</div>');
			   $('#drivers_list').html("");
               $('#record_count').html(0);
			   $('.total_drivers_count').html(0);
		       $('.total_active_drivers_count').html(0);
		       $('.total_inactive_drivers_count').html(0);
			   
			
		  }else{
        
          $('#drivers_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		   $('.total_drivers_count').html(res_arr[1]);
		   $('.total_active_drivers_count').html(res_arr[3]);
		   $('.total_inactive_drivers_count').html(res_arr[4]);
		  
		  }
          

        }
    });   

  });
  
</script>
</body>
</html>
