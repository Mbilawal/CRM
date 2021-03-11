<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
  #payout_report{
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
                <h3 class="padding-5 p_style"><?php echo $driver_details['firstname'];?> Payout Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              
			  <form id="revenueReportFilter" autocomplete="off" method="post" action="<?php echo AURL;?>drivers/export_daily_payout_csv">
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
                   
                <div class=" col-md-4 col-md-offset-8 col-xs-6">
                    <div class="toolbar pull-right col-md-12">
                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                        	<span>Last 30 Days</span>
                            <i class="fa fa-caret-down"></i>
                       	</button>
					</div>
                </div>
				  <div class="col-md-12" style="margin-top:35px;">
					  <div class="pull-right">
					     <input type="submit" class="btn btn-info" value="Export as CSV">
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
			
		
		<div class="payout_report_container">
           
          <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">Day</th>
                  <th style="min-width: 30px;font-weight: bold;">Total Amount</th>
                  <th style="min-width: 50px;font-weight: bold;">Total Payout</th>
                  <th style="min-width: 50px;font-weight: bold;">Detail View</th>
                </tr>
              </thead>
                <tbody>

				<?php 	
				if(count($payout)>0){
					
					$total_payout = 0;
					
					foreach($payout as $val){
					
					$total_payout +=$val["total_amount"];?>

					<tr role="row">
						<td><?php 
						 if($val["Day_name"]==0){
							$day_name = "Monday";
						 }
						 else if($val["Day_name"]==1){
							$day_name = "Tuesday";
						 }
						 else if($val["Day_name"]==2){
							$day_name = "Wednesday";
						 }
						 else if($val["Day_name"]==3){
							$day_name = "Thursday";
						 }
						 else if($val["Day_name"]==4){
							$day_name = "Friday";
						 }
						 else if($val["Day_name"]==5){
							$day_name = "Saturday";
						 }
						 else{
							$day_name = "Sunday";
						 }
						echo $day_name;
						?>
						</td>
						<td>R<?php echo number_format($val["total_amount"], 2, ".", ",");?></td>
					    <td>R<?php echo number_format(0, 2, ".", ",");?></td>
					    <td><a href="<?php echo base_url(); ?>admin/drivers/daily_payout_detail/<?php echo $driver_details['driver_id']; ?>/<?php echo $day_name; ?>" target="_blank" style="pointer:cursor;"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
					</tr> 
					  <?php } ?>
					 <tr role="row">
						<td class="text-right">Total</td>
						<td>R<?php echo number_format($total_payout, 2, ".", ",");?></td>
						<td>R<?php echo number_format(0, 2, ".", ",");?></td> 
					</tr> 
					<?php } else{ ?>
					<tr><td colspan="3"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
			
			   </table>
             </div>
            </div>
		</div>
          <div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
		   <div class="pull-right col-md-12"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"></h4></div>
		   <div class="col-md-12"><div id="payout_report"></div></div>
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
var startDate = moment(today).subtract(29, 'days').tz("Africa/Johannesburg").format('MMMM DD, YYYY');
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
        startDate: moment().subtract(29, 'days'),
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
        $("#payout_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
		
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/drivers/daily_payout_ajax',
                data: {from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY'),driver_id:driver_id},
				beforeSend: function(){
			      $('.loader').show();
				  $('.payout_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.payout_report_container').html(result);
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
$payout_report = array();
$total_amount = array();
$total_payout = array();
$days_list = "";
$payout_report[0]["name"] = "Total Amount";
$payout_report[0]["color"] = "#042f66";
$payout_report[1]["name"] = "Total Payout";
$payout_report[1]["color"] = "#ffc300";

$i = 0;
foreach($payout as $val){
 if($val["Day_name"]==0){
							$day_name = "Monday";
						 }
						 else if($val["Day_name"]==1){
							$day_name = "Tuesday";
						 }
						 else if($val["Day_name"]==2){
							$day_name = "Wednesday";
						 }
						 else if($val["Day_name"]==3){
							$day_name = "Thursday";
						 }
						 else if($val["Day_name"]==4){
							$day_name = "Friday";
						 }
						 else if($val["Day_name"]==5){
							$day_name = "Saturday";
						 }
						 else{
							$day_name = "Sunday";
						 }
 $days_list .= "'".$day_name."',";
 $total_amount[]= (float)$val['total_amount'];
 $total_payout[]= 0;
 $i++;
}

$payout_report[0]["data"] = $total_amount;  
$payout_report[1]["data"] = $total_payout;  
$payout_report_array = json_encode($payout_report);
$days_list = rtrim($days_list, ",");
?>
<script>
var data = '<?php echo $payout_report_array;?>';
var revenues = JSON.parse(data);
 $(function () {
Highcharts.chart('payout_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Payout Report'
    },
	subtitle: {
        text: '<?php echo $driver_details["firstname"];?>'
    },
    xAxis: {
        categories: [<?php echo $days_list;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Amount (R)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>R{point.y:.1f}</b></td></tr>',
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
    series: revenues
});

});
 </script>

</body>
</html>
