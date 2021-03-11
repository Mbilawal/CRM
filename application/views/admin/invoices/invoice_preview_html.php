<?php defined('BASEPATH') or exit('No direct script access allowed');
if($invoice->status == Invoices_model::STATUS_DRAFT){ ?>
   <div class="alert alert-info">
      <?php echo _l('invoice_draft_status_info'); ?>
   </div>
<?php }
if(isset($invoice->scheduled_email) && $invoice->scheduled_email) { ?>
   <div class="alert alert-warning">
      <?php echo _l('invoice_will_be_sent_at', _dt($invoice->scheduled_email->scheduled_at)); ?>
      <?php if(staff_can('edit', 'invoices') || $invoice->addedfrom == get_staff_user_id()) { ?>
         <a href="#"
         onclick="edit_invoice_scheduled_email(<?php echo $invoice->scheduled_email->id; ?>); return false;">
            <?php echo _l('edit'); ?>
         </a>
      <?php } ?>
   </div>
<?php } ?>
<div id="invoice-preview">
   <div class="row">
      <?php

      if($invoice->recurring > 0 || $invoice->is_recurring_from != NULL) {

         $recurring_invoice = $invoice;
         $show_recurring_invoice_info = true;

         if($invoice->is_recurring_from != NULL){
           $recurring_invoice = $this->invoices_model->get($invoice->is_recurring_from);
          // Maybe recurring invoice not longer recurring?
           if($recurring_invoice->recurring == 0){
            $show_recurring_invoice_info = false;
         } else {
            $next_recurring_date_compare = $recurring_invoice->last_recurring_date;
         }
      } else {
       $next_recurring_date_compare = to_sql_date($recurring_invoice->date);
       if($recurring_invoice->last_recurring_date){
        $next_recurring_date_compare = $recurring_invoice->last_recurring_date;
     }
  }
  if($show_recurring_invoice_info){
    if ($recurring_invoice->custom_recurring == 0) {
      $recurring_invoice->recurring_type = 'MONTH';
   }
   $next_date = date('Y-m-d', strtotime('+' . $recurring_invoice->recurring . ' ' . strtoupper($recurring_invoice->recurring_type), strtotime($next_recurring_date_compare)));
}
?>
<div class="col-md-12">
   <div class="mbot10">
      <?php if($invoice->is_recurring_from == null
         && $recurring_invoice->cycles > 0
         && $recurring_invoice->cycles == $recurring_invoice->total_cycles) { ?>
            <div class="alert alert-info no-mbot">
               <?php echo _l('recurring_has_ended', _l('invoice_lowercase')); ?>
            </div>
         <?php } else if($show_recurring_invoice_info){ ?>
            <span class="label label-default padding-5">
               <?php
               if($invoice->status == Invoices_model::STATUS_DRAFT){
                  echo '<i class="fa fa-exclamation-circle fa-fw text-warning" data-toggle="tooltip" title="'._l('recurring_invoice_draft_notice').'"></i>';
               }
               echo _l('cycles_remaining'); ?>:
               <b>
                  <?php
                  echo $recurring_invoice->cycles == 0 ? _l('cycles_infinity') : $recurring_invoice->cycles - $recurring_invoice->total_cycles;
                  ?>
               </b>
            </span>
            <?php
            if($recurring_invoice->cycles == 0 || $recurring_invoice->cycles != $recurring_invoice->total_cycles){
               echo '<span class="label label-default padding-5 mleft5"><i class="fa fa-question-circle fa-fw" data-toggle="tooltip" data-title="'._l('recurring_recreate_hour_notice',_l('invoice')).'"></i> ' . _l('next_invoice_date','<b>'._d($next_date).'</b>') .'</span>';
            }
         }
         ?>
      </div>
      <?php if($invoice->is_recurring_from != NULL){ ?>
         <?php echo '<p class="text-muted'.($show_recurring_invoice_info ? ' mtop15': '').'">'._l('invoice_recurring_from','<a href="'.admin_url('invoices/list_invoices/'.$invoice->is_recurring_from).'" onclick="init_invoice('.$invoice->is_recurring_from.');return false;">'.format_invoice_number($invoice->is_recurring_from).'</a></p>'); ?>
      <?php } ?>
   </div>
   <div class="clearfix"></div>
   <hr class="hr-10" />
<?php } ?>
<?php if($invoice->project_id != 0){ ?>
   <div class="col-md-12">
      <h4 class="font-medium mtop15 mbot20"><?php echo _l('related_to_project',array(
         _l('invoice_lowercase'),
         _l('project_lowercase'),
         '<a href="'.admin_url('projects/view/'.$invoice->project_id).'" target="_blank">' . $invoice->project_data->name . '</a>',
         )); ?></h4>
      </div>
   <?php } ?>
   <div class="col-md-6 col-sm-6">
      <h4 class="bold">
         <?php
         $tags = get_tags_in($invoice->id,'invoice');
         if(count($tags) > 0){
           echo '<i class="fa fa-tag" aria-hidden="true" data-toggle="tooltip" data-title="'.html_escape(implode(', ',$tags)).'"></i>';
        }
        ?>
        <a href="<?php echo admin_url('invoices/invoice_details/'.$invoice->id); ?>">
         <span id="invoice-number">
            <?php echo format_invoice_number($invoice->id); ?>
         </span>
      </a>
   </h4>
   <address>
      <?php echo format_organization_info(); ?>
   </address>
