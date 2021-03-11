<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  .p_style{
  color: #03a9f4;
  }
  a.text-default{
	  color:#004b6d!important;
  }
  .notification-image{
	  width:100px;
	  height:100px;
  }
  .notification-image {
    width: 60px!important;
    height: 60px!important;
}
	  
</style>
<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body" >
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Notifications Report  <span class="pull-right"><a href="<?php echo base_url();?>admin/clients/export_notifications_csv" target="_blank" class="btn btn-default buttons-collection btn-default-dt-options" type="button" id="csv_download" ><span>CSV DOWNLOAD</span></a></h4>
              </div>
              <hr class="hr_style" />
              <div class="row mbot15">
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                  <div class="top_stats_wrapper hrm-minheight85">
                     <a class="text-default mbot15">
                     <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Total Notifications             </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 total_notifications_count"><?php echo $notifications_count; ?></span>
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
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-edit"></i> Completed Notifications            </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24 completed_notifications_count"><?php echo ($notifications_count_completed); ?></span>
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
                      <a class="text-primary mbot15">
                        <p class="text-uppercase mtop5 hrm-minheight35">
                          <i class="hidden-sm glyphicon glyphicon-repeat"></i>
                          In Progress Notifications
                        </p>
                        <span class="pull-right bold no-mtop hrm-fontsize24 inprogress_notifications_count">
                          <?php echo ($notifications_count_inprogress); ?>
                        </span>
                       </a>
                       <div class="clearfix"></div>
                        <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-primary no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                        </div>
                    </div>
                </div>
         
                <div class="quick-stats-invoices col-xs-12 col-md-3 col-sm-6">
                   <div class="top_stats_wrapper hrm-minheight85">
                       <a class="text-warning mbot15">
                       <p class="text-uppercase mtop5 hrm-minheight35"><i class="hidden-sm glyphicon glyphicon-envelope"></i> Pending Notifications           </p>
                          <span class="pull-right bold no-mtop hrm-fontsize24 pending_notifications_count"><?php echo ($notifications_count_pending); ?></span>
                       </a>
                       <div class="clearfix"></div>
                       <div class="progress no-margin progress-bar-mini">
                          <div class="progress-bar progress-bar-warning no-percent-text not-dynamic hrm-fullwidth" role="progressbar" aria-valuenow="13" aria-valuemin="0" aria-valuemax="13" data-percent="100%">
                          </div>
                       </div>
                    </div>
                </div>
              </div>

              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Notifications    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
                  <div class=" col-md-3 col-xs-6">
                    <label><strong>Select Notification Status </strong></label>
                    <select class="js-example-data-ajax form-control notification_status select_filters" id="notification_status">
                       <option value="" selected="selected">Notification Status</option>
                      <option value="2" >Completed </option>
                      <option value="1" >In Progress </option>
                      <option value="0" >Pending </option> 
                    </select>
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label><strong>Select Month </strong></label>
                    <select name="month" id="month" class="js-example-data-ajax form-control select_filters">
                      <option value="">Select Month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select> 
                  </div>
                  <div class='col-sm-3'>
                    <label><strong>Date From</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class='col-sm-3'>
                    <label><strong>Date To</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" id="date_too" placeholder="To Date" name="date_too" class="form-control datepicker select_filters" value="" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12" style="">

                  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Sort By </strong></label>
                    <select class="js-example-data-ajax form-control sort select_filters" id="sort">
                      <option value="ASC" >Asc Notifications</option>
                      <option value="DESC" selected="selected">Desc Notifications</option>
                    </select>
                  </div>   
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Notification Send VIA </strong></label>
                    <select class="js-example-data-ajax form-control notification_type select_filters" id="notification_type">
					  <option value="" selected="selected" >All</option>
                      <option value="1" >WonderPush</option>
                      <option value="2">FireBase Notification</option>
                    </select>
                  </div>
                </div>
              </div>

              <hr />

   
           
            
         
          <div class="row">

            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
             <?php
                        if($this->session->flashdata('ok_message')){
                    ?>
                            <div class="alert alert-success"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php
                        }//end if($this->session->flashdata('err_message'))
