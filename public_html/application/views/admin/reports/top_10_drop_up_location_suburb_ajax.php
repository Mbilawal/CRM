  
							
				   <div class="col-md-12">
					<div id="top_10_stores_report"></div>
					<br>
					<div id="drop_location_revenue_report"></div>
					<br>
					<div id="drop_location_orders_report"></div>
					<br>
					<div id="top_10_customers_by_orders_report"></div>
					
					<br>
					<div id="top_10_customers_by_revenue_report"></div>
					
					</div>
			
<?php 
$drop_location_revenue_report = array();
$drop_location_revenues_total_sales = array();
$drop_location_list = "";
$drop_location_revenue_report[0]["name"] = "Revenue";
$drop_location_revenue_report[0]["color"] = "#008000";
$i = 0;
foreach($top_10_drop_up_locations_by_revenue as $val){

 $drop_location_list .= "'".$val['drop_location']."',";
 $drop_location_revenues_total_sales[]= (float)$val['revenue'];
 $i++;
 }
$drop_location_revenue_report[0]["data"] = $drop_location_revenues_total_sales; 
$drop_location_revenue_report_array = json_encode($drop_location_revenue_report);
$drop_location_list = rtrim($drop_location_list, ",");
?>
<script>
var data = '<?php echo $drop_location_revenue_report_array;?>';
var drop_location_revenues = JSON.parse(data);

$(function () {
	Highcharts.chart('drop_location_revenue_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 10 Drop Locations By Revenue'
    },
    xAxis: {
        categories: [<?php echo $drop_location_list;?>],
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
    series: drop_location_revenues
});
  
});
</script>

<?php 
$drop_location_no_of_orders_report = array();
$drop_location_no_of_orders = array();
$drop_location_list = "";
$drop_location_no_of_orders_report[0]["name"] = "Number of Orders";
$drop_location_no_of_orders_report[0]["color"] = "#FFC300";
$i = 0;
foreach($top_10_drop_up_locations_by_orders as $val){

 $drop_location_list .= "'".$val['drop_location']."',";
 $drop_location_no_of_orders[]= (int)$val['no_of_orders'];
 $i++;
 }
$drop_location_no_of_orders_report[0]["data"] = $drop_location_no_of_orders; 
$drop_location_no_of_orders_report_array = json_encode($drop_location_no_of_orders_report);
$drop_location_list = rtrim($drop_location_list, ",");
?>
<script>
var data = '<?php echo $drop_location_no_of_orders_report_array;?>';
var drop_location_no_of_orders = JSON.parse(data);

$(function () {
	Highcharts.chart('drop_location_orders_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 10 Drop Locations By Orders'
    },
    xAxis: {
        categories: [<?php echo $drop_location_list;?>],
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
    series: drop_location_no_of_orders
});
  
});
</script>

<?php 
$top_10_stores_report = array();
$top_10_stores_no_of_orders = array();
$stores_list = "";
$top_10_stores_report[0]["name"] = "Number of Orders";
$top_10_stores_report[0]["color"] = "#80F3D7";
$i = 0;
foreach($top_10_stores as $val){

 $stores_list .= "'".$val['company']."',";
 $top_10_stores_no_of_orders[]= (int)$val['total_count'];
 $i++;
 }
$top_10_stores_report[0]["data"] = $top_10_stores_no_of_orders; 
$top_10_stores_report_array = json_encode($top_10_stores_report);
$stores_list = rtrim($stores_list, ",");
?>
<script>
var data = '<?php echo $top_10_stores_report_array;?>';
var top_10_stores_no_of_orders = JSON.parse(data);

$(function () {
	Highcharts.chart('top_10_stores_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 10 Stores By Orders'
    },
    xAxis: {
        categories: [<?php echo $stores_list;?>],
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
    series: top_10_stores_no_of_orders
});
  
});
</script>

<?php 
$top_10_customers_report = array();
$top_10_customers_no_of_orders = array();
$customers_list = "";
$top_10_customers_report[0]["name"] = "Number of Orders";
$top_10_customers_report[0]["color"] = "#B5E750";
$i = 0;
foreach($top_10_customers_by_orders as $val){

 $customers_list .= "'".$val['firstname']."',";
 $top_10_customers_no_of_orders[]= (int)$val['total_orders'];
 $i++;
 }
$top_10_customers_report[0]["data"] = $top_10_customers_no_of_orders; 
$top_10_customers_report_array = json_encode($top_10_customers_report);
$customers_list = rtrim($customers_list, ",");
?>
<script>
var data = '<?php echo $top_10_customers_report_array;?>';
var top_10_customers_no_of_orders = JSON.parse(data);

$(function () {
	Highcharts.chart('top_10_customers_by_orders_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 10 Customers By Orders'
    },
    xAxis: {
        categories: [<?php echo $customers_list;?>],
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
    series: top_10_customers_no_of_orders
});
  
});
</script>


<?php 
$top_10_customers_report = array();
$top_10_customers_revenue = array();
$customers_list = "";
$top_10_customers_report[0]["name"] = "Revenue";
$top_10_customers_report[0]["color"] = "#E7A950";
$i = 0;
foreach($top_10_customers_by_revenue as $val){

 $customers_list .= "'".$val['firstname']."',";
 $top_10_customers_revenue[]= (float)$val['total'];
 $i++;
 }
$top_10_customers_report[0]["data"] = $top_10_customers_revenue; 
$top_10_customers_report_array = json_encode($top_10_customers_report);
$customers_list = rtrim($customers_list, ",");
?>
<script>
var data = '<?php echo $top_10_customers_report_array;?>';
var top_10_customers_revenue = JSON.parse(data);

$(function () {
	Highcharts.chart('top_10_customers_by_revenue_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 10 Customers By Revenue'
    },
    xAxis: {
        categories: [<?php echo $customers_list;?>],
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
    series: top_10_customers_revenue
});
  
});
</script>



