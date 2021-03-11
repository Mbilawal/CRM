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
#search_btn{
	margin-top:25px;
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
                <h3 class="padding-5 p_style">Dryvarfoods Driver Requests  <span class="pull-right"><a href="<?php echo base_url();?>admin/drivers/export_csv_requests/<?php echo $this->uri->segment(4);?>" target="_blank" class="btn btn-default buttons-collection btn-default-dt-options" type="button" id="csv_download" ><span>Export As CSV</span></a></h4>
              </div>
              <hr class="hr_style" />
              <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Requests</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_requests_count"><?php echo ($requests_count); ?></span>
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Accepted Requests            </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24 total_accepted_requests_count"><?php echo ($requests_count_accepted); ?></span>
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
                          Declined Requests
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_declined_requests_count">
                          <?php echo ($requests_count_declined); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-danger mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Cancelled Requests
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_canceled_requests_count">
                          <?php echo ($requests_count_cancelled); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-info mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-ok"></i>
                          Delivered Requests
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_delivered_requests_count">
                          <?php echo ($requests_count_delivered); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-info no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
                <div class="quick-stats-invoices col-xs-12 col-md-4 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-success mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-ok"></i>
                          Completed Requests
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_completed_requests_count">
                          <?php echo ($requests_count_completed); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
              
			  </div>

              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Requests    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="requestsFilter">
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
                    <select class="js-example-data-ajax form-control request_status select_filters" id="request_status" name="request_status">
                       <option value="" selected="selected">Status</option>
                      <option value="3" >Accepted </option>
                      <option value="2" >Declined </option>
					  <option value="4" >Cancelled </option>
					  <option value="5" >Delivered </option>
					  <option value="6" >Completed </option>
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
                      <option value="ASC" >Asc Requests</option>
                      <option value="DESC" selected="selected">Desc Requests</option>
                    </select>
                  </div>   
              
                   <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Order ID </strong></label>
                    <input class="form-control select_filters" type="text" name="order_id" id="order_id" value="" placeholder="Search By Order ID">
                  </div>
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Pickup Location </strong></label>
                    <input class="form-control select_filters" type="text" name="pickup_location" id="pickup_location" value="" placeholder="Search By Pickup Location">
                  </div>
				  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Drop Location </strong></label>
                    <input class="form-control select_filters" type="text" name="drop_location" id="drop_location" value="" placeholder="Search By Drop Location">
                  </div>
				 
				 </div>
				 
				 <div class="col-md-12 col-xs-12">
				 
				 <div class="col-md-12 col-xs-12">
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
                  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 50px;font-weight: bold;">Order ID</th>
                  <th style="min-width: 120px;font-weight: bold;">Pickup Location</th>
                  <th style="min-width: 120px;font-weight: bold;">Drop Location</th>
				  <th style="min-width: 120px;font-weight: bold;">Duration</th>
				  <th style="min-width: 120px;font-weight: bold;">Estimate Distance</th>
				  <th style="min-width: 120px;font-weight: bold;">Drop Distance</th>
                  <th style="min-width: 120px;font-weight: bold;">Status</th>
                  <th style="min-width: 120px;font-weight: bold;">Created At</th>
                </tr>
              </thead>
              <tbody id="requests_list">

                  <?php foreach ($requests as $key => $value) { 
           
          
           ?>
                  <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <td><a href="<?php echo AURL;?>orders/orders_detail/<?php echo $value['order_id']; ?>"> <?php echo $value['order_id']; ?></a></td>
					<td><?php echo $value["pickup_location"];?></td>
					<td><?php echo $value["drop_location"];?></td>
					<td><?php echo $value["duration"];?></td> 
				   <td><?php echo $value["est_distance"];?>KM</td>
				   <td><?php echo $value["drop_distance"];?>KM</td>
                    <td>
                    <?php if($value['status']==4){ ?>
                    <span class="label label-danger">Cancelled</span>
					<?php } else if($value['status']==2){ ?>
                    <span class="label label-danger">Declined</span>
                     <?php } else if($value['status']==3){ ?>
                    <span class="label label-success">Accepted</span>
                     <?php }else if($value['status']==5){ ?>
                    <span class="label label-info">Delivered</span>
                     <?php }else if($value['status']==6){ ?>
                      <span class="label label-success">Completed</span>
                      <?php } else{ ?>
					  
					  <?php } ?>
                    </td>
                    <td><?php echo date("d-m-Y  h:i A", strtotime($value['created_at'])); ?></td>
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

  $("body").on("click", ".requests_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var data = $("#requestsFilter").serialize();
	
	var driver_id = segments[6];
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>drivers/requests_ajax/"+driver_id+"/"+page,
          type: "POST",
          data: data,
          success: function(response){

              var res_arr = response.split('***||***');

              $('#requests_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("click", "#search_btn", function(){


    var page = 0;
	var segments = window.location.href.split( '/' );
    
	var driver_id = segments[6];
  
	var data = $("#requestsFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>drivers/requests_ajax/"+driver_id+"/"+page,
        type: "POST",
        data: data,
		beforeSend: function(){
			   $('#page_links123').html("");
			   $('#requests_list').html("");
               $('#record_count').html(0);
			   $('.total_requests_count').html(0);
		       $('.total_accepted_requests_count').html(0);
		       $('.total_declined_requests_count').html(0);
			   $('.total_canceled_requests_count').html(0);
			   $('.total_completed_requests_count').html(0);
			   $('.total_delivered_requests_count').html(0);
               $('.loader').show();
        },
        success: function(response){
          $('.loader').hide();
          var res_arr = response.split('***||***');
		  
		  if(res_arr=='norrequests'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No requests found !</div>');
			   $('#requests_list').html("");
               $('#record_count').html(0);
			   $('.total_requests_count').html(0);
		       $('.total_accepted_requests_count').html(0);
		       $('.total_declined_requests_count').html(0);
			   $('.total_canceled_requests_count').html(0);
			   $('.total_completed_requests_count').html(0);
			   $('.total_delivered_requests_count').html(0);
			   
			
		  }else{
        
          $('#requests_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		   $('.total_requests_count').html(res_arr[1]);
		   $('.total_accepted_requests_count').html(res_arr[3]);
		   $('.total_declined_requests_count').html(res_arr[4]);
		   $('.total_canceled_requests_count').html(res_arr[5]);
		   $('.total_completed_requests_count').html(res_arr[7]);
		   $('.total_delivered_requests_count').html(res_arr[6]);
		  
		  }
          

        }
    });   

  });
  
</script>
</body>
</html>
