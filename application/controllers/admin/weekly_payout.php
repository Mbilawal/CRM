<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>"; print_r($weekly_payout); exit;?>
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
                        <h3 class="padding-5 p_style" style="color: #03a9f4;">Weekly Payout Managment</h4>

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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Weeks Payout            </p>
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
                      <a class="text-primary mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Last Week Payout
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24">
                          <?php echo ($orders_count_declined); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                      <a class="text-warning mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-remove"></i>
                          Current Week Payout
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24">
                          <?php echo ($orders_count_declined); ?>
                        </span>
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
              <b><?php echo urldecode($name); ?></b> Restaurants Payouts <span class="pull-right">
              
              </span>
              </h4>
            </div>
           
         
       
         
            <div class="row">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
                <table class="table table-hover  no-footer dtr-inline collapsed" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                      <th style="min-width: 30px;font-weight: bold;">S.No</th>
                      <th style="min-width: 50px;font-weight: bold;"> Name</th>
                      <th style="min-width: 120px;font-weight: bold;"> Amount</th>
                        <th style="min-width: 120px;font-weight: bold;"> Currency</th>
                      <th style="min-width: 120px;font-weight: bold;">City</th>
                      <th style="min-width: 120px;font-weight: bold;">Created At</th>
                     
                    </tr>
                  </thead>
                  <tbody id="order_list">
                    <?php foreach ($weekly_payout as $key => $value) { 
				   
				  $sum  = $value['amount'];
				  $toal +=$sum; 
				   ?>
                    <tr role="row">
                      <td><b><?php echo $key+1; ?></b></td>
                      <td><b><?php echo ($value['name']==" ") ? "<span>N/A</span>" : $value['name']; ?></b></td>
                      <td><b><?php echo $value['amount']; ?></b></td>
                      <td><b><span class="label label-success"></span><?php 	echo $value['currency_code']; ?></b></td>
                       <td><b><?php echo $value['city']; ?></b></td>
                        <td><span class="label label-success"></span><?php echo $value['created_at']; ?> </td>
                        
                    </tr>
                    <?php } ?>
                     <hr class="hr_style" />
                     
                     <tr role="row">
                      <td><b></b></td>
                      <td><bold>Total Amount :</bold></td>
                      <td><bold> R <?php echo   $toal;?></bold></td>
                      <td></td>
                      </tr>
                    
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