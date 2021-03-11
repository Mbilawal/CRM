<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
   .error{
	   color:red;
   }
   b{
	   font-weight:bold!important;
   }
  .half-border{
   width: 32px;
   border-top: 3px solid #000!important;
   margin-top:0px!important;
   float:left;
  }
  .range_inputs{
	  display:none;
  }
  .order_container{
	width: 100%;
    float: left;
    margin: 15px 0px 0px 0px; 
  }
  h2{
	margin-bottom:5px!important;
  }
  
  .report_container{
	    border: 1px solid #ccc;
        width: 100%;
		margin-top: 25px;
        margin-bottom: 25px;
		padding:25px;
		float:left;
  }
  .label-grey{
	background-color: #ccc;
    border-radius: 0;
    padding: 5px!important; 
	margin-left:15px;
  }
  
  span.label{
	 border-radius:0px!important; 
  }
  
  .fa-comment{
	 color:blue; 
  }
  
  .progress-bar-mini{
	 border-radius:0px!important; 
  }
  
  .thead-dark tr th{
	color: #fff!important;
    background-color: #212529!important;
    border-color: #32383e!important;
  }
  
  .table tr td, .table tr th {
    padding: .75rem!important;
    vertical-align: top!important;
    border-top: 1px solid #dee2e6!important;
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

<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="row col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Merchant Top Meals Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <!--<hr class="hr_style" />-->
			  <!--<div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter  Report</h3></div>-->
              <div class="clearfix"></div>
              <hr class="hr_style">
			  
          <div class="row sales_report_container">
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			<div class="col-md-12">
			<h2>Sales</h2>
			<span class="half-border"></span>
			<div class="report_container">
				   <div class="col-md-3">
							<h4>R<?php echo number_format($total_sales, 2, ".", "");?></h4>
							<p>Net Payout</p>
				   </div>
				   <div class="col-md-9">
					<center>
					<p>Sales</p>
					<div id="sales_report"></div>
					</center>
					</div>
				
				   <div class="col-md-12">
				   <h4>Top Selling Menu Items</h4>
				   </div>
				   <?php if(count($meals)>0){ 
				    $count = 1;
				   ?>
				   <?php foreach($meals as $val){ 
				   if($count == 1 || $count == 6){
				   ?>
				   <div class="col-md-6">
				   
				    <ul>
				   <?php } ?>
					<li><?php echo $val["name"];?> (<b><?php echo $val["total_count"];?></b>)</li>
					<?php if($count == 5 || $count == 10){ ?>
					</ul>
				   </div>
					<?php } $count++; } ?>
				   <?php } ?>
		    </div>
            </div>
  
          <div class="col-md-12">
			<h2>Service Quality</h2>
			<span class="half-border"></span>
			<br>
			<p>Focus on speen and convenience to keep your Dryvar Foods customers happy.</p>
			<div class="report_container">
			<!--<div class="col-md-12">
			<p class="pull-right">Based on past 30 days</p>
			</div>-->
			<?php 
			$total_orders_count = $order_stats["total_accept_orders"]+$order_stats["total_cancel_orders"];
			$accept_percentage = number_format(($order_stats["total_accept_orders"]/$total_orders_count)*100, 2, ".", "");
			$cancel_percentage = number_format(($order_stats["total_cancel_orders"]/$total_orders_count)*100, 2, ".", "");
			?>
			<div class="col-md-12">
			<h4>Orders</h4>
			</div>
			<div class="order_container">
			<div class="col-md-2">
			<span style="padding-top:4px;">Accept Orders</span>
			</div>
			<div class="col-md-3">
			<div class="progress no-margin progress-bar-mini" style="height:20px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $accept_percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $accept_percentage;?>%;" data-percent="<?php echo $accept_percentage;?>">
                                 </div>
            </div>
			</div>
			<div class="col-md-7"><?php echo $accept_percentage;?>%</div>
			</div>
			<div class="order_container">
			<div class="col-md-2">
			<span style="padding-top:4px;">Cancel Orders</span>
			</div>
			<div class="col-md-3">
			<div class="progress no-margin progress-bar-mini" style="height:20px!important;">
                                 <div class="progress-bar progress-bar-danger no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $cancel_percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cancel_percentage;?>%;" data-percent="<?php echo $cancel_percentage;?>">
                                 </div>
            </div>
			</div>
			<div class="col-md-7"><?php echo $cancel_percentage;?>%</div>
			</div>
			</div>
			</div>

            <div class="col-md-6">
			<h2>Customer Satisfacton</h2>
			<span class="half-border"></span>
			</div>
			<div class="col-md-6">
			<p class="pull-right" style="margin-top:20px;">Based on past 3 months
			</div>
			<div class="col-md-12">
			<div class="report_container">
			<div class="col-md-7">
			<p>77%</p>
			<p>Satisfacton Rating</p>
			
			
			<div class="progress no-margin progress-bar-mini" style="height:20px!important;">
                                 <div class="progress-bar progress-bar-warning no-percent-text not-dynamic" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;" data-percent="77">
                                 </div> 77%
            </div>
			</div>
			<div class="col-md-5">
			<h4><b>See what people are saying about your dishes to learn what they like most</b></h4>
			<p>Customers like your food, Address lower-rated dshes to improve your satisfaction rating</p>
			</div>
			
			</div>
			</div>
			
			<div class="col-md-12">
			<h4>Ratings</h4>
			</div>
			<div class="col-md-12">
				<div class="report_container">
                <table class="table">
				<thead class="thead-dark">
				<tr>
				<th>Item</th>
				<th>Satisfaction Rating</th>
				<th>Negative Feedback</th>
				</tr>
				</thead>
				<tbody>
				
					<?php foreach($meals as $val){ ?>
					<tr>
				<td><?php echo $val["name"];?> (<b><?php echo $val["total_count"];?></b>)</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"><span class="label label-grey">Taste</span><span class="label label-default">1</span><span class="label label-grey">Temperature</span><span class="label label-default">1</span><span class="label label-grey">Presentation</span><span class="label label-default">1</span></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
					<?php } ?>
					
				</tbody>
				</table>
				</div>
			</div>
</div>

           </div>

</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" id="jquery-migrate-js" src="https://crm.dryvarfoods.com/assets/plugins/jquery/jquery-migrate.min.js?v=2.6.0"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?php 
$daily_revenue_report = array();
$daily_revenues_total_sales = array();
$day_list = "";
$daily_revenue_report[0]["name"] = "Sales";
$daily_revenue_report[0]["color"] = "#008000";
$i = 0;
foreach($daily_sales as $val){

 $day_list .= "'".$val['Day']."',";
 $daily_revenues_total_sales[]= (float)$val['total_daily_sales_revenue'];
 $i++;
 }
$daily_revenue_report[0]["data"] = $daily_revenues_total_sales; 
$daily_revenue_report_array = json_encode($daily_revenue_report);
$day_list = rtrim($day_list, ",");
?>
<script>
var data = '<?php echo $daily_revenue_report_array;?>';
var daily_revenues = JSON.parse(data);

$(function () {
	Highcharts.chart('sales_report', {
	credits:false,
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [<?php echo $day_list;?>],
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
    series: daily_revenues
});
  
});
</script>


</body>
</html>
