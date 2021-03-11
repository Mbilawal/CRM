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
                <h3 class="padding-5 p_style">Filter Top 10 Drop Up Location Suburb  <span class="pull-right">
				</span>
				</h3>
			  </div>
              <!--<hr class="hr_style" />-->
			  <!--<div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter  Report</h3></div>-->
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="ReportFilter" method="post">
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
				  <div class="pull-left col-md-6">
				    <label><strong>Date From</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input required="true" type="text" id="from_date" name="from_date" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
					<div class="from_date_error"></div>
				  </div>
                    <div class="toolbar pull-right col-md-6">
                        <label><strong>Date To</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input required="true" type="text" id="to_date" placeholder="To Date" name="to_date" class="form-control datepicker select_filters" value="" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div> 
                    <div class="to_date_error"></div>					
					</div>
                  
				
              </div>
			  <div class="row">
			  <div class="col-md-12 col-xs-12">
			    <div class="pull-right">
			      <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
			    </div>
			  </div>
			  </div>
			  </form>
              
              
          <div class="row sales_report_container">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			<div class="col-md-12">
			<h2>Dryvarfoods Top 10 Drop Up Location Suburb Report</h2>
			<span class="half-border"></span>
			<div class="report_container">
				<h4 class="label label-danger">No Results Found!</h4> 
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

$("#ReportFilter").validate({
	  errorPlacement: function(error, element) {
            if (element.attr("name") == 'from_date') {
                error.appendTo(".from_date_error");
            }
			else if (element.attr("name") == 'to_date') {
                error.appendTo(".to_date_error");
            }
            else {
                error.insertAfter(element);
            }
        }
  });
  
$("body").on("click", "#search_btn", function(){


    if($("#ReportFilter").valid()){
  
	var data = $("#ReportFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>reports/top_10_drop_up_location_suburb_ajax",
        type: "POST",
        data: data,
		beforeSend: function(){
			     $(".report_contaner").html("");
                 $('.loader').show();
                },
        success: function(response){
          $('.loader').hide();
          $(".report_container").html(response);
        }
    }); 
    }
    else{
		$("#ReportFilter").validate();
    }		

  });
  
</script>

</body>
</html>
