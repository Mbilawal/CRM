<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head();
//echo "<pre>";  print_r($arr_general_customers); exit;
?>

<div id="wrapper" class="customer_profile" style="min-height: 1314.4px;">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> </div>
      <div class="btn-bottom-toolbar btn-toolbar-container-out text-right"> </div>
      <div class="testing col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div>
              <div class="tab-content">
                <h4 class="customer-profile-group-heading">Add Invoice</h4>
                <div class="row">
                  <form action="https://crm.dryvarfoods.com/admin/general_customers/invoice_process" class="client-form" autocomplete="off" method="post" accept-charset="utf-8">
                    <div class="col-md-12">
                      <div class="tab-content mtop15">
                        <?php
                    if ($this->session->flashdata('err_message')) {
                    ?>
                        <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
                        <?php
                    } //end if($this->session->flashdata('err_message'))

                    if ($this->session->flashdata('ok_message')) {
                    ?>
                        <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
                        <?php
                    } //if($this->session->flashdata('ok_message'))
                    ?>
                        
                        <div role="tabpanel" class="tab-pane active" id="contact_info">
                          <div class="row">
                            <div class="panel_s invoice accounting-template">
                              <div class="additional"></div>
                              <div class="panel-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="f_client_id">
                                      
                                       
                                        <div class="dropdown bootstrap-select ajax-search bs3 ajax-remove-values-option" style="width: 100%;">
                                          <div class="form-group" app-field-wrapper="company">
                          <label for="first_name" class="control-label"> <small class="req text-danger">* </small>Select Customer</label>
                          <select id="customer" name="customer" class="form-control" >
                            <option value="">Select Customer</option>
                            <?php foreach($arr_general_customers as $customer){
							 if($customer['firstname']==""){ continue;}	
							?>
                            <option value="<?php echo $customer['firstname'].' '.$customer['lastname'];?>"><?php echo ucfirst($customer['firstname'].' '.$customer['lastname']);?></option>
                            <?php }?>
                          </select>
                        </div>
                                          
                                          
                                       
                                      </div>
                                    </div>
                                    
                                    <div class="row">
                                      
                                      <div class="col-md-6">
                                        <p class="bold">Bill To</p>
                                        <address>
                                        
                                       
                                        <textarea id="bill_to" name="bill_to" class="form-control" rows="4"></textarea>
                                        </address>
                                      </div>
                                      <div class="col-md-6">
                                        <p class="bold">Ship to</p>
                                        <address>
                                        
                                        <textarea id="ship_to" name="ship_to" class="form-control" rows="4"></textarea>
                                        
                                        </address>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="number">Invoice Number</label>
                                      <div class="input-group"> <span class="input-group-addon"> INV- </span>
                                        <input type="text" name="number" class="form-control" value="" data-isedit="true" data-original-number="true">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group" app-field-wrapper="date">
                                          <label for="date" class="control-label">Invoice Date</label>
                                          <div class="input-group date">
                                            <input type="text" id="date" name="date" class="form-control datepicker" value="" autocomplete="off">
                                            <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i> </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group" app-field-wrapper="duedate">
                                          <label for="duedate" class="control-label">Due Date</label>
                                          <div class="input-group date">
                                            <input type="text" id="duedate" name="duedate" class="form-control datepicker" value="" autocomplete="off">
                                            <div class="input-group-addon"> <i class="fa fa-calendar calendar-icon"></i> </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                  </div>
                                  <div class="col-md-6">
                                    <div class="panel_s no-shadow">
                                      
                                      <!--<div class="form-group mbot15">
                                        <label for="allowed_payment_modes" class="control-label">Allowed payment modes for this invoice</label>
                                        <br>
                                        <div class="dropdown bootstrap-select show-tick bs3" style="width: 100%;">
                                          <select class="selectpicker" data-toggle="" name="allowed_payment_modes[]" data-actions-box="true" multiple="true" data-width="100%" data-title="Non selected" tabindex="-98">
                                            <option value="1" selected="">Bank</option>
                                          </select>
                                          <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" title="Bank">
                                          <div class="filter-option">
                                            <div class="filter-option-inner">
                                              <div class="filter-option-inner-inner">Bank</div>
                                            </div>
                                          </div>
                                          <span class="bs-caret"><span class="caret"></span></span></button>
                                          <div class="dropdown-menu open">
                                            <div class="bs-actionsbox">
                                              <div class="btn-group btn-group-sm btn-block">
                                                <button type="button" class="actions-btn bs-select-all btn btn-default">Select All</button>
                                                <button type="button" class="actions-btn bs-deselect-all btn btn-default">Deselect All</button>
                                              </div>
                                            </div>
                                            <div class="inner open" role="listbox" id="bs-select-3" tabindex="-1" aria-multiselectable="true">
                                              <ul class="dropdown-menu inner " role="presentation">
                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>-->
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group" app-field-wrapper="currency">
                                            <label for="currency" class="control-label">Currency</label>
                                            <div class="dropdown bootstrap-select  bs3 dropup" style="width: 100%;">
                                              <select id="currency" name="currency" class="selectpicker" data-show-subtext="1" data-base="1" data-width="100%" data-none-selected-text="Non selected" data-live-search="true" tabindex="-98">
                                                <option value=""></option>
                                                <option value="1" selected="" data-subtext="R">ZAR</option>
                                              </select>
                                              
                                              
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <!--<div class="col-md-6">
                                          <div class="form-group">
                                            <label for="recurring" class="control-label"> Recurring Invoice? </label>
                                            <div class="dropdown bootstrap-select bs3" >
                                              <select class="form-control"  name="recurring"  tabindex="-98">
                                                <option value="0">No</option>
                                                <option value="1">Every 1 month</option>
                                                <option value="2">Every 2 months</option>
                                                <option value="3">Every 3 months</option>
                                                <option value="4">Every 4 months</option>
                                                <option value="5">Every 5 months</option>
                                                <option value="6">Every 6 months</option>
                                                <option value="7">Every 7 months</option>
                                                <option value="8">Every 8 months</option>
                                                <option value="9">Every 9 months</option>
                                                <option value="10">Every 10 months</option>
                                                <option value="11">Every 11 months</option>
                                                <option value="12">Every 12 months</option>
                                                <option value="custom">Custom</option>
                                              </select>
                                              
                                              
                                            </div>
                                          </div>
                                        </div>-->
                                        
                                        <div class="recurring_custom hide">
                                          <div class="col-md-6">
                                            <div class="form-group" app-field-wrapper="repeat_every_custom">
                                              <input type="number" id="repeat_every_custom" name="repeat_every_custom" class="form-control" min="1" value="1">
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="dropdown bootstrap-select bs3" style="width: 100%;">
                                              <select name="repeat_type_custom" id="repeat_type_custom" class="selectpicker" data-width="100%" data-none-selected-text="Non selected" tabindex="-98">
                                                <option value="day">Day(s)</option>
                                                <option value="week">Week(s)</option>
                                                <option value="month">Month(s)</option>
                                                <option value="year">Years(s)</option>
                                              </select>
                                              <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" role="combobox" aria-owns="bs-select-8" aria-haspopup="listbox" aria-expanded="false" data-id="repeat_type_custom" title="Day(s)">
                                              <div class="filter-option">
                                                <div class="filter-option-inner">
                                                  <div class="filter-option-inner-inner">Day(s)</div>
                                                </div>
                                              </div>
                                              <span class="bs-caret"><span class="caret"></span></span></button>
                                              <div class="dropdown-menu open">
                                                <div class="inner open" role="listbox" id="bs-select-8" tabindex="-1">
                                                  <ul class="dropdown-menu inner " role="presentation">
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div id="cycles_wrapper" class=" hide">
                                          <div class="col-md-12">
                                            <div class="form-group recurring-cycles">
                                              <label for="cycles">Total Cycles </label>
                                              <div class="input-group">
                                                <input type="number" class="form-control" disabled="" name="cycles" id="cycles" value="0">
                                                <div class="input-group-addon">
                                                  <div class="checkbox">
                                                    <input type="checkbox" checked="" id="unlimited_cycles">
                                                    <label for="unlimited_cycles">Infinity</label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group" app-field-wrapper="adminnote">
                                        <label for="adminnote" class="control-label">Admin Note</label>
                                        <textarea id="adminnote" name="adminnote" class="form-control" rows="4"></textarea>
                                      </div>
                                      
                                      <div class="form-group">
                                      <div class="checkbox checkbox-danger">
                                        <input type="checkbox" id="cancel_overdue_reminders" name="cancel_overdue_reminders">
                                        <label for="cancel_overdue_reminders">Prevent sending overdue reminders for this invoice</label>
                                      </div>
                                    </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="panel-body mtop10">
                                <div class="row">
                                  <!--<div class="col-md-12">
                                    <div class="pull-right"> <a class="btn btn-info add_more">Add New Item</a> </div>
                                  </div>-->
                                  <div class="col-md-12">
                                    <div class="table-responsive">
                                      <table id="order_table" class="table items items-preview invoice-items-preview" data-type="invoice">
                                        <thead>
                                          <tr>
                                            <th align="center">#</th>
                                            
                                            <th align="left">Date</th>
                                            <th align="left">Sale Amount</th>
                                            <th align="left">Quantity</th>
                                            <th align="right">Total Amount</th>
                                           
                                          </tr>
                                        </thead>
                                        <tbody class="ui-sortable">
                                          <tr class="orderItem" data-item-id="1">
                                            <td class="dragger item_no" align="center" width="5%">1</td>
                                            
