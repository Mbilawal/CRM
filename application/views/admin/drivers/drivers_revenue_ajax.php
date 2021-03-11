        <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			     <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">Driver ID</th>
				  <th style="min-width: 30px;font-weight: bold;">Driver Name</th>
				  <th style="min-width: 30px;font-weight: bold;">Total Comission Earned</th>
				  <th style="min-width: 30px;font-weight: bold;">Total Tips Payed to the Driver</th>
				  <th style="min-width: 30px;font-weight: bold;">Action</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($revenue)>0){
					foreach($revenue as $val){
					?>
					  <tr role="row">
						<td><?php echo $val["driver_id"];?></a></td>
						<td><?php echo get_driver_name($val["driver_id"]);?></a></td>
						<td>R<?php echo number_format($val["total_comission_earned"], 2, ".", ",");?></td>
						<td>R<?php echo number_format($val["total_tips_paid"], 2, ".", ",");?></td>
						<td><a href="<?php echo AURL;?>drivers/daily_payout/<?php echo $val["driver_id"];?>"><i class="fa fa-credit-card"></i> Payout</a></td>
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
if($driver=="all"){
	$subtitle = "All Drivers";
}
else{
	$subtitle = $driver;
}
?>
<?php 
$revenue_report = array();
$revenues_total_comission = array();
$revenues_total_tips_paid = array();
$drivers_list = "";
$revenue_report[0]["name"] = "Total Comission Earned";
$revenue_report[0]["color"] = "#042f66";
$revenue_report[1]["name"] = "Total Tips Payed to the Driver";
$revenue_report[1]["color"] = "#ffc300";

$i = 0;
foreach($revenue as $val){
 $drivers_list .= "'".get_driver_name($val["driver_id"])."',";
 $revenues_total_comission[]= (float)$val['total_comission_earned'];
 $revenues_total_tips_paid[]= (float)$val['total_tips_paid'];
 $i++;
}

$revenue_report[0]["data"] = $revenues_total_comission;  
$revenue_report[1]["data"] = $revenues_total_tips_paid;  
$revenue_report_array = json_encode($revenue_report);
$drivers_list = rtrim($drivers_list, ",");
?>
<script>
var data = '<?php echo $revenue_report_array;?>';
var revenues = JSON.parse(data);
 $(function () {
Highcharts.chart('revenue_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Drivers Revenue Report'
    },
	subtitle: {
        text: '<?php echo $subtitle;?>'
    },
    xAxis: {
        categories: [<?php echo $drivers_list;?>],
        title:{
			text:null,
		},
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
