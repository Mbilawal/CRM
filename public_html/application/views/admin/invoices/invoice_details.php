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
				<?php $this->load->view('admin/invoices/invoice_details_template'); ?>

			</div>
			<?php echo form_close(); ?>
			<?php $this->load->view('admin/invoice_items/item');?>
		</div>
	</div>
</div>
<?php init_tail(); ?>

</body>
</html>
