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
  .error{
	color:red;  
  }
</style>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Manual Orders Report  <span class="pull-right"><a href="<?php echo base_url();?>admin/orders/export_csv" target="_blank" class="btn btn-default buttons-collection btn-default-dt-options" type="button" id="csv_download" ><span>CSV DOWNLOAD</span></a></h4>
              </div>
              <hr class="hr_style" />
              <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Orders             </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count); ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-default no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-success mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Completed Orders            </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_completed); ?></span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-danger mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Declined Orders
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24">
                          <?php echo ($orders_count_declined); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-warning mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Orders           </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_pending); ?></span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
              </div>

              <div class="col-md-12 col-xs-12 bold p_style" style="">
                <h3> Filter Manual Orders 
                  <div  class="pull-right" style="float:right">
                    <small class="primary" style="color:darkgreen">Showing 25 of 
                      <span id="record_count"  ><?php echo $total_count?></span>
                    </small>
                  </div>
                </h3> 
              </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="FilterOrdersForm" action="<?php echo admin_url();?>invoices/invoice" method="post">
			  <input type="hidden" id="client_id" name="client_id" value="0">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
                  <div class=" col-md-3 col-xs-6">
                    <label><strong>Select Order Type </strong></label>
                    <select class="js-example-data-ajax form-control order_type select_filters1" id="order_type">
                      <option value="" selected="selected">Orders Type</option>
                      <option value="0">In Cart </option>
                      <option value="1" >Pending </option>
                      <option value="2" >Declined </option>
                      <option value="3" >Accepted </option>
                      <option value="4" >Cancelled </option>
                      <option value="5" >Delivery </option>
                      <option value="6" >Completed </option>
                      <option value="7" >Expired </option>
                    </select>
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label><strong>Select Month </strong></label>
                    <select name="month" id="month" class="js-example-data-ajax form-control select_filters1">
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
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters1" value="" placeholder="From Date" autocomplete="off" aria-invalid="false" required="true">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
					<div class="date_from_error"></div>
                  </div>
                  <div class='col-sm-3'>
                    <label><strong>Date To</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" id="date_too" placeholder="To Date" name="date_too" class="form-control datepicker select_filters1" value="" autocomplete="off" aria-invalid="false" required="true">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
					<div class="date_to_error"></div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Sort By </strong></label>
                    <select class="js-example-data-ajax form-control sort select_filters1" id="sort">
                      <option value="ASC" >Asc Orders</option>
                      <option value="DESC" selected="selected">Desc Orders</option>
                    </select>
                  </div>   
              
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Select Merchants </strong></label>
                    <select class="js-example-data-ajax form-control select_filters1" id="clients_select" name="clients_select" required="true">
                      <!-- <option value="" selected="selected">Select Client</option>
                      <option value="1" >Select Client</option>
                      <option value="2" >Select Client2</option>
                      <option value="3" >Select Client3</option> -->
                    </select>
					<div class="merchant_error"></div>
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Select Customers </strong></label>
                    <select class="js-example-data-ajax form-control select_filters1" id="contact_select">
                      <option value="" >Select Customer</option>
                      <option value="1" >Select Client</option>
                      <option value="2" >Select Client2</option>
                      <option value="3" >Select Client3</option>
                    </select>
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>Select Drivers </strong></label>
                    <select class="js-example-data-ajax form-control select_filters1" id="driver_select">
                      <option value="" selected="selected">Select Driver</option>
                      <option value="1" >Select Client</option>
                      <option value="2" >Select Client2</option>
                      <option value="3" >Select Client3</option>
                    </select>
                  </div>
                </div>
              </div>

              <hr />
         <div class="row">
		    <div class="col-md-12">
		    <div class="col-md-12">
		    <input type="submit" class="btn btn-info mbot15" value="Create New Invoice" style="float: right;">
			</div>
			</div>
		 </div>
          </form>
		  
		  <div class="row">
            <!--<a href="<?php echo admin_url();?>invoices/invoice?customer_id=" id="new_invoice_link" style="float: right;" class="btn btn-info mbot15">Create New Invoice</a>-->
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
            <table class="table table-hover  no-footer dtr-inline collapsed" >
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 50px;font-weight: bold;">Order ID</th>
                  <th style="min-width: 120px;font-weight: bold;">Customer</th>
                  <th style="min-width: 120px;font-weight: bold;">Resturant</th>
                  <th style="min-width: 80px;font-weight: bold;">Suburb</th>
                  <th style="min-width: 120px;font-weight: bold;">Status</th>
                  <th style="min-width: 120px;font-weight: bold;">Time Lapse</th>
                  <th style="min-width: 120px;font-weight: bold;">Total Amout</th>
                  <!--<th style="min-width: 120px;font-weight: bold;">Our Fee</th>-->
                  <th style="min-width: 120px;font-weight: bold;">Driver</th>
                  <th style="min-width: 120px;font-weight: bold;">Date</th>
                  <th style="min-width: 50px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="order_list">
                <?php foreach ($orders as $key => $value) { ?>
                  <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <td><a href="<?php echo AURL;?>orders/orders_detail/<?php echo $value['ID']; ?>"> <?php echo $value['ID']; ?></a></td>
                    <td><?php echo ($value['customer_name']==" " || $value['customer_name']==NULL || $value['customer_name']=="" || empty($value['customer_name'])) ?  "<span style=''>N/A</span>" : $value['customer_name']  ; ?></td>
                    <td><?php echo ($value['company_name']==" ") ? "<span style='color:red'>N/A</span>" : $value['company_name'];  ?></td>
                    <td><?php echo ($value['city']==" " || $value['city']=="") ? "<span >N/A</span>" : $value['city'];  ?></td>    
                    <td>
                      <?php if($value['status']=='InCart'){ ?>
                      <span class="label label-default">In Cart</span>
                      <?php }else if($value['status']=='Pending'){ ?>
                      <span class="label label-info">Pending</span>
                      <?php }else if($value['status']=='Declined'){ ?>
                      <span class="label label-danger">Declined</span>  
                      <?php }else if($value['status']=='Accepted'){ ?>
                      <span class="label label-primary">Accepted</span>
                      <?php }else if($value['status']=='Cancelled'){ ?>
                      <span class="label label-danger">Cancelled</span>
                      <?php }else if($value['status']=='Delivery'){ ?>
                      <span class="label label-warning">Delivery</span>
                       <?php }else if($value['status']=='Completed'){ ?>
                      <span class="label label-success">Completed</span>
                      <?php }else if($value['status']=='Expired'){ ?>
                      <span class="label label-danger">Expired</span>
                      <?php }else{ echo $value['status'];?>
                      <?php }?>
                    </td>
                    <td><?php echo time_elapsed_string($value['dated']);?></td>
                    <td><?php echo $value['total_amont']; ?></td>
                    <td><?php echo ($value['driver_name']==" ") ? "<span>N/A</span>" : $value['driver_name']; ?></td>
                    <td><?php echo date("F j, Y, g:i a", strtotime($value['dated']));?></td>
                     <td><a href="<?php echo AURL;?>clients/orders_detail/<?php echo $value['ID']; ?>"class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  <?php } ?>
                  <?php if(count($orders)<0 ){?>
                    <div class="alert alert-danger" role="alert">
                      0ops! No manual order found 
                    </div>
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
<script>
$(document).ready(function(e) {
  $("#FilterOrdersForm").validate({
	  errorPlacement: function(error, element) {
            if (element.attr("name") == 'date_from') {
                error.appendTo(".date_from_error");
            }
			else if (element.attr("name") == 'date_too') {
                error.appendTo(".date_to_error");
            }
			else if (element.attr("name") == 'clients_select') {
                error.appendTo(".merchant_error");
            }
            else {
                error.insertAfter(element);
            }
        }
  });
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
      url: "<?php echo admin_url(); ?>orders/clients_ajax_select/"+post_client,
      dataType: 'json',

      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

  $('#contact_select').select2({

    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>orders/contacts_ajax_select"+post_contact,
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
      url: "<?php echo admin_url(); ?>orders/contacts_ajax_select"+post_driver,
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

  

  $("body").on("click", ".order_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    if( filter_type == 'client'){
      var client = segments[7];
    }else{
      var client = $('#clients_select').val(); 
    }


    if( filter_type == 'driver'){ var driver  = segments[7];}
    else { var driver   = $('#driver_select').val(); }

    if( filter_type == 'contact'){ var contact  = segments[7];}
    else { var contact  = $('#contact_select').val(); }

    var client_user_id = '';
    
    if(client != ""){
      
      $.ajax({
          url: "<?php echo admin_url(); ?>orders/get_client_user_id",
          type: "POST",
          data: {client:client},
          success: function(response){
            client_user_id = response;
          }
      });
    }

    var orderby     = $("#sort").val();
    var date_from   = $("#date_from").val();
    var date_too    = $("#date_too").val();
    var month       = $("#month").val();
    var order_type  = $("#order_type").val();
    
    var url_append = "<?php echo admin_url(); ?>invoices/invoice?customer_id="+client_user_id+"&date_from"+date_from+"&date_to"+date_too+"&order_type"+order_type+"";

    //$('#new_invoice_link').attr('href', url_append);
	$('#FilterOrdersForm').attr('action', url_append);
	
	$("#client_id").val(client_user_id);

    if($(this).data("ci-pagination-page")){

      if(client != ""){
      
        $.ajax({
            url: "<?php echo admin_url(); ?>orders/get_client_user_id",
            type: "POST",
            data: {client:client},
            success: function(response){
              var url_append = "<?php echo admin_url(); ?>invoices/invoice?customer_id="+response+"&date_from="+date_from+"&date_to="+date_too+"&order_type=manual";

              //$('#new_invoice_link').attr('href', url_append);
			  $('#FilterOrdersForm').attr('action', url_append);            }
        });
      }

      $.ajax({
          url: "<?php echo admin_url(); ?>orders/orders_manual_ajax/"+page,
          type: "POST",
          data: {client:client,driver:driver,contact:contact,orderby:orderby,date_from:date_from,date_too:date_too,month:month,order_type:order_type},
          success: function(response){

              var res_arr = response.split('***||***');

              $('#order_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("change", ".select_filters1", function(){


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
    var client_user_id = '';
    
    if(client != ""){
      
      $.ajax({
          url: "<?php echo admin_url(); ?>orders/get_client_user_id",
          type: "POST",
          data: {client:client},
          success: function(response){
            var url_append = "<?php echo admin_url(); ?>invoices/invoice?customer_id="+response+"&date_from="+date_from+"&date_to="+date_too+"&order_type=manual";

            //$('#new_invoice_link').attr('href', url_append);
			$('#FilterOrdersForm').attr('action', url_append);          }
      });
    }

    $.ajax({
        url: "<?php echo admin_url(); ?>orders/orders_manual_ajax/"+page,
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
</body>
</html>
