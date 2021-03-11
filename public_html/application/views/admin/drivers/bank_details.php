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
            <h3 class="padding-5" style="color:#03A9F4"> Dryvarfoods Bank Details <b class="pull-right">Driver ID : <?php echo $bank_details_arr["driver_id"]; ?></b> </h3>
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
                    <div class="col-md-12 border-right project-overview-left">
                      <div class="row">
                        <div class="col-md-12">
                          <table class="table no-margin project-overview-table">
                            <tbody>
                              <tr class="project-overview-id">
                                <td class="bold">User Name</td>
                                <td><?php  echo $bank_details_arr['firstname']; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Account Number</td>
                                <td><?php  echo $bank_details_arr['account_number']; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Account Holder Name</td>
                                <td><?php  echo $bank_details_arr['account_holder_name']; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Bank Name</td>
                                <td><?php  echo $bank_details_arr['bank_name']; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold">Bank Code</td>
                                <td><?php  echo $bank_details_arr['bank_code']; ?></td>
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
