<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>";print_r($account_activity ); exit;?>
<style type="text/css">
  #account_activity_report{
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
</style>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Driver Account Activity Report  <span class="pull-right"><?php echo "Driver: ".ucfirst($driver_details['firstname']);?>
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              
			  <form id="revenueReportFilter" autocomplete="off" method="post" action="<?php echo AURL;?>drivers/export_account_activity_csv">
			  <input type="hidden" id="from_date" name="from_date" value="">
			  <input type="hidden" id="to_date" name="to_date" value="">
			  <input type="hidden" id="driver_id" name="driver_id" value="<?php echo $driver_details['driver_id'];?>">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
				  <div class="col-md-12 col-xs-12">
				  <?php
					if ($this->session->flashdata('err_message')) {
				     ?>
					 <div class="alert alert-danger">
					  <?php echo $this->session->flashdata('err_message'); ?>
					 </div>
				     <?php
				     }?>
					 <?php
					if ($this->session->flashdata('ok_message')) {
				     ?>
					 <div class="alert alert-success">
					  <?php echo $this->session->flashdata('ok_message'); ?>
					 </div>
				     <?php
				     }?>
				  </div>
                   
                    <div class=" col-md-6 col-xs-6">
                    <div class="toolbar pull-left ">
                    <div class="pull-right">
					     <input type="submit" class="btn btn-info" value="Export as CSV">
					  </div>
                  </div>
                  </div>
                  <div class=" col-md-6  col-xs-6">
                    <div class="toolbar pull-right ">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Today</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
                    </div>
                   
				 
				</div>
              </div>
               </form>
              
          <div class="row">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			
		
		<div class="account_activity_report_container">
          <div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
		   <div class="pull-right col-md-12"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"></h4></div>
		   <div class="col-md-12"><div id="account_activity_report"></div></div>
		</div>
		</div>
		</div>  
          <div class="row">
		    <div class="col-md-12">
            <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 30px;font-weight: bold;">Name</th>
                  <th style="min-width: 30px;font-weight: bold;">Vehicle Name</th>
                   <th style="min-width: 120px;font-weight: bold;">ONLINE / OFFLINE </th>
                  <th style="min-width: 30px;font-weight: bold;">Current Address</th>
                  <!--<th style="min-width: 30px;font-weight: bold;">Longitude</th>-->
                  <th style="min-width: 50px;font-weight: bold;">Location Updated At</th>
                 
				  <th style="min-width: 120px;font-weight: bold;">Created At</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($account_activity)>0){
					$order_total =0;
					$total_payout = 0;
					foreach($account_activity as $key => $val){
					?>
					  <tr role="row">
						<td><?php echo $key+1;?></td>
                        <td><?php echo ucfirst($driver_details['firstname']); ?></td>
                        <td><?php echo $val['vehicle_name']; ?></td>
                        <td>
						<?php if($val["status"]=="Online"){ ?>
						<span class="label label-success">ONLINE</span>
						<?php } else{ ?>
						<span class="label label-danger">OFFLINE</span>
						<?php } ?>
						</td>
                        <td>
                        <?php
                        
						echo $val["latitude"].'&nbsp;&nbsp;&nbsp;   -   &nbsp;&nbsp;&nbsp;'.$val["longitude"];
						$geolocation = $val["latitude"].','.$val["longitude"];
$request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=true&key=AIzaSyCgfn2q8lCMIMvWU4Cn-GYvU-rbchnfF7A'; 
$file_contents = file_get_contents($request);
$json_decode = json_decode($file_contents);

//echo "<pre>";  print_r($json_decode);  exit;
if(isset($json_decode->results[0])) {
    $response = array();
    foreach($json_decode->results[0]->address_components as $addressComponet) {
        if(in_array('political', $addressComponet->types)) {
                $response[] = $addressComponet->long_name; 
        }
    }

    if(isset($response[0])){ $first  =  $response[0];  } else { $first  = 'null'; }
    if(isset($response[1])){ $second =  $response[1];  } else { $second = 'null'; } 
    if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
    if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
    if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }

    if( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
        echo "<br/>Address:: ".$first;
        echo "<br/>City:: ".$second;
        echo "<br/>State:: ".$fourth;
        echo "<br/>Country:: ".$fifth;
    }
    
    else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
        echo "<br/>Address:: ".$first;
        echo "<br/>City:: ".$second;
        echo "<br/>State:: ".$third;
        echo "<br/>Country:: ".$fourth;
    }
    else if ( $first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null' ) {
        echo "<br/>City:: ".$first;
        echo "<br/>State:: ".$second;
        echo "<br/>Country:: ".$third;
    }
    else if ( $first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
        echo "<br/>State:: ".$first;
        echo "<br/>Country:: ".$second;
    }
    else if ( $first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null'  ) {
        echo "<br/>Country:: ".$first;
    }
  }
		?>
                      
						</td>
						<td><?php if($val["location_updated_at"]!=""){ echo date("F j, Y, g:i a", strtotime($val["location_updated_at"])); }else {echo "N/A";}?></td>
						
						<td><?php echo date("F j, Y, g:i a", strtotime($val["created_at"]));?></td>
					</tr> 
					  <?php } ?>
					<?php } else{ ?>
					<tr><td colspan="5"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
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
<?php init_tail(); ?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
var today = new Date();
var startDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
var endDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
$(".selected_date").html("<i class='fa fa-calendar'></i> "+startDate + ' - ' + endDate);
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
		var driver_id = $("#driver_id").val();
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#account_activity_report").html("");
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
		
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/drivers/account_activity_ajax',
                data: {from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY'),driver_id:driver_id},
				beforeSend: function(){
			      $('.loader').show();
				  $('.account_activity_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.account_activity_report_container').html(result);
					if(text_label=="Today" || text_label=="Yesterday"){
                       $(".selected_date").html(start.format('MMMM D, YYYY'));
					}
					else{
					  $(".selected_date").html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
					}
                }
             });  
        
      }
    )	
 });
 
</script>
<?php 
$account_activity_status_report = array();

$online_hours = array();
$offline_hours = array();

$days = "";

$account_activity_status_report[0]["name"] = "Online";
$account_activity_status_report[1]["name"] = "Offline";

$account_activity_status_report[0]["color"] = "#77E726";
$account_activity_status_report[1]["color"] = "#E72626";

$i = 0;
foreach($account_activity_status as $val){
 $days .= "'".$val['date']."',";
 $online_hours[]= (int)$val['online_hours'];
 $offline_hours[]= (int)$val['offline_hours'];
 $i++;
}
$account_activity_status_report[0]["data"] = $online_hours; 
$account_activity_status_report[1]["data"] = $offline_hours;
$account_activity_status_array = json_encode($account_activity_status_report);
$days = rtrim($days, ",");
?>
<script>
var data = '<?php echo $account_activity_status_array;?>';
var account_activity_status = JSON.parse(data);
 $(function () {
Highcharts.chart('account_activity_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Account Activity Report'
    },
    xAxis: {
        categories: [<?php echo $days;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No of Hours'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
    series: account_activity_status
});
 });
</script>

</body>
</html>
