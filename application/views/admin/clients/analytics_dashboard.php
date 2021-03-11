<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($get_graph_clients); exit;?>

<?php init_head();?>

<style>

    #container {
      min-width: 310px;
      max-width: 100%;
    }
    #containercity {
      height: 400px;
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
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            
            <div class="panel_s">
               <div class="panel-body">
                  
                  <div class="clearfix"></div>
                  <div class="row mbot15">
                    <div class="col-md-12">
                      <h3 class="padding-5">
                        Analytics Dashboard
                        <span style="float: right;">

                          <div class=" col-md-12 col-xs-12">
                            <select class="js-example-data-ajax form-control city_name" id="city_name">
                              <option value="" >All Cities</option>
                              <?php foreach( $cities as $key => $value){ ?>

                                <option value="<?php echo $value['city_name'];?>" ><?php echo $value['city_name'];?></option>

                              <?php } ?>
                              
                            </select>
                          </div>
                          
                        </span>
                      </h3>

                    </div>
                  </div>
                  <div id="data_div">
                    <hr class="hr-panel-heading" />

                    <div class="clearfix mtop20"></div>

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
                            
                          <div class="col-md-12">
                            <div class="panel_s contracts-expiring">
                              <div class="panel-body padding-10" >
                                  
                                <h3 class="padding-5">Orders</h3>
                                <hr class="hr-panel-heading-dashboard">
                                <div class="col-md-5">
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
                                <div class="col-md-7">
                                  <div class="text-center padding-5">
                                    <h3 class="padding-5">Orders Sales</h3>
                                    <hr class="hr-panel-heading-dashboard">
                                    <canvas id="myChart" width="800" height="380px"></canvas>
                                    
                                  </div>
                                </div>

                                <div class="col-md-12">
                                  <div class="text-center padding-5">
                                    
                                    <hr class="hr-panel-heading-dashboard">
                                    <div class="text-center padding-5">
                                      <figure class="highcharts-figure">
                                          <div id="orders_container"></div>
                                          <p class="highcharts-description">
                                              
                                          </p>
                                      </figure>
                                      
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="panel_s contracts-expiring">
                        <div class="panel-body padding-10" >
                            
                          <div class="col-md-12">
                            <div class="panel_s contracts-expiring">
                              <div class="panel-body padding-10" >
                                  
                                <h3 class="padding-5">Customers</h3>
                                <hr class="hr-panel-heading-dashboard">
                                <div class="text-center padding-5">
                                  <figure class="highcharts-figure">
                                      <div id="containercity"></div>
                                      <p class="highcharts-description">
                                          
                                      </p>
                                  </figure>
                                  
                                </div>

                                <div class="text-center padding-5">
                                  <figure class="highcharts-figure">
                                      <div id="users_container"></div>
                                      <p class="highcharts-description">
                                          
                                      </p>
                                  </figure>
                                  
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
      </div>
   </div>
</div>


<script type="text/javascript">
  
  // $( document ).ready(function() {
  //   $.ajax({
  //     url: "<?php echo admin_url(); ?>merchant_dashboard/merchant_dashboard_html/",
  //     type: "POST",
  //     success: function(response){

  //         $('#data_div').html(response);

  //     }
  //   });
  // });

  $('body').on('change', '#city_name', function(){

    var city = $(this).val();
    $.ajax({
        url: "<?php echo admin_url(); ?>merchant_dashboard/merchant_dashboard_html/"+city,
        type: "POST",
        success: function(response){

            $('#data_div').html(response);

        }
    });

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

Highcharts.chart('container2', {

      chart: {
          styledMode: true
      },

      title: {
          text: 'Area Orders Report'
      },

      series: [{
          type: 'pie',
          allowPointSelect: true,
          keys: ['name', 'y', 'selected', 'sliced'],
          data: <?php echo  json_encode($pie_chart); ?>,
          showInLegend: false
      }]
});
Highcharts.chart('containercity', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly New Signups'
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
            text: 'No of Customers'
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
        name: 'New Signups',
		color: '#337ab7',
		
        data: <?php echo json_encode($incoming_customers['new_signups']);?>

    }, {
        name: 'Purchased',
		color: '#5cb85c',
        data: <?php echo json_encode($incoming_customers['purchased']);?>

    }, {
        name: 'Never Purchased',
		color: '#fc2d42',
        data: <?php echo json_encode($incoming_customers['never_purchased']);?>

    }]
});

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'],
        
        datasets: [{
            label: '# of Sales',
            data: <?php echo json_encode($sales_graph_data['total_amount']) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 0.5
        }]
    },
    options: {
        responsive: true, 
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }

});

Highcharts.chart('orders_container', {

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


Highcharts.chart('users_container', {
  
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Users'
    },
    subtitle: {
        text: 'Source: dryvarfoods.com'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'No of Users'
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
        name: 'Users',
        data: <?php echo json_encode($order_status_graph['users']);?>

    }]
});    

</script>
</body>
</html>
