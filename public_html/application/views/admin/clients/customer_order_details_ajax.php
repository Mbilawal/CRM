
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #03a9f4;">
                <h3 class="bold"  ><?php echo ucfirst($customer['firstname'])?></h3>
                <span class="text-primary"><?php echo ucfirst($customer['email'])." | ".ucfirst($customer['phonenumber'])?></span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
                <h3 class="bold"><?php if($customer['datecreated']!=""){ echo date("F j, Y, g:i a", strtotime($customer['datecreated'])); }?></h3>
                <span class="text-success">Joining Date</span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
                <h3 class="bold"><?php echo ucfirst($customer['total_orders'])?> </h3>
                <span class="text-danger">Total Orders</span>
              </div>
              <div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #ff9900;">
                <h3 class="bold"><?php if($customer['total_orders']>0){ echo round($customer['total_amount']/$customer['total_orders'],2); }?> R</h3>
                <span class="text-warning">Average Order Value</span>
              </div>
            </div>
            <hr class="hr-panel-heading" />
            <div class="clearfix mtop20"></div>
            
            <div class="col-md-12">
              <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Possible Revenue </p>
                        <span class="pull-right no-mtop hrm-fontsize24"><?php echo ucfirst($customer['total_amount'])?> R</span>
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Completed Orders Revenue </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24" id="completedcount"><?php echo number_format($completed_orders_revenue["total_revenue"], 2, ".", ""); ?> R</span>
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
                          Total Declined Orders Revenue
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo number_format($declined_orders_revenue["total_revenue"], 2, ".", ""); ?> R
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Total Pending Orders Revenue          </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24" id="pendingcount"><?php echo ($orders_count_pending); ?> R</span>
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
              <div class="row mbot15">
			 <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-success mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-home"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                  
                          Favourite Store that Customer Likes
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo $favourite_store["company"];?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                        
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-danger mbot15">
					   <h2><center><i class="hidden-sm glyphicon glyphicon-heart"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          Favourite Meal Item
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php if($favourite_meal_item["name"]!=""){ echo $favourite_meal_item["name"]; } else{ echo ""; }?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                       
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-warning mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-shopping-cart"></i></center></h2>
                        <center>
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          Order Frequency
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          <?php echo $order_frequency;?>
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                        
                    </div>
                </div>
				
				<div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight198">
                      <a class="text-success mbot15">
					    <h2><center><i class="hidden-sm glyphicon glyphicon-cutlery"></i></center></h2>
                        <center><p class="text-uppercase mtop5 hrm-minheight35">
                          Customer Meal Preference Of Extras Added On
                        </p>
                        <span class="bold no-mtop hrm-fontsize24" id="declinecount">
                          
                        </span>
						</center>
                       </a>
                       <div class="clearfix"></div>
                    </div>
                </div>
         
             
			 </div>
            </div>
            
            
            <div class="col-md-12">
			   <div class="panel_s contracts-expiring">
                <div class="panel-body padding-10" >
                  <h3 class="padding-5" style="    color: #03a9f4;">TimeLine</h3>
                  <hr class="hr-panel-heading-dashboard">
                  <div class="text-center padding-5">
                    <div id="containerTimeline"></div>
                    <div class="alert alert-warning noorders" role="alert" style="display:none;">
                      0ops! No orders found against customer.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3 class="padding-5"><?php echo ucfirst($customer)?> <b>Order Detail</b></h3>
          <!--<hr class="hr-panel-heading-dashboard">-->
          <div class="text-center padding-5">
            <div class="row">
              <div class=" col-md-12 col-xs-12"  style="font-weight: bold;">
                <table class="table table-hover  no-footer dtr-inline collapsed orderstable" >
                  <thead>
                    <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                      <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                      <th style="min-width: 50px;font-weight: bold;">Order ID</th>
                      <th style="min-width: 120px;font-weight: bold;">Customer</th>
                      <th style="min-width: 120px;font-weight: bold;">Resturant</th>
                      <th style="min-width: 120px;font-weight: bold;">Suburb</th>
                      <th style="min-width: 120px;font-weight: bold;">Status</th>
                      <th style="min-width: 120px;font-weight: bold;">Reward Point</th>
                      <th style="min-width: 120px;font-weight: bold;">Loyalty Point</th>
                      <!--<th style="min-width: 120px;font-weight: bold;">Time Lapse</th>-->
                      <th style="min-width: 120px;font-weight: bold;">Total Amout</th>
                      <th style="min-width: 120px;font-weight: bold;">Driver</th>
                      <th style="min-width: 120px;font-weight: bold;">Date</th>
                    </tr>
                  </thead>
                  <tbody id="order_list">
                  </tbody>
                </table>
                <div class="alert alert-warning noorders" role="alert" style="display:none;">
                  0ops! No orders found against customer.
                </div>
                <span id="response_pagination">
                    <div class="row_iner">
                      <div id="pagigi">
                        <div id="page_links"></div>
                      </div>
                    </div>
                </span>
              </div>
            </div>
          </div>
          
