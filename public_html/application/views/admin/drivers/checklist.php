<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($checklist); exit;?>
<style type="text/css">
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
          <div class="panel-body" style="">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class=" p_style">Dryvarfoods Driver Checklist  <span class="pull-right">
				<form id="exportForm" method="post">
				<input type="hidden" id="report_type" name="report_type" value="">
				<input class="btn btn-default btn-export-csv" type="button" value="Export as CSV">
				<input class="btn btn-default btn-export-pdf" type="button" value="Export as PDF">
				</form>
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Requests    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="checklistFilter" autocomplete="off">
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
                  
                  <div class=" col-md-4 col-xs-6">
                    <label><strong>Select Month </strong></label>
                    <select name="month" id="month" class="js-example-data-ajax form-control">
                      <option value="">Select Month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select> 
                  </div>
                  <div class='col-sm-4'>
                    <label><strong>Date From</strong></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class='col-sm-4'>
                    <label><strong>Date To</strong></label>
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" id="date_too" placeholder="To Date" name="date_too" class="form-control datepicker select_filters" value="" autocomplete="off" aria-invalid="false">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12" style="">

                  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Sort By </strong></label>
                    <select class="js-example-data-ajax form-control orderby" id="orderby" name="orderby">
                      <option value="ASC" >Asc Checklist</option>
                      <option value="DESC" selected="selected">Desc Checklist</option>
                    </select>
                  </div>   
				  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Name </strong></label>
                    <input class="form-control" type="text" name="firstname" id="firstname" value="" placeholder="Search By Name">
                  </div>
				  
				  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Mobile Number </strong></label>
                    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Search By Mobile Number">
                  </div>
				 
				 
				 </div>
				 
				 <div class="col-md-12 col-xs-12">
				 
				 <div class="col-md-12 col-xs-12">
					<div class="pull-right">
					  <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
					</div>
				 </div>
			  </div>
              </div>
               </form>
              <hr />

          <div class="row">
            
            <div class=" col-md-12 col-xs-12">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 10px;">
            
            <span class="label label-success mtop5 s-status invoice-status-2">Scratched – S</span>
            <span class="label label-success mtop5 s-status invoice-status-2">Dented – D</span>
            <span class="label label-success mtop5 s-status invoice-status-2">Broken – B</span>
            <span class="label label-success mtop5 s-status invoice-status-2">Cracked – C</span>
            <span class="label label-success mtop5 s-status invoice-status-2">Missing – M</span>
            <span class="label label-success mtop5 s-status invoice-status-2">Neat - N</span>
            
            
            
			<div class="pull-right">
			<a class="btn btn-info" href="<?php echo AURL;?>drivers/add_checklist">Add Checklist</a>
			</div>
			<br/>
			<br/>
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="min-width: 30px;font-weight: bold;" aria-label=" activate to sort column ascending">S.NO</th>
                  <th style="min-width: 50px;font-weight: bold;">Driver Name</th>
                  <th style="min-width: 120px;font-weight: bold;">Mobile Number</th>
                  <th style="min-width: 120px;font-weight: bold;">Uniform</th>
				  <th style="min-width: 120px;font-weight: bold;">Tyres</th>
				  <th style="min-width: 120px;font-weight: bold;">Front Panel</th>
				<!--  <th style="min-width: 120px;font-weight: bold;">Right Side</th>
                  <th style="min-width: 120px;font-weight: bold;">Left Side</th>-->
				  <th style="min-width: 120px;font-weight: bold;">Exhaust Cover</th>
				  <th style="min-width: 120px;font-weight: bold;">Licence Disc</th>
				  <th style="min-width: 120px;font-weight: bold;">Mirrors</th>
				  <!--<th style="min-width: 120px;font-weight: bold;">Bin</th>-->
                  <th style="min-width: 120px;font-weight: bold;">Created At</th>
                  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="checklist_list">

                  <?php foreach ($checklist as $key => $value) { 
           
          
           ?>
                  <tr role="row">
                    <td><?php echo $key+1; ?></td>
					<td><a href="<?php echo AURL ?>drivers/detail/<?php echo $value["driver_id"];?>"><?php echo $value["driver_name"];?></a></td>
					<td><?php echo $value["mobile_number"];?></td>
					<td><?php echo $value["uniform"];?></td> 
				   <td><?php echo $value["tyres"];?></td>
				   <td><?php echo $value["front_panel"];?></td>
				  <!-- <td><?php echo $value["right_side"];?></td>
				   <td><?php echo $value["left_side"];?></td>-->
				   <td><?php echo $value["exhaust_cover"];?></td>
				   <td><?php echo $value["licence_disc"];?></td>
				   <td><?php echo $value["mirrors"];?></td>
				   <!--<td><?php echo $value["bin"];?></td>-->   
                   <td><?php echo date("F j, Y, g:i a",  strtotime($value['created_at']));?></td>
                    <td><a href="<?php echo AURL;?>drivers/detail/<?php echo $value['driver_id'];?>"class="btn btn-default btn-icon"><i class="fa fa-eye"></i></a></td>
                 
				</tr>
                  <?php } ?>
                  
                
              </tbody>
            </table>
            <span id="response_pagination">
              <?php
              if($page_links !=""){ ?>
                
                  <div class="row_iner">
                      <div id="pagigi">
                          <div id="page_links123"><?php echo $page_links;?></div>
                      </div>
                  </div>
                  <?php
              }
              ?>
          </span>
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
<script>

  $("body").on("click", ".checklist_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");
    
    var data = $("#checklistFilter").serialize();
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>drivers/checklist_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){

              var res_arr = response.split('***||***');

              $('#checklist_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("click", "#search_btn", function(){


    var page = 0;
	
	var data = $("#checklistFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>drivers/checklist_ajax/"+page,
        type: "POST",
        data: data,
		beforeSend: function(){
			   $('#page_links123').html("");
			   $('#checklist_list').html("");
               $('#record_count').html(0);
               $('.loader').show();
        },
        success: function(response){
          $('.loader').hide();
          var res_arr = response.split('***||***');
		  
		  if(res_arr=='norchecklist'){
			   $('#page_links123').html();
			   $('#checklist_list').html('<tr><td colspan="13"><div class="alert alert-danger" role="alert"> No checklist found !</div></td></tr>');
               $('#record_count').html(0);
		  }else{
        
          $('#checklist_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		  
		  }
          

        }
    });   

  });
  
</script>
</body>
</html>
