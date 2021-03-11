<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>"; print_r($orders); exit;?>
<style type="text/css">
  #payout_report{
	 overflow-x:scroll; 
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  tr:last-child{
	  border-top: 2px solid #03a9f4;
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
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Driver Payout Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              
			  <form id="revenueReportFilter" autocomplete="off" method="post" action="<?php echo AURL;?>drivers/export_payout_csv">
			  <input type="hidden" id="from_date" name="from_date" value="">
			  <input type="hidden" id="to_date" name="to_date" value="">
			  <input type="hidden" id="driver_id" name="driver_id" value="<?php echo $driver_details['driver_id'];?>">
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
                   
                  <div class=" col-md-4 col-md-offset-8 col-xs-6">
                    <div class="toolbar pull-right col-md-12">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>Last 30 Days</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
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
			
		
		<div class="payout_report_container">
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
          					 
                    if($val['order_type'] != "" && $val['order_type'] == 'manual'){
                        $val["total_amount"] = $val["total_amount"] - 20;
                    }
                    
                    if($val['order_type'] == 'manual'){
                      $order_type = '<span class="label label-primary">Manual</span>';
                      if($val["payout"] == "" || $val["payout"] == 0.00){
                        $val["payout"] = 28;
                      }
                    }else{
                      $order_type = '<span class="label label-success">Auto</span>';
                    }
                    
                    $order_total +=$val["total_amount"];
          					$total_payout +=$val["payout"]; 

                    ?>

        					  <tr role="row">
          						<td><?php echo $k;?></td>
                      <td><?php echo $val["order_id"]; ?></td>
                      <td><?php echo $order_type; ?></td>
          						<td><?php echo $val["pickup_location"];?></td>
          						<td><?php echo $val["drop_location"];?></td>
          						<td><?php echo $val["drop_distance"];?>KM</td>
          						<td>R <?php echo number_format($val["payout"], 2, ".", ",");?></td>
                      <td>R <?php echo number_format($val["tips_amount"], 2, ".", ",");?></td>
          					  <td>R <?php echo number_format($val["total_amount"], 2, ".", ",");?></td>
        					  </tr> 
        					
                  <?php $k++;} ?>

        					<tr role="row">
        						<td colspan="4" class="text-right">Total</td>
        						<td>R<?php echo number_format($total_payout, 2, ".", ",");?></td>
        						<td>R<?php echo number_format($order_total, 2, ".", ",");?></td> 
        					</tr> 
        				
                <?php } else{ ?>
      					
                <tr>
                  <td colspan="6">
                    <p class="text-danger">No Records Found</p>
                  </td>
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
<?php init_tail(); ?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.css">
<script src="<?php echo base_url();?>assets/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
var today = new Date();
var startDate = moment(today).subtract(29, 'days').tz("Africa/Johannesburg").format('MMMM DD, YYYY');
var endDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');
$(".selected_date").html("<i class='fa fa-calendar'></i> "+startDate + ' - ' + endDate);
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
        startDate: moment().subtract(29, 'days'),
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
		var driver_id = $("#driver_id").val();
        $("#payout_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
		
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/drivers/payout_ajax',
                data: {from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY'),driver_id:driver_id},
				beforeSend: function(){
			      $('.loader').show();
				  $('.payout_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.payout_report_container').html(result);
					if(text_label=="Today" || text_label=="Yesterday"){
           $(".selected_date").html(start.format('MMMM D, YYYY'));
        }
        else{
          $(".selected_date").html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
                    
                }
             });  
        
      }
    )	
 });
 
</script>
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

</body>
</html>
