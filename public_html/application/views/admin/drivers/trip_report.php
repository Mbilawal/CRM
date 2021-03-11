<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //echo "<pre>"; print_r($drivers_arr); exit;?>
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
                <h3 class=" p_style">Dryvarfoods Driver Trip Reports</h3></div>
              <hr class="hr_style" />
              <div class="col-md-12 col-xs-12 bold p_style" style="">
                <h3> Filter Drivers Trip  
                  <div  class="pull-right" style="float:right">
                    <small class="primary" style="color:darkgreen">Showing 25 of 
                      <span id="record_count"  ><?php echo $total_count?></span>
                    </small>
                  </div>
                </h3>
              </div>
              <div class="clearfix"></div>
              
    			  <form id="driversFilter" method="post" action="">
              <div class="row">
                <div class="col-md-12 col-xs-12" style="">
				  
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

  			      <div class="row" style="margin-top:25px;">
  			        <div class="col-md-12 col-xs-12">
  			          <div class="col-md-12 col-xs-12">
  					        <div class="pull-right">
  					          <input class="btn btn-info" type="button" name="search_btn" id="search_btn" value="Search">
  					        </div>
  				        </div>
  			        </div>
  			      </div>
  			    </form>
             
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
                        <th style="min-width: 100px;font-weight: bold;">Booking No.</th>
                        <th style="min-width: 120px;font-weight: bold;">Address</th>
                        <th style="min-width: 120px;font-weight: bold;">Trip Date</th>
                        <th style="min-width: 120px;font-weight: bold;">Trip Amount</th>
                        <th style="min-width: 120px;font-weight: bold;">Distance</th>
                        <th style="min-width: 120px;font-weight: bold;">Driver</th>
                        <th style="min-width: 120px;font-weight: bold;">Estimated Time</th>
      				          <th style="min-width: 100px;font-weight: bold;">Actual Time </th>
                        <th style="min-width: 100px;font-weight: bold;">Variance</th>
                        <th style="min-width: 60px;font-weight: bold;">Action</th>
                      </tr>
                    </thead>
                    <tbody id="drivers_list">

                      <?php foreach ($drivers_arr as $key => $value){?>
                      <tr role="row" style="height: 50px;">
                        <td><?php echo $key+1; ?></td>
                        <td><a target="_Blank" href="<?php echo AURL;?>clients/orders_detail/<?php echo $value['order_delivery']['order_id']; ?>"> <?php echo $value['order_delivery']['order_id']; ?></a></td>
                        <td><?php echo '<b>From : </b>'.$value['order_delivery']["pickup_location"].'<br /><b>To : </b>'.$value['order_delivery']["drop_location"];?></td>
    					          <td><?php echo date("F j, Y, g:i a", strtotime($value['order_delivery']["created_at"]));?></td>
                        <td><?php echo ($value['order_arr']["delivery_fee"] != "" && $value['order_arr']["delivery_fee"]!=0.00) ? "R ".$value['order_arr']["delivery_fee"] : '<span class="label label-danger">N/A</span>';?></td>
                        <td><?php echo number_format($value['order_delivery']["drop_distance"],  2, '.', '')."Km";?></td>
    					          <td><a target="_Blank" href="<?php echo AURL;?>drivers/detail/<?php echo $value['order_arr']['driver_id']; ?>"><?php echo ucfirst($value["firstname_driver"]);?></a></td>
                        <td>
    					          <?php 
            						  $to_time = ($value['order_arr']['created_at']);
            							$from_time = ($value['order_arr']['delivery_at']);
            							$fialONe =  round(abs($to_time - $from_time) / 60,2);
            							echo $fialONe. " minutes";
            							$to_time2 = strtotime($value['order_delivery']['started_at']);
            							$from_time2 = strtotime($value['order_delivery']['delivery_at']);
            							$fialTwo = round(abs($to_time2 - $from_time2) / 60,2);
            					  ?>
                        </td>
                        <td><?php echo $fialTwo. " minutes";?></td>
                        <td>
                          <?php 
    					             $variana  =  $fialTwo - $fialONe  ;
    					              if($variana >0){?>
    						              <span class="label label-danger"><?php echo $variana. " minutes";?></span>
    					              <?php }else{?>
                              <span class="label label-success"><?php echo $variana. " minutes";?></span>
                            <?php }?>
                        </td>
                        <td>
                          <a target="_Blank" href="<?php echo AURL;?>clients/orders_detail/<?php echo $value['order_delivery']['order_id']; ?>" class="btn btn fa fa-eye"></a>
                        </td>
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
          url: "<?php echo admin_url(); ?>drivers/trip_report_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){

              var res_arr = response.split('***||***');

              $('#drivers_list').html(res_arr[3]);
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
        url: "<?php echo admin_url(); ?>drivers/trip_report_ajax/"+page,
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

  		    if(response == 'norreport'){
  			    $('#page_links123').html('<div class="alert alert-danger" role="alert"> No drivers found !</div>');
  			    $('#drivers_list').html("");
            $('#record_count').html(0);
  		    }else{
            $('#drivers_list').html(res_arr[3]);
            $('#record_count').html(res_arr[1]);
  		      $('#page_links123').html(res_arr[2]);
  		    }
      }
    });   

  });
  
</script>
</body>
</html>
