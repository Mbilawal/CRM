<tr class="orderItem lastone" data-item-id="<?php echo $count;?>">
      <td class="dragger item_no ui-sortable-handle" align="center" width="5%"><?php echo $count;?></td>
      <td align="left;" width="10%">
<select class="form-control order_select" id="order_id<?php echo $count;?>" name="order_id[]" rowno="<?php echo $count;?>" required="true">
 <option value="">Select Order ID</option>
</select>
</td>
      <td align="left" width="10%"><input rowno="<?php echo $count;?>" type="text" id="date<?php echo $count;?>" name="date[]" class="form-control" value="" placeholder="Date" readonly></td>
      <td align="left" width="10%"><input rowno="<?php echo $count;?>" type="text" id="payout_amount<?php echo $count;?>" name="payout_amount[]" class="form-control payout_amount" value="" placeholder="Sub Total" readonly></td>
      <td align="left" width="10%"><input rowno="<?php echo $count;?>" type="text" id="commission_amount<?php echo $count;?>" name="commission_amount[]" class="form-control" value="" placeholder="Platform Fee" readonly></td>
      <td align="left" width="10%"><input rowno="<?php echo $count;?>" type="text" id="sales_amount<?php echo $count;?>" name="sales_amount[]" class="form-control" value="" placeholder="Total Fee" readonly></td>
      <td align="left" width="10%"><a rowno="<?php echo $count;?>" class="btn btn-danger btn-sm delete_item">Delete</a>
</tr>