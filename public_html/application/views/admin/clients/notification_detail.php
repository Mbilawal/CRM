<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<style type="text/css">
  .notification-image{
	  width:100px;
	  height:100px;
  }
	  
</style>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
<div class="content">
<div class="row">
  <div class="col-md-12">
    <div class="panel_s">
      <div class="panel-body" >
        <div class="clearfix"></div>
        <div class="row mbot15">
          <div class="col-md-12">
            <h3 class="padding-5" style="color:#03A9F4"> Dryvarfoods Notification Detail Report <b class="pull-right">Notification ID : <?php echo $notification_id; ?></b> </h3>
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
                                <td class="bold">Status</td>
                                <td>
								<?php if($notification_arr['status']=='0'){ ?>
                    <span class="label label-warning">Pending</span>
                    <?php }else if($notification_arr['status']=='2'){ ?>
                    <span class="label label-success">Completed</span>
                     <?php }else if($notification_arr['status']=='1'){ ?>
                      <span class="label label-primary">In Progress</span>
                      <?php }?>
								</td>
                              </tr>
                              <tr class="project-overview-id">
                                <td class="bold">Message Type</td>
                                <td><?php  echo ($notification_arr['message_type'] == 1)?"SMS":"Push Notification";?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Notification Type</td>
                                <td><?php  echo ($notification_arr['notification_type'] == 1)?"WonderPush":"FireBase Notification";?></td>
                              </tr>
							  <?php
							  if($notification_arr['to_type'] == "city"){
						           $to_type = "Specific City";
								   $user_type_label = "City";
								   $finalname  = $notification_arr['city'];
								}
								else if($notification_arr['to_type'] == "specific"){
									$to_type = "Specific User";
									$user_type_label = "User";
								   
									$allDeviceId = explode("***",$notification_arr["user_id"]);
										foreach($allDeviceId as $device_id){
											$name = get_user_name($device_id);
											$finalname  .= '<span class="label label-default">'.$name.'</span><br /><br />'; 
									   }
									   
								}
								else if($notification_arr['to_type'] == "insight"){
									$to_type = "Insight User";
									$user_type_label = "Insight User";
			$finalname  .= '<span class="label label-default">'. ucfirst(str_replace('_',' ',$notification_arr['insight_select'])).'</span><br /><br />'; 
								   
									   
								}
								else{
									$to_type = "All";
									$user_type_label = "City/User";
									$name = "";
								}
								?>
                              <tr class="project-overview-customer">
                                <td class="bold">To</td>
                                <td><?php  echo $to_type; ?></td>
                              </tr>
							  <tr class="project-overview-customer">
                                <td class="bold"><?php echo $user_type_label;?></td>
                                <td><?php  echo  $finalname; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">User Type</td>
                                <td><?php  echo ucfirst($notification_arr['user_type']);?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Image</td>
                                <td>
								<?php if($notification_arr['image_url']!=""){?>
									<img class="notification-image" src="<?php echo base_url()."assets/uploads/".$notification_arr['image_url'];?>"></td>
								<?php }else{ ?>
                                  ---
                                <?php }?>
								</td>
                              </tr>
                              <tr class="project-overview-billing">
                                <td class="bold">Title</td>
                                <td><?php  echo $notification_arr['title']; ?></td>
                              </tr>
                              <tr class="project-overview-billing">
                                <td class="bold">Message</td>
                                <td><?php  echo $notification_arr['message']; ?></td>
                              </tr>
                              <tr class="project-overview-date-created">
                                <td class="bold">Order Created at</td>
                                <td><?php echo date("d-m-Y h:i A", strtotime($notification_arr['date']." ".$notification_arr['hours'].":".$notification_arr['minutes']));?></td>
							  </tr>
                             <tr class="project-overview-date-created">
                                <td class="bold">Schedule at</td>
                                <td><?php echo date("d-m-Y h:i A", strtotime($notification_arr['date']." ".$notification_arr['hours'].":".$notification_arr['minutes']));?></td>
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
