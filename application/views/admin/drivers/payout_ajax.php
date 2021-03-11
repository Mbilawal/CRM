       <div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
		   <div class="pull-right col-md-12"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"></h4></div>
		   <div class="col-md-12"><div id="payout_report"></div></div>
		</div>
		</div>
		</div>  
        <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="min-width: 30px;font-weight: bold;">S.No</th>
				          <th style="min-width: 30px;font-weight: bold;">Order ID</th>
                  <th style="min-width: 30px;font-weight: bold;">Order Type</th>
                  <th style="min-width: 30px;font-weight: bold;">Pickup Point</th>
                  <th style="min-width: 50px;font-weight: bold;">Drop Point</th>
                  <th style="min-width: 120px;font-weight: bold;">Distance Covered</th>
                  <th style="min-width: 120px;font-weight: bold;">Payout</th>
                  <th style="min-width: 120px;font-weight: bold;">Tips</th>
				  <th style="min-width: 120px;font-weight: bold;">Order Total</th>
                </tr>
              </thead>
        <tbody>
					<?php 
					if(count($orders)>0){
					
            $order_total =0;
  					$total_payout = 0;
  					$k =1;
  					
            foreach($orders as $val){

              if($val['order_type'] == 'manual'){
                $order_type = '<span class="label label-primary">Manual</span>';
                if($val["payout"] == "" || $val["payout"] == 0.00){
                  $val["payout"] = 28;
                }
              }else{
                $order_type = '<span class="label label-success">Auto</span>';
              }


    					$order_total +=$val["total_amount"];
    					$total_payout +=$val["payout"]; ?>
  					  <tr role="row">
                <td><?php echo $k;?></td>
    						<td><?php echo $val["order_id"];?></td>
                <td><?php echo $order_type;?></td>
    						<td><?php echo $val["pickup_location"];?></td>
    						<td><?php echo $val["drop_location"];?></td>
    						<td><?php echo $val["drop_distance"];?>KM</td>
    						<td>R <?php echo number_format($val["payout"], 2, ".", ",");?></td>
                <td>R <?php echo number_format($val["tips_amount"], 2, ".", ",");?></td>
  					    <td>R <?php echo number_format($val["total_amount"], 2, ".", ",");?></td>
  					  </tr> 
  					
            <?php $k++;} ?>
					 <tr role="row">
						<td colspan=""></td>
                        <td colspan="4" class="text-right">Total</td>
						<td>R<?php echo number_format($total_payout, 2, ".", ",");?></td>
						<td>R<?php echo number_format($order_total, 2, ".", ",");?></td> 
					</tr> 
					<?php } else{ ?>
					<tr><td colspan="6"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
			
			   </table>
             </div>
            </div>
		</div>
   
<?php 
$payout_report = array();
$payout_amount = array();
$categories = "Total Earnings,Total Paid";

$payout_report[0]["name"] = "Amount";

$payout_amount[0]["name"]= "Total Earnings";
$payout_amount[0]["y"]= (int)$total_earnings;
$payout_amount[1]["name"]= "Total Paid";
$payout_amount[1]["y"]= (int)$total_paid;
$payout_report[0]["data"] = $payout_amount; 
$payout_report_array = json_encode($payout_report);
?>
<script>
var payout_series = JSON.parse('<?php echo $payout_report_array;?>');
 $(function () {
 Highcharts.chart('payout_report', {
	credits:false,
    chart: {
        type: 'pie'
    },
    title: {
        text: '<?php echo $driver_details["firstname"];?> Payout Report'
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Amount (R)'
        }
    },
	 tooltip: {
        pointFormat: '{series.name}: <b>R{point.y:.1f}</b>'
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
    series: payout_series
});
 });
</script>
