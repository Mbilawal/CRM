<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
        //echo '<pre>';
        //print_r($order_arr);
        //exit;
?>
<?php init_head(); ?>
<div id="wrapper">
<div class="content">
<div class="row">
  <div class="col-md-12">
    <div class="panel_s">
      <div class="panel-body" style="overflow-x: scroll;">
        <div class="clearfix"></div>
        <div class="row mbot15">
          <div class="col-md-12">
            <h3 class="padding-5" style="color:#03A9F4"> Dryvarfoods Driver Details <b class="pull-right">Driver ID : <?php echo $driver_id; ?></b> </h3>
          </div>
          <div class="col-md-3 col-xs-6" style="border-bottom: 2px solid #717171;">
            <h3 class="bold"></h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-xs-12" style="">
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
              <div class="panel_s">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-6 border-right project-overview-left">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="project-info bold font-size-14" style="color:#03A9F4"> Overview </p>
                        </div>
                        <div class="col-md-12">
                          <table class="table no-margin project-overview-table">
                            <tbody>
                              <tr class="project-overview-id">
                                <td class="bold">Driver Name</td>
                                <td><?php  echo $driver_arr['firstname']; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Driver Email</td>
                                <td><?php  echo $driver_arr['email']; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Phone Number</td>
                                <td><?php  echo $driver_arr['phonenumber']; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">City</td>
                                <td><?php echo ($driver_arr['city']==" " || $driver_arr['city']=="") ? "<span >N/A</span>" : $driver_arr['city'];  ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Last Order</td>
                                <td><?php if($driver_arr["last_order"]!=""){ ?> <a href="<?php echo AURL;?>orders/orders_detail/<?php echo $driver_arr["last_order"];?>" target="_Blank">#<?php echo $driver_arr["last_order"];?></a><?php } ?></td>
                   
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Orders Last 30 Days</td>
                                <td><?php  echo $driver_arr['orders_last_30_days']; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Total Orders</td>
                                <td><?php  echo $driver_arr['total_orders']; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Total Delivery Fee</td>
                                <td><?php  echo number_format($driver_arr['total_delivery_fee'], 2, ".", ","); ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Total Tip</td>
                                <td><?php  echo number_format($driver_arr['total_tip'], 2, ".", ","); ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Status</td>
                                <td>
								<?php if($driver_arr['active']==1){ ?>
								<span class="label label-success">Active</span>
								 <?php }else{ ?>
								  <span class="label label-danger">Inactive</span>
								  <?php }?>
								</td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Email Verified At</td>
                                <td><?php echo date("d-m-Y  h:i A", strtotime($driver_arr['email_verified_at']));; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 border-right project-overview-left">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="project-info bold font-size-14" style="color:#03A9F4"> Delivery Details </p>
                        </div>
                        <div class="col-md-12">
                          <table class="table no-margin project-overview-table">
                            <tbody>
                             
                              <tr class="project-overview-billing">
                                <td class="bold">Total Estimate Distance</td>
                                <td>
                                  <?php  echo ($driver_arr['total_estimate_distance']!='' && $driver_arr['total_estimate_distance']!='') ? $driver_arr['total_estimate_distance'].' KM' : "N/A"; ?>
                                </td>
                              </tr>
                             
                             
                              <tr class="project-overview-amount">
                                <td class="bold">Total Drop Distance</td>
                                <td><?php  echo ($driver_arr['total_drop_distance']!='' && $driver_arr['total_drop_distance']!='') ? $driver_arr['total_drop_distance'].' KM' : "N/A"; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="clearfix"></div>
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
</body>
</html>
