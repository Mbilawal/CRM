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

<style>

.modal-body {
  overflow-x: auto;
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
                <h3 class=" p_style"> Invoice Reports <div class="pull-right">
					  <a href="<?php echo base_url();?>admin/general_customers/new_invoice" class="btn btn-info"  name="" id="" >Add Invoice</a>
					</div></h3></div>
             <!-- <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style=""><h3> General Customers <div  class="pull-right" style="float:right"><small class="primary" style="color:darkgreen">Showing 25 of <span id="record_count"  ><?php echo $total_count?></span></small></div></h3> </div>-->
              
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
                      <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                    <?php
                    } //end if($this->session->flashdata('err_message'))

                    if ($this->session->flashdata('ok_message')) {
                    ?>
                      <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                    <?php
                    } //if($this->session->flashdata('ok_message'))
                    ?>
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

              
			  <div class="row" style="margin-top:25px;">
			  <div class="col-md-12 col-xs-12">
			    <div class="col-md-12 col-xs-12">
                
                        
					<div class="pull-right">
					  <input class="btn btn-info" type="button" name="" id="" value="Search">
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
                  <th style="min-width: 30px;font-weight: bold;">Customer</th>
                 
                  <th style="min-width: 120px;font-weight: bold;">Due Date</th>
                  
                  <th style="min-width: 120px;font-weight: bold;">Currency</th>
                   <th style="min-width: 50px;font-weight: bold;">Sale Amount </th>
                   <!-- <th style="min-width: 50px;font-weight: bold;">Commission Amount </th>-->
                  <th style="min-width: 130px;font-weight: bold;">Amount Paid</th>
				  <th style="min-width: 80px;font-weight: bold;">Total</th>
                  <th style="min-width: 80px;font-weight: bold;">Status</th>
				  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
              <tbody id="drivers_list">

                  <?php foreach ($arr_invoices as $key => $value) {  ?>
                  
                  <tr role="row" style="height: 50px;">
                    <td><?php echo $value['invoice_number']; ?></td>
                    <td><a target="_Blank" href="#"> <?php echo ($value['customer']!="") ? $value['customer'] : "N/A"; ?></a></td>
					
                    <td><?php echo date("F j, Y, g:i a", strtotime($value['duedate']));?></td>
                     
					<td><?php echo '<b>ZAR </b>';?></td>
					<td><?php echo number_format($value['sales_amount'],2); ?></td>
                   <!-- <td><?php echo number_format($value['commission_amount'],2); ?></td>-->
                    <td><?php echo number_format($value['amount_paid'],2); ?></td>
                    <td><?php echo number_format($value['total'],2); ?></td>
                   <td>
                    <?php if($value['status']==1){ ?>
                        <span class="label label-success">Active</span>
                         <?php }else{ ?>
                        <span class="label label-danger">In Active</span>
                    <?php }?>
                    </td>
                    <!--<a href="#" data-toggle="modal" data-target="#exampleModal<?php echo $value['invoice_number']; ?>" class="btn btn-primary fa fa-eye"></a>-->
					
                    <td><a href="https://crm.dryvarfoods.com/admin/general_customers/view_invoice/<?php echo $value['id']; ?>" class="btn btn-primary fa fa-eye"></a></td>
                  </tr>
                  
                  <!--<div class=" modal fade bd-example-modal-xl" id="exampleModal<?php echo $value['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
     <div class="card">
         <div class="card-header p-4">
             <a class="pt-2 d-inline-block" href="index.html" data-abc="true">BBBootstrap.com</a>
             <div class="float-right">
                 <h3 class="mb-0">Invoice #BBB10234</h3>
                 Date: 12 Jun,2019
             </div>
         </div>
         <div class="card-body">
             <div class="row mb-4">
                 <div class="col-sm-6">
                     <h5 class="mb-3">From:</h5>
                     <h3 class="text-dark mb-1">Tejinder Singh</h3>
                     <div>29, Singla Street</div>
                     <div>Sikeston,New Delhi 110034</div>
                     <div>Email: contact@bbbootstrap.com</div>
                     <div>Phone: +91 9897 989 989</div>
                 </div>
                 <div class="col-sm-6 ">
                     <h5 class="mb-3">To:</h5>
                     <h3 class="text-dark mb-1">Akshay Singh</h3>
                     <div>478, Nai Sadak</div>
                     <div>Chandni chowk, New delhi, 110006</div>
                     <div>Email: info@tikon.com</div>
                     <div>Phone: +91 9895 398 009</div>
                 </div>
             </div>
             <div class="table-responsive-sm">
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th class="center">#</th>
                             <th>Item</th>
                             <th>Description</th>
                             <th class="right">Price</th>
                             <th class="center">Qty</th>
                             <th class="right">Total</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <td class="center">1</td>
                             <td class="left strong">Iphone 10X</td>
                             <td class="left">Iphone 10X with headphone</td>
                             <td class="right">$1500</td>
                             <td class="center">10</td>
                             <td class="right">$15,000</td>
                         </tr>
                         <tr>
                             <td class="center">2</td>
                             <td class="left">Iphone 8X</td>
                             <td class="left">Iphone 8X with extended warranty</td>
                             <td class="right">$1200</td>
                             <td class="center">10</td>
                             <td class="right">$12,000</td>
                         </tr>
                         <tr>
                             <td class="center">3</td>
                             <td class="left">Samsung 4C</td>
                             <td class="left">Samsung 4C with extended warranty</td>
                             <td class="right">$800</td>
                             <td class="center">10</td>
                             <td class="right">$8000</td>
                         </tr>
                         <tr>
                             <td class="center">4</td>
                             <td class="left">Google Pixel</td>
                             <td class="left">Google prime with Amazon prime membership</td>
                             <td class="right">$500</td>
                             <td class="center">10</td>
                             <td class="right">$5000</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             <div class="row">
                 <div class="col-lg-4 col-sm-5">
                 </div>
                 <div class="col-lg-4 col-sm-5 ml-auto">
                     <table class="table table-clear">
                         <tbody>
                             <tr>
                                 <td class="left">
                                     <strong class="text-dark">Subtotal</strong>
                                 </td>
                                 <td class="right">$28,809,00</td>
                             </tr>
                             <tr>
                                 <td class="left">
                                     <strong class="text-dark">Discount (20%)</strong>
                                 </td>
                                 <td class="right">$5,761,00</td>
                             </tr>
                             <tr>
                                 <td class="left">
                                     <strong class="text-dark">VAT (10%)</strong>
                                 </td>
                                 <td class="right">$2,304,00</td>
                             </tr>
                             <tr>
                                 <td class="left">
                                     <strong class="text-dark">Total</strong> </td>
                                 <td class="right">
                                     <strong class="text-dark">$20,744,00</strong>
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <div class="card-footer bg-white">
             <p class="mb-0">BBBootstrap.com, Sounth Block, New delhi, 110034</p>
         </div>
     </div>
 </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>-->
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
