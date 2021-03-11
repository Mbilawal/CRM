<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";  print_r($get_graph_clients); exit;?>

<?php init_head();?>
<style>
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #fff; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #fff; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #f1f1f1;; 
}
</style>
<style>

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
                      <div class="panel_s">

                        <div class="panel-body">
                          <h3 class="no-margin"> Merchant Profile </h3>
                          <hr class="hr_style">
                          <div class="clearfix"></div>
                          <div class="row mbot15">
                            <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #717171;">
                              <h3 class="bold"><?php echo $orders_count; ?></h3>
                              <span class="text-dark">Total Orders</span>
                            </div>
                            <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                              <h3 class="bold"><?php echo $orders_count_completed; ?></h3>
                              <span class="text-success">Completed Orders</span>
                            </div>
                            <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #016ff9;">
                              <h3 class="bold"><?php echo $orders_count_pending; ?></h3>
                              <span class="text-primary">Incart Orders</span>
                            </div>
                            <div class="col-md-3 col-xs-6 " style="border-bottom: 2px solid #f32200;">
                              <h3 class="bold"><?php echo $orders_count_declined; ?></h3>
                              <span class="text-danger">Declined Orders</span>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                          <!-- <p class="pull-right text-info"> Call us at <?php echo $merchant['phonenumber']?> <br/> Visit us at  <?php echo $merchant['address']?> </p> -->
                            <img src="https://crm.dryvarfoods.com/assets/images/images.png" class="staff-profile-image-thumb" style="margin-left: 39%;">
                            <center>
                            <div class="profile mtop20 display-inline-block">
                              <h4> <?php echo $merchant['company']?> </h4>

                              <p class="display-block"><i class="fa fa-phone"></i> <?php echo $merchant['phonenumber']?></p>

                              <p class="display-block"><i class="fa fa-envelope"></i> <a href="mailto:admin@gmail.com"><?php echo $merchant['email']?></a></p>
                              
                              <p class="display-block"><i class="fa fa-building"></i> <?php echo $merchant['address']?></p>
                            </div>
                            </center>
                        </div>
                      </div>
                      
                      <hr class="hr-panel-heading">


                    </div>
                  </div>
                  <div id="data_div">


                    <div class="clearfix mtop20"></div>
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="panel_s contracts-expiring">
                          <div class="panel-body padding-10" style="min-height: 475px;max-height: 475px;
                              overflow-y: scroll;">
                              
                              <h3 class="padding-5">Recent Sales</h3>
                              <hr class="hr-panel-heading-dashboard">
                              <div class="text-center padding-5">
                                  <table class="table table-striped table-dashboard-two">
                                    <thead>
                                      <tr>
                                        <th class="wd-lg-25p" style="text-align: center;">Day</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Orders</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Sales</th>
                                        
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                      <?php foreach($last_10_sales as $key => $sales){ 
                                        $colr = '';
                                      ?>
                                        <tr class="<?php echo  $colr;?>">
                                          <td class="wd-lg-25p"><?php echo $sales['date'];?></td>
                                          <td class="tx-right tx-medium tx-inverse wd-lg-25p "><span class="badge success"><?php echo $sales['count']?></span></td>
                                          <td class="tx-right tx-medium tx-inverse wd-lg-25p">R<?php echo $sales['total_amount']?></td>
                                         
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
                          <div class="panel-body padding-10" style="min-height: 475px;max-height: 475px;overflow-y: scroll;">
                              
                              <h3 class="padding-5">Most Sold Menu Items</h3>
                              <hr class="hr-panel-heading-dashboard">
                              <div class="text-center padding-5">
                                  <table class="table table-striped table-dashboard-two">
                                    <thead>
                                      <tr>
                                        <th class="wd-lg-25p" style="text-align: center;">Item</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Quantity</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Sales</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php foreach($top_10_menu_items as $key => $clients){ $colr = '';?>
                                      <tr class="<?php echo  $colr;?>">
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['item_name'])?></td>
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['quantity'])?></td>
                                        <td class="wd-lg-25p">R<?php echo ucfirst($clients['price'])?></td>
                                        
                                      </tr>
                                      <?php }?>
                                   
                                    </tbody>
                                  </table>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                        <div class="panel_s contracts-expiring">
                          <div class="panel-body padding-10" style="min-height: 475px;max-height: 550px;">
                              
                              <h3 class="padding-5">Top Customers</h3>
                              <hr class="hr-panel-heading-dashboard">
                              <div class="text-center padding-5">
                                  <table class="table table-striped table-dashboard-two">
                                    <thead>
                                      <tr>
                                        <th class="wd-lg-25p" style="text-align: center;">Name</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Email</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Phone</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Total Orders</th>
                                        <th class="wd-lg-25p tx-right" style="text-align: center;">Total Amount</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php foreach($top_10_customers as $key => $clients){ $colr = '';?>
                                      <tr class="<?php echo  $colr;?>">
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['customer_name'])?></td>
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['customer_email'])?></td>
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['customer_phone'])?></td>
                                        <td class="wd-lg-25p"><?php echo ucfirst($clients['count'])?></td>
                                        <td class="wd-lg-25p">R<?php echo ucfirst($clients['total_amount'])?></td>
                                        
                                      </tr>
                                      <?php }?>
                                   
                                    </tbody>
                                  </table>
                              </div>
                          </div>
                        </div>
                      </div>


                    <div class="clearfix mtop20"></div>
                    

                    
                  </div>

                  
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script>

  $(function(){

    $('.city_name').select2({placeholder: "Select Suburb"});
    $('.select_filters').select2({placeholder: "Select Merchant"});
     var CustomersServerParams = {};
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

  Highcharts.chart('revenue_container', {
  
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
</body>
</html>
