<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link href="https://crm.dryvarfoods.com/assets/js/jqvmap/jqvmap.min.css" rel="stylesheet">
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            
            <div class="panel_s">
               <div class="panel-body">
                  
                  <div class="clearfix"></div>
                  <div class="row mbot15">
                     <div class="col-md-12">
                        <h3 class="padding-5">Orders Dashboard</h4>

                     </div>
                     <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #717171;">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                        <span class="text-dark">Total Orders</span>
                     </div>
                     <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients','active=1'.$where_summary); ?></h3>
                        <span class="text-success">Delivered Orders</span>
                     </div>
                     <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
                        <h3 class="bold"><?php echo total_rows(db_prefix().'clients','active=0'.$where_summary); ?></h3>
                        <span class="text-danger">Pending Orders</span>
                     </div>
                     <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                        <h3 class="bold"><?php//echo total_rows(db_prefix().'contacts','active=1'.$where_summary); ?>0</h3>
                        <span class="text-danger">Cancelled Orders</span>
                     </div>
                     
                  </div>
                  <hr class="hr-panel-heading" />
                  
                  <div class="clearfix mtop20"></div>
                  
                                   







<div class="row row-sm">
       
          </div><!-- row -->
<hr class="hr-panel-heading" />
                  
                  <div class="clearfix mtop20"></div>
                  
                  <div class="col-md-12">
                    <div class="panel_s contracts-expiring">
                      <div class="panel-body padding-10" >
                          
                          <h3 class="padding-5">Orders Graph</h3>
                          <hr class="hr-panel-heading-dashboard">
                          
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="panel_s contracts-expiring">
                      <div class="panel-body padding-10" style="height: 352px;">
                          
                          <h3 class="padding-5">Recent Orders</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                              <table class="table table-striped table-dashboard-two">
                                <thead>
                                  <tr>
                                    <th class="wd-lg-25p">Date</th>
                                    <th class="wd-lg-25p tx-right">Sales Count</th>
                                    <th class="wd-lg-25p tx-right">Earnings</th>
                                    <th class="wd-lg-25p tx-right">Tax Witheld</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>05 Oct 2018</td>
                                    <td class="tx-right tx-medium tx-inverse">25</td>
                                    <td class="tx-right tx-medium tx-inverse">$380.50</td>
                                    <td class="tx-right tx-medium tx-danger">-$23.50</td>
                                  </tr>
                                  <tr>
                                    <td>04 Oct 2018</td>
                                    <td class="tx-right tx-medium tx-inverse">34</td>
                                    <td class="tx-right tx-medium tx-inverse">$503.20</td>
                                    <td class="tx-right tx-medium tx-danger">-$13.45</td>
                                  </tr>
                                  <tr>
                                    <td>03 Oct 2018</td>
                                    <td class="tx-right tx-medium tx-inverse">30</td>
                                    <td class="tx-right tx-medium tx-inverse">$489.65</td>
                                    <td class="tx-right tx-medium tx-danger">-$20.98</td>
                                  </tr>
                                  <tr>
                                    <td>02 Oct 2018</td>
                                    <td class="tx-right tx-medium tx-inverse">27</td>
                                    <td class="tx-right tx-medium tx-inverse">$421.80</td>
                                    <td class="tx-right tx-medium tx-danger">-$22.22</td>
                                  </tr>
                                  <tr>
                                    <td>01 Oct 2018</td>
                                    <td class="tx-right tx-medium tx-inverse">31</td>
                                    <td class="tx-right tx-medium tx-inverse">$518.60</td>
                                    <td class="tx-right tx-medium tx-danger">-$23.01</td>
                                  </tr>
                                </tbody>
                              </table>
                          </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="panel_s contracts-expiring">
                      <div class="panel-body padding-10" style="height: 352px;">
                          
                          <h3 class="padding-5">Sales Density Map</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                              <div id="vmap2" height="800" class="vmap-wrapper"></div>

                          </div>
                      </div>
                    </div>
                  </div> -->
                  <div class="col-md-6">
                    <div class="panel_s contracts-expiring">
                      <div class="panel-body padding-10" style="height: 352px;">
                          
                          <h3 class="padding-5">Frequent Customers</h3>
                          <hr class="hr-panel-heading-dashboard">
                          <div class="text-center padding-5">
                              <table class="table table-striped table-dashboard-two">
                                
                                <tbody>

                                  <tr>

                                    <td class="tx-right tx-medium tx-inverse" style="text-align: left;">Customer 1</td>
                                    <td class="tx-right tx-medium tx-danger" style="text-align: right;">$23.50</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-right tx-medium tx-inverse" style="text-align: left;">Customer 2</td>
                                    <td class="tx-right tx-medium tx-danger" style="text-align: right;">$13.45</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-right tx-medium tx-inverse" style="text-align: left;">Customer 3</td>
                                    <td class="tx-right tx-medium tx-danger" style="text-align: right;">$20.98</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-right tx-medium tx-inverse" style="text-align: left;">Customer 4</td>
                                    <td class="tx-right tx-medium tx-danger" style="text-align: right;">$22.22</td>
                                  </tr>
                                  <tr>
                                    <td class="tx-right tx-medium tx-inverse" style="text-align: left;">Customer 5</td>
                                    <td class="tx-right tx-medium tx-danger" style="text-align: right;">$23.01</td>
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
   </div>
</div>
<?php init_tail(); ?>
<script src="https://crm.dryvarfoods.com/assets/js/jqvmap/jquery.vmap.min.js"></script>
<script src="https://crm.dryvarfoods.com/assets/js/jqvmap/maps/jquery.vmap.usa.js"></script>

</body>
</html>
