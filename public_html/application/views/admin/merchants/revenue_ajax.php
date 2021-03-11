        
           <?php 
		         	foreach($revenue as $val){
						
                           $base_revenue_all += $val["total_completed_revenue"];
                           $incart_base_revenue_all += $val["total_cart_revenue"];
						   $completed_order_all += $val["total_no_of_completed_orders"];
						   $incart_order_all += $val["total_no_of_cart_orders"];		
					}
			?>
        <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			     <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 30px;font-weight: bold;">Company</th>
				  <th style="min-width: 30px;font-weight: bold;">City</th>
				  <th style="min-width: 30px;font-weight: bold;">Average Per Order (Completed)</th>
				  <th style="min-width: 30px;font-weight: bold;">Sales Revenue of Completed Orders</th>
				 
				  <th style="min-width: 30px;font-weight: bold;">Average Per Order (In Cart)</th>
				  <th style="min-width: 30px;font-weight: bold;">Sales Revenue of In Cart Orders</th>
                  
                   <th style="min-width: 30px;font-weight: bold;">No. of Completed Orders</th>
                  <th style="min-width: 30px;font-weight: bold;">Completed Orders Percentage</th>
                  
				  <th style="min-width: 30px;font-weight: bold;">No. of In Cart Orders</th>
                  <th style="min-width: 30px;font-weight: bold;">In Cart Orders Percentage</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($revenue)>0){
					$base_revenue = 0;
					$incart_base_revenue = 0;
						
					foreach($revenue as $val){
						if($val["total_completed_revenue"]>$base_revenue){
                        $base_revenue=$val["total_completed_revenue"];
						}
						if($val["total_cart_revenue"]>$incart_base_revenue){
                        $incart_base_revenue=$val["total_cart_revenue"];
						}
						
					}
					$k=0;
					foreach($revenue as $val){
					$k++;
					$restaurant_data = get_restaurant_data($val["restaurant_id"]);
					
					$totalcompletedOrders  = $val["total_no_of_completed_orders"];
					$totalpendingOrders    = $val["total_no_of_cart_orders"];
					$overallorders         = $totalcompletedOrders +  $totalpendingOrders;
					
					?>
					  <tr role="row">
                        <td><?php echo $k;?></td>
					    <td><a href="<?php echo AURL;?>merchants/report/<?php echo $val["restaurant_id"];?>"><?php echo $restaurant_data["company"];?></a></td>
						<td><?php echo $restaurant_data["city"]==""?"N/A":$restaurant_data["city"];?></td>
						<?php
						if($val["total_no_of_completed_orders"]>0){
					
						$average_per_order = $val["total_completed_revenue"]/$val["total_no_of_completed_orders"];
						}
						else{
							$average_per_order = 0;
						}
						?>
						<td>R <?php echo number_format($average_per_order, 2, ".", ",");?></td>
						<td>R <?php echo number_format($val["total_completed_revenue"], 2, ".", ",");?></td>
						
						<?php
						if($val["total_no_of_cart_orders"]>0){
					
						$average_cart_per_order = $val["total_cart_revenue"]/$val["total_no_of_cart_orders"];
						}
						else{
							$average_cart_per_order = 0;
						}
						?>
						<td>R <?php echo number_format($average_cart_per_order, 2, ".", ",");?></td>
						<td>R <?php echo number_format($val["total_cart_revenue"], 2, ".", ",");?></td>
                        
                        <td><?php echo $val["total_no_of_completed_orders"];?></td>
						<td>
						<?php if($val["total_no_of_completed_orders"]>0){
							//$progress_percentage = (($val["total_completed_revenue"]*100)/$base_revenue);
							$progress_percentage = (($totalcompletedOrders*100)/$overallorders);
							?>
							<div class="col-md-12 text-right progress-finance-status">
							<?php echo number_format($progress_percentage, 2, ".", "");?>%
							<div class="progress no-margin progress-bar-mini">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo number_format($progress_percentage, 2, ".", "");?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress_percentage;?>%;" data-percent="<?php echo number_format($progress_percentage, 2, ".", "");?>">
                                 </div>
                              </div>
							 </div>
						<?php } ?>
						</td>
						<td><?php echo $val["total_no_of_cart_orders"];?></td>
						<td>
						<?php if($val["total_no_of_cart_orders"]>0){
							//$progress_percentage = (($val["total_cart_revenue"]*100)/$incart_base_revenue);
							$progress_percentage = (($totalpendingOrders*100)/$overallorders);
							?>
							<div class="col-md-12 text-right progress-finance-status">
							<?php echo number_format($progress_percentage, 2, ".", "");?>%
							<div class="progress no-margin progress-bar-mini">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo number_format($progress_percentage, 2, ".", "");?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress_percentage;?>%;" data-percent="<?php echo number_format($progress_percentage, 2, ".", "");?>">
                                 </div>
                              </div>
							 </div>
						<?php } ?>
						</td>
					  </tr> 
                      
                      
					  <?php } ?>
                      <hr />
                      <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="font-weight:bold">R <?php echo $base_revenue_all;?></td>
                      <td></td>
                      <td style="font-weight:bold">R <?php echo $incart_base_revenue_all;?></td>
                     
                     <td style="font-weight:bold"> <?php echo  $completed_order_all;?></td>
                      <td></td>
                      <td style="font-weight:bold"> <?php echo $incart_order_all;?></td>
                      <td></td>
                      <td></td>
                      
                      </tr>
					<?php } else{ ?>
					<tr><td colspan="10"><p class="text-danger">No Records Found</p></td></tr>
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
        <div class="pull-right"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"><i class="fa fa-calendar"></i> <?php echo date("F d, Y");?></h4></div>
        </div>
		<div class="col-md-12">
			<br/><br/><div id="revenue_report"></div>
		</div>
		</div>
		</div>
<?php 
if($city=="all"){
	$subtitle = "All Cities";
}
else{
	$subtitle = $city;
}
?>
<?php 
$revenue_report = array();
$revenues_total_completed_orders = array();
$revenues_total_in_cart_orders = array();
$merchants_list = "";
$revenue_report[0]["name"] = "Completed Orders";
$revenue_report[0]["color"] = "#042f66";
$revenue_report[1]["name"] = "In Cart Orders";
$revenue_report[1]["color"] = "#ffc300";

$i = 0;
foreach($revenue as $val){
 $restaurant_data = get_restaurant_data($val['restaurant_id']);
 $merchants_list .= "'".$restaurant_data["company"]."',";
 $revenues_total_completed_orders[]= ((float)$val['total_completed_revenue']*100)/(float)$base_revenue;
 $revenues_total_in_cart_orders[]= ((float)$val['total_cart_revenue']*100)/(float)$incart_base_revenue;
 $i++;
}

$revenue_report[0]["data"] = $revenues_total_completed_orders;  
$revenue_report[1]["data"] = $revenues_total_in_cart_orders;  
$revenue_report_array = json_encode($revenue_report);
$merchants_list = rtrim($merchants_list, ",");
?>
<script>
var data = '<?php echo $revenue_report_array;?>';
var revenues = JSON.parse(data);
 $(function () {
Highcharts.chart('revenue_report', {
	credits:false,
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Merchants Revenue Report'
    },
	subtitle: {
        text: '<?php echo $subtitle;?>'
    },
    xAxis: {
        categories: [<?php echo $merchants_list;?>],
        title:{
			text:null,
		},
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Sales Revenue (%)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f}%</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
         bar: {
            dataLabels: {
                enabled: true,
				formatter: function(){
                    return (this.y!=0)?parseFloat(this.y.toFixed(2))+'%':"";
                },
            }
        }
    },
	legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    series: revenues
});
 });
 </script>

</body>
</html>
