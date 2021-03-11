<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($orders); exit;?>
<style type="text/css">
  label.error, .custom_error{
	  color:red;
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
                <h3 class="padding-5 p_style">Dryvarfoods Add Driver Checklist  <span class="pull-right label label-default mtop5 s-status invoice-status-2" style="margin-bottom:20px"><b><?php echo date("l jS \of F Y h:i:s A");?></b></span></h3>
			  </div>
              <hr class="hr_style" />
              <div class="clearfix"></div>
			  <form id="addChecklistForm" method="post" action="<?php echo AURL;?>drivers/add_checklist_process">
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
                  
                  <div class=" col-md-12 col-xs-6">
                  
                  <div class=" col-md-6 col-xs-6">
                    <label><strong>Driver <small class="req text-danger">*</small></strong></label>
                    <select class="js-example-data-ajax form-control" name="driver_id" id="driver_id" required="true">
					        <option value="">Select Driver</option>
							<?php if(count($drivers)>0){
									foreach($drivers as $val){?>
								      <option value="<?php echo $val['driver_id'];?>"><?php echo $val['firstname'];?></option>
								<?php } } ?>
					</select>
					<?php echo form_error('driver_id', '<div class="custom_error">', '</div>'); ?>
                  </div>
				   <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Uniform <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="uniform" id="uniform" value="<?php echo set_value('uniform')?>" required="true">
					<?php echo form_error('driver_id', '<div class="custom_error">', '</div>'); ?>
                  </div>
                  </div>
                  <div class=" col-md-12 col-xs-6">
                  
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Tyres <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="tyres" id="tyres" value="<?php echo set_value('tyres')?>" required="true">
					<?php echo form_error('tyres', '<div class="custom_error">', '</div>'); ?>
                  </div>
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Front Panel <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="front_panel" id="front_panel" value="<?php echo set_value('front_panel')?>" required="true">
                    <?php echo form_error('front_panel', '<div class="custom_error">', '</div>'); ?>
				  </div>
                  </div>
                  
                  <div class=" col-md-12 col-xs-6">
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Right Side <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="right_side" id="right_side" value="<?php echo set_value('right_side')?>" required="true">
                    <?php echo form_error('right_side', '<div class="custom_error">', '</div>'); ?>
				  </div>
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Left Side <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="left_side" id="left_side" value="<?php echo set_value('left_side')?>" required="true">
                    <?php echo form_error('left_side', '<div class="custom_error">', '</div>'); ?>
				  </div>
                  </div>
                  
                  <div class=" col-md-12 col-xs-6">
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Exhaust Cover <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="exhaust_cover" id="exhaust_cover" value="<?php echo set_value('exhaust_cover')?>" required="true">
                    <?php echo form_error('exhaust_cover', '<div class="custom_error">', '</div>'); ?>
				  </div>
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Licence Disc <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="licence_disc" id="licence_disc" value="<?php echo set_value('licence_disc')?>" required="true">
                    <?php echo form_error('licence_disc', '<div class="custom_error">', '</div>'); ?>
				  </div>
                  </div>
                  
                  <div class=" col-md-12 col-xs-6">
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Mirrors <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="mirrors" id="mirrors" value="<?php echo set_value('mirrors')?>" required="true">
					<?php echo form_error('mirrors', '<div class="custom_error">', '</div>'); ?>
                  </div>
				  <div class=" col-md-6 col-xs-6">
                    <label class="mtop15"><strong>Bin <small class="req text-danger">*</small></strong></label>
                    <input class="form-control" type="text" name="bin" id="bin" value="<?php echo set_value('bin')?>" required="true">
					<?php echo form_error('bin', '<div class="custom_error">', '</div>'); ?>
                  </div>
                  </div>
				  <div class=" col-md-12 col-xs-6">
				       <div class="form-footer text-right mtop15">
                            <input type="submit" class="btn btn-info btn-fill" id="add_new_checklist" name="add_new_checklist" value="Add Driver CheckList">
                       </div>
				  </div>
                  
                </div>
              </div>
              </form>
              <hr />

           </div>
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>

<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/additional-methods.min.js"></script> 
<script>
  $("#addChecklistForm").validate({
        messages: {
			driver_id: {
    		  required: "The Driver is required",
    		},
			tyres: {
    		  required: "The Tyres is required",
    		},
    		uniform: {
    		  required: "The Uniform is required",
    		},
    		front_panel: {
    		  required: "The Front Panel is required",
    		},
			left_side: {
    		  required: "The Left Side are required",
    		},
			right_side: {
    		  required: "The Right Side is required",
    		},
			exhaust_cover: {
				required: "The Exhaust Cover is required",
			},
			licence_disc: {
				required: "The Licence Disc is required",
			},
			mirrors: {
				required: "The Mirrors is required",
			},
			bin: {
				required: "The Bin is required",
			}
          }
});

  $('#driver_id').select2({
    placeholder: "Select Driver",
  });
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
		  
		  if(res_arr=='norrequests'){
			   $('#page_links123').html('<div class="alert alert-danger" role="alert"> No checklist found !</div>');
			   $('#checklist_list').html("");
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
