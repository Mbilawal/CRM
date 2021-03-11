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
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">S.No</th>
                  <th style="min-width: 30px;font-weight: bold;">Latitude</th>
                  <th style="min-width: 30px;font-weight: bold;">Longitude</th>
                  <th style="min-width: 50px;font-weight: bold;">Location Updated At</th>
                  <th style="min-width: 120px;font-weight: bold;">Status</th>
				  <th style="min-width: 120px;font-weight: bold;">Created At</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($account_activity)>0){
					$order_total =0;
					$total_payout = 0;
					$k=1;
					foreach($account_activity as $val){
					?>
					  <tr role="row">
						<td><?php echo $k;?></td>
                        <td><?php echo $val["latitude"];?></td>
						<td><?php echo $val["longitude"];?></td>
						<td><?php if($val["location_updated_at"]!=""){ echo date("Y-m-d h:i A", strtotime($val["location_updated_at"])); }?></td>
						<td>
						<?php if($val["status"]=="Online"){ ?>
						<span class="label label-success"><?php echo $val["status"];?></span>
						<?php } else{ ?>
						<span class="label label-danger"><?php echo $val["status"];?></span>
						<?php } ?>
						</td>
						<td><?php echo date("Y-m-d h:i A", strtotime($val["created_at"]));?></td>
					</tr> 
					  <?php $k++;} ?>
					<?php } else{ ?>
					<tr><td colspan="5"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
			
			   </table>
             </div>
            </div>
		</div>
		
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
   