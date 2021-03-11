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

<style type="text/css">
  #revenue_report{
	 overflow-x:scroll; 
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  tr:last-child{
	  border-top: 2px solid #03a9f4;
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
#daterange-btn {
    font-size: 15px!important;
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
                        <h3 class="padding-5 p_style" style="color: #03a9f4;">Graphical Orders Report</h4>

                    </div>
                    <hr class="hr_style" />
                    
                     <div class="col-md-12">
                    <div class="row mbot15">
                      <form action="<?php echo admin_url().'orders_dashboard';?>" method="get" >
                        <div class=" col-md-3 col-xs-6">
                          <label class=""><strong>Select Merchants </strong></label>
                          <select class="js-example-data-ajax form-control select_filters" name='client' id="clients_select">
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
                             <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Cancelled Orders           </p>
                                <span class="pull-right bold no-mtop hrm-fontsize24"><?php echo ($orders_count_cancelled); ?></span>
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
                          
                        <h3 class="padding-5">Orders Report</h3>
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
                            
                          <h3 class="padding-5">Orders Reports Of Durban</h3>
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
                      <p class="highcharts-description"></p>
                  </figure>
                  
                   <hr class="hr-panel-heading" />
                 
                  <div class="row"> 
                  <div class=" col-md-2 col-xs-3">
                    <div class="toolbar pull-left col-md-12">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Filter By Today</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
                  </div>
                  </div>
                  <hr class="hr-panel-heading" />
                  
                  <figure class="highcharts-figure revenue_report_container">
                      <div id="containermonthly"></div>
                      <div class="revenue_report_container"></div>
                  </figure>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
var today = new Date();
var startDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
var endDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
$("#revenueReportFilter").validate({
        messages: {
			city: {
    		  required: "The City is required",
    		},
          }
});

  
 $(function () {
//Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment(), 'Today'],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days'), 'Yesterday'],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end, text_label="") {
        //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        if(text_label=="Today" || text_label=="Yesterday"){
           $(".selected_date").html(start.format('MMMM D, YYYY'));
        }
        else{
          $(".selected_date").html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#daterange-btn span').html(text_label);
		var city = $("#city").val();
        $("#revenue_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/orders_dashboard/orders_report_ajax',
                data: {city:city,from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY')},
				beforeSend: function(){
			      $('.loader').show();
				  $('.revenue_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.revenue_report_container').html(result);
                    
                }
             });  
        
      }
    )	
 });
 </script>
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
      url: "<?php echo admin_url(); ?>clients/clients_ajax_select/"+post_client,
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
        text: 'Monthly Orders Completed vs Incart vs Declined'
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
          text: 'Orders Report'
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
        text: 'Monthly Orders '
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

    }]});
	
  Highcharts.chart('containermonthly', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Over All Orders Report'
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

    }]});
	
		
</script>
</body>
</html>
