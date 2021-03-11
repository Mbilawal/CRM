<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body" style="">
            <div class="clearfix"></div>
            <div class="col-md-12">
              <h3 class="padding-5 p_style">
              Filter Orders <span class="pull-right">
              <div class="dt-buttons btn-group">
                <a href="<?php echo base_url();?>admin/clients/export" class="btn btn-default buttons-collection btn-default-dt-options" type="button" ><span>CSV DOWNLOAD</span></a>
                
              </div>
              </span>
              </h4>
            </div>
            <hr class="hr_style" />
            <div class="row">
              <div class="col-md-12 col-xs-12" style="">
                <div class=" col-md-3 col-xs-6">
                  <label><strong>Select Order Type </strong></label>
                  <select class="js-example-data-ajax form-control order_type" id="order_type">
                    <option value="" selected="selected">Orders Type</option>
                    <option value="completed" >Completed </option>
                    <option value="declined" >Declined </option>
                    <option value="pending" >Pending </option>
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label><strong>Select City </strong></label>
                  <select class="js-example-data-ajax form-control city_name" id="city_name">
                    <option value="" >Select City</option>
                    <option value="Amajuba" >Amajuba</option>
                    <option value="eThekwini" >eThekwini</option>
                    <option value="Harry Gwala" >Harry Gwala</option>
                    <option value="iLembe" >iLembe</option>
                    <option value="Ugu" >Ugu</option>
                    <option value="uMgungundlovu" >uMgungundlovu</option>
                    <option value="UMkhanyakude" >UMkhanyakude</option>
                    <option value="Umzinyathi" >Umzinyathi</option>
                    <option value="uThukela" >uThukela</option>
                    <option value="Kingetshwayo" >King Cetshwayo</option>
                    <option value="Zululand" >Zululand</option>
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label><strong>Select Report </strong></label>
                  <select class="js-example-data-ajax form-control report_type" id="report_type">
                    <option value="" selected="selected">Select Report Type</option>
                    <option value="daily" >Daily Report</option>
                    <option value="weekly" >Weekly Report</option>
                    <option value="monthly" >Monthy Report</option>
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label><strong>Select Month </strong></label>
                  <select name="month" class="js-example-data-ajax form-control">
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
                  <label><strong>Select Date </strong></label>
                  <div class='input-group date' id='datetimepicker1'>
                    <input type="text" id="start_date" name="start_date" class="form-control datepicker" value="2020-07-29" autocomplete="off" aria-invalid="false">
                    <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-xs-12" style="">
                <div class=" col-md-3 col-xs-6">
                  <label class="mtop15"><strong>Sort By </strong></label>
                  <select class="js-example-data-ajax form-control sort" id="sort">
                    <option value="" selected="selected">Asc Orders</option>
                    <option value="1" >Desc Orders</option>
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label class="mtop15"><strong>Select Merchants </strong></label>
                  <select class="js-example-data-ajax form-control select_filters" id="clients_select">
                    <!-- <option value="" selected="selected">Select Client</option>
                  <option value="1" >Select Client</option>
                  <option value="2" >Select Client2</option>
                  <option value="3" >Select Client3</option> -->
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label class="mtop15"><strong>Select Customers </strong></label>
                  <select class="js-example-data-ajax form-control select_filters" id="contact_select">
                    <option value="" >Select Customer</option>
                    <option value="1" >Select Client</option>
                    <option value="2" >Select Client2</option>
                    <option value="3" >Select Client3</option>
                  </select>
                </div>
                <div class=" col-md-3 col-xs-6">
                  <label class="mtop15"><strong>Select Drivers </strong></label>
                  <select class="js-example-data-ajax form-control select_filters" id="driver_select">
                    <option value="" selected="selected">Select Driver</option>
                    <option value="1" >Select Client</option>
                    <option value="2" >Select Client2</option>
                    <option value="3" >Select Client3</option>
                  </select>
                </div>
              </div>
            </div>
            <hr />
            <div class="row mbot15">
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-default mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Orders </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-default no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-success mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Completed Orders </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_completed); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-danger mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-remove"></i> Declined Orders </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_declined); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-warning mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Orders </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_pending); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-primary mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Today Orders </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-6">
                <div class="top_stats_wrapper hrm-minheight85"> <a class="text-primary mbot15">
                  <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Last Week </p>
                  <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count); ?></span> </a>
                  <div class="clearfix"></div>
                  <div class="progress no-margin progress-bar-mini">
                    <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%"> </div>
                  </div>
                </div>
              </div>
            </div>
            <style>
				  
				  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
}
.p_style{
	 color: #03a9f4;
	}
				  
				  </style>
            <div class="col-md-12 col-xs-12 bold p_style" style="">
              <h3> Dryvarfoods Orders Report
                <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div>
              </h3>
            </div>
            <div class="clearfix"></div>
            <hr class="hr_style">
            <div class="row">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
                <table class="table table-hover  no-footer dtr-inline collapsed" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                      <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                      <th style="min-width: 50px;font-weight: bold;">Order ID</th>
                      <th style="min-width: 120px;font-weight: bold;">Customer</th>
                      <th style="min-width: 120px;font-weight: bold;">Resturant</th>
                      <th style="min-width: 120px;font-weight: bold;">Status</th>
                      <th style="min-width: 120px;font-weight: bold;">Time Lapse</th>
                      <th style="min-width: 120px;font-weight: bold;">Total Amout</th>
                      <th style="min-width: 120px;font-weight: bold;">Driver</th>
                      <th style="min-width: 120px;font-weight: bold;">Date</th>
                    </tr>
                  </thead>
                  <tbody id="order_list">
                    <?php foreach ($orders as $key => $value) { 
				   
				  
				   ?>
                    <tr role="row">
                      <td><?php echo $key+1; ?></td>
                      <td><a href="https://crm.dryvarfoods.com/admin/clients/orders_detail/<?php echo $value['ID']; ?>"> <?php echo $value['ID']; ?></a></td>
                      <td><?php echo ($value['customer_name']==" " || $value['customer_name']==NULL || $value['customer_name']=="" || empty($value['customer_name'])) ?  "<span style=''>N/A</span>" : $value['customer_name']  ; ?></td>
                      <td><?php echo ($value['company_name']==" ") ? "<span style='color:red'>N/A</span>" : $value['company_name'];  ?></td>
                      <td><?php if($value['status']=='Pending'){ ?>
                        <span class="label label-primary">Pending</span>
                        <?php }else if($value['status']=='Completed'){ ?>
                        <span class="label label-success">Completed</span>
                        <?php }else if($value['status']=='Declined'){ ?>
                        <span class="label label-danger">Declined</span>
                        <?php }?></td>
                      <td><?php echo $value['time_ago']; ?></td>
                      <td><?php echo $value['total_amont']; ?></td>
                      <td><?php echo ($value['driver_name']==" ") ? "<span>N/A</span>" : $value['driver_name']; ?></td>
                      <td><?php echo $value['dated']; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <span id="response_pagination">
                <?php
              if($page_links !=""){ ?>
                <div class="row_iner">
                  <div id="pagigi">
                    <div id="page_links"><?php echo $page_links;?></div>
                  </div>
                </div>
                <?php
              }
              ?>
                </span> </div>
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

  

  $("body").on("click", ".order_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

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

    //var orderby = $("#orderby").val();
    //var order = $("#order").val();
   
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
          type: "POST",
          data: {client:client,driver:driver,contact:contact},
          success: function(response){

              var res_arr = response.split('***||***');

              $('#order_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links').html(res_arr[2]);

          }
      });
    }    

  });

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

    //var orderby = $("#orderby").val();
    //var order = $("#order").val();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
        type: "POST",
        data: {client:client,driver:driver,contact:contact},
        success: function(response){

            var res_arr = response.split('***||***');

            $('#order_list').html(res_arr[0]);
            $('#record_count').html(res_arr[1]);
            $('#page_links').html(res_arr[2]);

        }
    });   

  });

</script>
</body></html>