<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link href="<?php echo base_url();?>assets/select2/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
	.select2-container {
	    width: 100% !important;
	}
</style>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form'));
			if(isset($invoice)){
				echo form_hidden('isedit');
			}
			?>
			<div class="col-md-12">
				<?php $this->load->view('admin/invoices/invoice_template'); ?>

			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item');?>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script src="<?php echo base_url();?>assets/select2/js/select2.min.js"></script> 
<script>
	$(function(){
		//validate_invoice_form();
	    // Init accountacy currency symbol
	    //init_currency();
	    // Project ajax search
	    //init_ajax_project_search_by_customer_id();
	    // Maybe items ajax search
	    //init_ajax_search('items','#item_select.ajax-search',undefined,admin_url+'items/search');
	});
</script>
<script>
  
    var clientid = $("#clientid").val();

	if(clientid!=""){
		
		var filter_date_from 	= $('#filter_date_from').val();
		var filter_date_to 		= $('#filter_date_to').val();
		var filter_order_type 	= $('#filter_order_type').val();
		
			
	    $.ajax({
			  	type:'post',
			  	url: "<?php echo admin_url(); ?>invoices/get_order_items_ajax/"+clientid,
			    data: {filter_order_type:filter_order_type,filter_date_to:filter_date_to,filter_date_from:filter_date_from},	
                beforeSend: function() {    
				  $(".order_items_container").html('<tr><td colspan="7"><center><img src="<?php echo base_url();?>assets/images/Loading-Image.gif"></center></td></tr>');
				},			  
			  	success:function(result){

					$(".order_items_container").html(result);
					calculateTotal();
			  	}
			});
   
	}
	
	$("body").on('change', 'input[name="date"]', function () {
		 var date = $("#date").val();
		 var duedate = $("#duedate").val();
		 var clientid = $("#clientid").val();
		 $('#filter_date_from').val("");
		 $('#filter_date_to').val("");
		  $.ajax({
			  	type:'post',
			  	url: "<?php echo admin_url(); ?>invoices/get_order_items_ajax/"+clientid,
			    data: {filter_date_from:date,filter_date_to:duedate,filter_order_type:filter_order_type},
                beforeSend: function() {    
				  $(".order_items_container").html('<tr><td colspan="7"><center><img src="<?php echo base_url();?>assets/images/Loading-Image.gif"></center></td></tr>');
				},				
			  	success:function(result){

					$(".order_items_container").html(result);
					calculateTotal();
			  	}
			});
	});
	$("body").on('change', 'input[name="duedate"]', function () {
		 var date = $("#date").val();
		 var duedate = $("#duedate").val();
		 var clientid = $("#clientid").val();
		 $('#filter_date_from').val("");
		 $('#filter_date_to').val("");
		 
		  $.ajax({
			  	type:'post',
			  	url: "<?php echo admin_url(); ?>invoices/get_order_items_ajax/"+clientid,
			   data: {filter_date_from:date,filter_date_to:duedate,filter_order_type:filter_order_type},	
                beforeSend: function() {    
				  $(".order_items_container").html('<tr><td colspan="7"><center><img src="<?php echo base_url();?>assets/images/Loading-Image.gif"></center></td></tr>');
				},			  
			  	success:function(result){

					$(".order_items_container").html(result);
					calculateTotal();
			  	}
			});
	});

    $("body").on('change', 'select[name="clientid"]', function () {
		
		var clientid = $(this).val();

		var filter_order_type 	= $('#filter_order_type').val();
        if($('#filter_date_from').val()==""){
			var date = $("#date").val();
			var duedate = $("#duedate").val();
	    }
		else{
			var date = $('#filter_date_from').val();
		    var duedate = $('#filter_date_to').val();
		}
		 
		  $.ajax({
			  	type:'post',
			  	url: "<?php echo admin_url(); ?>invoices/get_order_items_ajax/"+clientid,
			    data: {filter_date_from:date,filter_date_to:duedate,filter_order_type:filter_order_type},
                beforeSend: function() {    
				  $(".order_items_container").html('<tr><td colspan="7"><center><img src="<?php echo base_url();?>assets/images/Loading-Image.gif"></center></td></tr>');
				}, 
			  	success:function(result){

					$(".order_items_container").html(result);
					calculateTotal();
			  	}
			});
  
	});
	
    // Add order to preview from the dropdown for invoices estimates
    $("body").on('change', '.order_select', function () {
        
        var order_id 			= $(this).val();	
		var rowno 	 			= $(this).attr("rowno");
		
        if(order_id != ''){

			$.ajax({
			  	type:'post',
			  	url: "<?php echo admin_url(); ?>invoices/get_order_details",
			  	data: {order_id:order_id},		  
			  	dataType: 'json',
			  	success:function(result){

					$("#commission_amount"+rowno).val(result.restaurant_commision_fee);
					 //$("#sales_amount"+rowno).val(result.total_amount);// By ALI
					$("#sales_amount"+rowno).val(result.subtotal)
					$("#date"+rowno).val(result.created_at);

					if(result.order_type == 'manual'){
						$("#payout_amount"+rowno).val(parseFloat(result.subtotal).toFixed(2));
					}else{
						$("#payout_amount"+rowno).val((parseFloat(result.subtotal)-parseFloat(result.restaurant_commision_fee)).toFixed(2));
					}

					calculateTotal();
			  	}
			});
        }
    });

    $("body").on('click', '.add_more', function () {
        
        // var rowCount = $("#order_table tbody tr").length;
        var rowCount = $('#order_table tr:last').attr('data-item-id');
		var rowno = parseInt(rowCount)+1;
		
		var filter_date_from 	= $('#filter_date_from').val();
		var filter_date_to 		= $('#filter_date_to').val();
		var filter_order_type 	= $('#filter_order_type').val();

		$.ajax({
		  	type:'post',
		  	url: "<?php echo admin_url(); ?>invoices/add_more",
		  	data: {rowno:rowno},
		  	success:function(result){
				$("#order_table tbody").append(result);
				var clientid = $("#clientid").val();
				$('#order_id'+rowno).select2({
					placeholder: "Select Order",
					ajax: {
					  method:'post',
					  url: "<?php echo admin_url(); ?>invoices/orders_ajax/"+clientid,
					  data: {filter_order_type:filter_order_type,filter_date_to:filter_date_to,filter_date_from:filter_date_from},
					  dataType: 'json',
					}
				}); 
		  	}
		});
    });
    
	$("body").on('click', '.delete_item', function () {
		var rowno = $(this).attr("rowno");
		$(this).closest("tr").remove();
		calculateTotal();
	});
	
	$("body").on('change', '#amount_paid_field', function () {
		calculateTotal();
	});
	
	function calculateTotal(){
	   var amount_paid = $("#amount_paid_field").val();
	   if(amount_paid==""){
		amount_paid = 0;
	   }
	   var payout_amount = 0;
	   $( ".payout_amount" ).each(function() {
		   if($(this).val()!=""){
		   payout_amount =parseFloat(payout_amount) + parseFloat($(this).val());
		   }
	   });
	   $("#payout_amount_field").val(parseFloat(payout_amount).toFixed(2));
	   $(".total_payout_amount").text("R"+parseFloat(payout_amount).toFixed(2));
	   var filter_order_type 	= $('#filter_order_type').val();
	   if(filter_order_type=="manual"){
		 var total = parseFloat(payout_amount)-parseFloat(amount_paid);  
	   }
	   else{
	   var total = parseFloat(payout_amount)+parseFloat(amount_paid);
	   }
	    $("#total_amount_field").val(parseFloat(total).toFixed(2));
	   $(".total").text("R"+parseFloat(total).toFixed(2));
	   
	}
</script>


</body>
</html>
