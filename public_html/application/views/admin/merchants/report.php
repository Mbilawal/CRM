<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
  .stats_icon{
	float:left;
    width:10%;	
  }
  .stats_content{
	float:left;
    width:90%;	
  }
  .report_container{
	    border: 4px solid #ccc;
        float: left;
        width: 100%;
  }
  .report_container_top{
	background-color: #148254;
    width: 100%;
    float: left;
    top: 0px;
    padding-top: 15px;
    padding-bottom: 15px;
    color: #fff;
  }
  .amount_label{
	color: #148254;
  }
  .average_container{
	float: left;
    width: 100%;
    padding-bottom: 35px;
    border-bottom: 2px solid #ccc;
    padding-top: 35px;
  }
  .average_container:last-child{
	  border-bottom:0px;
  }
  .average_container .col-md-4{
	  text-align:center;
  }
  .report_container_bottom{
    float: left;
    width: 100%;
    padding: 0px 20px;
   }
  .amount_container{
	background-color: #148254;
    padding: 10px 40px;
    border-radius: 8px;
    font-size: 16px;
    color: #fff;
  }
  .report_container_top div.col-md-7{
    border-right:1px solid #1fc9c8;
	border-left:1px solid #1fc9c8;
  }
  #report{
	 overflow-x:scroll; 
  }
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
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             <?php $restaurant_data = get_restaurant_data($restaurant_id);?>
              <div class="row col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods <?php echo $restaurant_data["company"];?> Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <!--<hr class="hr_style" />-->
			  <!--<div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter <?php echo $restaurant_data["company"];?> Report</h3></div>-->
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <input type="hidden" id="from_date" name="from_date" value="">
			  <input type="hidden" id="to_date" name="to_date" value="">
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
                  <div class=" col-md-12 col-xs-12">
                    <div class="toolbar pull-right col-md-12">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Today</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
                  </div>
				</div>
              </div>
              
              
          <div class="row">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			<div class="report_container">
            <div class="report_container_top">
               <div class="col-md-3">
			        
					<div class="col-md-12">
					  <div class="stats_icon">
					    <h4><i class="fa fa-user"></i></h4>
					  </div>
					  <div class="stats_content">
					    <h4><?php echo $total_customers;?></h4>
						<p>Customers</p>
					  </div>
					</div>
					<div class="col-md-12">
					  <div class="stats_icon">
					    <h4><i class="fa fa-signal"></i></h4>
					  </div>
					  <div class="stats_content">
					    <h4>R<?php echo $total_sales_revenue;?></h4>
						<p>Sales Revenue</p>
					  </div>
					</div>
					<div class="col-md-12">
					  <div class="stats_icon">
					    <h4><i class="fa fa-dollar"></i></h4>
					  </div>
					  <div class="stats_content">
					    <h4>R<?php echo $total_comission_earned;?></h4>
						<p>Commission Earned</p>
					  </div>
					</div>
					
			   </div>
			   <div class="col-md-7">
			    <center><h4><?php 
				if(count($total_weekly_sales_revenue)>0){
				$total_weekly_revenue = 0;
				  foreach($total_weekly_sales_revenue as $val){
					 $total_weekly_revenue +=$val["total_weekly_sales_revenue"];
				  }
				}
				echo "R ".number_format($total_weekly_revenue, 2, ".", ",");
				?></h4>
				<p>Average Weekly Sales Revenue</p>
				<div id="weekly_report"></div>
				</center>
			    </div>
			    <div class="col-md-2">
				  <center><h4>R<?php echo $last_30_days_sales_revenue;?></h4>
				  <p>Last 30 days Growth</p>
				  </center>
			    </div>

		    </div>
		    <div class="report_container_bottom">
			<div class="col-md-12 average_container">
				<div class="col-md-4">
				 <p class="amount_label">AVERAGE REVENUE PER ORDER</p>
				 <?php if($average_revenue_per_order==""){
					 $average_revenue_per_order = 0;
				 }
				 ?>
				 <span class="amount_container">R<?php echo number_format($average_revenue_per_order, 2, ".", ",");?></span>
				</div>
				<div class="col-md-6">
				   <div id="average_revenue_per_order"></div>
				</div>
			</div>
			<div class="col-md-12 average_container">
				<div class="col-md-4">
				<p class="amount_label">AVERAGE ORDERS PER Day</p>
				<?php if($average_orders_per_day==""){
					 $average_orders_per_day = 0;
				 }
				 ?>
				 <span class="amount_container"><?php echo number_format($average_orders_per_day, 2, ".", "");?></span>
				</div>
				<div class="col-md-6">
				   <div id="average_orders_per_day"></div>
				</div>
			</div>
			<div class="col-md-12 average_container">
				<div class="col-md-4">
				<p class="amount_label">PRIME BUSY DAYS</p>
				 <span class="amount_container"><?php echo ($prime_busy_days==""?"N\A":$prime_busy_days);?></span>
				</div>
				<div class="col-md-6">
				   <div id="prime_busy_days"></div>
				</div>
			</div>
			<div class="col-md-12 average_container">
				<div class="col-md-4">
				<p class="amount_label">BUSY ORDER TIMES</p>
				 <span class="amount_container"><?php echo ($prime_busy_times==""?"N\A":$prime_busy_times);?></span>
				</div>
				<div class="col-md-6">
				    <div id="busy_order_times"></div>
				</div>
			</div>
			</div>
		     <hr />
            </div>
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
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
		var city = $("#city").val();
        $("#revenue_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/merchants/report_ajax/<?php echo $restaurant_id;?>',
                data: {city:city,from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY')},
				beforeSend: function(){
			      $('.loader').show();
				  $('.report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.report_container').html(result);
                    
                }
             });  
        
      }
    )	
 });
 
