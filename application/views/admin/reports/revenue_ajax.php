        <div class="row">
			<div class="col-md-12">
				<div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
				<table class="table table-hover  no-footer dtr-inline collapsed">
				  <thead>
					<tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
					<th style="min-width: 30px;font-weight: bold;">City</th>
					  <th style="min-width: 30px;font-weight: bold;">Number of Orders</th>
					  <th style="min-width: 50px;font-weight: bold;">Total Sales</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Comission Earned</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Booking Fee</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Delivery Fee</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Tips Payed to the Driver</th>
					</tr>
				  </thead>
				  <tbody>

					  <?php 
					  $total_no_of_orders = 0;
					$total_sales = 0;
					if(count($revenue)>0){
					foreach($revenue as $val){
					$total_no_of_orders += $val["no_of_orders"];
					$total_sales += $val["total_sales"];
					$total_comission_earned += $val["total_comission_earned"];
					$total_booking_fee += $val["total_booking_fee"];
					$total_delivery_fee += $val["total_delivery_fee"];
					$total_tips_paid += $val["total_tips_paid"];
					?>
					  <tr role="row">
						<td><?php echo $val["city"];?></td>
						<td><?php echo $val["no_of_orders"];?></td>
						<td>R<?php echo number_format($val["total_sales"], 2, ".", ",");?></td>
						<td>R<?php echo number_format($val["total_comission_earned"], 2, ".", ",");?></td> 
					   <td>R<?php echo number_format($val["total_booking_fee"], 2, ".", ",");?></td>
					   <td>R<?php echo number_format($val["total_delivery_fee"], 2, ".", ",");?></td>
					   <td>R<?php echo number_format($val["total_tips_paid"], 2, ".", ",");?></td>
					</tr> 
					  <?php } ?>
					<tr role="row">
						<td>Total</td>
						<td><?php echo $total_no_of_orders;?></td>
						<td>R<?php echo number_format($total_sales, 2, ".", ",");?></td>
						<td>R<?php echo number_format($total_comission_earned, 2, ".", ",");?></td> 
					   <td>R<?php echo number_format($total_booking_fee, 2, ".", ",");?></td>
					   <td>R<?php echo number_format($total_delivery_fee, 2, ".", ",");?></td>
					   <td>R<?php echo number_format($total_tips_paid, 2, ".", ",");?></td>
					</tr> 
					<?php } else{ ?>
					<tr><td colspan="7"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
				</table>
				 </div>
			</div>
		</div>
		<hr />
		<div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
        <div class="pull-left"><h5 style="color:#212b35;margin-bottom:5px;font-size:16px;">TOTAL REVENUE</h5><h3 style="color:#212b35;margin-top:0px;">R<?php echo number_format($total_sales, 2, ".", ",");?></h3></div>
        <div class="pull-right"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"><i class="fa fa-calendar"></i> <?php echo date("F d, Y");?></h4><h3 style="color:#637381;font-size:16px;margin-top:14px"><?php echo $total_no_of_orders.($total_no_of_orders>1?" Orders":" Order");?></h4></div>
        </div>
		<div class="col-md-12">
			<br/><br/><div id="revenue_report"></div>
		</div>
		</div>
		</div>
		<br/>
		<br/>
		<div class="row">
		<div class="col-md-12">
		<div class="col-md-6">
		   <div id="order_report"></div>
		</div>
		<div class="col-md-6">
		   <div id="order_pie_report"></div>
		</div>
		</div>
		</div>
<?php 
$revenue_report = array();
$order_report = array();
$no_of_orders = array();
$revenues_total_sales = array();
$revenues_total_commission = array();
$revenues_total_booking_fee = array();
$revenues_total_delivery_fee = array();
$revenues_total_tips = array();
$cities_list = "";

$order_report[0]["name"] = "No of Orders";
$revenue_report[0]["name"] = "Total Sales";
$revenue_report[1]["name"] = "Total Comission Earned";
$revenue_report[2]["name"] = "Total Booking Fee";
$revenue_report[3]["name"] = "Total Delivery Fee";
$revenue_report[4]["name"] = "Total Tips Payed to the Driver";
$i = 0;
foreach($revenue as $val){
 $cities_list .= "'".$val['city']."',";
 $no_of_orders[$i]["name"]= $val['city'];
 $no_of_orders[$i]["y"]= (int)$val['no_of_orders'];
 $revenues_total_sales[]= (int)$val['total_sales'];
 $revenues_total_commission[]= (int)$val['total_comission_earned'];
 $revenues_total_booking_fee[]= (int)$val['total_booking_fee'];
 $revenues_total_delivery_fee[]= (int)$val['total_delivery_fee'];
 $revenues_total_tips[]= (int)$val['total_tips_paid'];
 $i++;
}
$order_report[0]["data"] = $no_of_orders; 
$revenue_report[0]["data"] = $revenues_total_sales; 
$revenue_report[1]["data"] = $revenues_total_commission; 
$revenue_report[2]["data"] = $revenues_total_booking_fee; 
$revenue_report[3]["data"] = $revenues_total_delivery_fee; 
$revenue_report[4]["data"] = $revenues_total_tips; 
$revenue_report_array = json_encode($revenue_report);
$order_report_array = json_encode($order_report);
$cities_list = rtrim($cities_list, ",");
?>
<script>
var data = '<?php echo $revenue_report_array;?>';
var revenues = JSON.parse(data);
var orders = JSON.parse('<?php echo $order_report_array;?>');
 $(function () {
Highcharts.chart('revenue_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Revenue Report'
    },
    xAxis: {
        categories: [<?php echo $cities_list;?>],
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
 Highcharts.chart('order_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Order Report'
    },
    xAxis: {
        categories: [<?php echo $cities_list;?>],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Order(s)'
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
    series: orders
});
 Highcharts.chart('order_pie_report', {
	credits:false,
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Order Report'
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number of Order(s)'
        }
    },
	 tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: orders
});
 });
</script>
</body>
</html>
