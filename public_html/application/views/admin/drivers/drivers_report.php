<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
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
</style>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body" style="">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class=" p_style">Dryvarfoods Driver Reports</h3></div>
              <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> Filter Drivers    <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="driversFilter" method="post" action="<?php echo base_url();?>admin/drivers/export_report">
			  <input type="hidden" name="report_type" id="report_type" value="csv">
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
				  </div>
                  <div class=" col-md-4 col-xs-6">
                    <label><strong>Select Month </strong></label>
                    <select name="month" id="month" class="js-example-data-ajax form-control select_filters">
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

                  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Name </strong></label>
                    <input class="form-control select_filters" type="text" name="firstname" id="firstname" value="" placeholder="Search By Name">
                  </div>
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Email </strong></label>
					<input class="form-control select_filters" type="text" name="email" id="email" value="" placeholder="Search By Email">
                    
                  </div>
				  <div class=" col-md-3 col-xs-6">
                  
                    <label class="mtop15"><strong>Phone Number </strong></label>
					<input class="form-control select_filters" type="text" name="phonenumber" id="phonenumber" value="" placeholder="Search By Phone Number">
                    
                  </div>
                  <div class=" col-md-3 col-xs-6">
                    <label class="mtop15"><strong>City </strong></label>
					<input class="form-control select_filters" type="text" name="city" id="city" value="" placeholder="Search By City">
                    
                  </div>
                </div>
              </div>
			  <div class="row" style="margin-top:25px;">
			  <div class="col-md-12 col-xs-12">
			    <div class="col-md-12 col-xs-12">
                <div class="row col-md-2 col-xs-3">
                <div class="pull-left">
					  <input class="btn btn-default export_report_btn" type="submit" name="export_csv_btn" id="export_csv_btn" value="Export As CSV">
					</div>
                    </div>
                    <div class="col-md-1 col-xs-3">
                    <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="name" name="online" value="1">
                           <label for="project_name">Online</label>
                        </div>
                        </div>
                        <div class="col-md-1 col-xs-3">
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" id="name" name="offline" value="0">
                           <label for="project_name">Offline</label>
                        </div>
                        </div>
                        
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
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
            <table class="table table-hover  no-footer dtr-inline collapsed" >
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="min-width: 30px;font-weight: bold;">S.NO</th>
                  <th style="min-width: 50px;font-weight: bold;">Driver ID</th>
                  <th style="min-width: 120px;font-weight: bold;">Name</th>
                  <th style="min-width: 100px;font-weight: bold;">Online / Offline</th>
                  
                  <th style="min-width: 120px;font-weight: bold;">Email</th>
                  <th style="min-width: 130px;font-weight: bold;">Phone Number</th>
				  <!--<th style="min-width: 80px;font-weight: bold;">City</th>-->
                  <th style="min-width: 120px;font-weight: bold;">Total Earnings</th>
                  <th style="min-width: 8px;font-weight: bold;">Total Paid</th>
                  <th style="min-width: 80px;font-weight: bold;">Status</th>
				  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="drivers_list">

                  <?php foreach ($drivers as $key => $value) { 
           
          
           ?>
                  <tr role="row" style="height: 50px;">
                    <td><?php echo $key+1; ?></td>
                    <td><a target="_Blank" href="<?php echo AURL;?>drivers/detail/<?php echo $value['id']; ?>"> <?php echo $value['id']; ?></a></td>
					<td><?php echo $value["firstname"];?></td>
                     <td>
                    <?php if($value['user_status']==1){ ?>
                    <span class="label label-success">ONLINE</span>
                     <?php }else{ ?>
                      <span class="label label-danger">OFFLINE</span>
                      <?php }?>
                    </td>
					<td><?php echo $value["email"];?></td>
					<td><?php echo ' <i class="fa fa-phone" style="font-size:20px; color:#84c529"></i> ( +27 ) '.$value["phonenumber"];?></td>
                   <!-- <td><?php echo ($value['city']==" " || $value['city']=="") ? "<span >N/A</span>" : $value['city'];  ?></td>-->
                    <td><b>R</b> <?php echo number_format($value["total_earnings"], 2, ".", ",");?></td>
                    <td><b>R</b> <?php echo number_format($value["total_paid"], 2, ".", ",");?></td>
                    <td>
                    <?php if($value['active']==1){ ?>
                    <span class="label label-success">Active</span>
                     <?php }else{ ?>
                      <span class="label label-danger">Inactive</span>
                      <?php }?>
                    </td>
					
                    <td><a href="<?php echo AURL;?>drivers/detail/<?php echo $value['id'];?>"class="fa fa-eye"></a>
                    <!--<a href="<?php echo AURL;?>drivers/weekly_payout/<?php echo $value["id"];?>"><i class="fa fa-bar-chart-o"></i></a>-->&nbsp;&nbsp;&nbsp;<a href="<?php echo AURL;?>drivers/payout/<?php echo $value["id"];?>"><i class="fa fa-pie-chart"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo AURL;?>drivers/bank_details/<?php echo $value["id"];?>"><i class="fa fa-credit-card"></i></a>&nbsp;&nbsp;&nbsp;<a title="Account Activity" href="<?php echo AURL;?>drivers/account_activity/<?php echo $value["id"];?>"><i class="fa fa-history"></i></a></td>
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
</div>
<?php init_tail(); ?>
<script>
  $("body").on("click", ".driver_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var data = $("#driversFilter").serialize();
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>drivers/report_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){

              var res_arr = response.split('***||***');

              $('#drivers_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("click", "#search_btn", function(){
	  
    var page = 0;
	var data = $("#driversFilter").serialize();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>drivers/report_ajax/"+page,
        type: "POST",
        data: data,
		beforeSend: function(){
			   $('#page_links123').html("");
			   $('#drivers_list').html("");
               $('#record_count').html(0);
			   

                     $('.loader').show();
                },
        success: function(response){
          $('.loader').hide();
          var res_arr = response.split('***||***');
		  
		  if(res_arr=='norreport'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No drivers found !</div>');
			   $('#drivers_list').html("");
               $('#record_count').html(0);
			   
			
		  }else{
        
          $('#drivers_list').html(res_arr[0]);
          $('#record_count').html(res_arr[1]);
		   $('#page_links123').html(res_arr[2]);
		  
		  }
          

        }
    });   

  });
  
</script>
</body>
</html>
