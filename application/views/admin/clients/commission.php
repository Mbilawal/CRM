<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($commission); exit;?>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />

<style>

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

.highcharts-credits{
  display:none!important;
}
.hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
}
</style>

<?php
foreach($commission as $totalcommision){
   $sumTotalAmount  += $totalcommision['total_revenue'];
}


 ?>


<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="clearfix"></div>
            
            
            
            <div class="row mbot15">
                     <div class="col-md-12">
                        <h3 class="padding-5 p_style" style="color: #03a9f4;">Restaurant Payout Managment</h4>

                     </div>
                     <hr class="hr_style" />

                    <div class="row mbot15">
                    <div class="col-md-12">
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Piad Amount             </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo number_format((float)$sumTotalAmount, 2, '.', '').' R'; ?></span>
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Complete Payout            </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo number_format((float)$sumTotalAmount, 2, '.', '').' R'; ?></span>
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
                          <i class="hidden-sm glyphicon glyphicon-edit"></i>
                          Need to Pay
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24">
                          <?php echo 0; ?> R
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Payment           </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo 0 ?> R</span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
              </div>

                  </div>
            
         
         <div class="col-md-12">
              <h3 class="padding-5 p_style">
              Filter Payouts 
              </h3>
            </div>
            <hr class="hr_style" />
            <div class="row">
              <div class="col-md-12 col-xs-12" style="">
            
       
         
            <div class="row">
              <div class=" col-md-12 col-xs-12">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
                <table class="table table-hover  no-footer dtr-inline collapsed" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                     
                      <th style="min-width: 30px;font-weight: bold;">S.No</th>
                      <th style="min-width: 30px;font-weight: bold;">ID</th>
                      <th style="min-width: 50px;font-weight: bold;"> Name</th>
                       <th style="min-width: 50px;font-weight: bold;"> Total Orders</th>
                      <th style="min-width: 120px;font-weight: bold;">Total Earnings</th>
                      <th style="min-width: 120px;font-weight: bold;">Total Paid</th>
                      <th style="min-width: 120px;font-weight: bold;">Status</th>
                      <th style="min-width: 120px;font-weight: bold;">Action</th>
                    </tr>
                  </thead>
                  <tbody id="order_list">
                    <?php foreach ($commission as $key => $value) { 
				   
				  
				   ?>
                    <tr role="row">
                     
                      <td><b><?php echo $key+1; ?></b></td>
                      <td><b><?php echo $value['user_id']; ?></b></td>
                      <td><b><?php echo ($value['name']==" " || $value['name']=="") ? "<span>N/A</span>" : $value['name']; ?></b></td>
                      <td><b><span class="label label-primary"><?php echo $value['total_orders']; ?></span> </b></td>
                       <td><b><?php echo  number_format((float)$value['total_revenue'], 2, '.', ''); ?> R</b></td>
                      
                       <td><b><?php echo number_format((float)$value['total_revenue'], 2, '.', ''); ?> R</b></td>
                     
                        <td><span class="label label-success">Paid</span><?php //echo $value['total_revenue']; ?> </td>
                        <td>
    <a href="https://crm.dryvarfoods.com/admin/clients/orders/client/<?php echo $value['user_id']; ?>" class="btn btn-primary btn-icon" data-toggle="tooltip" title="" data-original-title="Restaurant Orders Payout">
    <i class="fa fa-external-link"></i>
    </a>
    <a href="https://crm.dryvarfoods.com/admin/clients/weekly_payout/<?php echo ($value['name']); ?>" class="btn btn-success btn-icon" data-toggle="tooltip" title="" data-original-title="Weekly Payout"><i class="fa fa-external-link"></i></a></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
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

    var orderby = $("#sort").val();
    var date_from = $("#start_date").val();
    var date_too = $("#end_date").val();
    var month = $("#month").val();
    var order_type = $("#order_type").val();
	
	
   
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
          type: "POST",
          data: {client:client,driver:driver,contact:contact,orderby:orderby,date_from:date_from,date_too:date_too,month:month,order_type:order_type},
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

    var orderby = $("#sort").val();
    var date_from = $("#start_date").val();
    var date_too = $("#end_date").val();
    var month = $("#month").val();
    var order_type = $("#order_type").val();
  
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/payout_ajax/"+page,
        type: "POST",
        data: {client:client,driver:driver,contact:contact,orderby:orderby,date_from:date_from,date_too:date_too,month:month,order_type:order_type},
        success: function(response){

            var res_arr = response.split('***||***');

            $('#order_list').html(res_arr[0]);
            $('#record_count').html(res_arr[1]);
            $('#page_links').html(res_arr[2]);

        }
    });   

  });

</script>
</body>
</html>
