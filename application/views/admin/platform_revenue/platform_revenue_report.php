<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
   .overall_stats{
	width:100%;  
   }
  .platform_revenue_report_container{
	background-color: #f0f0f0;
    padding: 30px;
  }
  .platform_contaner_sidebar{
	background: #f6f8fa;
    border-radius: 5px;
    border: 1px solid #ccc;  
	padding:10px 0px;
  }
  .platform_table_container, .chart_container{
	    background-color: #fff;
        padding: 0.5px 25px;
        border-radius: 5px;  
		border: 1px solid #ccc; 
  }
  .chart_container{
	margin-top:25px; 
  }
  .error{
	color:red;  
  }
  #revenue_report{
	 overflow-x:scroll; 
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  td{
	 padding:10px 0px!important; 
   }
   td span{
	 color:#000;
	 font-weight:bold;
   }
   h1{
	font-weight:bold!important;  
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
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Platform Revenue<span class="pull-right">
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Platform Revenue</h3></div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="revenueReportFilter" autocomplete="off" method="post" action="<?php echo AURL;?>platform_revenue/export_platform_revenue">
			  <input type="hidden" id="from_date" name="from_date" value="">
			  <input type="hidden" id="to_date" name="to_date" value="">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
				  <div class="col-md-12 col-xs-12">
				  <?php
					if ($this->session->flashdata('err_message')) {
				     ?>
					 <div class="alert alert-danger">
					  <?php echo $this->session->flashdata('err_message'); ?>
					 </div>
				     <?php
				     }?>
					 <?php
					if ($this->session->flashdata('ok_message')) {
				     ?>
					 <div class="alert alert-success">
					  <?php echo $this->session->flashdata('ok_message'); ?>
					 </div>
				     <?php
				     }?>
				  </div>
				  <div class='col-md-4 col-sm-4'>
                    
								<select class="js-example-data-ajax form-control select_filters " name="city" id="city" required="true">
								<option value="all" selected>All Cities</option>
								<?php if(count($cities)>0){
									foreach($cities as $val){
										if($val['city']!=""){
										?>
								      <option value="<?php echo $val['city'];?>"><?php echo $val['city'];?></option>
								<?php } } } ?>
								</select>
                  </div>
                  <div class='col-md-4 col-sm-4 merchants_dropdown'>
                    
								<select class="js-example-data-ajax form-control select_filters " name="restaurant_id" id="restaurant_id" required="true">
								<option value="all" selected>All Merchants</option>
								<?php if(count($merchants)>0){
									foreach($merchants as $val){?>
								      <option value="<?php echo $val['dryvarfoods_id'];?>"><?php echo $val['company'];?></option>
								<?php } } ?>
								</select>
                  </div>
                  <div class=" col-md-4 col-xs-4">
                    <select class="js-example-data-ajax form-control select_filters " name="year" id="year" required="true">
								<option value="2021" selected>2021</option>
								<option value="2020">2020</option>
								<option value="2019">2019</option>
					</select>
                  </div>
				  <div class="col-md-12" style="margin-top:35px;">
					  <div class="pull-right">
					     <input type="submit" class="btn btn-info" value="Export as CSV">
					  </div>
				  </div>
				</div>
              </div>
               </form>
              
          <div class="row">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			<div class="col-md-12 platform_revenue_report_container">
              
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

    </div>
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
$("#revenueReportFilter").validate({
        messages: {
			restaurant_id: {
    		  required: "The Merchant is required",
    		},
          }
});

$('#city').select2({
    placeholder: "Select City",
  });
  
$('#restaurant_id').select2({
    placeholder: "Select Merchant",
  });
  
  $('#year').select2({
    placeholder: "Select Year",
  });
  
 $("body").on("change", ".select_filters", function(){
	var id = $(this).attr("id");
	if(id=="city"){
		restaurant_id = "all";
	}
	else{
    var restaurant_id = $("#restaurant_id").val();
	}
	var year = $("#year").val();
	var city = $("#city").val();
    $("#platform_revenue_report").html("");
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/platform_revenue/platform_revenue_ajax',
                data: {restaurant_id:restaurant_id,year:year,city:city},
				beforeSend: function(){
			      $('.loader').show();
				  $('.platform_revenue_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.platform_revenue_report_container').html(result);
                    
                }
             });  
 });
 
$("body").on("change", "#city", function(){
    var city = $("#city").val();
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/platform_revenue/get_merchants_by_city',
                data: {city:city},
				beforeSend: function(){
			      $('.loader').show();
				  $('.merchants_dropdown').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.merchants_dropdown').html(result);
					$('#restaurant_id').select2({
						placeholder: "Select Merchant",
					  });
                    
                }
             });  
 });
</script>
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
