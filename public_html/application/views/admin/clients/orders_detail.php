<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
 /*echo '<pre>';
        print_r($order_arr);
        exit;*/
?>
<?php init_head(); ?>


<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<div id="wrapper">
<div class="content">
<div class="row">
  <div class="col-md-12">
    <div class="panel_s">
      <div class="panel-body" style="overflow-x: scroll;">
        <div class="clearfix"></div>
        <div class="row mbot15">
          <div class="col-md-12">
          
            <h3 class="padding-5" style="color:#03A9F4"> Dryvarfoods Order Detail Report <b class="pull-right">Order ID : <?php echo $order_id; ?></b> </h3>
          
          </div>
          <!--<div class="col-md-3 col-xs-6 border-right" style="border-bottom: 2px solid #717171;">
            <h3 class="bold"><?php echo ($orders_count); ?></h3>
            <span class="text-dark"></span> </div>
          <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
            <h3 class="bold"><?php echo ($orders_count_completed); ?></h3>
            <span class="text-success"></span> </div>
          <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #f32200;">
            <h3 class="bold"><?php echo ($orders_count_declined); ?></h3>
            <span class="text-danger"></span> </div>
          <div class="col-md-2 col-xs-6 border-right" style="border-bottom: 2px solid #31f300;">
            <h3 class="bold"><?php echo ($orders_count_pending); ?></h3>
            <span class="text-info"></span> </div>
          <div class="col-md-3 col-xs-6" style="border-bottom: 2px solid #717171;">
            <h3 class="bold"></h3>
          </div>-->
           <hr class="hr_style" />
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-xs-12" style="">
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
              <div class="panel_s">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-md-6 border-right project-overview-left">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="project-info bold font-size-14" style="color:#03A9F4"> Overview </p>
                        </div>
                        <div class="col-md-12">
                          <table class="table no-margin project-overview-table">
                            <tbody>
                              <tr class="project-overview-id" >
                                <td class="bold" style="width: 190px;">Customer Name</td>
                                <td><?php  echo ($order_arr['customer_name']!='' && $order_arr['customer_name']!=' ') ? ucfirst($order_arr['customer_name']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-id">
                                <td class="bold">Customer Address</td>
                                <td><?php  echo ($order_arr['customer_address']!='' && $order_arr['customer_address']!=' ') ? ucfirst($order_arr['customer_address']) : ""; ?>, <?php  echo ($order_arr['customer_state']!='' && $order_arr['customer_state']!=' ') ? ucfirst($order_arr['customer_state']) : ""; ?>, <?php  echo ($order_arr['customer_city']!='' && $order_arr['customer_city']!=' ') ? ucfirst($order_arr['customer_city']) : ""; ?></td>
                              </tr>
                              <tr class="project-overview-id">
                                <td class="bold">Customer Phone</td>
                                <td><i class="fa fa-phone" style="font-size:20px; color:#84c529"></i>   ( +27 ) <?php  echo ($order_arr['customer_phonenumber']!='' && $order_arr['customer_phonenumber']!=' ') ? ($order_arr['customer_phonenumber']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Company Name</td>
                                <td><?php  echo ($order_arr['company_name']!='' && $order_arr['company_name']!=' ') ? ucfirst($order_arr['company_name']) : "N/A"; ?></td>
                              </tr>
                               <tr class="project-overview-id">
                                <td class="bold">Company Address</td>
                                <td><?php  echo ($order_arr['company_address']!='' && $order_arr['company_address']!=' ') ? ucfirst($order_arr['company_address']) : ""; ?>, <?php  echo ($order_arr['company_state']!='' && $order_arr['company_state']!=' ') ? ucfirst($order_arr['company_state']) : ""; ?>, <?php  echo ($order_arr['company_city']!='' && $order_arr['company_city']!=' ') ? ucfirst($order_arr['company_city']) : ""; ?></td>
                              </tr>
                              <tr class="project-overview-id">
                                <td class="bold">Company Phone</td>
                                <td><i class="fa fa-phone" style="font-size:20px; color:#84c529"></i>   ( +27 ) <?php  echo ($order_arr['company_phonenumber']!='' && $order_arr['company_phonenumber']!=' ') ? ($order_arr['company_phonenumber']) : "N/A"; ?></td>
                              </tr>
                             
                              <tr class="project-overview-customer">
                                <td class="bold">Order Type </td>
                                <td><span class="label label-success">
								<?php  echo ($order_arr['order_type']!='' && $order_arr['order_type']!=' ') ? ucfirst($order_arr['order_type']) : "N/A"; ?>
                                </span>
                                </td>
                              </tr>
                             
                              <tr class="project-overview-customer">
                                <td class="bold">Sub Total Amount</td>
                                <td><?php  echo ($order_arr['subtotal']!='' && $order_arr['subtotal']!=' ') ? ('R '.$order_arr['subtotal']) : "N/A"; ?></td>
                              </tr>
                             
                              <tr class="project-overview-customer">
                                <td class="bold">Total Amount</td>
                                <td><?php  echo ($order_arr['total_amount']!='' && $order_arr['total_amount']!=' ') ? ('R '.$order_arr['total_amount']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Commission Fee</td>
                                <td><?php  echo ($order_arr['restaurant_commision_fee']!='' && $order_arr['restaurant_commision_fee']!=' ') ? ('R '.$order_arr['restaurant_commision_fee']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Delivery Fee</td>
                                <td><?php  echo ($order_arr['delivery_fee']!='' && $order_arr['delivery_fee']!=' ') ? ('R '.$order_arr['delivery_fee']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-billing">
                                <td class="bold">Driver Name</td>
                                <td><?php  echo ($order_arr['driver_name']!='' && $order_arr['driver_name']!=' ') ? ucfirst($order_arr['driver_name']) : "N/A"; ?></td>
                              </tr>
                              
                              <tr class="project-overview-id">
                                <td class="bold">Driver Phone</td>
                                <td><i class="fa fa-phone" style="font-size:20px; color:#84c529"></i>   ( +27 ) <?php  echo ($order_arr['driver_phonenumber']!='' && $order_arr['driver_phonenumber']!=' ') ? ($order_arr['driver_phonenumber']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-date-created">
                                <td class="bold">Order Created at</td>
                                <td><?php  echo ($order_arr['created_at']!='' && $order_arr['created_at']!='') ? date('d F, Y (l) h:i:s A', $order_arr['created_at']) : "N/A"; ?></td>
                             
                             
                            <!--  <tr class="project-overview-deadline">
                                <td class="bold">Order Accepted</td>
                                <td><?php  echo ($order_arr['accepted_at']!='' && $order_arr['accepted_at']!=0) ? date('d F, Y (l) h:i:s A', $order_arr['accepted_at']) : "N/A"; ?></td>
                              </tr>-->
                             
                             
                              <tr class="project-overview-deadline">
                                <td class="bold">Ready Driver Requested</td>
                                <td><?php  echo ($order_arr['accepted_at']!='' && $order_arr['accepted_at']!=0) ? date('d F, Y (l) h:i:s A', $order_arr['accepted_at']) : "N/A"; ?></td>
                                
                                </tr>
                                
                                <tr class="project-overview-deadline">
                                <td class="bold">Accepted by driver at</td>
                                <td><?php  echo ($order_arr['delivery_details']['driver_accepted_at']!='' && $order_arr['delivery_details']['driver_accepted_at']!=0) ? date('d F, Y (l) h:i:s A', strtotime($order_arr['delivery_details']['driver_accepted_at'])) : "N/A"; ?></td>
                                
                                </tr>
                                
                                
                                <tr class="project-overview-deadline">
                                <td class="bold"> Confirmed by driver at</td>
                                <td><?php  echo ($order_arr['delivery_details']['confirmed_at']!='' && $order_arr['delivery_details']['confirmed_at']!=0) ? date('d F, Y (l) h:i:s A', strtotime($order_arr['delivery_details']['confirmed_at'])) : "N/A"; ?></td>
                                
                                </tr>
                                
                             
                              <tr class="project-overview-amount">
                                <td class="bold">Start by driver at</td>
                                <td><?php  echo ($order_arr['delivery_details']['started_at']!='' && $order_arr['delivery_details']['started_at']!=0) ? date('d F, Y (l) h:i:s A', strtotime($order_arr['delivery_details']['started_at'])) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-amount">
                                <td class="bold">Delivered by driver at</td>
                                <td><?php  echo ($order_arr['delivery_details']['delivery_at']!='' && $order_arr['delivery_details']['delivery_at']!=0) ? date('d F, Y (l) h:i:s A', strtotime($order_arr['delivery_details']['delivery_at'])) : "N/A"; ?></td>
                              </tr>
                              <tr> </tr>
                              <tr class="project-overview-status">
                                <td class="bold">Completed by driver at</td>
                                <td><?php  echo ($order_arr['completed_at']!='' && $order_arr['completed_at']!=0) ? date('d F, Y (l) h:i:s A', $order_arr['completed_at']) : "N/A"; ?></td>
                              </tr>
                                </tr>
                              
                              <tr class="project-overview-start-date">
                                <td class="bold">Updated at</td>
                                <td><?php  echo ($order_arr['updated_at']!='' && $order_arr['updated_at']!=0) ? date('d F, Y (l) h:i:s A', $order_arr['updated_at']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-estimated-hours">
                                <td class="bold">Currency </td>
                                <td><span class="label label-primary">
                                  <?php  echo ($order_arr['currency_code']!='' && $order_arr['currency_code']!='') ? ucfirst($order_arr['currency_code']) : "N/A"; ?>
                                  </</td>
                              </tr>
                              <tr class="project-overview-estimated-hours">
                                <td class="bold">Payment Type </td>
                                <td><?php if($order_arr['payment_type']==1){?>
                                  <i class="fa fa-credit-card" style="font-size:24px; color:#03A9F4"></i> Wallet 
                                  <?php }else{?>
                                  <i class="fa fa-google-wallet" style="font-size:24px; color:#03A9F4"></i> Credit Card
                                  <?php }?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 border-right project-overview-left">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="project-info bold font-size-14" style="color:#03A9F4"> Delivery Details </p>
                        </div>   
                        
                        
                        <div class="col-md-12">
                          <table class="table no-margin project-overview-table">
                            <tbody>
                              <tr class="project-overview-id">
                                <td class="bold">Pickup Location </td>
                                <td><?php  echo ($order_arr['delivery_details']['pickup_location']!='' && $order_arr['delivery_details']['pickup_location']!='') ? ucfirst($order_arr['delivery_details']['pickup_location']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-customer">
                                <td class="bold">Drop Location</td>
                                <td><?php  echo ($order_arr['delivery_details']['drop_location']!='' && $order_arr['delivery_details']['drop_location']!='') ? ucfirst($order_arr['delivery_details']['drop_location']) : "N/A"; ?></td>
                              </tr>
                              <tr class="project-overview-billing">
                                <td class="bold">Estimate Distance</td>
                                <td><span class="label label-warning">
                                  
								  
								   <?php  echo ($order_arr['delivery_details']['est_distance']!='' && $order_arr['delivery_details']['est_distance']!='') ? ucfirst($order_arr['delivery_details']['est_distance']).' KM' : "N/A"; ?>
								 
                                  </span></td>
                              </tr>
                              
                              <tr class="project-overview-billing">
                                <td class="bold">Tips Amount</td>
                                <td>
                                  <?php  echo ($order_arr['tips_amount']!='' && $order_arr['tips_amount']!='') ? ucfirst($order_arr['tips_amount']) : "N/A"; ?>
                                  </td>
                              </tr>
                              
                               <tr class="project-overview-billing">
                                <td class="bold">Booking Fee</td>
                                <td>
                                  <?php  echo ($order_arr['booking_fee']!='' && $order_arr['booking_fee']!='') ? ucfirst($order_arr['booking_fee']) : "N/A"; ?>
                                  </td>
                              </tr>
                             
                             
                              <tr class="project-overview-amount">
                                <td class="bold">Drop Distance</td>
                                <td><?php  echo ($order_arr['delivery_details']['drop_distance']!='' && $order_arr['delivery_details']['drop_distance']!='') ? ucfirst($order_arr['delivery_details']['drop_distance']).' KM' : "N/A"; ?></td>
                              </tr>
                              
                              <tr class="project-overview-amount">
                                <td class="bold"> Distance Fare</td>
                                <td><?php  echo ($order_arr['delivery_details']['distance_fare']!='' && $order_arr['delivery_details']['distance_fare']!='') ? ucfirst($order_arr['delivery_details']['distance_fare']): "N/A"; ?></td>
                              </tr>
                              
                              <tr class="project-overview-amount">
                                <td class="bold">Total Fare</td>
                                <td><?php  echo ($order_arr['delivery_details']['total_fare']!='' && $order_arr['delivery_details']['total_fare']!='') ? ucfirst($order_arr['delivery_details']['total_fare']) : "N/A"; ?></td>
                              </tr>
                              
                              
                               <tr class="project-overview-amount">
                                <td class="bold">Duration</td>
                                <td><?php  echo ($order_arr['delivery_details']['duration']!='' && $order_arr['delivery_details']['duration']!='') ? ucfirst($order_arr['delivery_details']['duration']) : "N/A"; ?></td>
                              </tr>
                              
                               <tr class="project-overview-amount">
                                <td class="bold">Status</td>
                                <td> <?php if($order_arr['delivery_details']['status']==1){ ?>
                    <span class="label label-primary">1</span>
                    <?php }else if($order_arr['delivery_details']['status']==2){ ?>
                    <span class="label label-success">2</span>
                     <?php }else if($order_arr['delivery_details']['status']==3){ ?>
                      <span class="label label-danger">3</span>
                      
                      <?php }else if($order_arr['delivery_details']['status']==4){ ?>
                      <span class="label label-primary">4</span>
                       <?php }else if($order_arr['delivery_details']['status']==5){ ?>
                      <span class="label label-primary">5</span>
                      <?php }?>
                      </td>
                              </tr>
                             
                             
                             
                              
                              <tr class="project-overview-status">
                                <td class="bold">Confirmed At</td>
                                <td><?php  echo ($order_arr['delivery_details']['confirmed_at']==' ' || $order_arr['delivery_details']['confirmed_at']='0000-00-00 00:00:00') ? date('d F, Y (l) h:i:s A', $order_arr['updated_at']) : date('d F, Y (l) h:i:s A', $order_arr['delivery_details']['confirmed_at']); ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 project-overview-right">
                      <hr class="hr-panel-heading">
                      <p class="project-info bold font-size-14" style="color:#03A9F4"> <b>Order Items </b></p>
                      <table class="table table-hover  no-footer dtr-inline collapsed">
                        <thead>
                          <tr role="row" style="background:#f0f0f0; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                            <th style="font-weight: bold;">Item </th>
                            <th style="font-weight: bold;">Deal Status</th>
                            <th style="font-weight: bold;">Qunatity</th>
                            <th style="font-weight: bold;">Price</th>
                            <th style="font-weight: bold;"><span class="pull-right"> Amount</span></th>
                          </tr>
                        </thead>
                        <tbody id="order_list">
                          <?php 

$amount  = 0;
foreach($order_arr['order_items'] as  $key => $items){ $amount +=  $items['total_amount'];?>
                          <tr role="row">
                            <td><?php echo ($items['item_name']!='' && $items['item_name']!=' ') ? $items['item_name'] : "N/A"; ?> <br />
                            <small><?php echo $order_arr['order_add_ons'][$key]['item_add_on']?> <b> * <?php echo $order_arr['order_add_ons'][$key]['is_multiple']?></b></small>
                            </td>
                            <td><span class="label label-primary"><?php echo $items['daily_deal_status']?></span></td>
                            <td><span class="label label-warning"><?php echo $items['quantity']?></span></td>
                             <td><span class="label label-warning"><?php echo $items['orginal_price']?></span></td>
                            <td><span class="pull-right">R <?php echo $items['total_amount']?></span></td>
                          </tr>
                          <?php }?>
                          <tr role="row">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total : </td>
                            <td><span class="pull-right"><?php echo 'R '.$amount?></span></td>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-md-12">
                      <hr class="hr-panel-heading">
                      <!--To Work with icons-->
                      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
                      <div class="container">
                        <h2 class="text-center">Customer Review</h2>
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-2"> <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid" style="height:70px"/>
                                <p class="text-secondary text-center"><!--15 Minutes Ago--></p>
                              </div>
                              <div class="col-md-9">
                                <p> <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>
                                  <?php  echo ($order_arr['customer_name']!='' && $order_arr['customer_name']!=' ') ? ucfirst($order_arr['customer_name']) : "N/A"; ?>
                                  </strong></a>
                                  <?php for($i=0;$i < $order_arr['review']['rating'];$i++) { ?>
                                  <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                  <?php } ?>
                                </p>
                                <div class="clearfix"></div>
                                <p>No Comments</p>
                                <p> </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- /.modal --> 
                    
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
<script>
$(document).ready(function(e) {

  var segments = window.location.href.split( '/' );
  if(segments.length > 5){
    var filter_type = segments[6];
  }else{
    var filter_type = '';
  }
 
  var post_client = '';
  var post_contact = '';
  var post_driver = '';
  if( filter_type == 'client'){ post_client = segments[7];}
  if( filter_type == 'contact'){ post_contact = segments[7];}
  if( filter_type == 'driver'){ post_driver = segments[7];}

  $('#clients_select').select2({
    placeholder: "Select Client",
    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/clients_ajax_select/"+post_client,
      dataType: 'json',

      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

  $('#contact_select').select2({

    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/contacts_ajax_select"+post_contact,
      dataType: 'json',
      data: function (params) {
        var query = {
          term: params.term,
          type: '0'
        }
        return query;
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

  $('#driver_select').select2({

    ajax: {
      method:'post',
      url: "<?php echo admin_url(); ?>clients/contacts_ajax_select"+post_driver,
      dataType: 'json',
      data: function (params) {
        var query = {
          term: params.term,
          type: '2'
        }
        return query;
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }

  });

});

  

  $("body").on("click", ".order_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    if( filter_type == 'client'){ var client  = segments[7];}
    else { var client   = $('#clients_select').val(); }

    if( filter_type == 'driver'){ var driver  = segments[7];}
    else { var driver   = $('#driver_select').val(); }

    if( filter_type == 'contact'){ var contact  = segments[7];}
    else { var contact  = $('#contact_select').val(); }

    //var orderby = $("#orderby").val();
    //var order = $("#order").val();
   
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
          type: "POST",
          data: {client:client,driver:driver,contact:contact},
          success: function(response){

              var res_arr = response.split('***||***');

              $('#order_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
              $('#page_links').html(res_arr[2]);

          }
      });
    }    

  });

  $("body").on("change", ".select_filters", function(){


    var page = 0;
    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    if( filter_type == 'client'){ var client  = segments[7];}
    else { var client   = $('#clients_select').val(); }

    if( filter_type == 'driver'){ var driver  = segments[7];}
    else { var driver   = $('#driver_select').val(); }

    if( filter_type == 'contact'){ var contact  = segments[7];}
    else { var contact  = $('#contact_select').val(); }

    //var orderby = $("#orderby").val();
    //var order = $("#order").val();
   
    $.ajax({
        url: "<?php echo admin_url(); ?>clients/orders_ajax/"+page,
        type: "POST",
        data: {client:client,driver:driver,contact:contact},
        success: function(response){

            var res_arr = response.split('***||***');

            $('#order_list').html(res_arr[0]);
            $('#record_count').html(res_arr[1]);
            $('#page_links').html(res_arr[2]);

        }
    });   

  });

</script>
</body>
</html>
