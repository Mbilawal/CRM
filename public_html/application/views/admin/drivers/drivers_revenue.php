<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
.progress-finance-status{
	margin-top:0px!important;
	margin-bottom:0px!important;
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
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Drivers Revenue Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Drivers Revenue Report</h3></div>
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
                    
								<select class="js-example-data-ajax form-control select_filters " name="driver" id="driver" required="true">
								<option value="all" selected>All Drivers</option>
								<?php if(count($franchise_drivers)>0){
									foreach($franchise_drivers as $val){?>
								      <option value="<?php echo $val['driver_id'];?>"><?php echo $val['driver_name'];?></option>
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
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			<div class="revenue_report_container">
              
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
		var driver = $("#driver").val();
        $("#revenue_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/drivers/drivers_revenue_ajax',
                data: {driver:driver,from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY')},
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
 
 $("body").on("change", "#driver", function(){
    var driver = $("#driver").val();
    $("#revenue_report").html("");
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/drivers/drivers_revenue_ajax',
                data: {driver:driver,from_date:startDate,to_date:endDate},
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
        text: 'All Drivers'
    },
    xAxis: {
        categories: [<?php echo $drivers_list;?>],
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
