<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
.progress-finance-status{
	margin-top:0px!important;
	margin-bottom:0px!important;
}
  #revenue_report{
	 overflow-x:scroll; 
	 height:1000px;
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
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="row col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Merchants Revenue Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <hr class="" />
              
              <div class="clearfix"></div>
              <hr class="hr_style">
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
                  <div class='col-md-6 col-sm-6'>
                    
								<select class="js-example-data-ajax form-control select_filters " name="city" id="city" required="true">
								<option value="all" selected>All Cities</option>
								<?php if(count($cities)>0){
									foreach($cities as $val){?>
								      <option value="<?php echo $val['city'];?>"><?php echo $val['city'];?></option>
								<?php } } ?>
								</select>
                  </div>
                  <div class=" col-md-6 col-xs-6">
                    <div class="toolbar pull-right col-md-12">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Today</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
                  </div>
				</div>
              </div>
              
              
          <div class="row">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
            <?php 
			
		         	foreach($revenue as $val){
						
                           $base_revenue_all += $val["total_completed_revenue"];
                           $incart_base_revenue_all += $val["total_cart_revenue"];
						   
						   $completed_order_all += $val["total_no_of_completed_orders"];
						   $incart_order_all += $val["total_no_of_cart_orders"];
						
					}
			?>
			<div class="revenue_report_container">
              
          <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="">
			<!--<div class=" col-md-8"></div><div class=" col-md-4">  <span class="default" >Total Completed Order Revenue : <?php echo $base_revenue_all;?> </span> <span class="default">Total Cart Order Revenue : <?php echo $incart_base_revenue_all;?> </span></div>-->
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
		<div class="col-md-12"><br/><br/><div id="revenue_report"></div></div>
		
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
var today = new Date();
var startDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
var endDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');

$('#city').select2({
    placeholder: "Select City",
  });
  
 $(function () {
//Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment(), 'Today'],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days'), 'Yesterday'],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end, text_label="") {
        //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        if(text_label=="Today" || text_label=="Yesterday"){
           $(".selected_date").html(start.format('MMMM D, YYYY'));
        }
        else{
          $(".selected_date").html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#daterange-btn span').html(text_label);
		var city = $("#city").val();
        $("#revenue_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/merchants/revenue_report_ajax',
                data: {city:city,from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY')},
				beforeSend: function(){
			      $('.loader').show();
				  $('.revenue_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.revenue_report_container').html(result);
                    
                }
             });  
        
      }
    )	
 });
 
 $("body").on("change", "#city", function(){
    var city = $("#city").val();
    $("#revenue_report").html("");
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/merchants/revenue_report_ajax',
                data: {city:city,from_date:startDate,to_date:endDate},
				beforeSend: function(){
			      $('.loader').show();
				  $('.revenue_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.revenue_report_container').html(result);
                    
                }
             });  
 });
</script>
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
        text: 'All Cities'
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
