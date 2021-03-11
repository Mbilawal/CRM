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
                <h3 class=" p_style">General Customers Reports <div class="pull-right">
					  <a href="<?php echo base_url();?>admin/general_customers/new_customer" class="btn btn-info"  name="" id="" >Add Customer</a>
					</div></h3></div>
             <!-- <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> General Customers <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>-->
               <?php
                    if ($this->session->flashdata('err_message')) {
                    ?>
                      <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                    } //end if($this->session->flashdata('err_message'))

                    if ($this->session->flashdata('ok_message')) {
                    ?>
                      <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php
                    } //if($this->session->flashdata('ok_message'))
                    ?>
              <div class="clearfix"></div>
              <hr class="hr_style">
			  <form id="driversFilter" method="post" >
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
                  
                  <div class=" col-md-4 col-xs-6">
                  
                    <label class=""><strong>Name </strong></label>
                    <input class="form-control select_filters" type="text" name="firstname" id="firstname" value="" placeholder="Search By Name">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-xs-12" style="">

                  
				  <div class=" col-md-4 col-xs-6">
                  
                    <label class="mtop15"><strong>Email </strong></label>
					<input class="form-control select_filters" type="text" name="email" id="email" value="" placeholder="Search By Email">
                    
                  </div>
                  
                   <div class=" col-md-4 col-xs-6">
                   <label class="mtop15"><strong>. </strong></label>
					  <input class="btn btn-info" type="button" name="" id="" value="Search"style="margin-top:35px;">
					</div>
				  
                </div>
              </div>
			  <div class="row" style="margin-top:25px;">
			  <div class="col-md-12 col-xs-12">
			    <div class="col-md-12 col-xs-12">
                
                        
					
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
                  <th style="min-width: 30px;font-weight: bold;">Customer ID</th>
                  <th style="min-width: 50px;font-weight: bold;">First Name</th>
                  <th style="min-width: 120px;font-weight: bold;">Last Name</th>
                  
                  <th style="min-width: 120px;font-weight: bold;">Email</th>
                  <th style="min-width: 130px;font-weight: bold;">Phone Number</th>
				  <th style="min-width: 80px;font-weight: bold;">City</th>
                  <th style="min-width: 80px;font-weight: bold;">Status</th>
				  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="drivers_list">

                  <?php foreach ($arr_general_customers as $key => $value) {  ?>
                  
                  <tr role="row" style="height: 50px;">
                    <td><?php echo $key+1; ?></td>
                    <td><a target="_Blank" href="#"> <?php echo $value['id']; ?></a></td>
					<td><?php echo ($value["firstname"]!="") ? $value["firstname"] :"N/A";?></td>
                    <td><?php echo ($value["lastname"]!="") ? $value["lastname"]: "N/A";?></td>
					<td><?php echo ($value["email"]!="") ? $value["email"]: "N/A";?></td>
					<td><?php echo ' <i class="fa fa-phone" style="font-size:20px; color:#84c529"></i> ( +27 ) '.$value["phonenumber"];?></td>
                    <td><?php echo ($value['city']!=" " || $value['city']=="") ? "<span >N/A</span>" : $value['city'];  ?></td>
                   <td>
                    <?php if($value['user_status']==1){ ?>
                    <span class="label label-success">Active</span>
                     <?php }else{ ?>
                      <span class="label label-danger">In Active</span>
                      <?php }?>
                    </td>
					
                    <td><a href="https://crm.dryvarfoods.com/admin/general_customers/edit_customer/<?php echo $value['id']; ?>" class="btn btn-primary fa fa-eye"></a></td>
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