?>
          
            <table class="table table-hover  no-footer dtr-inline collapsed" >
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <!--<th style="min-width: 50px;font-weight: bold;">Notification ID</th>-->
                  <th style="min-width: 120px;font-weight: bold;">Message Type</th>
                  <th style="min-width: 120px;font-weight: bold;">Notification VIA</th>
				  <th style="min-width: 120px;font-weight: bold;">Send To</th>
				  <!--<th style="min-width: 120px;font-weight: bold;">User/City Name</th>-->
				  <th style="min-width: 80px;font-weight: bold;">User Type</th>
                  <th style="min-width: 80px;font-weight: bold;">Image</th>
                  <th style="min-width: 120px;font-weight: bold;">Title</th>
                  <th style="min-width: 120px;font-weight: bold;">Message</th>
				  <th style="min-width: 120px;font-weight: bold;">Schedule At</th>
                  <th style="min-width: 100px;font-weight: bold;">Status</th>
                  <th style="min-width: 100px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="notification_list">

                  <?php foreach ($notifications as $key => $value) { 
           $finalname ='';
          
           ?>
                  <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <!--<td><a href="<?php echo AURL;?>clients/notification_detail/<?php echo $value['id']; ?>"> <?php echo $value['id']; ?></a></td>-->
                    <td><?php echo ($value['message_type'] == 1)?"SMS":"Push Notification"; ?></td>
                    <td><?php echo ($value['notification_type'] == 1)?"WonderPush":"FireBase Notification"; ?></td>
                    <td><?php  if($value['to_type'] == "city"){
						           echo "Specific City"."<br />";
								   echo $name = '<b>'.str_replace('***',', ',$value['city']).'</b>';
								}
								else if($value['to_type'] == "specific"){
									
									$allDeviceId = explode("***",$value["user_id"]);
										foreach($allDeviceId as $device_id){
											$name = get_user_name($device_id);
											$finalname  .= $name.',<br />'; 
									   }
									   echo $finalname;
								}
								else if($value['to_type'] == "insight"){
									
									echo ucfirst(str_replace('_',' ',$value["insight_select"]));
								}
								else{
									echo "All";
									$name = "N/A";
								}
								   ?>
					</td>
					<!--<td><?php echo $name;?></td>-->
					<td><?php echo ucfirst($value['user_type']);?></td>
					<td>
					<?php if($value['image_url']!=""){?>
					<img class="notification-image" src="<?php echo base_url()."assets/uploads/".$value['image_url'];?>"></td>
					<?php }else{?>
                    N/A
                    <?php }?>
					<td><?php echo $value['title'];?></td>
					<td><?php echo ($value['message']!='') ? ($value['message']) : '<span class="align-centre">-----</span>';?></td>
					<td><?php echo date("F j, Y, g:i a", strtotime($value['date']." ".$value['hours'].":".$value['minutes']));?></td>
                 
                    
                    <td>
          <?php if($value['status']=='0'){ ?>
                    <span class="label label-warning">Pending</span>
                    <?php }else if($value['status']=='2'){ ?>
                    <span class="label label-success">Completed</span>
                     <?php }else if($value['status']=='1'){ ?>
                      <span class="label label-primary">In Progress</span>
                      <?php }?>
                    </td>
                    
                    <td>
                <a href="<?php echo AURL;?>clients/notification_detail/<?php echo $value['id']; ?>"class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a>
                <a href="<?php echo AURL;?>clients/delete_notification/<?php echo $value['id']; ?>" class="btn btn-danger btn-icon "><i class="fa fa-remove"></i></a>
            </td>
                  </tr>
                  <?php } ?>
                  
                  
                  
                
              </tbody>
            </table>
            <span id="response_pagination">
              <?php
              if($page_links !=""){ ?>
                
                  <div class="row_iner">
                      <div id="pagigi">
                          <div id="page_links123"><?php echo $page_links;?></div>
                      </div>
                  </div>
                  <?php
              }
              ?>
          </span>
          </div>
        </div>
            
    </div>
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script>
$(document).ready(function(e) {

  var segments = window.location.href.split( '/' );
  if(segments.length > 5){
    var filter_type = segments[6];
  }else{
    var filter_type = '';
  }
});

  

  $("body").on("click", ".notification_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }

    var orderby = $("#sort").val();
    var date_from = $("#date_from").val();
    var date_too = $("#date_too").val();
    var month = $("#month").val();
    var notification_type = $("#notification_type").val();
	var notification_status = $("#notification_status").val();
   
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/notifications_ajax/"+page,
          type: "POST",
          data: {orderby:orderby,date_from:date_from,date_too:date_too,month:month,notification_type:notification_type,notification_status:notification_status},
          success: function(response){

              var res_arr = response.split('***||***');

              $('#notification_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("change", ".select_filters", function(){


    var page = 0;
    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var orderby = $("#sort").val();
    var date_from = $("#date_from").val();
    var date_too = $("#date_too").val();
    var month = $("#month").val();
    var notification_type = $("#notification_type").val();
	var notification_status = $("#notification_status").val();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/notifications_ajax/"+page,
        type: "POST",
        data: {orderby:orderby,date_from:date_from,date_too:date_too,month:month,notification_type:notification_type,notification_status:notification_status},
        success: function(response){

          var res_arr = response.split('***||***');
		  
		  if(res_arr=='nornotifications'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No notifications found !</div>');
			   $('#notification_list').html("");
               $('#record_count').html(0);
			   $('.total_notifications_count').html(0);
			   $('.pending_notifications_count').html(0);
		       $('.completed_notifications_count').html(0);
		       $('.inprogress_notifications_count').html(0);
			
		  }else{
        
          $('#notification_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		   $('.total_notifications_count').html(res_arr[1]);
		   $('.pending_notifications_count').html(res_arr[3]);
		   $('.completed_notifications_count').html(res_arr[4]);
		   $('.inprogress_notifications_count').html(res_arr[5]);
		  
		  }
          

        }
    });   

  });

</script>
</body>
</html>
