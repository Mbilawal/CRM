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
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" />
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body" >
             <div class="clearfix"></div> 
            <div class="row">
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Customer Recommended FOOD</h3>
              </div>
            </div>
              <hr class="hr_style" />
              <div class="clearfix"></div>
              
          <div class="row">

          <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
      			<div class="loader">
      			   <center>
      				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
      			   </center>
      			</div>
            <table class="table table-hover  no-footer dtr-inline collapsed" >
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
                  <th style="font-weight: bold; max-width: 150px;">S.NO</th>
                  <th style="font-weight: bold; max-width: 150px;">Customer ID</th>
                  <th style="font-weight: bold; max-width: 150px;">Name</th>
                  <th style="font-weight: bold; max-width: 150px;">Email</th>
                  <th style="font-weight: bold; max-width: 150px;">Cross Sale Item</th>
                </tr>
              </thead>
              <tbody id="clients_list">
                <?php foreach ($clients as $key => $value) {  ?>
                <tr role="row">
                    <td><?php echo $key+1; ?></td>
                    <td><a href="<?php echo AURL;?>clients/referral_customer_details/<?php echo $value['dryvarfoods_id']; ?>"> <?php echo $value['dryvarfoods_id']; ?></a></td>
                   <td><?php echo $value["firstname"];?></td>
					         <td><?php echo $value["email"];?></td>
					         <td><?php echo get_recommended_cross_item_to_user($value['dryvarfoods_id']); ?></td>
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
<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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

  

  $("body").on("click", ".client_filter_pagination li a", function(event){

    event.preventDefault();
    var page = $(this).data("ci-pagination-page");

    var segments = window.location.href.split( '/' );
    if(segments.length > 5){
      var filter_type = segments[6];
    }else{
      var filter_type = '';
    }
    
    var data = $("#clientsFilter").serialize();
	
    if($(this).data("ci-pagination-page")){

      $.ajax({
          url: "<?php echo admin_url(); ?>clients/recommended_cross_customers_food_ajax/"+page,
          type: "POST",
          data: data,
          success: function(response){
              var res_arr = response.split('***||***');
              $('#clients_list').html(res_arr[0]);
              $('#record_count').html(res_arr[1]);
		          $('#page_links123').html(res_arr[2]);

          }
      });
    }    

  });

</script>
</body>
</html>
