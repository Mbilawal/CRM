<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style type="text/css">
  #payout_report{
	 overflow-x:scroll; 
  }
  .hr_style {
    margin-top: 10px;
    border: 0.5px solid;
    color: #03a9f4;
  }
  tr:last-child{
	  border-top: 2px solid #03a9f4;
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
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
          
             <div class="clearfix"></div>
             
              <div class="col-md-12">
                <h3 class="padding-5 p_style">Dryvarfoods Driver Weekly Payout Report  <span class="pull-right"><?php echo "Driver Name:".$driver_details['firstname'];?>
				</span>
				</h3>
			  </div>
              <hr class="hr_style" />
              
			  <form id="weeklyPayoutReportFilter" autocomplete="off" method="post" action="<?php echo AURL;?>drivers/export_payout_csv">
			  <input type="hidden" id="driver_id" name="driver_id" value="<?php echo $driver_details['driver_id'];?>">
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
                   
				  <div class="col-md-12" style="margin-top:35px;">
					  <div class="pull-right">
					     <input type="submit" class="btn btn-info" value="Export as CSV">
					  </div>
				  </div>
				</div>
              </div>
               </form>
              
          <div class="row">
            
            <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			<div class="loader">
			   <center>
				   <img class="loading-image" src="<?php echo base_url();?>assets/images/search.gif" alt="loading..">
			   </center>
			</div>
			</div>
			
		
		<div class="payout_report_container">
          <div class="row">
		<div class="col-md-12">
		<div class="col-md-12">
		   <div class="pull-right col-md-12"><h5 style="color:#637381;font-size:16px;margin-bottom:0px" class="selected_date"></h4></div>
		   <div class="col-md-12"><div id="payout_report"></div></div>
		</div>
		</div>
		</div>  
          <div class="row">
		    <div class="col-md-12">
                <div class=" col-md-12 col-xs-12"  style="font-weight: bold;padding-top: 20px;">
			
            <table class="table table-hover  no-footer dtr-inline collapsed">
              <thead>
                <tr role="row" style="background:#f6f8fa; border-top: 1px solid #f0f0f0!important;border-left: 0;border-right: 1px solid #f0f0f0;">
				  <th style="min-width: 30px;font-weight: bold;">Week Day</th>
                  <th style="min-width: 30px;font-weight: bold;">Total Amount</th>
                  <th style="min-width: 50px;font-weight: bold;">Payout Amount</th>
				  <th style="min-width: 120px;font-weight: bold;">Action</th>
                </tr>
              </thead>
                <tbody>

					  <?php 
					if(count($payout)>0){
					$order_total =0;
					$total_payout = 0;
					foreach($payout as $val){
					$order_total +=$val["total_amount"];
					$total_payout +=$val["payout"];
					?>
					  <tr role="row">
						<td><?php echo $val["from_week_day"]." - ".$val["to_week_day"];?></td>
					    <td>R<?php echo number_format($val["total_amount"], 2, ".", ",");?></td>
						<td>R<?php echo number_format($val["payout"], 2, ".", ",");?></td>
						<td><a href="<?php echo AURL;?>drivers/per_day_report/<?php echo $driver_details['driver_id'];?>/<?php echo $val["from_week_day"];?>/<?php echo $val["to_week_day"];?>"><i class="fa fa-bar-chart-o"></i></a></td>
					</tr> 
					  <?php } ?>
					 <tr role="row">
						<td class="text-right">Total</td>
						<td>R<?php echo number_format($total_payout, 2, ".", ",");?></td>
						<td>R<?php echo number_format($order_total, 2, ".", ",");?></td> 
						<td>&nbsp;</td>
					</tr> 
					<?php } else{ ?>
					<tr><td colspan="4"><p class="text-danger">No Records Found</p></td></tr>
					<?php } ?>
					
				  </tbody>
			
			   </table>
             </div>
            </div>
		</div>
    </div>
 
  </div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>
</body>
</html>
