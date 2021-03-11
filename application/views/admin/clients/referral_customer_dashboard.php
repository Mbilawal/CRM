<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($get_graph_clients); exit;?>
<?php init_head();?>

<?php ini_set("memory_limit","512M"); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />


<style>
  .highcharts-figure, .highcharts-data-table table {
    /*min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;*/
  }
  #container {
    height: 400px;
  }
  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
   /* max-width: 1200px;*/
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
  #container2 {
  min-width: 310px;
  max-width: 1200px;
  height: 400px;
  margin: 0 auto
  }
  .buttons {
  min-width: 310px;
  text-align: center;
  margin-bottom: 1.5rem;
  font-size: 0;
  }
  .buttons button {
  cursor: pointer;
  border: 1px solid silver;
  border-right-width: 0;
  background-color: #f8f8f8;
  font-size: 1rem;
  padding: 0.5rem;
  outline: none;
  transition-duration: 0.3s;
  }
  .buttons button:first-child {
  border-top-left-radius: 0.3em;
  border-bottom-left-radius: 0.3em;
  }
  .buttons button:last-child {
  border-top-right-radius: 0.3em;
  border-bottom-right-radius: 0.3em;
  border-right-width: 1px;
  }
  .buttons button:hover {
  color: white;
  background-color: rgb(158, 159, 163);
  outline: none;
  }
  .buttons button.active {
  background-color: #0051B4;
  color: white;
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
}
.highcharts-drilldown-axis-label{
	text-decoration:none!important;
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
                <h3 class="padding-5" style="color: #03a9f4;">
                  Customers Dashboard 
                  <span style="float: right;width: 30%">

                    <form id="myForm" class="col-md-12 col-xs-12" style="float: right;width: 100%" action="<?php echo admin_url().'clients/referrals_dashboard';?>" method="get" >
                      <div class=" col-md-12 col-xs-12">
                        <select class="js-example-data-ajax form-control city_name" name="city">
                          <option value="" >All Cities</option>
                          <?php foreach( $cities as $key => $value){ ?>

                            <option value="<?php echo $value['city_name'];?>" ><?php echo $value['city_name'];?></option>

                          <?php } ?>
                          
                        </select>
                      </div>

                      <!-- <div class='col-md-3 col-xs-3'>

                        <label><strong>. </strong></label><br />
                        <input type="submit" name="submit" id="submit" style="padding: 4px 12px;font-size: 12px;" value="Search" class=" btn btn-success buttons-collection btn-default-dt-options"  />
                       
                         
                      </div> -->
                    </form>
                  </span>
                </h3>
                <hr class="hr_style">
              </div>
              
              
              

             

              <hr />
              
              <div class="col-md-12">
              
              
              <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-user"></i> Total Customers             </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo $stats['total_customers']; ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_customers']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                
                 <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-success mbot15">
                     <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-user"></i> Active Customers            </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo $stats['active_customers']; ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['active_customers']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                
                 <!--<div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-danger mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-user"></i> Inactive Customers           </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo $stats['inactive_customers']; ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['active_customers']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>-->
                
                
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-info mbot15">
                     <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Orders</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo $stats['total_orders']; ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-info no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                  
                  <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-primary mbot15">
                     <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-edit"></i> Average Order</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24">R <?php echo $stats['average_amount']; ?> </span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
              
                 
                </div>
                <div class="col-md-12">
                  <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                    <div class="top_stats_wrapper ">
                       <a class="text-success mbot15">
                       <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Revenue</p>
                          <span class="pull-right bold no-mtop hrm-fontsize24">R <?php echo $stats['total_amount']; ?> </span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                  </div>
                  <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                    <div class="top_stats_wrapper ">
                       <a class="text-success mbot15">
                       <p class="text-uppercase mtop5"><i class="hidden-sm glyphicon glyphicon-edit"></i> Completed Revenue</p>
                          <span class="pull-right bold no-mtop hrm-fontsize24">R <?php echo $stats['total_amount_c']; ?> </span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                  </div>
                  <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                    <div class="top_stats_wrapper ">
                       <a class="text-danger mbot15">
                       <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-remove"></i> Declined Revenue</p>
                          <span class="pull-right bold no-mtop hrm-fontsize24"> R <?php echo $stats['total_amount_d']; ?></span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                  </div>
                  <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-2">
                    <div class="top_stats_wrapper ">
                       <a class="text-warning mbot15">
                       <p class="text-uppercase mtop5 "><i class="hidden-sm glyphicon glyphicon-edit"></i> Pending Revenue</p>
                          <span class="pull-right bold no-mtop hrm-fontsize24">R <?php echo $stats['total_amount_p']; ?> </span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                  </div>
                </div>

                
              </div>
            </div>
       
            
            <div class="">
              <div class="">
                <div class="panel-body padding-10" >
                  
                  <h3 class="padding-5" style="color: #03a9f4;">Top 10 Customers</h3>
                  <hr class="hr_style">
                  <hr class="hr-panel-heading-dashboard">
                  <div class="text-center padding-5">
                    
                    <figure class="highcharts-figure">
                      <div id="container2"></div>
                      <p class="highcharts-description">
                      </p>
                    </figure>
                  </div>
                </div>
              </div>
            </div>

            <div class="">
              <div class="">
                <div class="panel-body " >
                  
                  <h3 class="padding-5" style="color: #03a9f4;">Top 10 Customer Favorites</h3>
                  <hr class="hr_style">
                  <hr class="hr-panel-heading-dashboard">
                  <div class="text-center padding-5">
                    
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                      <p class="highcharts-description">
                      </p>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
           
           
              <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" style="    min-height: 352px;">
                  <h3 class="padding-5" style="color: #03a9f4;">Customer Insights</h3>
                  <hr class="hr_style">
                  <hr class="hr-panel-heading-dashboard">
                  <div class="text-center padding-5">
                    <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="min-height: 352px;max-height: 352px;overflow-y: scroll;">
                            
                            <h3 class="padding-5 text-success">First Time Ordering</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-5">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                      <th class="wd-lg-25p" style="text-align: center;">S.No</th>
                                      <th class="wd-lg-25p">Name</th>
                                      <th class="wd-lg-25p " style="text-align: center;">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                    <?php foreach($first_purchased as $key => $value){ ?>
                                    
                                      <tr >
                                        <td class="wd-lg-25p "><?php echo $key+1; ?></td>
                                        
                                        <td class="wd-lg-25p pull-left"><a href="<?php echo admin_url()?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id'] ?>" target="_blank" ><?php echo ucfirst($value['customer_name'])?> </a></td>
                                        <td class="wd-lg-25p "><?php echo date('jS \of F',strtotime($value['datecreated']))?></td>
                                      </tr>
                                    <?php }?>
                                 
                                  </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="min-height: 352px;max-height: 352px;overflow-y: scroll;">
                            
                            <h3 class="padding-5 text-warning">Never Purchased</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-5">
                                <select class="form-control" id="never_purchased_range" >
                                  <option value="">Select Date Range</option>
                                  <option value="7">Signed Up 7 days ago</option>
                                  <option value="14">Signed Up 14 days ago</option>
                                  <option value="30">Signed Up 30 days ago</option>
                                  <option value="60">Signed Up 60 days ago</option>
                                  <option value="90">Signed Up 90 days ago</option>
                                </select>
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                    <th class="wd-lg-25p " style="text-align: center;">S.No</th>
                                      <th class="wd-lg-25p" >Name</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody id="never_purchased_body" >
                                  
                                    <?php foreach($never_purchased as $key => $value){ ?>
                                    
                                      <tr >
                                       <td class="wd-lg-25p"><?php echo $key+1; ?></td>
                                        <td class="wd-lg-25p pull-left"><a href="<?php echo admin_url()?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id'] ?>" target="_blank" ><?php echo ucfirst($value['firstname'])?> </a></td>
                                        <td class="wd-lg-25p"><?php echo date('jS \of F',strtotime($value['datecreated']))?></td>
                                      </tr>
                                    <?php }?>
                                 
                                  </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="min-height: 352px;max-height: 352px;overflow-y: scroll;">
                            
                            <h3 class="padding-5 text-danger">Not Purchased more than 10 days</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-5">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                     <th class="wd-lg-25p" style="text-align: center;">S.No</th>
                                      <th class="wd-lg-25p" >Name</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                    <?php $purchased_10 = array_reverse($purchased_10); foreach($purchased_10 as $key => $value){ ?>
                                    
                                      <tr >
                                      <td class="wd-lg-25p"><?php echo $key+1; ?></td>
                                        <td class="wd-lg-25p pull-left"><a href="<?php echo admin_url()?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id'] ?>" target="_blank" ><?php echo ucfirst($value['firstname'])?> </a></td>
                                        <td class="wd-lg-25p"><?php echo date('jS \of F',strtotime($value['datecreated']))?></td>
                                      </tr>
                                    <?php }?>
                                 
                                  </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="min-height: 352px;max-height: 352px;overflow-y: scroll;">
                            
                            <h3 class="padding-5 text-primary">New Signups in last 10 days</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-5">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                    <th class="wd-lg-25p" style="text-align: center;">S.No</th>
                                      <th class="wd-lg-25p" >Name</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    
                                    <?php $new_signups = array_reverse($new_signups); foreach($new_signups as $key => $value){ ?>
                                    
                                      <tr >
                                       <td class="wd-lg-25p"><?php echo $key+1; ?></td>
                                        <td class="wd-lg-25p pull-left"><a href="<?php echo admin_url()?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id'] ?>" target="_blank" ><?php echo ucfirst($value['firstname'])?> </a></td>
                                        <td class="wd-lg-25p"><?php echo date('jS \of F',strtotime($value['datecreated']))?></td>
                                      </tr>
                                    <?php }?>
                                 
                                  </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="min-height: 352px;">
                            
                            <h3 class="padding-5">Not Purchased Since</h3>
                            
                            <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr style="background-color: #ccc;">
                                      <th class="wd-lg-25p" style="text-align: center;">10 d</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">21 d</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">30 d</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">60 d</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">90 d</th>
                                    </tr>
                                  </thead>
                            </table>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-2">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                      <th class="wd-lg-25p" style="text-align: center;">Name</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Email</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                    <?php foreach($get_graph_clients as $key => $clients){ $colr = '';?>
                                    
                                      <tr class="<?php echo  $colr;?>">
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['company'])?></td>
                                        <td class="tx-right tx-medium tx-inverse wd-lg-25p "><?php echo ($clients['active']==1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Non Active </span>' ?></td>
                                      </tr>
                                    <?php }?>
                                 
                                  </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div> -->
                    
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script> 
<script>
  $('.city_name').select2({placeholder: "Select Suburb"});
  $(".city_name").on('change',function(){        
        $("#myForm").submit(); // Submit the form
    });
  Highcharts.chart('container', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Based on Most Customer Orders'
      },
      subtitle: {
          text: ''
      },
      accessibility: {
          announceNewData: {
              enabled: true
          }
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'Total Completed Orders'
          }
  
      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.1f}'
              },
              point: {
                events: {
                    click: function(event){
                      var id = event.point.id;
                      var win = window.open("<?php echo admin_url()?>merchant_dashboard/merchant_profile/"+id, '_blank');
                      if (win) {
                          win.focus();
                      } else {
                          alert('Please allow popups for this website');
                      }
                    }
                }
              }
          }
      },
  
      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
      },
  
      series: [
          {
              name: "Browsers",
			
              colorByPoint: true,
              data: <?php echo json_encode($top_10_restaurants);?>
          }
      ],
      drilldown: {
          series: [
              {
                  name: "Chrome",
                  id: "Chrome",
                  data: [
                      [
                          "v65.0",
                          0.1
                      ],
                      [
                          "v64.0",
                          1.3
                      ],
                      [
                          "v63.0",
                          53.02
                      ],
                      [
                          "v62.0",
                          1.4
                      ],
                      [
                          "v61.0",
                          0.88
                      ],
                      [
                          "v60.0",
                          0.56
                      ],
                      [
                          "v59.0",
                          0.45
                      ],
                      [
                          "v58.0",
                          0.49
                      ],
                      [
                          "v57.0",
                          0.32
                      ],
                      [
                          "v56.0",
                          0.29
                      ],
                      [
                          "v55.0",
                          0.79
                      ],
                      [
                          "v54.0",
                          0.18
                      ],
                      [
                          "v51.0",
                          0.13
                      ],
                      [
                          "v49.0",
                          2.16
                      ],
                      [
                          "v48.0",
                          0.13
                      ],
                      [
                          "v47.0",
                          0.11
                      ],
                      [
                          "v43.0",
                          0.17
                      ],
                      [
                          "v29.0",
                          0.26
                      ]
                  ]
              },
              {
                  name: "Firefox",
                  id: "Firefox",
                  data: [
                      [
                          "v58.0",
                          1.02
                      ],
                      [
                          "v57.0",
                          7.36
                      ],
                      [
                          "v56.0",
                          0.35
                      ],
                      [
                          "v55.0",
                          0.11
                      ],
                      [
                          "v54.0",
                          0.1
                      ],
                      [
                          "v52.0",
                          0.95
                      ],
                      [
                          "v51.0",
                          0.15
                      ],
                      [
                          "v50.0",
                          0.1
                      ],
                      [
                          "v48.0",
                          0.31
                      ],
                      [
                          "v47.0",
                          0.12
                      ]
                  ]
              },
              {
                  name: "Internet Explorer",
                  id: "Internet Explorer",
                  data: [
                      [
                          "v11.0",
                          6.2
                      ],
                      [
                          "v10.0",
                          0.29
                      ],
                      [
                          "v9.0",
                          0.27
                      ],
                      [
                          "v8.0",
                          0.47
                      ]
                  ]
              },
              {
                  name: "Safari",
                  id: "Safari",
                  data: [
                      [
                          "v11.0",
                          3.39
                      ],
                      [
                          "v10.1",
                          0.96
                      ],
                      [
                          "v10.0",
                          0.36
                      ],
                      [
                          "v9.1",
                          0.54
                      ],
                      [
                          "v9.0",
                          0.13
                      ],
                      [
                          "v5.1",
                          0.2
                      ]
                  ]
              },
              {
                  name: "Edge",
                  id: "Edge",
                  data: [
                      [
                          "v16",
                          2.6
                      ],
                      [
                          "v15",
                          0.92
                      ],
                      [
                          "v14",
                          0.4
                      ],
                      [
                          "v13",
                          0.1
                      ]
                  ]
              },
              {
                  name: "Opera",
                  id: "Opera",
                  data: [
                      [
                          "v50.0",
                          0.96
                      ],
                      [
                          "v49.0",
                          0.82
                      ],
                      [
                          "v12.1",
                          0.14
                      ]
                  ]
              }
          ]
      }
  });

  Highcharts.chart('container2', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Based on Most Customer Orders'
      },
      subtitle: {
          text: ''
      },
      accessibility: {
          announceNewData: {
              enabled: true
          }
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'Total Completed Orders'
          }
  
      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.1f}'
              },
              point: {
                events: {
                    click: function(event){
                      var id = event.point.id;
                      var win = window.open("<?php echo admin_url()?>clients/referral_customer_details/"+id, '_blank');
                      if (win) {
                          win.focus();
                      } else {
                          alert('Please allow popups for this website');
                      }
                    }
                }
              }
          }
      },
  
      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
      },
  
      series: [
          {
              name: "Customer",
              colorByPoint: true,
			  
              data: <?php echo json_encode($top_10_contacts);?>
          }
      ],
      drilldown: {
          series: [
              {
                  name: "Chrome",
                  id: "Chrome",
                  data: [
                      [
                          "v65.0",
                          0.1
                      ],
                      [
                          "v64.0",
                          1.3
                      ],
                      [
                          "v63.0",
                          53.02
                      ],
                      [
                          "v62.0",
                          1.4
                      ],
                      [
                          "v61.0",
                          0.88
                      ],
                      [
                          "v60.0",
                          0.56
                      ],
                      [
                          "v59.0",
                          0.45
                      ],
                      [
                          "v58.0",
                          0.49
                      ],
                      [
                          "v57.0",
                          0.32
                      ],
                      [
                          "v56.0",
                          0.29
                      ],
                      [
                          "v55.0",
                          0.79
                      ],
                      [
                          "v54.0",
                          0.18
                      ],
                      [
                          "v51.0",
                          0.13
                      ],
                      [
                          "v49.0",
                          2.16
                      ],
                      [
                          "v48.0",
                          0.13
                      ],
                      [
                          "v47.0",
                          0.11
                      ],
                      [
                          "v43.0",
                          0.17
                      ],
                      [
                          "v29.0",
                          0.26
                      ]
                  ]
              },
              {
                  name: "Firefox",
                  id: "Firefox",
                  data: [
                      [
                          "v58.0",
                          1.02
                      ],
                      [
                          "v57.0",
                          7.36
                      ],
                      [
                          "v56.0",
                          0.35
                      ],
                      [
                          "v55.0",
                          0.11
                      ],
                      [
                          "v54.0",
                          0.1
                      ],
                      [
                          "v52.0",
                          0.95
                      ],
                      [
                          "v51.0",
                          0.15
                      ],
                      [
                          "v50.0",
                          0.1
                      ],
                      [
                          "v48.0",
                          0.31
                      ],
                      [
                          "v47.0",
                          0.12
                      ]
                  ]
              },
              {
                  name: "Internet Explorer",
                  id: "Internet Explorer",
                  data: [
                      [
                          "v11.0",
                          6.2
                      ],
                      [
                          "v10.0",
                          0.29
                      ],
                      [
                          "v9.0",
                          0.27
                      ],
                      [
                          "v8.0",
                          0.47
                      ]
                  ]
              },
              {
                  name: "Safari",
                  id: "Safari",
                  data: [
                      [
                          "v11.0",
                          3.39
                      ],
                      [
                          "v10.1",
                          0.96
                      ],
                      [
                          "v10.0",
                          0.36
                      ],
                      [
                          "v9.1",
                          0.54
                      ],
                      [
                          "v9.0",
                          0.13
                      ],
                      [
                          "v5.1",
                          0.2
                      ]
                  ]
              },
              {
                  name: "Edge",
                  id: "Edge",
                  data: [
                      [
                          "v16",
                          2.6
                      ],
                      [
                          "v15",
                          0.92
                      ],
                      [
                          "v14",
                          0.4
                      ],
                      [
                          "v13",
                          0.1
                      ]
                  ]
              },
              {
                  name: "Opera",
                  id: "Opera",
                  data: [
                      [
                          "v50.0",
                          0.96
                      ],
                      [
                          "v49.0",
                          0.82
                      ],
                      [
                          "v12.1",
                          0.14
                      ]
                  ]
              }
          ]
      }
  });


  
  $('body').on('change', '#never_purchased_range', function(){

    var range = $(this).val();
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/customer_never_purchased_ajax",
        type: "POST",
        data:{range:range},
        success: function(response){

            $('#never_purchased_body').html(response);

        }
    });

  });
  
</script>
</body>
</html>