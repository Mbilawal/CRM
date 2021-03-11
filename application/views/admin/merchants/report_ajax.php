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
					 if($val["Week"]!=""){
					 $total_weekly_revenue +=$val["total_weekly_sales_revenue"];
					 }
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
			 
			 <?php 
$weekly_revenue_report = array();
$weekly_revenues_total_sales = array();
$week_list = "";
$weekly_revenue_report[0]["name"] = "Average Sales Revenue";
$weekly_revenue_report[0]["color"] = "#148254";
$i = 0;
foreach($total_weekly_sales_revenue as $val){
 
 $week_list .= "'Week ".$val['Week']."',";
 
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
