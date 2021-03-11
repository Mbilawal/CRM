<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($sales_graph_data); exit;?>

<?php init_head();?>

<style>
    .stats_title{
		font-size:12px;
	}
    #container33 {
        height: 400px;
    }

    #container {
      min-width: 310px;
      max-width: 100%;
    }
    #containercity {
      height: 400px;
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
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<?php init_tail(); ?>
<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script> 
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>

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
                      <h3 class="padding-5" style="color: #03a9f4;">
                        Merchant Dashboard
                        
                        
                        
                      </h3>
                      
                      <hr class="hr_style">
                      <div class="quick-stats-invoices col-xs-12 col-md-12 col-sm-12">
                      <div class="row mbot15">
                        <form action="<?php echo admin_url().'merchant_dashboard';?>" method="get" >
                          <div class=" col-md-3 col-xs-6">
                            <label class=""><strong>Select Merchant </strong></label>
                            <select class="js-example-data-ajax form-control select_filters" name='client' id="clients_select">
                              <option value="" >All Merchants</option>
                              <?php foreach( $merchants as $key => $value){ ?>

                                <option value="<?php echo $value['dryvarfoods_id'];?>" ><?php echo $value['company'];?></option>

                              <?php } ?>
                            </select>
                          </div>

                          <div class=" col-md-3 col-xs-6">
                            <label class=""><strong>Select Suburb</strong></label>
                            <select class="js-example-data-ajax form-control city_name" name="city">
                              <option value="" >All Cities</option>
                              <?php foreach( $cities as $key => $value){ ?>

                                <option value="<?php echo $value['city_name'];?>" ><?php echo $value['city_name'];?></option>

                              <?php } ?>
                              
                            </select>
                          </div>
                          <div class=" col-md-3 col-xs-6">
                            <label class=""><strong>Select Month</strong></label>
                            <select class="js-example-data-ajax form-control months" name="month">
                              <option value="" >Year 2020</option>
                              <option value="01" >JAN 2020</option>
                              <option value="02" >FEB 2020</option>
                              <option value="03" >MAR 2020</option>
                              <option value="04" >APR 2020</option>
                              <option value="05" >MAY 2020</option>
                              <option value="06" >JUN 2020</option>
                              <option value="07" >JUL 2020</option>
                              <option value="08" >AUG 2020</option>
                              <option value="09" >SEP 2020</option>
                              <option value="10" >OCT 2020</option>
                              <option value="11" >NOV 2020</option>
                              <option value="12" >DEC 2020</option>
                              
                            </select>
                          </div>
						  
						  <div class=" col-md-3 col-xs-6">
                            <label class=""><strong>Select Year</strong></label>
                            <select class="js-example-data-ajax form-control years" name="year">
                              <option value="2021" selected>2021</option>
                              <option value="2020" >2020</option>
                              
                            </select>
                          </div>

                          <div class='col-sm-12'>
                            <div class="text-right">
                            <label><strong>. </strong></label><br />
                            <input type="submit" name="submit" id="submit" style="padding: 4px 12px;font-size: 12px;" value="Search" class=" btn btn-success buttons-collection btn-default-dt-options"  />
                            </div>
                             
                          </div>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div id="data_div">
                  
                  
                  
              
              
              <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 stats_title "><i class="hidden-sm glyphicon glyphicon-user"></i> Total Merchants            </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo total_rows(db_prefix().'clients',($where_summary != '' ? substr($where_summary,5) : '')); ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo total_rows(db_prefix().'clients',($where_summary != '' ? substr($where_summary,5) : '')); ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                
                 <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-success mbot15">
                     <p class="text-uppercase mtop5 stats_title"><i class="hidden-sm glyphicon glyphicon-user"></i> Active Merchants            </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo total_rows(db_prefix().'clients','active=1'.$where_summary); ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['active_customers']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                
                 <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-danger mbot15">
                     <p class="text-uppercase mtop5 stats_title"><i class="hidden-sm glyphicon glyphicon-user"></i> Inactive Customer           </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo total_rows(db_prefix().'clients','active=0'.$where_summary); ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-danger no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['active_customers']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                
                  <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-info mbot15">
                     <p class="text-uppercase mtop5 stats_title"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total contacts</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo 0 ?></span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-info no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                
                  
                  <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-primary mbot15">
                     <p class="text-uppercase mtop5 stats_title"><i class="hidden-sm glyphicon glyphicon-edit"></i> Inactive Contacts</p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo total_rows(db_prefix().'contacts','active=0'.$where_summary); ?> </span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
              
                 <div class="quick-stats-invoices col-xs-12 col-md-2 col-sm-2">
                  <div class="top_stats_wrapper ">
                     <a class="text-success mbot15">
                     <p class="text-uppercase mtop5 stats_title"><i class="hidden-sm glyphicon glyphicon-edit"></i> Contacts In <?php echo total_rows(db_prefix().'contacts','last_login LIKE "'.date('Y-m-d').'%"'.$where_summary); ?></p>
                        <span class="pull-right bold no-mtop hrm-fontsize24"> 0 <?php echo $stats['total_amount']; ?> </span>
                     </a>
                     <div class="clearfix"></div>
                     <div class="progress no-margin progress-bar-mini">
                        <div class="progress-bar progress-bar-success no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="<?php echo $stats['total_orders']; ?>" aria-valuemax="13" data-percent="100%">
                        </div>
                     </div>
                  </div>
                </div>
                </div>
                  
                  
                    <div class="row mbot15">
                    
                    
                   
                    
                      
                       
                       
                     
                       
                       <!--<div class="col-md-2  col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
                          <h3 class="bold"><?php echo total_rows(db_prefix().'contacts','active=0'.$where_summary); ?></h3>
                          <span class="text-danger"><?php echo _l('customers_summary_inactive'); ?></span>
                       </div>
                       <div class="col-md-2 col-xs-6" style="border-bottom: 2px solid #717171;">
                          <h3 class="bold"><?php echo total_rows(db_prefix().'contacts','last_login LIKE "'.date('Y-m-d').'%"'.$where_summary); ?></h3>
                          <span class="text-muted">
                            <?php
                              $contactsTemplate = '';
                              if(count($contacts_logged_in_today)> 0){
                                foreach($contacts_logged_in_today as $contact){
                                   $url = admin_url('clients/client/'.$contact['userid'].'?contactid='.$contact['id']);
                                   $fullName = $contact['firstname'] . ' ' . $contact['lastname'];
                                   $dateLoggedIn = _dt($contact['last_login']);
                                   $html = "<a href='$url' target='_blank'>$fullName</a><br /><small>$dateLoggedIn</small><br />";
                                   $contactsTemplate .= html_escape('<p class="mbot5">'.$html.'</p>');
                                }
                              } 
                            ?>
                            <span <?php if($contactsTemplate != ''){ ?> class="pointer text-has-action" data-toggle="popover" data-title="<?php echo _l('customers_summary_logged_in_today'); ?>" data-html="true" data-content="<?php echo $contactsTemplate; ?>" data-placement="bottom" <?php } ?>><?php echo _l('customers_summary_logged_in_today'); ?></span>
                          </span>
                       </div>-->
                    </div>
                    <hr class="hr-panel-heading" />

                    <div class="clearfix mtop20"></div>

                    <div class="col-md-12">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" >
                            
                            <h3 class="padding-5">Sales Graph</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center padding-5">
                                <!-- <canvas id="myChart" width="800" height="380px"></canvas> -->
                                <div id="revenue_container2"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" >
                            
                          <h3 class="padding-5">Revenue Graph</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                            <div id="container"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" >
                            
                          <h3 class="padding-5">Orders Graph</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                            <div id="revenue_container"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr class="hr-panel-heading" />

                    <div class="clearfix mtop20"></div>
                    

                    <div class="col-md-6">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" style="    min-height: 352px;">
                            
                            <h3 class="padding-5">Recent Sales</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center ">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                      <th class="wd-lg-25p" style="">Month</th>
                                      <th class="wd-lg-25p " style="">Orders</th>
                                      <th class="wd-lg-25p tx-center" style="">Sales</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                    <?php foreach($sales_graph_data['dates'] as $key => $sales){ 
                                      $colr = '';
                                    ?>
                                      <?php //if($key==12){break;}?>
                                      <?php if(date('M')==ucfirst($sales_graph_data['dates'][$key])){ $colr = "success"; }; ?>
                                      <tr class="<?php echo  $colr;?>">
                                        <td class="wd-lg-25p" style="text-align: left;"><?php echo strtoupper($sales_graph_data['dates'][$key])?></td>
                                        <td class="tx-right tx-medium tx-inverse " style="text-align: left;"><span class="badge success"><?php echo $sales_graph_data['total_orders'][$key]?></span></td>
                                        <td class="tx-right tx-medium tx-inverse " style="text-align: left;"><?php echo number_format($sales_graph_data['total_amount'][$key])?> R</td>
                                       
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
                        <div class="panel-body padding-10" style="min-height: 352px;">
                            
                            <h3 class="padding-5">Recent Merchants</h3>
                            <hr class="hr-panel-heading-dashboard">
                            <div class="text-center">
                                <table class="table table-striped table-dashboard-two">
                                  <thead>
                                    <tr>
                                      <th class="wd-lg-25p" style="text-align: center;">S.No</th>
                                      <th class="wd-lg-25p">Company</th>
                                      <th class="wd-lg-25p tx-right" style="text-align: center;">Status</th>
                                     
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                  <?php foreach($get_graph_clients as $key => $clients){ $colr = '';?>
                                  <?php if($key==12){break;}?>
                                   <?php //if(date('M')==ucfirst($clients['company'])){ $colr = "success"; }; ?>
                                    <tr class="<?php echo  $colr;?>">
                                    <td class="wd-lg-25p"><?php echo $key+1;?></td>
                                      <td class="wd-lg-25p pull-left"><?php echo ucfirst($clients['company'])?></td>
                                      <td class="tx-right tx-medium tx-inverse wd-lg-25p "><?php echo ($clients['active']==1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Non Active </span>' ?></td>
                                      
                                    </tr>
                                    <?php }?>
                                 
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
      </div>
   </div>
</div>


<script>

  $(function(){

    $('.months').select2({placeholder: "Select Month"});
	$('.years').select2({placeholder: "Select Year"});
    $('.city_name').select2({placeholder: "Select Suburb"});
    $('.select_filters').select2({placeholder: "Select Merchant"});
     var CustomersServerParams = {};
  });

  // var ctx = document.getElementById('myChart').getContext('2d');
  // var myChart = new Chart(ctx, {
  //     type: 'bar',
  //     data: {
  //         labels: <?php echo json_encode($sales_graph_data['months']) ?>,
  //         datasets: [{
  //             label: '# of Sales',
		// 	   colorByPoint: false,
		// 	  color : "#190202",
  //             data: <?php echo json_encode($sales_graph_data['total_amount']) ?>,
  //             backgroundColor: [
  //                 'rgba(255, 99, 132, 1)',
  //                 'rgba(54, 162, 235, 1)',
  //                 'rgba(255, 206, 86, 1)',
  //                 'rgba(75, 192, 192, 1)',
  //                 'rgba(153, 102, 255, 1)',
  //                 'rgba(255, 159, 64, 1)',
  //                 'rgba(255, 159, 64, 1)',
  //                 'rgba(153, 102, 255, 1)',
  //                 'rgba(75, 192, 192, 1)',
  //                 'rgba(255, 206, 86, 1)',
  //                 'rgba(54, 162, 235, 1)',
  //                 'rgba(255, 99, 132, 1)',
                
  //             ],
  //             borderColor: [
  //                 'rgba(255, 99, 132, 1)',
  //                 'rgba(54, 162, 235, 1)',
  //                 'rgba(255, 206, 86, 1)',
  //                 'rgba(75, 192, 192, 1)',
  //                 'rgba(153, 102, 255, 1)',
  //                 'rgba(255, 159, 64, 1)',
  //                 'rgba(255, 159, 64, 1)',
  //                 'rgba(153, 102, 255, 1)',
  //                 'rgba(75, 192, 192, 1)',
  //                 'rgba(255, 206, 86, 1)',
  //                 'rgba(54, 162, 235, 1)',
  //                 'rgba(255, 99, 132, 1)',
  //             ],
  //             borderWidth: 0.5
  //         }]
  //     },
  //     options: {
  //         responsive: true, 
  //         scales: {
  //             yAxes: [{
  //                 ticks: {
  //                     beginAtZero: true
  //                 }
  //             }]
  //         }
  //     }
  
  // });

  Highcharts.chart('revenue_container2', {
  
    chart: {
        type: 'column'
    },
    title: {
        text: 'Revenue Graph'
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: <?php echo json_encode($sales_graph_data['months']) ?>,
    },
    yAxis: {
        title: {
            text: 'Sales (R)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Sales (R) COMPLETED',
        color: '#5cb85c',
        data: <?php echo json_encode($sales_graph_data['total_amount']) ?>

    }]
  });

  Highcharts.chart('revenue_container', {
  
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Orders Completed vs Incart vs Declined'
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: <?php echo json_encode( ( $sales_graph_data['months']) ) ?>,
    },
    yAxis: {
        title: {
            text: 'No of Orders'
        },
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '  COMPLETED',
    color: '#5cb85c',
        data: <?php echo json_encode(($order_status_graph['completed']) );?>

    }, {
        name: '  INCART',
    color: '#337ab7',
        data: <?php echo json_encode(($order_status_graph['pending']) );?>

    }, {
        name: '  DECLINED',
    color: '#fc2d42',
        data: <?php echo json_encode(( $order_status_graph['declined']) );?>

    }]
  });

  Highcharts.getJSON('https://crm.dryvarfoods.com/admin/merchant_dashboard/revenue_graph', function (data) {

    // Create the chart
    var chart = Highcharts.stockChart('container', {

        chart: {
            height: 400
        },

        title: {
            text: 'Overall Revenue Graph'
        },

        subtitle: {
            text: ''
        },

        rangeSelector: {
            selected: 1
        },

        series: [{
            name: 'Revenue Generated (R)',
            data: data,
            type: 'area',
            threshold: null,
            tooltip: {
                valueDecimals: 2
            }
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 500
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    }
                }
            }]
        }
    });
});

  


</script>
</body>
</html>
