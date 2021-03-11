<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="_filters _hidden_inputs">
    <?php
    foreach($invoices_sale_agents as $agent){
        echo form_hidden('sale_agent_'.$agent['sale_agent']);
    }
    foreach($invoices_statuses as $_status){
        $val = '';
        if($_status == $this->input->get('status')){
            $val = $_status;
        }
        echo form_hidden('invoices_'.$_status,$val);
    }
    foreach($invoices_years as $year){
        echo form_hidden('year_'.$year['year'],$year['year']);
    }
    foreach($payment_modes as $mode){
        echo form_hidden('invoice_payments_by_'.$mode['id']);
    }
    echo form_hidden('not_sent',$this->input->get('filter'));
    echo form_hidden('not_have_payment');
    echo form_hidden('recurring');
    echo form_hidden('project_id'); ?>

    <div class="display-block text-left">         
       <div class="row">
          <div class="panel_s mbot10 col-md-12" style="">
             <div class="custom_dev" style="background: #fff;">
               <div class='col-sm-3'>
                  <label><strong>Date From</strong></label>
                  <div class='input-group date' id='datetimepicker1'>
                      <input type="text" id="date_from" name="date_from" class="form-control datepicker select_filters1" value="" placeholder="From Date" autocomplete="off" aria-invalid="false">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
               </div>
               <div class='col-sm-3'>
                  <label><strong>Date To</strong></label>
                  <div class='input-group date' id='datetimepicker2'>
                      <input type="text" id="date_too" placeholder="To Date" name="date_too" class="form-control datepicker select_filters1" value="" autocomplete="off" aria-invalid="false">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
               </div>
              <div class='col-sm-2'>
                <label><strong></strong></label>
                <button type="button" class="btn btn-primary apply_filter_date" style="margin-top: 26px" onclick="dt_custom_view('start','.table-invoices','0'); return false;">Apply</button>
              </div>
            </div>
          </div>
       </div>
    </div>

</div>
