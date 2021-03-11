<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php if(isset($client)){ ?>
	<h4 class="customer-profile-group-heading"><?php echo _l('client_invoices_tab'); ?></h4>
	<?php if(has_permission('invoices','','create')){ ?>
		<a href="<?php echo admin_url('invoices/invoice?customer_id='.$client->userid); ?>" class="btn btn-info mbot15<?php if($client->active == 0){echo ' disabled';} ?>">
			<?php echo _l('create_new_invoice'); ?>
		</a>
	<?php } ?>
	<?php if(has_permission('invoices','','view') || has_permission('invoices','','view_own') || get_option('allow_staff_view_invoices_assigned') == '1'){ ?>
		<a href="#" class="btn btn-info mbot15" data-toggle="modal" data-target="#client_zip_invoices">
			<?php echo _l('zip_invoices'); ?>
		</a>
		<div id="invoices_total" class="mbot20"></div>

		<!-- <div class="display-block text-left">         
           <?php if($_GET['group'] == 'invoices'){ ?>      
           <div class="row">
              <div class="col-md-12 col-xs-12" style="">
                 <div class="col-sm-3">
                    <label><strong>Date From</strong></label>
                    <div class="input-group date" id="datetimepicker1">
                       <input type="text" id="date_from" name="date_from_client" class="form-control datepicker select_filters1" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                       <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>
                 <div class="col-sm-3">
                    <label><strong>Date To</strong></label>
                    <div class="input-group date" id="datetimepicker2">
                       <input type="text" id="date_too" placeholder="To Date" name="date_to_client" class="form-control datepicker select_filters1" value="" autocomplete="off" aria-invalid="false">
                       <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                       </span>
                    </div>
                 </div>
                 <div class="col-sm-2">
                    <label><strong></strong></label>
                    <button type="button" class="btn btn-primary apply_filter_date" style="margin-top: 26px" return false;">Apply</button>
                 </div>
              </div>
           </div>
           <?php  } ?>
        </div> -->


		<?php
		$this->load->view('admin/invoices/table_html', array('class'=>'invoices-single-client'));
		$this->load->view('admin/clients/modals/zip_invoices');
		?>
	<?php } ?>
<?php } ?>
