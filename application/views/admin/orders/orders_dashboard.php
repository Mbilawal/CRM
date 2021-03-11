<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link href="https://crm.dryvarfoods.com/assets/js/jqvmap/jqvmap.min.css" rel="stylesheet">
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
                        <h3 class="padding-5 p_style" style="color: #03a9f4;">Graphical Manual Orders Report</h4>

                    </div>
                    <hr class="hr_style" />
                    
                     <div class="col-md-12">
                    <div class="row mbot15">
                      <form action="<?php echo admin_url().'orders/dashboard';?>" method="get" >
                        <div class=" col-md-3 col-xs-6">
                          <label class=""><strong>Select Merchants </strong></label>
                          <select class="js-example-data-ajax form-control select_filters1" name='client' id="clients_select">
                          </select>
                        </div>

                        <div class=" col-md-3 col-xs-6">
                          <label class=""><strong>Select Suburb</strong></label>
                          <select class="js-example-data-ajax form-control city_name1" name="city">
                            <option value="" >All Cities</option>
                            <?php foreach( $cities as $key => $value){ ?>

                              <option value="<?php echo $value['city_name'];?>" ><?php echo $value['city_name'];?></option>

                            <?php } ?>
                            
                          </select>
                        </div>

                        <div class='col-sm-3'>

                          <label><strong>. </strong></label><br />
                          <input type="submit" name="submit" id="submit" style="padding: 4px 12px;font-size: 12px;" value="Search" class=" btn btn-success buttons-collection btn-default-dt-options"  />
                         
                           
                        </div>
                      </form>
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
                             <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Incart Orders           </p>
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
                  <hr class="hr-panel-heading" />
                  
                  <div class="clearfix mtop20"></div>
                  
                    <script src="https://code.highcharts.com/highcharts.js"></script>
                    <script src="https://code.highcharts.com/modules/series-label.js"></script>
                    <script src="https://code.highcharts.com/modules/exporting.js"></script>
                    <script src="https://code.highcharts.com/modules/export-data.js"></script>
                    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                    <div class="col-md-8">
                    <div class="panel_s contracts-expiring">
                      <div class="panel-body padding-10" >
                          
                        <h3 class="padding-5">Manual Orders Report</h3>
                        <hr class="hr-panel-heading-dashboard">
                        <div class="text-center padding-5">
                          <figure class="highcharts-figure">
                              <div id="container"></div>
                              <p class="highcharts-description"></p>
                          </figure>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-4">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" >
                            
                          <h3 class="padding-5">Manual Orders Reports Of Durban</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                            <script src="https://code.highcharts.com/modules/export-data.js"></script>
                            <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                            <figure class="highcharts-figure">
                                <div id="container2"></div>
                                <p class="highcharts-description"></p>
                            </figure>
                          </div>
                        </div>
                      </div>
                  </div>
                  <br />
                  <hr />
                  <hr class="hr-panel-heading" />
                  
                  <div class="clearfix mtop20"></div>
                  <div class="row row-sm"></div>
                  
                  <script src="https://code.highcharts.com/highcharts.js"></script>
                  <script src="https://code.highcharts.com/modules/exporting.js"></script>
                  <script src="https://code.highcharts.com/modules/export-data.js"></script>
                  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

                  <style>

                    .highcharts-figure, .highcharts-data-table table {
                      /*  min-width: 310px; 
                        max-width: 800px;
                        margin: 1em auto;*/
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
                    	/*max-width: 500px;*/
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

                  <figure class="highcharts-figure">
                      <div id="containercity"></div>
                      <p class="highcharts-description">
                          
                      </p>
                  </figure>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
<script src="https://crm.dryvarfoods.com/assets/js/jqvmap/jquery.vmap.min.js"></script>
<script src="https://crm.dryvarfoods.com/assets/js/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script>
$(document).ready(function(e) {

  $('.city_name').select2({placeholder: "Select Suburb"});
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
      url: ,//<?php echo admin_url(); ?>orders/clients_ajax_select/"+post_client
      dataType: 'json',

      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

});

  

</script>


<script>

Highcharts.chart('container', {
  
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Manual Orders Completed vs Incart vs Declined'
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'No of Orders'
        }
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
        data: <?php echo json_encode($order_status_graph['completed']);?>

    }, {
        name: '  INCART',
		color: '#337ab7',
        data: <?php echo json_encode($order_status_graph['pending']);?>

    }, {
        name: '  DECLINED',
		color: '#fc2d42',
        data: <?php echo json_encode($order_status_graph['declined']);?>

    }]
});

</script>

<script>
  Highcharts.chart('container2', {

      chart: {
          styledMode: true
      },

      title: {
          text: 'Manual Orders Report'
      },

      xAxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },

      series: [{
          type: 'pie',
          allowPointSelect: true,
          keys: ['name', 'y', 'selected', 'sliced'],
          data: <?php echo  json_encode($pie_chart); ?>,
          showInLegend: true
      }]
  });

  Highcharts.chart('containercity', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Manual Orders '
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No of Orders'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
  
  
    series: [{
          name: '  COMPLETED',
		color: '#5cb85c',
        data: <?php echo json_encode($order_status_graph['completed']);?>

    }, {
        name: '  INCART',
		color: '#337ab7',
        data: <?php echo json_encode($order_status_graph['pending']);?>

    }, {
         name: '  DECLINED',
		color: '#fc2d42',
        data: <?php echo json_encode($order_status_graph['declined']);?>

    }]
});
</script>
</body>
</html>
