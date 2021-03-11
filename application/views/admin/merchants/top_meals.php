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
                <h3 class="padding-5 p_style">Dryvarfoods Merchant Top Meals Report  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <!--<hr class="hr_style" />-->
			  <!--<div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter  Report</h3></div>-->
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <div class="row">
                
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
				  <form id="topMealsForm" action="<?php echo base_url();?>admin/merchants/export_top_meals_report" method="post">
				  
				  <input type="hidden" id="from_date" name="from_date" value="">
				  <input type="hidden" id="to_date" name="to_date" value="">
				  <div class="pull-left col-md-6">
				    <select class="js-example-data-ajax form-control select_filters " data-live-search="true" name="restaurant_id" id="restaurant_id" required="true">
                              <option value="">Select Merchant</option>
							  <?php if(count($restaurants)>0){
									foreach($restaurants as $val){?>
                              <option value="<?php echo $val['dryvarfoods_id'];?>"><?php echo $val['company'];?></option>
                              <?php } } ?>
                    </select>
					<div class="restaurant_id_error"></div>
				  </div>
                    <div class="toolbar pull-right col-md-6">
                                      <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>7 Days</span>
                                        <i class="fa fa-caret-down"></i>
                                      </button>
					</div>
					<div class="col-md-12">
					<div class="pull-right" style="margin-top:25px;">
					<input class="btn btn-info" type="submit" value="Export as PDF">
					</div>
					</div>
					</form>
                  
				
              </div>
              
              
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
							<h4>R0.00</h4>
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
				   <div class="col-md-12">
				   
				   </div>
		    </div>
            </div>
  
          <div class="col-md-12">
			<h2>Service Quality</h2>
			<span class="half-border"></span>
			<br>
			<p>Focus on speen and convenience to keep your Dryvar Foods customers happy.</p>
			<div class="report_container">
			<div class="col-md-12">
			<p class="pull-right">Based on past 30 days</p>
			</div>
			<div class="col-md-12">
			<h4>Orders</h4>
			</div>
			<div class="order_container">
			<div class="col-md-2">
			<span style="padding-top:4px;">Accept Orders</span>
			</div>
			<div class="col-md-3">
			<div class="progress no-margin progress-bar-mini" style="height:20px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100" style="width: 91%;" data-percent="91">
                                 </div>
            </div>
			</div>
			<div class="col-md-7">91%</div>
			</div>
			<div class="order_container">
			<div class="col-md-2">
			<span style="padding-top:4px;">Cancel Orders</span>
			</div>
			<div class="col-md-3">
			<div class="progress no-margin progress-bar-mini" style="height:20px!important;">
                                 <div class="progress-bar progress-bar-danger no-percent-text not-dynamic" role="progressbar" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100" style="width: 9%;" data-percent="9">
                                 </div>
            </div>
			</div>
			<div class="col-md-7">9%</div>
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
				<tr>
				<td>Item 1</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"><span class="label label-grey">Taste</span><span class="label label-default">1</span><span class="label label-grey">Temperature</span><span class="label label-default">1</span><span class="label label-grey">Presentation</span><span class="label label-default">1</span></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
				<tr>
				<td>Item 2</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"><span class="label label-grey">Taste</span><span class="label label-default">1</span><span class="label label-grey">Temperature</span><span class="label label-default">1</span><span class="label label-grey">Presentation</span><span class="label label-default">1</span></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
				<tr>
				<td>Item 3</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
								<tr>
				<td>Item 4</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"><span class="label label-grey">Taste</span><span class="label label-default">1</span><span class="label label-grey">Temperature</span><span class="label label-default">1</span><span class="label label-grey">Presentation</span><span class="label label-default">1</span></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
				<tr>
				<td>Item 5</td>
				<td><div class="progress no-margin progress-bar-mini" style="height:15px!important;">
                                 <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;" data-percent="100">
                                 </div>
            </div> <span style="display:inlne;">100% (3)</span></td>
				<td style="padding-top:15px!important;"><div class="pull-left"></div><div class="pull-right"><i class="fa fa-comment"></i></div></td>
				</tr>
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
var startDate = moment().tz("Africa/Johannesburg").subtract('days', 6).format('MMMM DD, YYYY');
var endDate = moment(today).tz("Africa/Johannesburg").format('MMMM DD, YYYY');

$("#from_date").val(startDate);
$("#to_date").val(endDate);

$(function () {
//Date range as a button
    $('#daterange-btn').daterangepicker(
      {
		showCustomRangeLabel: false,
        ranges   : {
          '7 Days' : [moment(today).tz("Africa/Johannesburg").subtract(6, 'days'), moment(today).tz("Africa/Johannesburg")],
          '30 Days': [moment(today).tz("Africa/Johannesburg").subtract(29, 'days'), moment(today).tz("Africa/Johannesburg")],
        },
        startDate: moment(today).tz("Africa/Johannesburg").subtract('days', 6),
        endDate  : moment(today).tz("Africa/Johannesburg")
      },
      function (start, end, text_label="") {
        //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $(".selected_date").html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
       
        $('#daterange-btn span').html(text_label);
		var restaurant_id = $("#restaurant_id").val();
        $("#sales_report").html("");
		startDate = start.format('MMMM D, YYYY');
		endDate = end.format('MMMM D, YYYY');
		$("#from_date").val(start.format('MMMM D, YYYY'));
		$("#to_date").val(end.format('MMMM D, YYYY'));
		if(restaurant_id!=""){
        $.ajax({
                type:'POST',
                url:'<?php echo base_url();?>admin/merchants/top_meals_report_ajax',
                data: {id:restaurant_id,from_date:start.format('MMMM D, YYYY'),to_date:end.format('MMMM D, YYYY')},
				beforeSend: function(){
			      $('.loader').show();
				  $('.sales_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.sales_report_container').html(result);
                    
                }
             });  
        
      }
	  }
    )

    $("body").on("change", "#restaurant_id", function(){
    var restaurant_id = $("#restaurant_id").val();
	if(restaurant_id!=""){
        $.ajax({
                type:'POST',
                 url:'<?php echo base_url();?>admin/merchants/top_meals_report_ajax',
                data: {restaurant_id:restaurant_id,from_date:startDate,to_date:endDate},
				beforeSend: function(){
			      $('.loader').show();
				  $('.sales_report_container').html("");
                },
                success:function(result){
					$('.loader').hide();
                    $('.sales_report_container').html(result);
                    
                }
             });  
    }
 });
	
 });
 
 $('#restaurant_id').select2({
    placeholder: "Select Merchant",
  });
  $("#topMealsForm").validate({
	  rules:{
		 "restaurant_id" :{
			 required : true,
		 },
	  },
	  errorPlacement: function(error, element) {
			error.insertAfter(".restaurant_id_error");
		}
  });
</script>

</body>
</html>