<td align="left" ><input rowno="1" type="text" id="date1" name="date[]" class="form-control datepicker" value="" placeholder="Date"  ></td>
<td align="left" >
<input rowno="1" type="text" id="sales_amount1" name="sales_amount" class="form-control" value="" placeholder="Sale Amount"  onkeyup="show_total(this.value)"></td>
<td align="left" >
<input rowno="1" type="text" id="commission_amount1" name="commission_amount" class="form-control" value="" placeholder="Quantity" onkeyup="show_total(this.value)" ></td>
<td align="left" ><input rowno="1" type="text" id="payout_amount1" name="payout_amount" class="form-control payout_amount" value="" placeholder="Payout Amount" 
></td>
                                            
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="col-md-7 col-md-offset-5">
                                    <table class="table text-right">
                                      <tbody>
                                        <tr id="subtotal">
                                          <td><span class="bold" style="font-weight: bold;">Payout Amount</span>
                                            <input type="hidden" name="payout_amount_field" id="payout_amount_field" value="0.00"></td>
                                          <td class="total_payout_amount">R0.00</td>
                                        </tr>
                                        <tr>
                                          <td><span class="bold" style="font-weight: bold;">Amount Paid (R)</span></td>
                                          <td class="total_amount_paid"><input type="number" name="amount_paid_field" id="amount_paid_field" value="" onkeyup="show_total(this.value)"></td>
                                        </tr>
                                        <tr>
                                          <td><span class="bold" style="font-weight: bold;">Total</span>
                                            <input type="hidden" name="total_amount_field" id="total_amount_field" value=""></td>
                                          <td class="total1">R0.00
                                            <input type="hidden" name="total" value="0.00"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div id="removed-items"></div>
                                <div id="billed-tasks"></div>
                                <div id="billed-expenses"></div>
                                
                              </div>
                              <div class="row">
                                <div class="col-md-12 mtop15">
                                  <div class="panel-body bottom-transaction">
                                    <div class="form-group mtop15" app-field-wrapper="clientnote">
                                      <label for="clientnote" class="control-label">Client Note</label>
                                      <textarea id="clientnote" name="clientnote" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group mtop15" app-field-wrapper="terms">
                                      <label for="terms" class="control-label">Terms &amp; Conditions</label>
                                      <textarea id="terms" name="terms" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="btn-bottom-toolbar text-right">
                                 <!--<button class="btn-tr btn btn-default mleft10 text-right invoice-form-submit save-as-draft transaction-submit"> Save as Draft </button>-->
                                     
                                      <div class="btn-group dropup">
                                        <input type="submit" class="btn-tr btn btn-info " value="Submit">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> </button>
                                        <ul class="dropdown-menu dropdown-menu-right width200">
                                          <li> <a href="#" class="invoice-form-submit save-and-send transaction-submit"> Save &amp; Send </a> </li>
                                          <li> <a href="#" class="invoice-form-submit save-and-send-later transaction-submit"> Save and Send Later </a> </li>
                                          <li> <a href="#" class="invoice-form-submit save-and-record-payment transaction-submit"> Save &amp; Record Payment </a> </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="btn-bottom-pusher"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                
                <?php init_tail(); ?>
                
                
				<script>
                    function show_total(val){
                        
                        var sales_amount       = document.getElementById('sales_amount1').value;
                        var extra_charge       = document.getElementById('commission_amount1').value;
                        var amount_paid_field  = document.getElementById('amount_paid_field').value;
						var payout_amount1     = document.getElementById('payout_amount1').value;
						
						
                       
                        if(amount_paid_field == "" || amount_paid_field == 0){
							
                            var Newbalance = parseFloat(sales_amount) * parseFloat(extra_charge);	
							$('#payout_amount1').val(Newbalance);
							$('.total_payout_amount').html("ZAR "+Newbalance .toFixed(2));
							$('.total1').html("ZAR "+Newbalance .toFixed(2));;
				  
                        }else if(amount_paid_field > 0){
							
							
							
                            var Newbalance = parseFloat(payout_amount1) - parseFloat(amount_paid_field);
							$('.total1').html("ZAR "+Newbalance .toFixed(2));
                            $('#total_amount_field').val(Newbalance);
                        }
                          
                        
                    }
                </script>
                <script>
				
				
				
				
  /*  window.addEventListener('load',function(){
       appValidateForm($('#customer-group-modal'), {
        name: 'required'
    }, manage_customer_groups);*/

       $('#customer_group_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
        $('#customer_group_modal .add-title').removeClass('hide');
        $('#customer_group_modal .edit-title').addClass('hide');
        $('#customer_group_modal input[name="id"]').val('');
        $('#customer_group_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(group_id) !== 'undefined') {
            $('#customer_group_modal input[name="id"]').val(group_id);
            $('#customer_group_modal .add-title').addClass('hide');
            $('#customer_group_modal .edit-title').removeClass('hide');
            $('#customer_group_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   /*});*/
    function manage_customer_groups(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-customer-groups')){
                    $('.table-customer-groups').DataTable().ajax.reload();
                }
                if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                    var groups = $('select[name="groups_in[]"]');
                    groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                    groups.selectpicker('refresh');
                }
                alert_float('success', response.message);
            }
            $('#customer_group_modal').modal('hide');
        });
        return false;
    }

</script> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-bottom-pusher"></div>
  </div>
</div>