</div>
<div class="col-sm-6 text-right">
   <span class="bold"><?php echo _l('Payment report to'); ?>:</span>
   <address>
      <?php $client_info = get_client_address($invoice->clientid); 
      echo '<a href="' . admin_url('clients/client/' . $invoice->clientid) . '" target="_blank"><b>'.$client_info["company"].'</b></a>';
	  ?>
	  <br>
	  <?php  
	    echo $client_info["address"];
	  ?>
	  <br>
	  <?php 
	    echo $client_info["city"].", ".$client_info["zip"];
	  ?>
	  <br>
	  <?php  
	    echo $client_info["state"];
	  ?>
	  <br>
	  <?php  
	    $country = get_country($client_info["country"]);
	    echo $country->short_name;
	  ?>
   </address>
   <?php if($invoice->include_shipping == 1 && $invoice->show_shipping_on_invoice == 1){ ?>
      <span class="bold"><?php echo _l('ship_to'); ?>:</span>
      <address>
         <?php echo format_customer_info($invoice, 'invoice', 'shipping'); ?>
      </address>
   <?php } ?>
   <p class="no-mbot">
      <span class="bold">
         <?php echo _l('invoice_data_date'); ?>
      </span>
      <?php echo date('F j, Y',strtotime($invoice->date)); ?>
   </p>
   <?php $query = $this->db->query("SELECT * FROM `tblinvoicepaymentrecords` where invoiceid='".$invoice->id."' ");
   $pa = $query->result_array();
   
   if(count($pa)){ ?>
      <p class="no-mbot">
         <span class="bold">
            <?php echo _l('Payout Date'); ?>
         </span>
         <?php echo date('F j, Y',strtotime($pa['0']['date'])); ?>
      </p>
   <?php } ?>
   <?php if(!empty($invoice->duedate)){ ?>
      <p class="no-mbot">
         <span class="bold">
            <?php echo _l('invoice_data_duedate'); ?>
         </span>
         <?php echo date('F j, Y',strtotime($invoice->duedate)); ?>
      </p>
   <?php } ?>
   
   <p class="no-mbot">
      From: <?php echo date('F j, Y',strtotime($invoice->date)-604800); ?> 
   </p>
   <p class="no-mbot">
   To: <?php echo date('F j, Y',strtotime($invoice->date)); ?>
   </p>
   <?php if($invoice->sale_agent != 0 && get_option('show_sale_agent_on_invoices') == 1){ ?>
      <p class="no-mbot">
         <span class="bold"><?php echo _l('sale_agent_string'); ?>: </span>
         <?php echo get_staff_full_name($invoice->sale_agent); ?>
      </p>
   <?php } ?>
   <?php if($invoice->project_id != 0 && get_option('show_project_on_invoice') == 1){ ?>
      <p class="no-mbot">
         <span class="bold"><?php echo _l('project'); ?>:</span>
         <?php echo get_project_name_by_id($invoice->project_id); ?>
      </p>
   <?php } ?>
   <?php $pdf_custom_fields = get_custom_fields('invoice',array('show_on_pdf'=>1));
   foreach($pdf_custom_fields as $field){
    $value = get_custom_field_value($invoice->id,$field['id'],'invoice');
    if($value == ''){continue;} ?>
    <p class="no-mbot">
      <span class="bold"><?php echo $field['name']; ?>: </span>
      <?php echo $value; ?>
   </p>
<?php } ?>
</div>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="table-responsive">
         <?php
         $items = get_items_table_data($invoice, 'invoice', 'html', true);
         
         // echo $items->table();
         ?>
         <table class="table items items-preview invoice-items-preview" data-type="invoice">
            <thead>
               <tr>
                  <th align="center">#</th>
                  <th align="left">Order ID</th>
                  <th align="left">Date</th>
				  <?php if($invoice->filter_order_type == "manual"){?>
				  <th align="left">Delivery Distance Fee</th>
                  <th align="left">Platform Fee</th>
                  <th align="left">Amount Due</th>
				  <?php } else{ ?>
                  <th align="left">Sale Amt</th>
                  <th align="left">Commission Amt</th>
                  <th align="right">Payout Amt</th>
				  <?php } ?>
               </tr>
            </thead>
            <tbody class="ui-sortable">
               <?php 
                  $query = $this->db->query("SELECT * FROM `tblinvoice_items` where invoice_id='".$invoice->id."' ");
                  $data_arr = $query->result_array();
				  
				  
                  $t_com = 0;$t_sale = 0;
				  if($invoice->filter_order_type == "manual"){
                  foreach ($data_arr as $key => $value) {
					  
					  
                     $sno = $key+1;
                     $commission_amount = $value['sales_amount']-$value['commission_amount'];
					 
					 if($commission_amount<0){
						 $commission_amount = (-1)*$commission_amount;
					 }

                     $t_com = $t_com + $commission_amount;
                     //$t_sale = $t_sale + $value['commission_amount'];
                     echo '

                        <tr class="sortable" data-item-id="1">
                           <td class="dragger item_no ui-sortable-handle" align="center" width="5%">'.$sno.'</td>
                           <td align="left;" width="10%">'.$value['order_id'].'</td>
                           <td align="left" width="10%">'.$value['date'].'</td>
                           <td align="left" width="10%">'.number_format($value['sales_amount'],2).' R</td>
                           <td align="left" width="10%">'.number_format($commission_amount,2).' R</td>
                           <td align="right" width="10%">'.number_format($value['commission_amount'],2).' R</td>
                        </tr>
                     ';
                  }
                  }
				  else{
					foreach ($data_arr as $key => $value) {
					  
					  
                     $sno = $key+1;
                     $commission_amount = $value['commission_amount']-$value['sales_amount'];
					 
					 if($commission_amount<0){
						 $commission_amount = (-1)*$commission_amount;
					 } 

                     $t_com = $t_com + $commission_amount;
                     $t_sale = $t_sale + $value['sales_amount'];
                     echo '

                        <tr class="sortable" data-item-id="1">
                           <td class="dragger item_no ui-sortable-handle" align="center" width="5%">'.$sno.'</td>
                           <td align="left;" width="10%">'.$value['order_id'].'</td>
                           <td align="left" width="10%">'.$value['date'].'</td>
                           <td align="right" width="10%">R'.number_format($value['sales_amount'],2).'</td>
                           <td align="left" width="10%">R'.number_format($commission_amount,2).'</td>
                           <td align="left" width="10%">R'.number_format($value['commission_amount'],2).'</td>
                        </tr>
                     ';
                  }
  
				  }
               ?>

               
            </tbody>
         </table>
      </div>
   </div>
   <div class="col-md-7 col-md-offset-5">
      <table class="table text-right">
         <tbody>
            
            <?php if(count($invoice->payments) > 0 && get_option('show_total_paid_on_invoice') == 1) { ?>
               <tr>
                  <td><span class="bold" style="font-weight: bold;" >Total Sales Amount</span></td>
                  <td>
                     <?php //echo '-' . app_format_money(sum_from_table(db_prefix().'invoicepaymentrecords',array('field'=>'amount','where'=>array('invoiceid'=>$invoice->id))), $invoice->currency_name); ?>
                     
                     
                     <?php echo 'R'.number_format($invoice->total_sales_amount,2);  ?>
                  </td>
               </tr>
            <?php } ?>
            <?php if(get_option('show_credits_applied_on_invoice') == 1 && $credits_applied = total_credits_applied_to_invoice($invoice->id)){ ?>
               <tr>
                  <td><span class="bold"><?php echo _l('applied_credits'); ?></span></td>
                  <td>
                     <?php //echo '-' . app_format_money($credits_applied, $invoice->currency_name); ?>
                     
                     <?php echo 'R'.number_format($t_com,2); ?>
                  </td>
               </tr>
            <?php } ?>
            <?php if(get_option('show_amount_due_on_invoice') == 1 && $invoice->status != Invoices_model::STATUS_CANCELLED) { ?>
               <tr>
                  <!--<td><span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger ';} ?>bold" style="font-weight: bold;" ><?php echo _l('invoice_amount_due'); ?></span></td>-->
                  
                  <td><span class="bold" style="font-weight: bold;" >Total Commission Paid</span></td>
                  
                  <td>
                     <span class="<?php if($invoice->total_left_to_pay > 0){echo 'text-danger';} ?>">
                         <?php echo 'R'.number_format($t_com,2); ?>
                     </span>
                  </td>
               </tr>
            <?php } ?>
            <hr />
            <tr id="subtotal">
               <td><span class="bold" style="font-weight: bold;" >Total Payout Amount</span>
               </td>
               <td class="total">
                  <?php //echo app_format_money($invoice->total, $invoice->currency_name); ?>  
                  <span class="label label-primary mtop5 s-status invoice-status-2"><?php echo 'R'.number_format($invoice->total,2); ?>  </span>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<?php if(count($invoice->attachments) > 0){ ?>
   <div class="clearfix"></div>
   <hr />
   <p class="bold text-muted"><?php echo _l('invoice_files'); ?></p>
   <?php foreach($invoice->attachments as $attachment){
      $attachment_url = site_url('download/file/sales_attachment/'.$attachment['attachment_key']);
      if(!empty($attachment['external'])){
         $attachment_url = $attachment['external_link'];
      }
      ?>
      <div class="mbot15 row inline-block full-width" data-attachment-id="<?php echo $attachment['id']; ?>">
         <div class="col-md-8">
            <div class="pull-left"><i class="<?php echo get_mime_class($attachment['filetype']); ?>"></i></div>
            <a href="<?php echo $attachment_url; ?>" target="_blank"><?php echo $attachment['file_name']; ?></a>
            <br />
            <small class="text-muted"> <?php echo $attachment['filetype']; ?></small>
         </div>
         <div class="col-md-4 text-right">
            <?php if($attachment['visible_to_customer'] == 0){
               $icon = 'fa-toggle-off';
               $tooltip = _l('show_to_customer');
            } else {
               $icon = 'fa-toggle-on';
               $tooltip = _l('hide_from_customer');
            }
            ?>
            <a href="#" data-toggle="tooltip" onclick="toggle_file_visibility(<?php echo $attachment['id']; ?>,<?php echo $invoice->id; ?>,this); return false;" data-title="<?php echo $tooltip; ?>"><i class="fa <?php echo $icon; ?>" aria-hidden="true"></i></a>
            <?php if($attachment['staffid'] == get_staff_user_id() || is_admin()){ ?>
               <a href="#" class="text-danger" onclick="delete_invoice_attachment(<?php echo $attachment['id']; ?>); return false;"><i class="fa fa-times"></i></a>
            <?php } ?>
         </div>
      </div>
   <?php } ?>
<?php } ?>
<hr />
<?php if($invoice->clientnote != ''){ ?>
   <div class="col-md-12 row mtop15">
      <p class="bold text-muted"><?php echo _l('invoice_note'); ?></p>
      <p><?php echo $invoice->clientnote; ?></p>
   </div>
<?php } ?>
<?php if($invoice->terms != ''){ ?>
   <div class="col-md-12 row mtop15">
      <p class="bold text-muted"><?php echo _l('terms_and_conditions'); ?></p>
      <p><?php echo $invoice->terms; ?></p>
   </div>
<?php } ?>
</div>
