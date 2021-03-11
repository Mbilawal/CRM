<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			include_once(APPPATH.'views/admin/invoices/filter_params.php');
			
			$this->load->view('admin/invoices/list_template');

			$clientid = '';
			if($_GET['clientid']){
				$client_arr = explode('#', $_GET['clientid']);
				$clientid = $client_arr[0];
			}

			?>
			<input type="hidden" name="userid" value="<?php echo $clientid; ?>" />
		</div>
	</div>
</div>
<?php $this->load->view('admin/includes/modals/sales_attach_file'); ?>
<script>var hidden_columns = [2,6,7,8];</script>
<?php init_tail(); ?>
<script>
	$(function(){
		init_invoice();
	});
</script>

<script type="text/javascript">

</script>
</body>
</html>