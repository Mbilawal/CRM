        <div class="col-md-3  platform_contaner_sidebar">
			   <center>
			    <h4 style="margin-bottom:0px;"><i class="fa fa-shopping-cart"></i></h4>
				<h4>Orders</h4>
				<h1><?php echo $total_orders;?></h1>
				</center>
				<table class="overall_stats">
				<tr>
				<td>Completed Orders</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $completed_orders;?></span></td>
				</tr>
				<tr>
				<td>Completed Orders (Manual)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $completed_manual_orders;?></span></td>
				</tr>
				<tr>
				<td>Completed Orders (Regular)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $completed_regular_orders;?></span></td>
				</tr>
				<tr>
				<td>In Cart Orders</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $incart_orders;?></span></td>
				</tr>
				<tr>
				<td>In Cart Orders (Manual)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $incart_manual_orders;?></span></td>
				</tr>
				<tr>
				<td>In Cart Orders (Regular)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $incart_regular_orders;?></span></td>
				</tr>
				<tr>
				<td>Declined Orders</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $declined_orders;?></span></td>
				</tr>
				<tr>
				<td>Declined Orders (Manual)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $declined_manual_orders;?></span></td>
				</tr>
				<tr>
				<td>Declined Orders (Regular)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $declined_regular_orders;?></span></td>
				</tr>
				<tr>
				<td>Cancelled Orders</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $cancelled_orders;?></span></td>
				</tr>
				<tr>
				<td>Cancelled Orders (Manual)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $cancelled_manual_orders;?></span></td>
				</tr>
				<tr>
				<td>Cancelled Orders (Regular)</td>
				<td>&nbsp;&nbsp;</td>
				<td><span><?php echo $cancelled_regular_orders;?></span></td>
				</tr>
				</table>
			   
			</div>
			<div class="col-md-9">
				 <div class="platform_table_container" >
				 <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				      <th style="min-width: 30px;font-weight: bold;">Month</th>
					  <th style="min-width: 30px;font-weight: bold;">Total Completed Sales</th>
					  <th style="min-width: 50px;font-weight: bold;">Total Comission Earned</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Regular Delivery Fee</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Manual Delivery Platform Fee</th>
					  <th style="min-width: 120px;font-weight: bold;">Total Manual Delivery Fee</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($platform_revenue)>0){
					foreach($platform_revenue as $val){
					$total_manual_platform_fee = $val["total_manual_orders"]*20;
					?>
					  <tr role="row">
						<td><?php echo $val["month"];?></td>
						<td>R<?php echo number_format($val["total_sales"], 2, ".", ",");?></td>
						<td>R<?php echo number_format($val["total_comission_earned"], 2, ".", ",");?></td> 
					   <td>R<?php echo number_format($val["total_auto_delivery_fee"], 2, ".", ",");?></td>
					   <td>R<?php echo number_format($total_manual_platform_fee, 2, ".", ",");?></td>
					   <td>R<?php echo number_format($val["total_manual_delivery_fee"], 2, ".", ",");?></td>
					</tr> 
					  <?php } ?>
				<?php } else{ ?>
					<tr><td colspan="6"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
				</table>
				 </div>
				 <div class="chart_container">
				   <div id="platform_revenue_report"></div>
			     </div>
               
			
            </div>
<?php 
$revenue_report = array();
$total_sales = array();
$total_commission = array();
$total_regular_delivery_fee = array();
$total_manual_delivery_platform_fee = array();
$total_manual_delivery_fee = array();
$months_list = "";

$revenue_report[0]["name"] = "Total Completed Sales";
$revenue_report[1]["name"] = "Total Comission Earned";
$revenue_report[2]["name"] = "Total Regular Delivery Fee";
$revenue_report[3]["name"] = "Total Manual Delivery Platform Fee";
$revenue_report[4]["name"] = "Total Manual Delivery Fee";
$i = 0;
foreach($platform_revenue as $val){
 $total_manual_platform_fee = $val["total_manual_orders"]*20;
 $months_list .= "'".$val['month']."',";
 $total_sales[]= (int)$val['total_sales'];
 $total_commission[]= (int)$val['total_comission_earned'];
 $total_regular_delivery_fee[]= (int)$val['total_auto_delivery_fee'];
 $total_manual_delivery_platform_fee[]= (int)$total_manual_platform_fee;
 $total_manual_delivery_fee[]= (int)$val['total_manual_delivery_fee'];
 $i++;
}
$revenue_report[0]["data"] = $total_sales; 
$revenue_report[1]["data"] = $total_commission; 
$revenue_report[2]["data"] = $total_regular_delivery_fee; 
$revenue_report[3]["data"] = $total_manual_delivery_platform_fee; 
$revenue_report[4]["data"] = $total_manual_delivery_fee; 
$revenue_report_array = json_encode($revenue_report);
$months_list = rtrim($months_list, ",");
?>
<script>
var data = '<?php echo $revenue_report_array;?>';
var revenues = JSON.parse(data);
 $(function () {
Highcharts.chart('platform_revenue_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Platform Revenue'
    },
    xAxis: {
        categories: [<?php echo $months_list;?>],
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
