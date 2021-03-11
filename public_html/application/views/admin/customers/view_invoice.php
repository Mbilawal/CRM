<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper" class="customer_profile" style="min-height: 1314.4px;">
  <div class="content">
    <div class="row">
      <div class="col-md-12"> </div>
      
        <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
        </div>
      
      <div class="testing col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div>
              <div class="tab-content">
                <h4 class="customer-profile-group-heading">View Invoice</h4>
                <div class="row">
                  <div class="container">
<div class="row">
    				<!-- BEGIN INVOICE -->
					<div class="col-xs-12">
						<div class="grid invoice">
							<div class="grid-body">
								<div class="invoice-title">
									<div class="row">
										<div class="col-xs-12">
											<img src="https://crm.dryvarfoods.com/uploads/company/96d6f2e7e1f705ab5e59c84a6dc009b2.png" alt="" height="35">
										</div>
									</div>
									<br>
									<div class="row">
										<div class="col-xs-12">
											<h2>Invoice<br>
											<span class="small">Order #<?php echo $arr_invoice['id']?></span></h2>
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-6">
										<address>
											<strong>Billed To:</strong><br>
											<?php  echo $arr_invoice['bill_to'] ?>
										</address>
									</div>
									<div class="col-xs-6 text-right">
										<address>
											<strong>Shipped To:</strong><br>
											<?php  echo $arr_invoice['ship_to'] ?>
										</address>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<!--<address>
											<strong>Payment Method:</strong><br>
											Visa ending **** 1234<br>
											h.elaine@gmail.com<br>
										</address>-->
									</div>
									<div class="col-xs-6 text-right">
										<address>
											<strong>Order Date:</strong><br>
											<?php echo date("F j, Y, g:i a", strtotime($value['created_date']));?>
										</address>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h3>ORDER SUMMARY</h3>
										<table class="table table-striped">
											<thead>
												<tr class="line">
													<td><strong>#</strong></td>
													<td class="text-left"><strong>Note</strong></td>
													<td class="text-center"><strong>Sale Amount</strong></td>
                                                   
													<td class="text-left"><strong>QuantitY</strong></td>
                                                     <td class="text-center"><strong>Amount Paid</strong></td>
                                                    <td class="text-right"><strong>Total Amount</strong></td>
                                                    
													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td><?php echo $arr_invoice['clientnote'] ?></td>
                                                    <td class="text-center"><?php echo $arr_invoice['sales_amount'] ?></td>
                                                    <td class="text-left"><?php  echo $arr_invoice['quantity'] ?></td>
													<td class="text-center"><?php  echo $arr_invoice['amount_paid'] ?></td>
													
													<td class="text-right"><?php  echo $arr_invoice['total'] ?></td>
												</tr>
												
												
												<tr>
													<td colspan="4"></td>
													<td class="text-right"><strong>Taxes</strong></td>
													<td class="text-right"><strong>N/A</strong></td>
												</tr>
												<tr>
													<td colspan="4">
													</td><td class="text-right"><strong>  Amount Total</strong></td>
													<td class="text-right"><strong>R <?php  echo $arr_invoice['sales_amount'] * $arr_invoice['quantity'] ?></strong></td>
												</tr>
                                                <tr>
													<td colspan="4">
													</td><td class="text-right"><strong>Remaining Total</strong></td>
													<td class="text-right"><strong>R <?php  echo $arr_invoice['total'] ?></strong></td>
												</tr>
											</tbody>
										</table>
									</div>									
								</div>
								<div class="row">
									<div class="col-md-12 text-right identity">
										<p>Designer identity<br><strong> <?php echo ucfirst($arr_invoice['customer']) ?></strong></p>
									</div>
								</div>
                                
                                <div class="row">
									<div class="col-md-12 text-right identity">
										&nbsp;&nbsp;&nbsp;&nbsp;
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END INVOICE -->
				</div>
</div>
                  
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-bottom-pusher"></div>
  </div>
</div>
