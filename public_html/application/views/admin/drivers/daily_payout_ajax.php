        
        <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
               <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">Day</th>
                  <th style="min-width: 30px;font-weight: bold;">Total Amount</th>
                  <th style="min-width: 50px;font-weight: bold;">Total Payout</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($payout)>0){
					$total_payout = 0;
					foreach($payout as $val){
					$total_payout +=$val["total_amount"];
					?>
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
						?></td>
						<td>R<?php echo number_format($val["total_amount"], 2, ".", ",");?></td>
					    <td>R<?php echo number_format(0, 2, ".", ",");?></td>
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