</script>
<?php 
$weekly_revenue_report = array();
$weekly_revenues_total_sales = array();
$week_list = "";
$weekly_revenue_report[0]["name"] = "Average Sales Revenue";
$weekly_revenue_report[0]["color"] = "#148254";
$i = 0;
foreach($total_weekly_sales_revenue as $val){
 if($val["Week"]!=""){
 $week_list .= "'Week ".$val['Week']."',";
 }
 else{
	$week_list .= "'Week 0'"; 
 }
 $weekly_revenues_total_sales[]= (float)$val['total_weekly_sales_revenue'];
 $i++;
 }
$weekly_revenue_report[0]["data"] = $weekly_revenues_total_sales; 
$weekly_revenue_report_array = json_encode($weekly_revenue_report);
$week_list = rtrim($week_list, ",");



$average_orders_per_day_report = array();
$no_of_orders_per_day = array();
$days_list = "";
$average_orders_per_day_report[0]["name"] = "Orders Per Day";
$average_orders_per_day_report[0]["color"] = "#148254";
$i = 0;
foreach($average_orders_per_day_data as $val){
 if($val["week_day"]!=""){
	 if($val["week_day"]==0){
		$day_name = "Monday";
	 }
	 else if($val["week_day"]==1){
		$day_name = "Tuesday";
	 }
	 else if($val["week_day"]==2){
		$day_name = "Wednesday";
	 }
	 else if($val["week_day"]==3){
		$day_name = "Thursday";
	 }
	 else if($val["week_day"]==4){
		$day_name = "Friday";
	 }
	 else if($val["week_day"]==5){
		$day_name = "Saturday";
	 }
	 else{
		$day_name = "Sunday";
	 }
 $days_list .= "'".$day_name."',";
 $no_of_orders_per_day[]= (int)$val['no_of_orders'];
 $i++;
 }
}
$average_orders_per_day_report[0]["data"] = $no_of_orders_per_day; 
$average_orders_per_day_report_array = json_encode($average_orders_per_day_report);
$days_list = rtrim($days_list, ",");

$prime_busy_times_report = array();
$prime_busy_times = array();
$hours_list = "";
$prime_busy_times_report[0]["name"] = "Order Times";
$prime_busy_times_report[0]["color"] = "#148254";
$i = 0;
foreach($prime_busy_times_data as $val){
 if($val["hours"]!=""){
 $hours_list .= "'".date("h:i A", strtotime($val["hours"].":00"))."',";
 $prime_busy_times[]= (int)$val['no_of_orders'];
 $i++;
 }
}
$prime_busy_times_report[0]["data"] = $prime_busy_times; 
$prime_busy_times_report_array = json_encode($prime_busy_times_report);
$hours_list = rtrim($hours_list, ",");
?>
<script>
var data = '<?php echo $weekly_revenue_report_array;?>';
var weekly_average_revenues = JSON.parse(data);

var data2 = '<?php echo $average_orders_per_day_report_array;?>';
var average_orders = JSON.parse(data2);

var data3 = '<?php echo $prime_busy_times_report_array;?>';
var busy_hours = JSON.parse(data3);

 $(function () {
	Highcharts.chart('weekly_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $week_list;?>],
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
    series: weekly_average_revenues
});
  
    Highcharts.chart('average_orders_per_day', {
	credits:false,
    chart: {
        type: 'line'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $days_list;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Orders'
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
         line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: average_orders
});
  
 Highcharts.chart('busy_order_times', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $hours_list;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Orders'
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
    series: busy_hours
});
 
 });
 </script>

</body>
</html>
