<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
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
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Piad Amount             </p>
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Complete Payout            </p>
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
                          Need to Pay
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Payment           </p>
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

                  </div>
            
         
         <div class="col-md-12">
              <h3 class="padding-5 p_style">
              Filter Payouts <span class="pull-right">
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
                
                <div class='col-sm-3'>
                  <label><strong>From Date </strong></label>
                  <div class='input-group date' id='datetimepicker1'>
                    <input type="text" id="start_date" name="start_date" class="form-control datepicker" value="2020-07-29" autocomplete="off" aria-invalid="false">
                    <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                </div>
                
                <div class='col-sm-3'>
                  <label><strong>To Date </strong></label>
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
                
              </div>
            </div>
       
         
            <div class="row">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
                <table class="table table-hover  no-footer dtr-inline collapsed" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                      <th style="min-width: 30px;font-weight: bold;">ID</th>
                      <th style="min-width: 50px;font-weight: bold;"> Name</th>
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
                      <td><b><?php echo $value['driver_id']; ?></b></td>
                      <td><b><?php echo ($value['driver_name']==" ") ? "<span>N/A</span>" : $value['driver_name']; ?></b></td>
                      <td><b><?php echo $value['total_orders']; ?></b></td>
                      <td><b><?php echo $value['total_revenue']; ?></b></td>
                        <td><span class="label label-success">Paid</span><?php //echo $value['total_revenue']; ?> </td>
                        <td>
    <a href="https://crm.dryvarfoods.com/admin/clients/resturant_payout" class="btn btn-primary btn-icon" data-toggle="tooltip" title="" data-original-title="Restaurant Payout">
    <i class="fa fa-eye"></i>
    </a>
    <a href="https://crm.dryvarfoods.com/admin/clients/resturant_weekly_payout" class="btn btn-success btn-icon" data-toggle="tooltip" title="" data-original-title="Weekly Payout"><i class="fa fa-external-link"></i></a></td>
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

</body></html>