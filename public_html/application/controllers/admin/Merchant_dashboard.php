
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Merchant_dashboard extends AdminController
{
    /* List all clients */
    public function index()
    {
        
        $data['cities'] = $this->clients_model->get_all_cities();
        $data['merchants'] = $this->clients_model->get_all_restuarants();
        $data['sales_graph_data']        = $this->clients_model->get_sales_graph($_GET);
        
        
        $data['get_graph_clients']       = $this->clients_model->get_graph_clients($_GET);

        $data['orders_count']            = $this->clients_model->count_orders('', $_GET );
        $data['orders_count_completed']  = $this->clients_model->count_orders(6,$_GET);
        $data['orders_count_pending']    = $this->clients_model->count_orders(1,$_GET);
        $data['orders_count_declined']   = $this->clients_model->count_orders(2,$_GET);
        $data['order_status_graph']      = $this->clients_model->order_status_graph($_GET);
        $data['top_10_menu_items']       = $this->clients_model->top_10_menu_items($_GET);

        $data['title'] = _l('Merchant Dashboard');

        


        $this->load->view('admin/clients/merchant_dashboard', $data);
    }

    public function merchant_dashboard_html($city='')
    {   
        $sales_graph_data        = $this->clients_model->get_sales_graph( array(),$city );
        
        
        $get_graph_clients       = $this->clients_model->get_graph_clients($city);
        
       
        $orders_count            = $this->clients_model->count_orders( array('city' =>  $city) );
        
        
        $orders_count_completed  = $this->clients_model->count_orders_statuses('completed',$city);
        
        
        
        
        $orders_count_pending    = $this->clients_model->count_orders_statuses('pending',$city);
        $orders_count_declined   = $this->clients_model->count_orders_statuses('declined',$city);
        
        ?>




            <div class="row mbot15">
               <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #717171;">
                  <h3 class="bold"><?php echo total_rows(db_prefix().'clients',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                  <span class="text-dark">Total Merchants</span>
               </div>
               <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                  <h3 class="bold"><?php echo total_rows(db_prefix().'clients','active=1'.$where_summary); ?></h3>
                  <span class="text-success">Active Merchants</span>
               </div>
               <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
                  <h3 class="bold"><?php echo total_rows(db_prefix().'clients','active=0'.$where_summary); ?></h3>
                  <span class="text-danger">Inactive Merchants</span>
               </div>
               <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                  <h3 class="bold"><?php//echo total_rows(db_prefix().'contacts','active=1'.$where_summary); ?>0</h3>
                  <span class="text-info"><?php echo _l('customers_summary_active'); ?></span>
               </div>
               <div class="col-md-2  col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
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
               </div>
            </div>
            <hr class="hr-panel-heading" />

            <div class="clearfix mtop20"></div>

            <div class="col-md-12">
              <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" >
                    
                    <h3 class="padding-5">Sales Graph</h3>
                    <hr class="hr-panel-heading-dashboard">
                    <div class="text-center padding-5">
                        <canvas id="myChart" width="800" height="380px"></canvas>
                    </div>
                </div>
              </div>
            </div>

            <hr class="hr-panel-heading" />

            <div class="clearfix mtop20"></div>

            <!-- <div class="col-md-12">
              <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" >
                    
                    <h3 class="padding-5">Sales Graph</h3>
                    <hr class="hr-panel-heading-dashboard">
                    <div class="text-center padding-5">
                      <figure class="highcharts-figure">
                          <div id="container33"></div>
                          <p class="highcharts-description">
                              Chart showing how different series types can be combined in a single
                              chart. The chart is using a set of column series, overlaid by a line and
                              a pie series. The line is illustrating the column averages, while the
                              pie is illustrating the column totals.
                          </p>
                      </figure>
                    </div>
                </div>
              </div>
            </div> -->

            <div class="col-md-6">
              <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" style="    min-height: 352px;">
                    
                    <h3 class="padding-5">Recent Sales</h3>
                    <hr class="hr-panel-heading-dashboard">
                    <div class="text-center padding-5">
                        <table class="table table-striped table-dashboard-two">
                          <thead>
                            <tr>
                              <th class="wd-lg-25p" style="text-align: center;">Month</th>
                              <th class="wd-lg-25p tx-right" style="text-align: center;">Orders</th>
                              <th class="wd-lg-25p tx-right" style="text-align: center;">Sales</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                          
                            <?php foreach($sales_graph_data['dates'] as $key => $sales){ 
                              $colr = '';
                            ?>
                              <?php if($key==8){break;}?>
                              <?php if(date('M')==ucfirst($sales_graph_data['dates'][$key])){ $colr = "success"; }; ?>
                              <tr class="<?php echo  $colr;?>">
                                <td class="wd-lg-25p"><?php echo strtoupper($sales_graph_data['dates'][$key])?></td>
                                <td class="tx-right tx-medium tx-inverse wd-lg-25p "><span class="badge success"><?php echo $sales_graph_data['total_orders'][$key]?></span></td>
                                <td class="tx-right tx-medium tx-inverse wd-lg-25p">R <?php echo $sales_graph_data['total_amount'][$key]?></td>
                               
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
                    <div class="text-center padding-5">
                        <table class="table table-striped table-dashboard-two">
                          <thead>
                            <tr>
                              <th class="wd-lg-25p" style="text-align: center;">S.No</th>
                              <th class="wd-lg-25p" style="text-align: center;">Company</th>
                              <th class="wd-lg-25p tx-right" style="text-align: center;">Status</th>
                             
                              
                            </tr>
                          </thead>
                          <tbody>
                          
                          <?php foreach($get_graph_clients as $key => $clients){ $colr = '';?>
                          <?php if($key==8){break;}?>
                           <?php //if(date('M')==ucfirst($clients['company'])){ $colr = "success"; }; ?>
                            <tr class="<?php echo  $colr;?>">
                            <td class="wd-lg-25p"><?php echo $key+1;?></td>
                              <td class="wd-lg-25p"><?php echo ucfirst($clients['company'])?></td>
                              <td class="tx-right tx-medium tx-inverse wd-lg-25p "><?php echo ($clients['active']==1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Non Active </span>' ?></td>
                              
                            </tr>
                            <?php }?>
                         
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>


            <script>

              $(function(){

                $('#city_name').select2();
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

              // Highcharts.chart('container33', {
              //     title: {
              //         text: 'Combination chart'
              //     },
              //     xAxis: {
              //         categories: ['Store A', 'Store B', 'Store C', 'Store D', 'Store E']
              //     },
              //     labels: {
              //         items: [{
              //             html: 'Total fruit consumption',
              //             style: {
              //                 left: '50px',
              //                 top: '18px',
              //                 color: ( // theme
              //                     Highcharts.defaultOptions.title.style &&
              //                     Highcharts.defaultOptions.title.style.color
              //                 ) || 'black'
              //             }
              //         }]
              //     },
              //     series: [{
              //         type: 'column',
              //         name: 'Store A',
              //         data: [3, 2, 1, 3, 4]
              //     }, {
              //         type: 'column',
              //         name: 'Store B',
              //         data: [2, 3, 5, 7, 6]
              //     }, {
              //         type: 'column',
              //         name: 'Store C',
              //         data: [4, 3, 3, 9, 0]
              //     }, {
              //         type: 'spline',
              //         name: 'Average',
              //         data: [3, 2.67, 3, 6.33, 3.33],
              //         marker: {
              //             lineWidth: 2,
              //             lineColor: Highcharts.getOptions().colors[3],
              //             fillColor: 'white'
              //         }
              //     }, {
              //         type: 'pie',
              //         name: 'Total consumption',
              //         data: [{
              //             name: 'Store A',
              //             y: 13,
              //             color: Highcharts.getOptions().colors[0] // Jane's color
              //         }, {
              //             name: 'Store B',
              //             y: 23,
              //             color: Highcharts.getOptions().colors[1] // John's color
              //         }, {
              //             name: 'Store C',
              //             y: 19,
              //             color: Highcharts.getOptions().colors[2] // Joe's color
              //         }],
              //         center: [100, 80],
              //         size: 100,
              //         showInLegend: false,
              //         dataLabels: {
              //             enabled: false
              //         }
              //     }]
              
              // });


            </script>



        <?php
        exit;
    }


    public function analytics_dashboard(){

        
        $data['cities'] = $this->clients_model->get_all_cities();
        $data['title'] = _l('Analytics Dashboard');

        $data['pie_chart'] = $this->clients_model->get_area_order_stats();

        $data['incoming_customers'] = $this->clients_model->incoming_customers();

        $data['sales_graph_data']        = $this->clients_model->get_sales_graph( array(),'' );
        $data['order_status_graph']        = $this->clients_model->order_status_graph(array());
        
        $this->load->view('admin/clients/analytics_dashboard', $data);


    }

    public function revenue_graph(){

        $data = $this->clients_model->revenue_graph();
        echo json_encode($data);
        exit;
    }

    public function merchant_profile($client){
		

    	$_GET['client'] = $client; 
        
        $data['merchant']      = $this->clients_model->get_merchant($client );
        $data['orders_count']            = $this->clients_model->count_orders('', $_GET );
        $data['orders_count_completed']  = $this->clients_model->count_orders('completed',$_GET);
        $data['orders_count_pending']    = $this->clients_model->count_orders('pending',$_GET);
        $data['orders_count_declined']  = $this->clients_model->count_orders('declined',$_GET);


        $data['top_10_menu_items']        = $this->clients_model->top_10_menu_items($_GET);
        $data['top_10_customers']        = $this->clients_model->top_10_customers($_GET);
        $data['last_10_sales']		= $this->clients_model->last_10_sales($_GET);

        $data['title'] = _l('Merchant Profile');
        $this->load->view('admin/clients/merchant_profile', $data);
    }




}